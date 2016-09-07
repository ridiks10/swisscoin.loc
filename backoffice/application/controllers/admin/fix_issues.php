<?php

require_once 'Inf_Controller.php';

class Fix_issues extends Inf_Controller {

    function __construct() {
        parent::__construct();
    }

    function fix_table_fields() {
        //use this function if you want to add any fields to any tables
        //this function will change the tables of existing demos too
        $table = "infinite_languages";
        $field_name = 'default_id';
        $result = $this->fix_issues_model->fixTableFields($table, $field_name);

        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    function fix_table_fields_config() {
        //use this function if you want to add any fields to any tables
        //this function will change the tables of existing demos too
        $result = $this->fix_issues_model->fixTableFieldsConfig();

        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    function fix_table_structure_config() {
        
        //use this function if you want to add any fields to any tables
        //this function will change the tables of existing demos too
        $table='_configuration';
        $field='pair_price';
        $result = $this->fix_issues_model->fixTableStructConfig($table,$field);
        $field1='referal_amount';
        $result1 = $this->fix_issues_model->fixTableStructConfig($table,$field1);
        $result2 = $this->fix_issues_model->fixTableStructConfig('_package','pair_value');
        $result3 = $this->fix_issues_model->fixTableStructConfig('_pin_request','pin_amount');
        $result4 = $this->fix_issues_model->fixTableStructConfig('_pin_used','pin_amount');
        $result5 = $this->fix_issues_model->fixTableStructConfig('_pin_used','pin_balance_amount');
        $result6 = $this->fix_issues_model->fixTableStructConfig('_ewallet_payment_details','used_amount');
        $result7 = $this->fix_issues_model->fixTableStructConfig('_configuration','pair_value');
        if ($result && $result1 && $result2 && $result3 && $result4 && $result5 && $result6 && $result7) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
//ALTER TABLE  `1427_configuration` CHANGE  `pair_price`  `pair_price` DOUBLE NOT NULL
    function fix_MLM_table_engine_type() {
        //set table Type to InnoDB for all MLM Tables
        $result = $this->fix_issues_model->fixTableEngineType();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_configuartion_dates() {
        //set table Type to start & end date to configuartion table

        $result = $this->fix_issues_model->fixConfigurationStartEndDates();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_amount_type_table() {
        $result = $this->fix_issues_model->fixAmountTypeTable();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_country_name_to_id() {
        $result = $this->fix_issues_model->fixCountryNameToId();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_mail_status_field() {
        $result = $this->fix_issues_model->fixMailStatusField();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_default_mail_content() {
        $result = $this->fix_issues_model->fixDefaultMailContent();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_default_mail_settings() {
        $result = $this->fix_issues_model->fixDefaultMailSettings();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function change_default_mail_id() {
        $result = $this->fix_issues_model->fixDefaultMailID();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_facebook_share_content() {
        $result = $this->fix_issues_model->fixFacebookShareContent();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function generate_new_opencart_tables() {

        $result = $this->fix_issues_model->generateNewOpencartTables();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_smtp_settings() {

        $result = $this->fix_issues_model->fixSMTPSettings();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_leg_amount_fields() {

        $result = $this->fix_issues_model->fixLegAmountFields();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    
    function fix_bv_field_name() {
        $result = $this->fix_issues_model->fixBvFieldName();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    
    function create_kb_attachments_table() {
        $result = $this->fix_issues_model->createKbAttachmentsTable();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    
        function rename_ticket_system() {
        $result = $this->fix_issues_model->renameTicketSystem();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
     
    function fix_activity_history_table() {
        $result = $this->fix_issues_model->fixActivityHistoryTable();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    
    function fix_module_status_table_field() {
        $result = $this->fix_issues_model->fixModuleStatusTableField();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

    function fix_plan_setting_menu() {
        $result = $this->fix_issues_model->fixPlanSettingsMenu();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    
    function fix_unilevel_list_menu() {
        $result = $this->fix_issues_model->fixUnilevelListMenu();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }
    function fix_Activity_history() {
        $result = $this->fix_issues_model->InsertActivityHistoryMenu();
        if ($result) {
            echo "Fixed";
        } else {
            echo "Failed";
        }
    }

}
