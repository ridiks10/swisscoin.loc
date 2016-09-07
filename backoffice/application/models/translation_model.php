<?php

class translation_model extends Core_Inf_Model {

    private $_table = 'translation';
    
    private $_languages = [];
    
    private $_scriptDefault = 'en';
    
    public function __construct() {
        parent::__construct();

        if(!$this->db->table_exists($this->_table)) {
            $this->db->query("
CREATE TABLE IF NOT EXISTS `{$this->db->dbprefix($this->_table)}` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `key` varchar(100) NOT NULL,
  `text` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang` (`lang`,`tag`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
"
            );
        }
        
        $this->_languages = $this->db->get("infinite_languages")->result_array();
    }

    /**
     * Return id code for language
     * @param int|string $language
     * @return int Language code in system
     * @throws Exception if Language not found
     */
    public function getLangId($language)
    {
        if (is_numeric($language)) {
            return intval($language);
        } else {
            foreach ($this->_languages as $_lang) {
                if ($_lang['lang_code'] === $language || $_lang['lang_name_in_english'] === $language) {
                    return intval($_lang['lang_id']);
                }
            }
        }
        throw new Exception("Invalid language");
    }
    
    /**
     * Return system name for language id
     * @param int $id
     * @return string
     */
    public function getLangName($id)
    {
        foreach ($this->_languages as $language) {
            if ($language['lang_id'] == $id) {
                return $language['lang_name_in_english'];
            }
        }
        
        return 'english';
    }
    
    /**
     * Return list of translation 
     * @return array Array with all videos
     */
    public function getTranslation($language, $tag = null) {
        $arr = [
            'lang' => $this->getLangId($language)
        ];
        if (!is_null($tag)) {
            $arr['tag'] = $tag;
        }
        return $this->db->order_by('text', 'ASC')->get_where($this->_table, $arr)->result();
    }
    
    public function getAdminTranslation($language, $tag = null) {
        $arr = [
            'e.lang' => $this->LANG_ID
        ];
        $lang = $this->getLangId($language);
        if (!is_null($tag)) {
            $arr['e.tag'] = $tag;
        }
        $this->db->_protect_identifiers = false;
//        $query = $this->db->query("SELECT e.key, e.lang, e.tag, l.text FROM {$this->table_prefix}{$this->_table} as e LEFT JOIN {$this->table_prefix}{$this->_table} as l ON l.lang = {$lang} AND e.tag = l.tag AND e.key = l.key WHERE e.lang = {$this->LANG_ID} ORDER BY text ASC");
        $query = $this->db->select('e.key, e.lang, e.tag, l.text')->from($this->_table . ' as e')->join($this->_table . ' as l', "l.lang = {$lang} AND e.tag = l.tag AND e.key = l.key", 'left', false)->order_by('text', 'ASC')->where($arr)->get();
        $this->db->_protect_identifiers = true;
        return $query->result();
    }

    /**
     * Return list of all languages registered in system
     * @return array
     */
    public function getLanguages()
    {
        return $this->_languages;
    }
    
    /**
     * Return list of all active languages in system
     * @return array
     */
    public function getActiveLanguages()
    {
        $active = [];
        foreach ($this->_languages as $language) {
            if ($language['status'] == 'no') {
                continue;
            }
            $active[] = $language;
        }
        return $active;
    }
    
    /**
     * Return full info about system default language
     * @return array
     */
    public function getDefaultLanguage()
    {
        foreach ($this->_languages as $language) {
            if ($language['status'] == 'no') {
                continue;
            }
            if ($language['default_id']) {
                return $language;
            }
        }
    }
    
    /**
     * Return untranslated strings for language
     * @param int $lang
     * @param bool $returnArray return as array of array or array of objects
     * @return array List of untranslated strings
     */
    public function emptyTranslation($lang, $returnArray = false)
    {
        $this->db->_protect_identifiers = false;
        $q = $this->db->select('e.tag, e.key, t.lang_code, e.text as english, l.text')->from($this->_table . ' as e')->join($this->_table . ' as l', "l.lang = {$lang} AND e.tag = l.tag AND e.key = l.key", 'left', false)->join('infinite_languages as t', "t.lang_id = {$lang}", 'left')->where('e.lang', $this->LANG_ID)->where('l.text IS NULL')->get();
        $this->db->_protect_identifiers = true;
        return $returnArray ? $q->result_array() : $q->result();
    }
    
    public function translationUpdate($data)
    {
        if (empty($data['translation'])) {
            log_message('error', 'Empty translation string ' . implode(' ', $data));
            return true;
        }
        if (empty($data['key']) || empty($data['language']) || empty($data['tag'])) {
            log_message('error', 'Invalid translation data ' . implode(' ', $data));
            throw new Exception('Invalid translation data');
        }
        $lang = $this->getLangId($data['language']);
        $this->db->where(['lang' => $lang, 'tag LIKE' => $data['tag'], 'key LIKE' => $data['key']])->update($this->_table, ['text' => $data['translation']]);
        return $this->db->affected_rows();
    }
    
    public function translationInsert($tag, $key)
    {
        if (empty($key) || empty($tag)) {
            log_message('error', 'Invalid translation data :' . $tag . '-' . $key);
            return false;
        }
        $insert = [];
        foreach ($this->_languages as $language) {
            $insert[] = ['lang' => $language['lang_id'], 'tag' => "'{$tag}'", 'key' => "'{$key}'"];
        }
        try {
            $this->db->query("INSERT IGNORE INTO `{$this->table_prefix}{$this->_table}` (`lang`, `tag`, `key`) VALUES ". implode(',', array_map(function($a){return '(' . implode(',', $a) . ')';}, $insert)));
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
    
    public function translationInsertUpdate($data)
    {
        if (empty($data['translation'])) {
            log_message('error', 'Empty translation string ' . implode(' ', $data));
            $data['translation'] = null;
        } else {
            $data['translation'] = $this->db->escape($data['translation']);
        }
        if (empty($data['key']) || empty($data['lang']) || empty($data['tag'])) {
            log_message('error', 'Invalid translation data ' . implode(' ', $data));
            throw new Exception('Invalid translation data');
        }
        try {
            $this->db->query("INSERT INTO `{$this->table_prefix}{$this->_table}` (`lang`, `tag`, `key`, `text`) VALUES ({$data['lang']}, {$this->db->escape($data['tag'])}, {$this->db->escape($data['key'])}, {$data['translation']}) ON DUPLICATE KEY UPDATE `text` = {$data['translation']}");
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
    
    public function translationInsertUpdateBatch($data)
    {
        try {
            $this->db->query("INSERT INTO `{$this->table_prefix}{$this->_table}` (`lang`, `tag`, `key`, `text`) VALUES ". implode(',', array_map(function($a){return '(' . implode(',', array_map(function($b){return $this->db->escape($b);}, $a)) . ')';}, $data)) . " ON DUPLICATE KEY UPDATE `text` = VALUES(text)");
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
    
}
