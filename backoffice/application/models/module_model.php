<?php

class module extends Model {

    public function selectUsers($letters) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $login_employee = $this->table_prefix . "login_employee";

        $letters = mysql_escape_string($letters);
        $qr = "SELECT user_id,user_name FROM " . $login_employee . " WHERE user_name like
    '" . $letters . "%' ";
        echo $qr;
        #echo "1$letters###select cust_id,cust_name from cust_details where cust_name
        // like '"
        //.$letters."%'|";
        $res = $this->selectData($qr, "Error on select cust_details-6544445536345667554452");
        while ($inf = mysql_fetch_array($res)) {
            echo $inf["login_id"] . "###" . $inf["user_name"] . "|";
        }
    }

    public function insertIntoUserPermission($arr_post) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $login_user = $this->table_prefix . "login_employee";



        $rr = array_keys($arr_post);
//echo "####".$rr."<br>";
        $module_permission = "";
        $user_name = $arr_post['user'];
        for ($i = 0; $i < count($arr_post); $i++) {
            if ($rr[$i] != "user" AND $rr[$i] != "permission") {
                $module_permission.= $arr_post[$rr[$i]] . ",";
            }
        }
        $module_permission = substr($module_permission, 0, strlen($module_permission) - 1);
        //echo $module_permission;
        $qr = "UPDATE  $login_user SET module_status='$module_permission' WHERE user_name='$user_name'";


        $res = $this->updateData($qr, "Error on Update login-90009");
    }

    public function viewPermission($user) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $login_user = $this->table_prefix . "login_employee";
        $qr = "SELECT module_status FROM $login_user WHERE user_name='$user' OR  user_id='$user'";
             $res = $this->selectData($qr, "Error on Select login-09");

        $row = mysql_fetch_array($res);
        $permission = $row['module_status'];
      
        $arr = explode(",", $permission);
       
        $c = 0;
        $main_menu = "";
        $other_menu = "";
        $main_count = 0;
        $other_count = 0;
        $other_menu_arr = Array();
        $menu_arr = Array();
        $main_menu2 = Array();
        $sub_menu_arr = Array();
        for ($i = 0; $i < count($arr); $i++) {
            $menu = explode("#", $arr[$i]);
            $m = "m";

            if ($menu[0] == $m) {
             
                $menu_arr[$main_count++] = $menu[1];
            } else if ($menu[0] == "o") {
               
                $other_menu_arr[$other_count++] = $menu[1];
            } else {
               
                $sub_menu_main_arr[$c] = $main_menu[0];
                $sub_menu_arr[$c++] = $menu[1];
            }
        }
      
        $menu_id = $this->getMenuId($this->table_prefix);

        while ($row = mysql_fetch_array($menu_id)) {
            $text = $this->getMenuTextId($row['id'], $this->table_prefix);
            $sub_row = $this->getsubMenuId($row['id'], $this->table_prefix);
       
            $c = mysql_num_rows($sub_row);

            $main_menu2 = "";
            $i = 0;
            $flage = "b";

            while ($row1 = mysql_fetch_array($sub_row)) {

                $text1 = $this->getSubmenuText($row1['sub_id'], $this->table_prefix);
              
                if (in_array($row1['sub_id'], $sub_menu_arr)) {

                    $main_menu2.="<td></td> <td><input type='checkbox' name='" . $row1['sub_id'] . "' id='" . $row1['sub_id'] . "' value='" . $row['id'] . "#" . $row1['sub_id'] . "'
                                       checked='checked' /> $text1 </td>";
                } else {


                    $main_menu2.="<td></td> <td><input type='checkbox' name='" . $row1['sub_id'] . "' id='" . $row1['sub_id'] . "' value='" . $row['id'] . "#" . $row1['sub_id'] . "'
                                               /> $text1 </td>";
                }
                $i++;
            }

            if ($c != 0) {
                $main_menu.= "<table><tr id='enq_main'><td>$text</td></tr> <tr id='enq'>" . $main_menu2 . "</tr></table>";
               
            } else {

                if (in_array($row['id'], $menu_arr)) {
                    $main_menu.="<table><tr><td align= 'center'><input type='checkbox' name='m" . $row['id'] . "k' id='" . $row['id'] . "' value='" . "m#" . $row['id'] . "'
                                       checked='checked' /> $text </td></tr></table>";
                } else {
                    $main_menu.=" <table><tr><td><input type='checkbox' name='" . $row['id'] . "' id='m" . $row['id'] . "k' value='" . "m#" . $row['id'] . "'
                                               /> $text </td></tr></table>";
                }
            }
        }
        $other_id = $this->getOtherId($this->table_prefix);
        while ($row = mysql_fetch_array($other_id)) {

            $text = $this->getOtherLink($row['id'], $this->table_prefix);
            if (in_array($row['id'], $other_menu_arr)) {
                $other_menu.=" <table><tr><td><input type='checkbox' name='" . $row['id'] . "' id='" . $row['id'] . "' value='" . "o#" . $row['id'] . "'
                                       checked='checked' /> $text </td></tr></table>";
            } else {
                $other_menu.=" <table><tr><td><input type='checkbox' name='" . $row['id'] . "' id='" . $row['id'] . "' value='" . "o#" . $row['id'] . "'
                                               /> $text </td></tr></table>";
            }
        }
        $submit_button = "<tr><td></td>
         <td><input type='submit' name='permission' id='permission'
                    value='Set Permission'> </td></tr></table></form>";

        $arrays['main_menu'] = $main_menu;
        $arrays['other_menu'] = $other_menu;
        $arrays['submit_button'] = $submit_button;

        return $arrays;
    }

    public function getnameToId($user_name) {
        $this->load->model('validation_model');
        $user_id = $this->validation_model->userNameToID($user_name);
        return $user_id;
    }

    public function getMenuTextId($menu_id, $table_prefix) {
        $menu = $table_prefix . "infinite_mlm_menu";
        $qr = "SELECT text FROM $menu WHERE id='" . $menu_id . "'";

        $res = $this->selectData($qr, "ERROR in menu12323443");
        $row = mysql_fetch_array($res);
        return $row['text'];
    }

    public function getOtherLink($menu_id, $table_prefix) {
        $menu = $table_prefix . "module_names";
        $qr = "SELECT module_name FROM $menu WHERE id = " . $menu_id;
        $res = $this->selectData($qr, "ERROR in menu12323443nbnb");

        $row = mysql_fetch_array($res);
        $arr = explode("/", $row['module_name']);
        return $arr[1];
    }

    public function getSubmenuText($menu_id, $table_prefix) {
        $menu = $table_prefix . "infinite_mlm_sub_menu";
        $qr = "SELECT sub_text FROM $menu WHERE sub_id='" . $menu_id . "'";
        // echo $qr."<br>";
        $res = $this->selectData($qr, "ERROR in menu12323443qqqw");
        $row = mysql_fetch_array($res);
        return $row['sub_text'];
    }

    public function getMenuNo($table_prefix) {
        $menu = $table_prefix . "infinite_mlm_menu";
        $qr = "SELECT COUNT(id) FROM $menu";
        $res = $this->selectData($qr, "ERROR on count selection");
        $row = mysql_fetch_array($res);
     
        return $row[0];
    }

    public function getMenuId($table_prefix) {
        $menu = $table_prefix . "infinite_mlm_menu";
        $qr = "SELECT id FROM $menu where perm_emp = 1";
        $res = $this->selectData($qr, "ERROR on count selection");
      
        return $res;
    }

    public function getsubMenuId($id, $table_prefix) {
        $menu = $table_prefix . "infinite_mlm_sub_menu";
        $qr = "SELECT  sub_id,sub_refid FROM $menu WHERE sub_refid =" . $id . " AND perm_emp = 1";
        $res = $this->selectData($qr, "ERROR on count selection");
      
        return $res;
    }

    public function getOtherId($table_prefix) {
        $menu = $table_prefix . "module_names";
        $qr = "SELECT id FROM $menu";
        $res = $this->selectData($qr, "ERROR on count selectionasasasas");
      
        return $res;
    }

    public function check($sub_row, $arr) {
        $c = mysql_num_rows($sub_row);
        $r = mysql_fetch_array($sub_row);
        if (in_array($r['sub_ref_id'], $arr)) {
            $c = 0;
        }
        return $c;
    }

}
