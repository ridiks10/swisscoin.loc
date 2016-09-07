<?php

class currency_model extends inf_model {

    public function __construct() {
        parent::__construct();
    }

    public function automaticCurrencyUpdate($default_currency) {
        //Using Yahoo finance API
        $multy_currency_status = $this->getMultyCurrencyStatus();
        $result = false;
        if ($multy_currency_status == 'yes') {
            $currencies = $this->getAllCurrencyCodes($default_currency);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $currencies) . '&f=sl1&e=.csv');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            $content = curl_exec($curl);
            curl_close($curl);

            $lines = explode("\n", trim($content));
            foreach ($lines as $line) {
                $currency = substr($line, 4, 3);
                $value = substr($line, 11, 6);
                if ((float) $value) {
                    $result = $this->updateCurrencyValues($currency, $value);
                }
            }
        } else {
            $result = true;
        }

        return $result;
    }

    public function getAllCurrencyCodes($default_currency = 'USD') {

        $currency = array();
        $this->db->select('code');
        $this->db->from('currency_details');
        $query = $this->db->get();
        foreach ($query->result_array() AS $row) {
            $currency[] = $default_currency . $row['code'] . '=X';
        }
        return $currency;
    }

    public function getCurrencyDetails() {
        $currency_details = array();
        $this->db->select('*');
        $this->db->from('currency_details');
        $this->db->where('delete_status', 'yes');
        $this->db->where('status', 'enabled');
        $query = $this->db->get();

        foreach ($query->result_array() as $row) {
            $currency_details[] = $row;
        }
        return $currency_details;
    }

    public function getCurrencyDetailsById($id) {
        $currency_details = array();
        $this->db->select('*');
        $this->db->from('currency_details');
        $this->db->where('id', $id);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $currency_details = $row;
        }
        return $currency_details;
    }

    public function updateCurrencyDetails($details) {
        $this->db->set('title', $details['currency_title']);
        $this->db->set('code', $details['currency_code']);
        $this->db->set('value', $details['currency_value']);
        $this->db->set('symbol_left', $details['symbol_left']);
        $this->db->set('symbol_right', $details['symbol_right']);
        $this->db->set('status', $details['status']);
        $this->db->where('id', $details['currency_id']);
        return $res = $this->db->update('currency_details');
    }

    public function insertCurrencyDetails($details) {
        $data = array(
            'title' => $details['currency_title'],
            'code' => $details['currency_code'],
            'value' => $details['currency_value'],
            'symbol_left' => $details['symbol_left'],
            'symbol_right' => $details['symbol_right'],
            'status' => $details['status'],
        );
        return $res = $this->db->insert('currency_details', $data);
    }

    public function setDefaultCurrency($id, $user_id) {
        $this->db->set('default_id', 0);
        $this->db->update('currency_details');

        $this->db->set('default_id', 1);
        $this->db->set('value', 1);
        $this->db->where('id', $id);
        $query = $this->db->update('currency_details');

        if ($query) {
            $this->updateProjectDefaultCurrency($id, $user_id);
        }
        return $query;
    }

    public function updateProjectDefaultCurrency($id, $user_id) {
        $this->updateUserCurrency($id, $user_id);

        $query2 = $this->db->query("ALTER TABLE " . $this->db->dbprefix . "login_user ALTER COLUMN default_currency SET DEFAULT $id");
    }

    public function updateUserCurrency($id, $user_id) {
        $this->db->set('default_currency', $id);
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('login_user');
        return $res;
    }

    public function changeConversionStatus($status) {
        $this->db->set('currency_conversion_status', $status);
        $result = $this->db->update('module_status');
    }

    public function getConversionStatus() {
        $conversion_status = '';
        $this->db->select('currency_conversion_status');
        $this->db->from('module_status');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $conversion_status = $row['currency_conversion_status'];
        }
        return $conversion_status;
    }

    public function getMultyCurrencyStatus() {
        $multy_currency_status = '';
        $this->db->select('multy_currency_status');
        $this->db->from('module_status');
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $multy_currency_status = $row->multy_currency_status;
        }
        if ($multy_currency_status == 'yes') {
            return true;
        }
        return false;
    }

    public function getUserDefaultCurrencyDetails($user_id = '') {
        $currency = NULL;
        $this->db->select('default_currency');
        $this->db->from('login_user');
        $this->db->where('user_id', $user_id);
        $this->db->limit(1);
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $currency_id = $row->default_currency;
            $currency = $this->getCurrencyDetailsById($currency_id);
        }
        return $currency;
    }

    public function getProjectDefaultCurrencyDetails() {
        $currency_details = array();
        $this->db->select('*');
        $this->db->from('currency_details');
        $this->db->where('default_id', 1);
        $query = $this->db->get();
        foreach ($query->result_array() as $row) {
            $currency_details = $row;
        }
        return $currency_details;
    }

    public function getAllCurrency() {
        $currency_array = array();
        $this->db->select('id,symbol_left,symbol_right,title');
        $this->db->from('currency_details');
        $this->db->where('status', 'enabled');
        $query = $this->db->get();
        $i = 0;
        foreach ($query->result() as $row) {
            $currency_array[$i]['id'] = $row->id;
            $currency_array[$i]['title'] = $row->title;
            $currency_array[$i]['symbol_left'] = $row->symbol_left;
            $currency_array[$i]['symbol_right'] = $row->symbol_right;
            $i++;
        }

        return $currency_array;
    }

    public function updateCurrencyValues($currency, $value) {

        $value = (float) $value;
        $this->db->set("value", $value);
        $this->db->set("last_modified", date('Y-m-d H:i:s'));
        $this->db->where("code", $currency);
        return $this->db->update("currency_details");
    }

    public function deleteCurrency($delete_id) {
        $this->db->set('delete_status', 'no');
        $this->db->where('id', $delete_id);
        $result = $this->db->update('currency_details');
        return $result;
    }

    public function getPaypalSupportedCurrencies() {
        //Reference : https://developer.paypal.com/docs/integration/direct/rest_api_payment_country_currency_support/
        $currencies = array("AUD", "BRL", "CAD", "CZK", "DKK", "EUR", "HKD", "HUF", "ILS", "JPY", "MYR", "MXN", "TWD", "NZD", "NOK", "PHP", "PLN", "GBP", "RUB", "SGD", "SEK", "CHF", "THB", "TRY", "USD");
        return $currencies;
    }

    public function getCurrencyConversionRate($base_currency_code, $currency_code) {
        $conversion_rate = 1;
        $currencies[] = $base_currency_code . $currency_code . '=X';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://download.finance.yahoo.com/d/quotes.csv?s=' . implode(',', $currencies) . '&f=sl1&e=.csv');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        $content = curl_exec($curl);
        curl_close($curl);

        $lines = explode("\n", trim($content));
        foreach ($lines as $line) {
            $conversion_rate = substr($line, 11, 6);
        }

        return $conversion_rate;
    }

}
