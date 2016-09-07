<?php

/**
 * 
 */
class Core_Inf_Lang {
    
    private $_lines = [];
    
    private $_loaded = [];
    
    private $_study = null;
    
    private $_db = null;
    
    private $_default = '';
    
    /**
     * Default constructor.
     * Note: do all assignments *only* throw injection 
     */
    public function __construct() {
        log_message('debug', "Database language Class Initialized");
        
        // include database early to get access to load
        require_once(BASEPATH.'database/DB.php');
        
        $this->_db =& DB();
        
        $this->_default = @$this->_db->select('lang_id')->get_where('infinite_languages', ['default_id' => 1], 1)->row()->lang_id ?: 0;
        
        $this->load('db');
    }
    
    /**
     * Loads requested translation tag from db
     * @param array|string $tag tags that must be loaded
     * @param int|string $language Language id or language code/name
     * @param type $notused1
     * @param type $notused2
     * @param type $notused3
     */
    public function load($tag = [], $language = null, $notused1 = FALSE, $notused2 = TRUE, $notused3 = '')
    {
        if (!is_array($tag)) {
            $tag = [$tag];
        }
        $tagsToLoad = [];
        foreach ($tag as $tagName) {
            if (strpos($tagName, '/')) {
                $tagName = explode('/', $tagName)[1];
            }
            if (!in_array($tagName, $this->_loaded)) {
                $tagsToLoad[] = $tagName;
            }
        }
        if (count($tagsToLoad) < 1) {
            log_message('debug', "Requested tag already loaded");
            return;
        }
        // default params
        $lang = $this->_default;
        
        // check for language
        if (!is_null($language)) {
            foreach ($this->_db->select('*')->where("status", "yes")->get("infinite_languages")->result_array() as $_lang) {
                if (empty($lang)) {
                    $lang = $_lang['lang_id'];
                }
                if ((is_numeric($language) && intval($_lang['lang_id']) === intval($language))
                    || $_lang['lang_code'] === $language || $_lang['lang_name_in_english'] === $language
                ) {
                    $lang = $_lang['lang_id'];
                }
            }
        }
        // 
        $query = $this->_db->select('key, text')->where('lang', $lang)->where_in('tag', $tagsToLoad)->get('translation');
        $newLines = [];
        foreach ($query->result_array() as $line) {
            $newLines[$line['key']] = $line['text'];
        }
        $query->free_result();
        $this->_lines = array_merge($this->_lines, $newLines);
        log_message('debug', 'Added translation for ' . implode(', ', $tagsToLoad) . ' with ' . count($newLines) . ' lines');
        $this->_loaded = array_merge($this->_loaded, $tagsToLoad);
    }
    
    /**
     * Translate line.
     * @param string $line
     * @param string|array $default [optional] Treat as default value for fallback if string,
     * or as list of replacement parameters if array
     * @param array $params [optional] List of replacement parameters
     * @return string
     */
    public function line($line = '', $default = null, $params = [])
    {
        if ($line === '') {
            return '';
        }
        if (is_array($default)) {
            $params = $default;
            $default = null;
        }
        if (is_null($default)) {
            $default = $line;
        }
        
        if (isset($this->_lines[$line])) {
            $translation = $this->_lines[$line];
        } else {
            log_message('error', 'Could not find the language line "'.$line.'"');
            if (!is_null($this->_study)) {
                $CI =& get_instance();
                $CI->translation_model->translationInsert($this->_study, $line);
            }
            $translation = $default;
        }
        
        try {
            $matches = [];
            if (preg_match_all('/\{[a-z\-_0-9]+\}/i', $translation, $matches)) {
                $_tmp = [];
                foreach ($matches[0] as $key => $val) {
                    $_tmp[$val] = @$params[trim($val,'{}')] ?: (@$params[$key] ?: '');
                }
                $params = $_tmp;
            }
            return str_replace($matches[0], $params, $translation);
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return $line;
        }
        
        
    }
    
    /**
     * Sets study mode. All missing translation will be added to list using $tag as category
     * @param string $tag
     */
    public function study($tag)
    {
        if (is_null($tag)) {
            $this->_study = null;
            return;
        }
        if (is_numeric($tag) || !is_string($tag)) {
            log_message('error', 'Invalid study tag: ' . $tag . '(' . gettype($tag) . ')');
            return;
        }
        $this->_study = $tag;
    }
    
    /**
     * Import old translation files
     */
    public function ImportOld()
    {
        $CI =& get_instance();
        
        foreach ($CI->translation_model->getLanguages() as $language) {
//            if ($language['status'] == 'no')
//                continue;
            $this->addDir('language/' . $language['lang_name_in_english'], $language['lang_id']);
            $this->addDir('language/' . $language['lang_name_in_english'], $language['lang_id'], false);
        }
    }
    
    /**
     * Looks for files in directory
     * @param string $dir
     * @param int $lang
     */
    protected function addDir($dir, $lang, $app = true)
    {
        echo '<br>' . ($app ? APPPATH : BASEPATH) . $dir . '<br>';
        $d = scandir(($app ? APPPATH : BASEPATH) . $dir);
        $files = array_diff($d, ['..', '.']);
        foreach ($files as $file) {
            $fn = rtrim($dir, '/') . '/' . $file;
            if (is_dir(($app ? APPPATH : BASEPATH) . $fn)) {
                $this->addDir($fn, $lang);
                continue;
            }
            $name = pathinfo($fn, PATHINFO_FILENAME);
            $name = substr($name, 0, strlen($name) - 5);
            $this->loadLang($fn, $lang, $name, $app); 
        }
    }
    
    /**
     * Load strings from specified file and add them to db.
     * @param string $file
     * @param int $langId
     * @param string $tag
     * @return type
     */
    protected function loadLang($file, $langId, $tag, $app = true)
    {
        try {
            include (($app ? APPPATH : BASEPATH) . $file);
        } catch (Exception $ex) {
            // Ignoring errors
        }
        
        if (!isset($lang)) {
            return;
        }
        
        $CI =& get_instance();
        
        $arr = [
            'lang' => $langId,
            'tag' => $tag,
        ];
        $tmp = [];
        foreach ($lang as $key => $text) {
            $tmp[] = array_merge($arr, ['key' => $key, 'translation' => $text]);
        }
        $CI->translation_model->translationInsertUpdateBatch($tmp);
    }
    
}