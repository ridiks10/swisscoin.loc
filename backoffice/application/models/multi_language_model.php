<?php

class multi_language_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function getLanguageDetails() {
        $language_details = array();
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $this->db->where('status', 'yes');
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $language_details[] = $row;
        }
        return $language_details;
    }

    public function getLangDetailsById($id) {

        $lang_details = array();
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $this->db->where('lang_id', $id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $lang_details = $row;
        }
        return $lang_details;
    }

    public function updateLangDetails($details) {
        $this->db->set('lang_code', $details['lang_code']);
        $this->db->set('lang_name', $details['lang_name']);
        $this->db->set('lang_name_in_english', $details['lang_name_in_english']);
        $this->db->set('status', $details['status']);
        $this->db->where('lang_id', $details['lang_id']);
        return $res = $this->db->update('infinite_languages');
    }

    public function getDefaultLang($lang_id) {
        $this->db->select('*');
        $this->db->from('infinite_languages');
        $this->db->where('default_id', $lang_id);
        $default_language = $this->db->get();
        return $default_language;
    }

    public function insertLanguageDetails($details) {
        $data = array(
            'lang_code' => $details['lang_code'],
            'lang_name' => $details['lang_name'],
            'lang_name_in_english' => $details['lang_name_in_english'],
            'status' => $details['status'],
        );
        return $res = $this->db->insert('infinite_languages', $data);
    }

    public function deleteLanguage($delete_id) {
        $this->db->set('status', 'no');
        $this->db->where('lang_id', $delete_id);
        $result = $this->db->update('infinite_languages');
        return $result;
    }

    public function setDefaultLanguage($lang_id, $user_id) {
        $this->db->set('default_id', 0);
        $this->db->update('infinite_languages');

        $this->db->set('default_id', 1);
        $this->db->where('lang_id', $lang_id);
        $query = $this->db->update('infinite_languages');
        if ($query) {
            $this->updateProjectDefaultLanguage($lang_id, $user_id);
        }
        return $query;
    }

    public function updateProjectDefaultLanguage($lang_id, $user_id) {
        $this->setUserDefaultLanguage($lang_id, $user_id);

        $this->db->set('default_lang', $lang_id);
        $query1 = $this->db->update('site_information');

        $query3 = $this->db->query("ALTER TABLE " . $this->db->dbprefix . "login_user ALTER COLUMN default_lang SET DEFAULT $lang_id");
    }

    public function setUserDefaultLanguage($lang_id, $user_id) {
        $this->db->set('default_lang', $lang_id);
        $this->db->where('user_id', $user_id);
        $query2 = $this->db->update('login_user');
    }

    public function updateAllUserDefaultLanguage($lang_id, $new_lang_id) {
        $this->db->set('default_lang', $new_lang_id);
        $this->db->where('default_lang', $lang_id);
        $query2 = $this->db->update('login_user');
    }

    public function getActiveLangaugeID() {
        $lang_id = 1;
        $this->db->select('lang_id');
        $this->db->where('status', 'yes');
        $this->db->order_by('lang_id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get('infinite_languages');
        foreach ($query->result_array() AS $row) {
            $lang_id = $row['lang_id'];
        }
        return $lang_id;
    }

}
