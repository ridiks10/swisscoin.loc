<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @property Menu $menu 
 * @property-read validation_model $validation_model Validation model :D
 * Try avoid to use this model as much as you can, because there is to much DB requests
 */
class Core_Inf_Controller extends CI_Controller {

    public $IP_ADDR;                        //IP ADDRESS
    public $SERVER_TIME;                    //SERVER TIME
    public $table_prefix;                   //TABLE PREFIX
    public $MLM_PLAN;                       //MLM PLAN
    public $CURRENT_CTRL = NULL;            //CURRENT CONTROLLER CLASS
    public $CURRENT_MTD = NULL;             //CURRENT CONTROLLER METHOD
    public $BASE_URL;                       //BASE URL
    public $CURRENT_URL;                    //CURRENT URL 
    public $CURRENT_URL_FULL;               //CURRENT URL WITH URL ARGUEMENTS
    public $REDIRECT_URL_FULL;               //CURRENT URL WITH URL ARGUEMENTS
    public $LEFT_MENU = NULL;               //BACKOFFICE LEFT MENU
    public $VIEW_DATA_ARR = array();        //DATA ARRAY FOR VIEW FILES
    public $ARR_SCRIPT = array();           //SCRPT ARRAY FOR VIEW FILES
    public $COMPANY_NAME;                   //COMAPNY NAME
    public $LANG_ARR = array();             //ARRAY OF ALL ACTIVE LANGUAGES
    public $LANG_ID;                        //CURRENT LANGUAGE ID
    public $LANG_NAME;                      //CURRENT LANGUAGE FOLDER NAME
    public $HEADER_LANG;                    //COMMON LANGUAGE ARRAY FOR HEADER TEXTS
    public $SESS_STATUS;                    //SESS STATUS
    public $LOG_USER_NAME = NULL;           //LOGGED USER NAME
    public $LOG_USER_ID = NULL;             //LOGGED USER ID
    public $LOG_USER_TYPE = NULL;           //LOGGED USER TYPE admin/distributer/employee
    public $ADMIN_USER_NAME = NULL;         //ADMIN USER NAME
    public $ADMIN_USER_ID = NULL;           //ADMIN USER ID
    public $CURRENCY_ARR = array();         //ARRAY OF ALL ACTIVE CURRENCIES
    public $DEFAULT_CURRENCY_VALUE;         //DEFAULT CURRENCY CONVERSION VALUE
    public $DEFAULT_CURRENCY_CODE;          //DEFAULT CURRENCY CODE
    public $DEFAULT_SYMBOL_LEFT = '';       //DEFAULT CURRENCY SYMBOL LEFT
    public $DEFAULT_SYMBOL_RIGHT = '';      //DEFAULT CURRENCY SYMBOL RIGHT
    Public $ADMIN_THEME_FOLDER;             //ADMIN THEME FOLDER
    Public $USER_THEME_FOLDER;              //USER THEME FOLDER
    public $FROM_MOBILE;                    //ACCESS FROM MOBILE
    public $MODULE_STATUS;                  //MODULE STATUS ARRAY
    public $SHUFFLE_STATUS;                 //SHUFFLE STATUS FOR BOARD PLAN
    public $LANG_STATUS;                    //MULTI LANGUAGE MODULE STATUS
    public $HELP_STATUS;                    //HELP LINK STATUS
    public $STATCOUNTER_STATUS;             //STAT COUNTER STATUS
    public $FOOTER_DEMO_STATUS;             //FOOTER DEMO TEXT STATUS
    public $CAPTCHA_STATUS;                 //CAPTCHA STATUS
    public $LIVECHAT_STATUS;                //LIVE CHAT STATUS
    public $COMMON_PAGES;                   //PAGES WITHOUT ADMIN/USER PREFIX IN URL
    public $NO_LOGIN_PAGES;                 //PAGES THAT DOESN'T NEED LOGGED IN SESSION
    public $NO_TRANSLATION_PAGES;           //PAGES THAT DOESN'T NEED TRANSLATION FILE
    public $NO_MODEL_CLASS_PAGES;           //PAGES THAT DOESN'T NEED MODEL CLASS
    public $CSRF_TOKEN_NAME;                //CSRF TOKEN NAME
    public $CSRF_TOKEN_VALUE;               //CSRF TOKEN VALUE
	public $TERMCONDITIONS;
	public $IMPRESSUM;

    function __construct() {
        
        parent::__construct();
        
        $this->initialize_public_variables();

        $this->set_session_time_out();

        $this->load_default_model_classes();

        $this->set_public_url_values();

        $this->check_request_from_mobile();

        if (!$this->FROM_MOBILE) {
            $this->set_logged_user_data();
        } else {
            $this->set_mobile_user_data();
        }

        $this->load_default_langauge();

        $this->load_default_currency();

        $this->load_admin_theme_folder();

        $this->load_user_theme_folder();

        $this->set_module_status_array();

        $this->auto_load_model_class();

        $this->set_live_chat_code();
    }

    function initialize_public_variables() {
        $this->SESS_STATUS = FALSE;
        $this->FROM_MOBILE = FALSE;
        $this->MODULE_STATUS = array();
        $this->MLM_PLAN = 'Unilevel';
        $this->LANG_ID = 1;
        $this->LANG_NAME = 'english';
        $this->table_prefix = '55_';
        $this->CURRENT_CTRL = $this->router->class;
        $this->CURRENT_MTD = $this->router->method;
        $this->CURRENT_URL_FULL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->REDIRECT_URL_FULL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->CURRENT_URL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->IP_ADDR = $this->input->server('REMOTE_ADDR');
        $this->BASE_URL = base_url();
        $this->PUBLIC_URL = $this->BASE_URL . "public_html/";
        $this->DEFAULT_CURRENCY_VALUE = 1;
        $this->DEFAULT_CURRENCY_CODE = 'EUR';
        $this->DEFAULT_SYMBOL_LEFT = '€';
        $this->DEFAULT_SYMBOL_RIGHT = '';
        $this->ADMIN_THEME_FOLDER = 'default';
        $this->USER_THEME_FOLDER = 'default';
        $this->COMMON_PAGES = array("login", "register", "auto_register", "captcha", "time", "social_invites");
        $this->NO_LOGIN_PAGES = array("login", "captcha", "backup", "time", "cron", "fix_issues", "test_mail", "oc_register", "social_invites", "register", "moodle");
        $this->NO_TRANSLATION_PAGES = array("auto_register", "captcha", "time", "fix_issues", "test_mail", "oc_register", "social_invites");
        $this->NO_MODEL_CLASS_PAGES = array("auto_register", "time", "test_mail", "ajax");
        $this->CSRF_TOKEN_NAME = $this->security->get_csrf_token_name();
        $this->CSRF_TOKEN_VALUE = $this->security->get_csrf_hash();

    }

    function set_session_time_out() {
        if ($this->CURRENT_CTRL != "time") {
            $this->session->set_userdata("inf_user_page_load_time", time());
        }
    }

    function load_default_model_classes() {
        $this->load->model('inf_model', '', TRUE);
        $this->load->model('validation_model', '', TRUE);
        $this->load->model('captcha_model', '', TRUE);
        $this->load->model('currency_model', '', TRUE);
        $this->load->model('country_state_model', '', TRUE);
        $this->load->model('mail_model', '', TRUE);
    }

    function set_public_url_values() {
        $this->CURRENT_URL = $this->CURRENT_CTRL . "/" . $this->CURRENT_MTD;
        $this->CURRENT_URL_FULL = "";
        $this->REDIRECT_URL_FULL = "";
        $uri_count = count($this->uri->segments);

        for ($i = 1; $i <= $uri_count; $i++) {
            $uri_segment = $this->uri->segments[$i];

            if ($uri_segment != 'en' && $uri_segment != 'es' && $uri_segment != 'ch' && $uri_segment != 'pt' && $uri_segment != 'de' && $uri_segment != 'po' && $uri_segment != 'tr' && $uri_segment != 'it' && $uri_segment != 'fr' && $uri_segment != 'ru') {

                $this->CURRENT_URL_FULL.= $uri_segment;

                if ($i == 1) {
                    if ($uri_segment != "admin" && $uri_segment != "user") {
                        $this->REDIRECT_URL_FULL.= $uri_segment;
                    }
                } else {
                    $this->REDIRECT_URL_FULL.= $uri_segment;
                }

                if (($i + 1) <= count($this->uri->segments)) {
                    $this->CURRENT_URL_FULL.="/";
                    $this->REDIRECT_URL_FULL.="/";
                }
            }
        }
    }

    function update_session_status() {
        if (in_array("register", $this->NO_LOGIN_PAGES)) {
            if ($this->checkSession()) {
                $this->SESS_STATUS = TRUE;
            }
        } else {
            $this->SESS_STATUS = TRUE;
        }
    }

    function check_request_from_mobile() {
        $post_array = array();
        if ($this->input->post()) {
            $post_array = $this->input->post();
        } else {
            if (isset($_GET["admin_username"]) && isset($_GET["user_name"]) && isset($_GET["from_mobile"])) {
                $post_array ["admin_username"] = $_GET["admin_username"];
                $post_array ["user_name"] = $_GET["user_name"];
                $post_array ["from_mobile"] = $_GET["from_mobile"];
            }
        }
        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);

        if (isset($post_array["from_mobile"]) && $post_array["from_mobile"]) {
            $this->FROM_MOBILE = true;
        }
    }

    function set_logged_user_data() {

        if ($this->checkSession()) {

            $logged_in_arr = $this->session->userdata('inf_logged_in');
            $this->LOG_USER_NAME = $logged_in_arr['user_name'];
            $this->LOG_USER_ID = $logged_in_arr['user_id'];
            $this->LOG_USER_TYPE = $logged_in_arr['user_type'];
            $this->ADMIN_USER_ID = $logged_in_arr['admin_user_id'];
            $this->ADMIN_USER_NAME = $logged_in_arr['admin_user_name'];
            $this->MLM_PLAN = $logged_in_arr['mlm_plan'];
            $this->table_prefix = $logged_in_arr['table_prefix'];

            $user_details = $this->validation_model->getUserDetails($this->LOG_USER_ID, $this->LOG_USER_TYPE);

            $email = $user_details['user_detail_email'];
            $affiliates_count = $user_details['affiliates_count'];
            $status = $user_details['status'];
            $profile_pic = $user_details['user_photo'];
            $rank_status = $user_details['rank_status'];
            $rank = $user_details['rank'];
            $rank_name = $user_details['rank_name'];

            $this->set("email", $email);
            $this->set('profile_pic', $profile_pic);
            $this->set('rank_status', $rank_status);
            $this->set('rank', $rank);
            $this->set('rank_name', $rank_name);
            $this->set("affiliates_count", $affiliates_count);
            $this->set("status", $status);
        }
    }

    function set_mobile_user_data() {

        $this->load->model("android/android_inf_model");
        $this->load->model("login_model");

        $post_array = array();
        if ($this->input->post()) {
            $post_array = $this->input->post();
        } else {
            if (isset($_GET["admin_username"]) && isset($_GET["user_name"]) && isset($_GET["from_mobile"])) {
                $post_array ["admin_username"] = $_GET["admin_username"];
                $post_array ["user_name"] = $_GET["user_name"];
                $post_array ["from_mobile"] = $_GET["from_mobile"];
            }
        }

        $post_array = $this->validation_model->stripTagsPostArray($post_array);
        $post_array = $this->validation_model->escapeStringPostArray($post_array);

        $admin_userid = '';
        $table_prefix = '';

        if (isset($post_array["admin_username"]) && isset($post_array["user_name"])) {

            $admin_username = $post_array["admin_username"];

            if (DEMO_STATUS == "yes") {
                $check_demo = $this->login_model->checkDemoDetails($admin_username);
            } else {
                $check_demo = $this->android_inf_model->getAdminDetails($admin_username);
            }

            if ($check_demo) {
                $admin_userid = $check_demo["id"];
                $table_prefix = $check_demo["id"] . "_";
                $this->session->set_userdata('inf_table_prefix', $table_prefix);
                $this->android_inf_model->setDBPrefix($table_prefix);
            } else {
                $user_details['status'] = false;
                $user_details['message'] = 'Invalid Demo or Admin UserName';
                echo json_encode($user_details);
                exit();
            }

            $user_name = $post_array["user_name"];
            $password = isset($post_array["password"]) ? $post_array["password"] : '';

            $login_detail = $this->android_inf_model->login_user($user_name, $password);

            if ($login_detail) {
                if ($password != '') {
                    $json_response['status'] = true;
                    $json_response['message'] = 'Login Success';
                    echo json_encode($json_response);
                    exit();
                }
                foreach ($login_detail as $row) {
                    $sess_array = array(
                        'user_id' => $row->user_id,
                        'user_name' => $row->user_name,
                        'user_type' => $row->user_type,
                        'admin_user_name' => $admin_username,
                        'admin_user_id' => $admin_userid,
                        'table_prefix' => $table_prefix,
                        'is_logged_in' => true
                    );
                }
            } else {
                $json_response['status'] = false;
                $json_response['message'] = 'Invalid Username or Password';
                echo json_encode($json_response);
                exit();
            }

            $this->inf_model->trackModule();
            $sess_array['mlm_plan'] = $this->inf_model->MODULE_STATUS['mlm_plan'];
            $this->session->set_userdata('inf_logged_in', $sess_array);

            $this->LOG_USER_NAME = $sess_array['user_name'];
            $this->LOG_USER_ID = $sess_array['user_id'];
            $this->LOG_USER_TYPE = $sess_array['user_type'];
            $this->ADMIN_USER_ID = $sess_array['admin_user_id'];
            $this->ADMIN_USER_NAME = $sess_array['admin_user_name'];
            $this->MLM_PLAN = $sess_array['mlm_plan'];
            $this->table_prefix = $sess_array['table_prefix'];

            $user_details = $this->validation_model->getUserDetails($this->LOG_USER_ID, $this->LOG_USER_TYPE);

            $email = $user_details['user_detail_email'];
            $affiliates_count = $user_details['affiliates_count'];
            $status = $user_details['status'];
            $profile_pic = $user_details['user_photo'];
            $rank_status = $user_details['rank_status'];
            $rank = $user_details['rank'];
            $rank_name = $user_details['rank_name'];

            $this->set("email", $email);
            $this->set('profile_pic', $profile_pic);
            $this->set('rank_status', $rank_status);
            $this->set('rank', $rank);
            $this->set('rank_name', $rank_name);
            $this->set("affiliates_count", $affiliates_count);
            $this->set("status", $status);
        } else {
            $user_details['status'] = false;
            $user_details['message'] = 'Access Denied';
            echo json_encode($user_details);
            exit();
        }
    }

    function load_default_langauge() {

        $this->LANG_ARR = $this->inf_model->getAllLanguages();
        $lang_arr_count = count($this->LANG_ARR);
        $uri_lang_code = $this->uri->segment(1);

        if (strlen($uri_lang_code) == 2) {
            $lang_active = false;
            for ($i = 0; $i < $lang_arr_count; $i++) {
                if ($uri_lang_code == $this->LANG_ARR[$i]['lang_code']) {
                    $lang_active = true;
                    $this->LANG_ID = $this->LANG_ARR[$i]['lang_id'];
                    $this->LANG_NAME = $this->LANG_ARR[$i]['lang_name_in_english'];
                    $this->inf_model->setDefaultLang($this->LANG_ID);
                    $this->session->set_userdata("inf_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
                }
            }
            if (!$lang_active) {
                $default_language_array = $this->inf_model->getProjectDefaultLang();
                $this->LANG_ID = $default_language_array['lang_id'];
                $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                $this->session->set_userdata("inf_language", array("lang_id" => $this->LANG_ID, "lang_name_in_english" => $this->LANG_NAME));
            }
        } else {
            if ($this->checkSession()) {
                if (!in_array($this->CURRENT_CTRL, $this->NO_LOGIN_PAGES)) {
                    $user_type = $this->LOG_USER_TYPE;
                    if ($user_type == "employee") {
                        $user_id = $this->ADMIN_USER_ID;
                    } else {
                        $user_id = $this->LOG_USER_ID;
                    }
                    $this->LANG_ID = $this->inf_model->getDefaultLang($user_id);
                    $this->LANG_NAME = $this->inf_model->getLanguageName($this->LANG_ID);
                }
            } else {
                if ($this->session->userdata("inf_language")) {
                    $language_array = $this->session->userdata("inf_language");
                    $this->LANG_ID = $language_array['lang_id'];
                    $this->LANG_NAME = $language_array['lang_name_in_english'];
                } else {
                    $default_language_array = $this->inf_model->getProjectDefaultLang();
                    $this->LANG_ID = $default_language_array['lang_id'];
                    $this->LANG_NAME = $default_language_array['lang_name_in_english'];
                }
            }
        }

        $langs = ['common'];

        if (!in_array($this->CURRENT_CTRL, $this->NO_TRANSLATION_PAGES)) {
            if (in_array($this->CURRENT_CTRL, $this->COMMON_PAGES)) {
                $langs[] = $this->CURRENT_CTRL;
            } else {
                $subfolder = "admin";
                if ($this->LOG_USER_TYPE != "admin" && $this->LOG_USER_TYPE != "employee") {
                    $subfolder = "user";
                }
                $langs[] = $subfolder . '/' . $this->CURRENT_CTRL;
            }
        }
        $this->lang->load($langs, $this->LANG_NAME);
    }

    function load_default_currency() {
        $user_id = $this->LOG_USER_ID;
        if ($user_id) {
            $multy_currency_status = $this->currency_model->getMultyCurrencyStatus();
            $default_admin_currency = $this->currency_model->getProjectDefaultCurrencyDetails();

            if ($multy_currency_status) {
                $conversion_status = $this->currency_model->getConversionStatus();
                if ($conversion_status == 'automatic') {
                    if ($default_admin_currency['last_modified'] < date("Y-m-d")) {
                        $this->currency_model->automaticCurrencyUpdate($default_admin_currency['code']);
                    }
                }
                $currency_details = $this->currency_model->getUserDefaultCurrencyDetails($user_id);
                if (!$currency_details) {
                    $currency_details = $default_admin_currency;
                }
                $this->DEFAULT_CURRENCY_VALUE = $currency_details['value'];
                $this->DEFAULT_CURRENCY_CODE = $currency_details['code'];
                $this->DEFAULT_SYMBOL_LEFT = $currency_details['symbol_left'];
                $this->DEFAULT_SYMBOL_RIGHT = $currency_details['symbol_right'];
            } else {
                $this->DEFAULT_CURRENCY_VALUE = 1;
                $this->DEFAULT_CURRENCY_CODE = '';
                $this->DEFAULT_SYMBOL_LEFT = '';
                $this->DEFAULT_SYMBOL_RIGHT = '';
            }
            $this->CURRENCY_ARR = $this->currency_model->getAllCurrency();
        }
    }

    function load_admin_theme_folder() {
        if ($this->checkSession()) {
            $theme_folder = $this->inf_model->getThemeFolder();
            $directories = glob(APPPATH . 'views/admin/layout/themes/*');
            foreach ($directories as $directory) {
                if ($theme_folder == basename($directory)) {
                    $this->ADMIN_THEME_FOLDER = $theme_folder;
                    break;
                }
            }
        }
    }

    function load_user_theme_folder() {
        if ($this->checkSession()) {
            $theme_folder = $this->inf_model->getUserThemeFolder();
            $directories = glob(APPPATH . 'views/user/layout/themes/*');
            foreach ($directories as $directory) {
                if ($theme_folder == basename($directory)) {
                    $this->USER_THEME_FOLDER = $theme_folder;
                    break;
                }
            }
        }
    }

    function set_module_status_array() {
        $set_module = false;
        if (DEMO_STATUS == "yes") {
            if ($this->LOG_USER_ID) {
                $set_module = TRUE;
            }
        } else {
            $set_module = TRUE;
        }


        if ($set_module) {

            $this->MODULE_STATUS = $this->inf_model->trackModule();

            if ($this->MODULE_STATUS ['mlm_plan'] == "Board") {
                $this->SHUFFLE_STATUS = $this->MODULE_STATUS ['shuffle_status'];
            }

            if (DEMO_STATUS == 'no' && $this->MODULE_STATUS ['replicated_site_status'] == "yes" && $this->MODULE_STATUS ['replicated_site_status_demo'] == "yes") {
                $this->NO_LOGIN_PAGES[] = "register";
                $this->load->model('register_model', '', TRUE);
            }

            $this->set("LANG_STATUS", $this->MODULE_STATUS ['lang_status']);
            $this->set("HELP_STATUS", $this->MODULE_STATUS ['help_status']);
            $this->set("STATCOUNTER_STATUS", $this->MODULE_STATUS ['statcounter_status']);
            $this->set("FOOTER_DEMO_STATUS", $this->MODULE_STATUS ['footer_demo_status']);
            $this->set("CAPTCHA_STATUS", $this->MODULE_STATUS ['captcha_status']);
            $this->set("LIVECHAT_STATUS", $this->MODULE_STATUS ['live_chat_status']);
        } else {
            $this->set("LANG_STATUS", 'yes');
            $this->set("HELP_STATUS", 'yes');
            $this->set("STATCOUNTER_STATUS", 'yes');
            $this->set("FOOTER_DEMO_STATUS", 'yes');
            $this->set("CAPTCHA_STATUS", 'yes');
            $this->set("LIVECHAT_STATUS", 'yes');
        }
    }

    function auto_load_model_class() {
        if (!in_array($this->CURRENT_CTRL, $this->NO_MODEL_CLASS_PAGES)) {
            $sub_directory = $this->uri->segment(1);
            if ($sub_directory == "super_admin") {
                $controler_class_model = $this->CURRENT_CTRL . "_model";
                $this->load->model("super_admin/$controler_class_model", '', TRUE);
            } else {
                $controler_class_model = $this->CURRENT_CTRL . "_model";
                $this->load->model($controler_class_model, '', TRUE);
            }
        }
    }

    function set_live_chat_code() {
        $CHAT_CODE = '';
        if ($this->checkSession() && $this->MODULE_STATUS ['live_chat_status'] == 'yes') {
            $CHAT_CODE = ' <!--Start of Tawk.to Script-->
                                <script type="text/javascript">
                                    var Tawk_API=Tawk_API||{ }, Tawk_LoadStart=new Date();
                                    (function(){
                                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                                    s1.async=true;
                                    s1.src="https://embed.tawk.to/5465a1c8eebdcbe3576a5f8f/default";
                                    s1.charset="UTF-8";
                                    s1.setAttribute("crossorigin","*");
                                    s0.parentNode.insertBefore(s1,s0);
                                    })();
                                </script>
                            <!--End of Tawk.to Script-->';
        }
        $this->set("CHAT_CODE", $CHAT_CODE);
    }
	function is_admin() {
		return isset( $this->LOG_USER_TYPE ) && $this->LOG_USER_TYPE === 'admin';
	}
    function load_langauge_scripts() {
        $this->set_array_scripts();
        $this->set_header_language();
    }

    function set_public_variables() {
		$this->load->model('swisscoin_model');
		$this->load->model('register_model');
		$this->set('TERMCONDITIONS', $this->register_model->getTermsConditions($this->LANG_ID) );
		$this->set('IMPRESSUM', $this->swisscoin_model->getImpressumContent() );
        $this->set('USER_AJAX_URL', base_url() . 'user/ajax' );
        $this->set('ADMIN_AJAX_URL', base_url() . 'admin/ajax' );
        $this->set("DEMO_STATUS", DEMO_STATUS);
        $this->set("REPLICATION_URL", REPLICATION_URL);
        $this->set("SITE_URL", SITE_URL);
        $this->set("IP_ADDR", $this->IP_ADDR);
        $this->set("BASE_URL", $this->BASE_URL);
        $this->set("MLM_PLAN", $this->MLM_PLAN);
        $this->set("SESS_STATUS", $this->SESS_STATUS);
        $this->set("CURRENT_CTRL", $this->CURRENT_CTRL);
        $this->set("CURRENT_MTD", $this->CURRENT_MTD);
        $this->set("CURRENT_URL", $this->CURRENT_URL);
        $this->set("CURRENT_URL_FULL", $this->CURRENT_URL_FULL);
        $this->set('LANG_ID', $this->LANG_ID);
        $this->set('LANG_NAME', $this->LANG_NAME);
        $this->set('LANG_ARR', $this->LANG_ARR);
        $this->set('LOG_USER_ID', $this->LOG_USER_ID);
        $this->set('LOG_USER_NAME', $this->LOG_USER_NAME);
        $this->set('LOG_USER_TYPE', $this->LOG_USER_TYPE);
        $this->set('ADMIN_USER_ID', $this->ADMIN_USER_ID);
        $this->set('ADMIN_USER_NAME', $this->ADMIN_USER_NAME);
        $this->set('COMPANY_NAME', $this->COMPANY_NAME);
        $this->set('MODULE_STATUS', $this->MODULE_STATUS);
        $this->set('LEFT_MENU', $this->LEFT_MENU);
        $this->set('PUBLIC_URL', $this->PUBLIC_URL);
        $this->set('DEFAULT_CURRENCY_VALUE', $this->DEFAULT_CURRENCY_VALUE);
        $this->set('DEFAULT_CURRENCY_CODE', $this->DEFAULT_CURRENCY_CODE);
        $this->set('DEFAULT_SYMBOL_LEFT', $this->DEFAULT_SYMBOL_LEFT);
        $this->set('DEFAULT_SYMBOL_RIGHT', $this->DEFAULT_SYMBOL_RIGHT);
        $this->set('CURRENCY_ARR', $this->CURRENCY_ARR);
        $this->set('SERVER_TIME', date("H:i:s"));
        $this->set('SERVER_DATE', date("l\, F jS\, Y "));
        $this->set('ADMIN_THEME_FOLDER', $this->ADMIN_THEME_FOLDER);
        $this->set('USER_THEME_FOLDER', $this->USER_THEME_FOLDER);
        $this->set('TABLE_PREFIX', $this->table_prefix);
        $this->set('CSRF_TOKEN_NAME', $this->CSRF_TOKEN_NAME);
        $this->set('CSRF_TOKEN_VALUE', $this->CSRF_TOKEN_VALUE);
    }

    function set_header_mailbox() {
        $this->load->model('mailSystem_model');
        $this->set("unread_mail", $this->mailSystem_model->countUnreadMessages($this->LOG_USER_ID, $this->LOG_USER_TYPE));
        $this->set("mail_content", $this->mailSystem_model->messageHeaderContent($this->LOG_USER_ID, $this->LOG_USER_TYPE, mailSystem_model::MESSAGE_UNREAD));
    }

    function set_demo_upgrade_status() {
        $session_data = $this->session->userdata('inf_logged_in');
        $table_prefix = $session_data['table_prefix'];
        $user_ref_id = str_replace("_", "", $table_prefix);
        $upgrade_cond = $this->inf_model->checkUpgrade($user_ref_id);
        $this->set('upgrade_cond', $upgrade_cond);
    }

    function set_flash_message() {
        $FLASH_ARR_MSG = $this->session->flashdata('MSG_ARR');
        if (isset($FLASH_ARR_MSG)) {
            $this->set("MESSAGE_DETAILS", $FLASH_ARR_MSG["MESSAGE"]["DETAIL"]);
            $this->set("MESSAGE_TYPE", $FLASH_ARR_MSG["MESSAGE"]["TYPE"]);
            $this->set("MESSAGE_STATUS", $FLASH_ARR_MSG["MESSAGE"]["STATUS"]);
        } else {
            $this->set("MESSAGE_STATUS", FALSE);
        }
    }

    function set_array_scripts() {
        $this->VIEW_DATA_ARR['ARR_SCRIPT'] = $this->inf_model->getURLScripts($this->CURRENT_URL);
    }

    function set_header_language() {
        $this->VIEW_DATA_ARR['HEADER_LANG'] = $this->HEADER_LANG;
    }

    function set_site_information() {
        $this->load->model('validation_model', '', TRUE);
        $site_info = $this->validation_model->getSiteInformation();
        if (!file_exists('public_html/images/logos/' . $site_info['logo'])) {
            $site_info['logo'] = 'logo_login_page.png';
        }
        $this->COMPANY_NAME = $site_info['company_name'];
        $this->set("site_info", $site_info);
    }

    function checkSession() {
        $flag = isset($this->session->userdata['inf_logged_in']) ? true : false;
        return $flag;
    }

    function checkAdminLogged() {
        if ($this->checkSession()) {
            $user_type = $this->LOG_USER_TYPE;
            if ($user_type != "admin" && $user_type != "employee")
                $this->redirect("", "../user/home");
        } else {
            $base_url = base_url();
            $login_link = $base_url . "login";
            if ($this->CURRENT_URL != "cleanup/clean_up" && $this->menu->UrlToId($this->CURRENT_URL)) {
                $this->session->set_userdata("redirect_url", $this->REDIRECT_URL_FULL);
            } else {
                $this->session->unset_userdata("redirect_url");
            }
            echo "You don't have permission to access this page. <a href='$login_link'>Login</a>";
            die();
        }
        return true;
    }

    function checkUserLogged() {

        if ($this->checkSession()) {
            $user_type = $this->LOG_USER_TYPE;
            if ($user_type != "distributor") {
                $this->redirect("", "../admin/home");
            }
        } else {
            $base_url = base_url();
            $login_link = $base_url . "login";
            if ($this->CURRENT_URL != "cleanup/clean_up" && $this->menu->UrlToId($this->CURRENT_URL)) {
                $this->session->set_userdata("redirect_url", $this->REDIRECT_URL_FULL);
            } else {
                $this->session->unset_userdata("redirect_url");
            }
            echo "You don't have permission to access this page. <a href='$login_link'>Login</a>";
            die();
        }
        return true;
    }

    function checkLogged() {
        $base_url = base_url();
        $login_link = $base_url . "login";

        if (!$this->checkSession()) {
            if ($this->CURRENT_URL != "cleanup/clean_up" && $this->menu->UrlToId($this->CURRENT_URL)) {
                $this->session->set_userdata("redirect_url", $this->REDIRECT_URL_FULL);
            } else {
                $this->session->unset_userdata("redirect_url");
            }
            die("You don't have permission to access this page. <a href='$login_link'>Login</a>");
        }
        return true;
    }

    public function check_replica_session() {
        $flag = isset($this->session->userdata['replica_session']) ? true : false;
        return $flag;
    }

    function check_menu_permitted() {
        if ($this->LOG_USER_TYPE == 'employee') {
            $user_id = $this->LOG_USER_ID;
            $assigned_menus = $this->inf_model->getAllAssignedMenus($user_id);
            if (isset($this->CURRENT_URL) && $this->CURRENT_URL != 'home/index') {
                $link_id = $this->inf_model->getURLID($this->CURRENT_URL);
                $menu_id = '';
                if ($link_id) {
                    $current_class = $this->router->fetch_class();
//ne sree
                    $status = $this->inf_model->checkMenuPermitted($link_id, 'perm_emp', $menu_id, $assigned_menus);
                    if (!$status && $current_class != 'ticket_system' && $current_class != 'employee') {
                        $msg = "you don't have permission to access this page";
                        $this->redirect($msg, 'home', false);
                    }
                }
            }
        }
    }

    function set($set_key, $set_value) {
        $this->VIEW_DATA_ARR[$set_key] = $set_value;
    }

    function setView() {
        $sub_directory = 'user';
        if ($this->LOG_USER_TYPE != 'distributor') {
            $sub_directory = 'admin';
        }
        if ($this->FROM_MOBILE) {
            $sub_directory = 'mobile';
        }
        if (in_array($this->CURRENT_CTRL, $this->COMMON_PAGES)) {
            $this->smarty->view($this->CURRENT_CTRL . '/' . $this->CURRENT_MTD . '.tpl', $this->VIEW_DATA_ARR);
        } else {
            $this->smarty->view("$sub_directory/" . $this->CURRENT_CTRL . '/' . $this->CURRENT_MTD . '.tpl', $this->VIEW_DATA_ARR);
        }
    }

    function redirect($msg, $page, $message_type = false, $MSG_ARR = array()) {

        $MSG_ARR["MESSAGE"]["DETAIL"] = $msg;
        $MSG_ARR["MESSAGE"]["TYPE"] = $message_type;
        $MSG_ARR["MESSAGE"]["STATUS"] = true;
        $this->session->set_flashdata('MSG_ARR', $MSG_ARR);

        $path = base_url();

        $split_pages = explode("/", $page);
        $controller_name = $split_pages[0];

        if ($this->checkSession()) {
            if (in_array($controller_name, $this->COMMON_PAGES)) {
                $path .= $page;
                redirect("$path", 'refresh');
                exit();
            } else {
                $user_type = $this->session->userdata['inf_logged_in']['user_type'];
                if ($user_type == "admin" || $user_type == "employee") {
                    $path .= "admin/" . $page;
                } else {
                    $path .= "user/" . $page;
                }
                redirect("$path", 'refresh');
                exit();
            }
        } else {
            if (in_array($controller_name, $this->COMMON_PAGES) && in_array($controller_name, $this->NO_LOGIN_PAGES)) {
                $path .= $page;
                redirect("$path", 'refresh');
                exit();
            } else {
                $path .= "login";
                redirect("$path", 'refresh');
                exit();
            }
        }
    }

}
