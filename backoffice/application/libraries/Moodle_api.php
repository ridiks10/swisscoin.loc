<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Moodle_api
{
    const STUDENT_ROLE = 5;

    var $token = null;
    var $server = null;
    var $dir = null;
    var $xmlrpc_url = null;
    var $login_url = null;

    var $package_levels = array(
        // swisscoi_veto.package => moodle.user_enrolments
        1 => 2, // - :: LEVEL 0 - ROOKIE
        2 => 4, // TRAINEE :: LEVEL 1 - TRAINEE
        3 => 5, // TESTER-50 :: LEVEL 2 - TESTER-50
        4 => 6, // TESTER-100 :: LEVEL 3 - TESTER-100
        5 => 7, // TESTER-250 :: LEVEL 4 - TESTER-250
        6 => 8, // TRADER-500 :: LEVEL 5 - TRADER-500
        7 => 9, // TRADER-1000 :: LEVEL 6 - TRADER-1000
        8 => 10, // CRYPTO-TRADER :: LEVEL 7 - CRYPTO-TRADER
        9 => 11, // CRYPTO-MAKLER :: LEVEL 8 - CRYPTO-MAKLER
        10 => 12, // CRYPTO-BROKER :: LEVEL 9 - CRYPTO-BROKER
        11 => 13, // CRYPTO-MANAGER :: LEVEL 10 - CRYPTO-MANAGER
        12 => 14, // CRYPTO-DIRECTOR :: LEVEL 11 - CRYPTO-DIRECTOR
    );

    var $error = '';

    public function __construct($config)
    {
        $this->token = $config['token'];
        $this->server = $config['server'];
        $this->dir = $config['dir'];
        $this->xmlrpc_url = $config['xmlrpc_url'];
        $this->login_url = $config['login_url'];
    }

    function sendRequest($function_name, $params)
    {
        $this->error = null;

        $request = xmlrpc_encode_request($function_name, array($params), array('encoding' => 'UTF-8'));

        $context = stream_context_create(array('http' => array(
            'method' => "POST",
            'header' => "Content-Type: text/xml",
            'content' => $request
        )));

        $path = $this->server . $this->dir . $this->xmlrpc_url . $this->token;
        $file = file_get_contents($path, false, $context);

        $response = xmlrpc_decode($file);

        if (!isset($response[0]) && isset($response['users'])) {
            $response = $response['users'];
        }

        if (is_array($response) && isset($response[0])) {
            $response = $response[0];
        }

        if ((!isset($response) || !is_array($response) || !array_key_exists('id', $response)) && isset($response['faultCode'])) {
            $this->error = 'Moodle error: '
                . (!empty($response['faultCode']) ? $response['faultString'] . ". Fault code: " . $response['faultCode'] : 'No info. Check parameters and permission') . ". <br />\r\n"
                . 'Server reply: ' . $file;

            return false;
        }

        return $response;
    }

    function getUser($fields)
    {
        if (!is_array($fields)) {
            $fields = array(
                'key' => 'id',
                'value' => $fields,
            );
        }

        // core_user_get_users_by_id
        // Required capabilities: moodle/user:viewdetails, moodle/user:viewhiddendetails, moodle/course:useremail, moodle/user:update
        return $this->sendRequest('core_user_get_users', array($fields));
    }

    function createUser($fields)
    {
        $fields = $this->filterFields($fields);

        // Required capability: moodle/user:create
        return $this->sendRequest('core_user_create_users', array($fields));
    }

    function updateUser($fields)
    {
        $fields = $this->filterFields($fields);

        // Required capability: moodle/user:update
        return $this->sendRequest('core_user_update_users', array($fields));
    }

    function getCourse($id) {
        $params = array('ids' => array($id));

        // Required capability: moodle/course:view,moodle/course:update,moodle/course:viewhiddencourses
        return $this->sendRequest('core_course_get_courses', $params);
    }

    function enrollUser($user_id, $course_id) {
        $user = $this->getUser($user_id);
        $course = $this->getCourse($course_id);
        if (empty($user) || empty($course)) {
            return false;
        }

        $params = array(
            'roleid' => self::STUDENT_ROLE,
            'userid' => $user_id,
            'courseid' => $course_id
        );

        // Required capability: enrol/manual:enrol
        return $this->sendRequest('enrol_manual_enrol_users', array($params));
    }

    function freeEnrollUser($user_id) {
        $course_id = reset($this->package_levels);
        return $this->enrollUser($user_id, $course_id);
    }

    function changeUserPackage($user_id, $package_id) {
        foreach($this->package_levels as $package => $course_id) {
            if ($package <= $package_id) {
                $this->enrollUser($user_id, $course_id);
            }
        }
    }

    function filterFields($fields)
    {
        $user_fields = array();
        if (isset($fields['id'])) $user_fields['id'] = $fields['id'];
        if (isset($fields['username'])) $user_fields['username'] = strtolower($fields['username']);
        if (isset($fields['password'])) $user_fields['password'] = $fields['password'];
        if (isset($fields['firstname'])) $user_fields['firstname'] = $fields['firstname'];
        if (isset($fields['lastname'])) $user_fields['lastname'] = $fields['lastname'];
        if (isset($fields['email'])) $user_fields['email'] = $fields['email'];
        if (isset($fields['city'])) $user_fields['city'] = $fields['city'];
        if (isset($fields['country'])) $user_fields['country'] = $fields['country'];
        if (isset($fields['auth'])) $user_fields['auth'] = $fields['auth'];
        if (isset($fields['preferences'])) $user_fields['preferences'] = $fields['preferences'];

        return $user_fields;
    }

    function getUserToken($user)
    {
        $path = $this->server . $this->dir . $this->login_url . '?username=' . strtolower($user['user_name']) . '&email=' . $user['email'];
        $response = file_get_contents($path);

        return json_decode($response);
    }

    function loginUser($credentials)
    {
        $path = $this->server . $this->dir . $this->login_url;
        if ($credentials->success) {
            $path = $path . '?user_id=' . $credentials->user->user_id . '&token=' . $credentials->user->token;
        }
        header('Location: ' . $path);
        exit();
    }
}