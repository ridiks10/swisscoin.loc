<?php

require_once 'user/Inf_Controller.php';

class moodle extends Inf_Controller {

    function export_user_to_academy() {

        echo "Start exporting users to Academy!\r\n";

        $this->load->model('moodle_model');

        $users = $this->moodle_model->getUserList();

        foreach($users as $user) {
            $user_detail = $this->moodle_model->getUserDetail($user->user_id);
            $new_user = $this->moodle_model->createUser($user, $user_detail);

            if (!empty($new_user)) {
                echo "User is added:\r\n";
                echo "    Id: " . $user->user_id . "\r\n";
                echo "    Name: " . $user->user_name . "\r\n";
                echo "    New id: " . $new_user['id'] . "\r\n";
            } else {
                echo "User is NOT added:\r\n";
                echo "    Id: " . $user->user_id . "\r\n";
                echo "    Name: " . $user->user_name . "\r\n";
            }
        }

        exit();
    }
}
