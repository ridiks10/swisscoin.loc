<?php

class tabular_tree_class_model extends inf_model {

    function createChildren($id, $recursive = false) {
        $children = array();

        $this->db->select('id,father_id,active,user_name,position');
        $this->db->from('ft_individual');
        $this->db->where("father_id", $id);
        $this->db->order_by('position', 'ASC');
        $res = $this->db->get();

        $i = 0;
        foreach ($res->result_array() as $row) {
            $children[$i]["id"] = $row["id"];
            $children[$i]["father_id"] = $row["father_id"];
            $children[$i]["position"] = $row["position"];
            $children[$i]["active"] = $row["active"];
            $children[$i]["user_name"] = $row["user_name"];
            $children[$i]["current_status"] = $row["active"];
            $i++;
        }
        return $children;
    }

    function getUserFullName($user_id) {
        $user_name = "";
        $this->db->select('user_name');
        $this->db->from('ft_individual');
        $this->db->where('id', $user_id);
        $this->db->limit('1');
        $res = $this->db->get();

        foreach ($res->result() as $row) {
            $user_name = $row->user_name;
        }
        return $user_name;
    }

    function getChildren($data) {
        $tmp = $this->createChildren((int) $data);
        $result = array();

        $arr_len = count($tmp);
        for ($i = 0; $i < $arr_len; $i++) {
            $fullname = $this->getUserFullName($tmp[$i]["id"]);
            $id = $tmp[$i]["id"];

            if ($tmp[$i]["active"] == "yes") {
                $state = "true";
                $icon = "file.png";
                $title = $fullname;
            } else if ($tmp[$i]["active"] == "server") {
                $state = "false";
                $icon = "add_1.png";
                $title = lang("BLANK");
            } else {
                $state = "closed";
                $icon = "file.png";
                $title = $fullname;
            }
            if ($tmp[$i]["current_status"] == 'yes') {
                $active = " - ACTIVE";
            } else if ($tmp[$i]["current_status"] == 'no') {
                $active = " - INACTIVE";
            } else {
                $active = "BLANK";
            }


            $result[] = array(
                "title" => $title,
                "id" => $id,
                "icon" => $icon,
                "expand" => true
            );
        }
        return json_encode($result);
    }

    public function getUserId($user_name) {

        $this->load->model('validation_model');
        $user_id = $this->validation_model->userNameToId($user_name);
        return $user_id;
    }

}
