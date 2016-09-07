<?php

class party_setup_model extends Inf_Model {

    public function __construct() {
        $this->load->model('country_state_model');
    }

    public function getAllHosts($user_id) {
        $host = array();
        $i = 0;
        $this->db->select('first_name');
        $this->db->select('last_name');
        $this->db->select('id');
        $this->db->from('party_host');
        $this->db->where('added_by', $user_id);
        $this->db->where('status', 'yes');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $host[$i]['first_name'] = $row['first_name'];
            $host[$i]['last_name'] = $row['last_name'];
            $host[$i]['id'] = $row['id'];

            $i++;
        }
        return $host;
    }

    public function getHostName($host_id) {
        $party_name = "NA";
        $i = 0;
        $this->db->select('first_name');
        $this->db->select('last_name');
        $this->db->select('id');
        $this->db->from('party_host');
        $this->db->where('id', $host_id);
        $this->db->where('status', 'yes');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $party_name = $row['first_name'] . ',' . $row['last_name'];
        }
        return $party_name;
    }

    public function addNewHost($new_host, $user_id) {
        $add_date = date('Y-m-d H:i:s');
        $this->db->set('first_name', $new_host['first_name']);
        $this->db->set('last_name', $new_host['last_name']);
        $this->db->set('address', $new_host['host_address']);
        $this->db->set('city', $new_host['host_city']);
        $this->db->set('state', $new_host['host_state']);
        $this->db->set('zip', $new_host['host_zip']);
        $this->db->set('phone', $new_host['host_phone']);
        $this->db->set('email', $new_host['host_email']);
        $this->db->set('country', $new_host['host_country']);
        $this->db->set('added_by', $user_id);
        $this->db->set('party_count', 0);
        $this->db->set('date', $add_date);
        $res = $this->db->insert('party_host');
        return $res;
    }

    public function getNewHostId($user_id) {
        $this->db->select_max('id');
        $this->db->where('added_by', $user_id);
        $this->db->from('party_host');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $id = $row->id;
        }
        return $id;
    }

    public function getUserAsHostId($user_id) {
        $this->db->select('*');
        $this->db->from('party_host');
        $this->db->where('added_by', $user_id);
        $this->db->where('user', 'yes');
        $res = $this->db->get();
        $cnt = $res->num_rows();
        if ($cnt > 0) {
            foreach ($res->result() as $row) {
                return $row->id;
            }
        } else {
            $this->db->select('*');
            $this->db->from('user_details');
            $this->db->where('user_detail_refid', $user_id);
            $res = $this->db->get();
            foreach ($res->result() as $row) {
                $name = $row->user_detail_name;
                $name = $name . " ";
                $pieces = explode(" ", $name);
                $first_name = $pieces[0];
                $last_name = $pieces[1];

                $address = $row->user_detail_address;
                if ($address == "") {
                    $address = "NULL";
                }
                $city = $row->user_detail_town;
                if ($city == "") {
                    $city = "NULL";
                }
                $state = $row->user_detail_state;
                if ($state == "") {
                    $state = "NULL";
                }
                $zip = $row->user_detail_pin;
                if ($zip == "") {
                    $zip = 0;
                }
                $phone = $row->user_detail_mobile;
                if ($phone == "") {
                    $phone = 0;
                }
                $email = $row->user_detail_email;
                if ($email == "") {
                    $email = "NULL";
                }
                $country = $row->user_detail_country;
                if ($country == "") {
                    $country = "NULL";
                }
            }
            $this->db->set('first_name', $first_name);
            $this->db->set('last_name', $last_name);
            $this->db->set('address', $address);
            $this->db->set('city', $city);
            $this->db->set('state', $state);
            $this->db->set('zip', $zip);
            $this->db->set('phone', $phone);
            $this->db->set('email', $email);
            $this->db->set('country', $country);
            $this->db->set('added_by', $user_id);
            $this->db->set('party_count', 0);
            $this->db->set('user', 'yes');
            $res1 = $this->db->insert('party_host');
            if ($res1) {
                $id = $this->getNewHostId($user_id);
            }
            return $id;
        }
    }

    public function getHostAddress($id) {
        $address = array();
        $this->db->select('address,city,state,zip,phone,email,country');
        $this->db->where('id', $id);
        $this->db->from('party_host');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $address['address'] = $row['address'];
            $address['city'] = $row['city'];
            $address['state'] = $row['state'];
            $address['zip'] = $row['zip'];
            $address['phone'] = $row['phone'];
            $address['email'] = $row['email'];
            $address['country'] = $row['country'];
        }
        return $address;
    }

    public function getUserAddress($user_id) {
        $address = array();
        $this->db->select('user_detail_address,user_detail_town,user_detail_state,user_detail_pin,user_detail_mobile,user_detail_country,user_detail_email');
        $this->db->where('user_detail_refid', $user_id);
        $this->db->from('user_details');
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $address['address'] = $row['user_detail_address'];
            $address['city'] = $row['user_detail_town'];
            $address['state1'] = $row['user_detail_state'];
            if ($address['state1'] != "") {
                $address['state'] = $this->country_state_model->getStateIDfromName($address['state1']);
            } else {
                $address['state'] = "";
            }
            $address['zip'] = $row['user_detail_pin'];
            $address['phone'] = $row['user_detail_mobile'];
            $address['email'] = $row['user_detail_email'];
            //$address['country1'] = $row['user_detail_country'];
            $address['country'] = $row['user_detail_country'];
        }
        return $address;
    }

    public function getStateIDfromName($name) {
        $this->db->select('zone_id');
        $this->db->from('zone');
        $this->db->where('name', $name);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->zone_id;
        }
    }

    public function insertNewParty($party, $party_name,$party_type='') {
        $file_name1 = "";
        $config['upload_path'] = './public_html/images/party_image/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['max_width'] = '1920';
        $config['max_height'] = '1080';

        $this->load->library('upload', $config);

        if ($_FILES['image1']['error'] != 4) {
            if (!$this->upload->do_upload('image1')) {
                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name1 = $data['upload_data']['file_name'];
            }
        } else {
            $file_name1 = "party_image.png";
        }
        if ($file_name1 != "") {
            $this->db->set('party_count', 'party_count +' . 1, FALSE);
            $this->db->where('id', $party['host_id']);
            $this->db->update('party_host'); //////////////update the no of party conducted by host

            $this->db->set('host_id', $party['host_id']);
            $this->db->set('from_date', $party['from_date']);
            $this->db->set('to_date', $party['to_date']);
            $this->db->set('from_time', $party['from_time']);
            $this->db->set('to_time', $party['to_time']);
           if($party_type=='host_address' || $party_type=='user_address')
           {
//            print_r($party['address']);die();
               $this->db->set('address', $party['address']['address']);
            $this->db->set('city', $party['address']['city']);
            $this->db->set('state', $party['address']['state']);
            $this->db->set('country', $party['address']['country']);
            $this->db->set('phone', $party['address']['phone']);
            $this->db->set('email', $party['address']['email']); 
            
           }
           else{
             $this->db->set('address', $party['address']);
            $this->db->set('city', $party['city']);
            $this->db->set('state', $party['state']);
            $this->db->set('country', $party['country']);
            $this->db->set('phone', $party['phone']);
            $this->db->set('email', $party['email']); 
             
           }
           $this->db->set('zip', $party['zip']);
             
           $this->db->set('added_by', $party['user_id']);
            $this->db->set('status', 'open');
            $this->db->set('guest_count', 0);
            $this->db->set('party_name', $party_name);
            $this->db->set('party_image', $file_name1);
            $this->db->set('address_type', $party['address_type']);
            $res = $this->db->insert('party');
            return $res;
        }
    }

    public function getCreatedPartyId() {
        $this->db->select_MAX('id');
        $this->db->from('party');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->id;
        }
    }

    public function getPartyDetails($party_id) {
        $obj_arr = array();
        $this->db->select('*');
        $this->db->from('party');
        $this->db->where('id', $party_id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $obj_arr["host_id"] = $row->host_id;
            $obj_arr["host_name"] = $this->getHostNameFromID($obj_arr["host_id"]);
            $obj_arr["from_date"] = $row->from_date;
            $obj_arr["to_date"] = $row->to_date;
            $obj_arr["from_time"] = $row->from_time;
            $obj_arr["to_time"] = $row->to_time;
            $obj_arr["address"] = $row->address;
            $obj_arr["city"] = $row->city;
            $obj_arr["state_id"] = $row->state;
            $obj_arr["state"] = $this->country_state_model->getStateNameFromId($obj_arr["state_id"]);
            $obj_arr["country_id"] = $row->country;
            $obj_arr["country"] = $this->country_state_model->getCountryNameFromId($obj_arr["country_id"]);
            $obj_arr["zip"] = $row->zip;
            $obj_arr["phone"] = $row->phone;
            $obj_arr["email"] = $row->email;
            $obj_arr["status"] = $row->status;
            $obj_arr["guest_no"] = $row->guest_count;
            $obj_arr["party_name"] = $row->party_name;
            $obj_arr["party_image"] = $row->party_image;
        }
        return $obj_arr;
    }

    public function getHostNameFromID($id) {
        $this->db->select('first_name,last_name');
        $this->db->from('party_host');
        $this->db->where('id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->first_name . " " . $row->last_name;
        }
    }

    public function getStateNameFromId($id) {
        $this->db->select('name');
        $this->db->from('zone');
        $this->db->where('zone_id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->name;
        }
    }

}
