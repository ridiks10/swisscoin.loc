<?php

//require_once 'Inf_Model.php';

class Party_model extends Inf_Model {

    private $mailObj;

    public function __construct() {
        require_once 'Phpmailer.php';
        $this->mailObj = new PHPMailer();
        $this->load->model('validation_model');
    }

    public function getHostAllDetails($id) {
        $i = 0;
        $guest_detail = array();
        $this->db->select('*');
        $this->db->from('party_host');
        $this->db->where('status', 'yes');
        $this->db->where('added_by', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $guest_detail["$i"]["id"] = $row['id'];
            $guest_detail["$i"]["first_name"] = $row['first_name'];
            $guest_detail["$i"]["last_name"] = $row['last_name'];
            $guest_detail["$i"]["address"] = $row['address'];
            $guest_detail["$i"]["city"] = $row['city'];
            $guest_detail["$i"]["state"] = $row['state'];
            $guest_detail["$i"]["zip"] = $row['zip'];
            $guest_detail["$i"]["phone"] = $row['phone'];
            $guest_detail["$i"]["email"] = $row['email'];
            $guest_detail["$i"]["country"] = $row['country'];
            $guest_detail["$i"]["party_count"] = $row['party_count'];
            $guest_detail["$i"]["guest"] = $row['guest'];
            $guest_detail["$i"]["status"] = $row['status'];
            $i++;
        }
        return $guest_detail;
    }

    public function saveNewHostDetails($data, $id) {
        $this->db->set('first_name', $data['firstname']);
        $this->db->set('last_name', $data['lastname']);
        $this->db->set('address', $data['address']);
        $this->db->set('city', $data['city']);
        $this->db->set('state', $data['state']);
        $this->db->set('zip', $data['zip']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('email', $data['email']);
        $this->db->set('country', $data['country']);
        $this->db->set('added_by', $id);
        $res = $this->db->insert('party_host');
        return $res;
    }

    public function getEditHostDetails($id) {
        $party_host = "party_host";
        $query = $this->db->get_where($party_host, array('id' => $id));
        foreach ($query->result() as $row) {
            return $row;
        }
    }

    public function getGuestDetails($id) {
        $i = 0;
        $guest_detail = array();
        $this->db->select('*');
        $this->db->from('party_guest');
        $this->db->where('status', 'yes');
        $this->db->where('added_by', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $guest_detail["$i"]["id"] = $row['guest_id'];
            $guest_detail["$i"]["first_name"] = $row['first_name'];
            $guest_detail["$i"]["last_name"] = $row['last_name'];
            $guest_detail["$i"]["address"] = $row['address'];
            $guest_detail["$i"]["city"] = $row['city'];
            $guest_detail["$i"]["state"] = $row['state'];
            $guest_detail["$i"]["zip"] = $row['zip'];
            $guest_detail["$i"]["phone"] = $row['phone'];
            $guest_detail["$i"]["email"] = $row['email'];
            $guest_detail["$i"]["country"] = $row['country'];
            $guest_detail["$i"]["status"] = $row['status'];
            $i++;
        }
        return $guest_detail;
    }

    public function deleteHost($id) {
        $party_host = "party_host";
        $this->db->set('status', 'no');
        $this->db->where('id', $id);
        $res = $this->db->update($party_host);
        return $res;
    }

    public function editHostDetails($data, $edit_id) {
        $this->db->set('first_name', $data['firstname']);
        $this->db->set('last_name', $data['lastname']);
        $this->db->set('address', $data['address']);
        $this->db->set('city', $data['city']);
        $this->db->set('state', $data['state']);
        $this->db->set('zip', $data['zip']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('email', $data['email']);
        $this->db->set('country', $data['country']);
        $this->db->where('id', $edit_id);
        $res = $this->db->update('party_host');
        return $res;
    }

    public function saveNewGuestDetails($data, $id) {
       
        $this->db->set('first_name', $data['firstname']);
        $this->db->set('last_name', $data['lastname']);
        $this->db->set('address', $data['address']);
        $this->db->set('city', $data['city']);
        $this->db->set('state', $data['state']);
        $this->db->set('zip', $data['zip']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('email', $data['email']);
        $this->db->set('country', $data['country']);
        $this->db->set('added_by', $id);
        $res = $this->db->insert('party_guest');
        return $res;
    }

    public function getMaxGuestId() {
        $this->db->select_max('guest_id');
        $this->db->from('party_guest');
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $id = $row->guest_id;
        }
        return $id;
    }

    public function addGuestInvitedDetails($selected_id, $id, $party_id) {
        $host_id = $this->getHostId($party_id);
        $party = "party";
        $no = 1;
        $date = date("Y-m-d H:i:s");
        $res = FALSE;
        for ($i = 0; $i < count($selected_id); $i++) {
            $this->db->set('guest_id', $selected_id[$i]);
            $this->db->set('party_id', $party_id);
            $this->db->set('host_id', $host_id);
            $this->db->set('added_by', $id);
            $this->db->set('date', $date);
            $res = $this->db->insert('party_guest_invited');

            $this->db->set('guest_count', 'guest_count+' . $no, FALSE);
            $this->db->where('id', $party_id);
            $res1 = $this->db->update($party);
            $this->db->set('guest', 'guest' + $no, FALSE);
            $this->db->where('id', $host_id);
            $res2 = $this->db->update('party_host');
            if ($res) {
                $party_details = $this->getPartyDetails($party_id);
                $mail_id = $this->getGuestMailId($selected_id[$i]);
                $subject = 'Party Invitaion';
                if ($mail_id != "") {

///////send an invitation mail to guest for attend party////

                    $mailBodyDetails = '<html xmlns="http://www.w3.org/1999/xhtml">
                                                <head>
                                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                                          
                                                    <link href="http://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css">
                                                    <style> 
                                                                margin:0px;
                                                                padding:0px;
                                                    </style>

                                                </head>
                                                <body>
                                                    <div style="width:80%;padding:40px;border: solid 10px #D0D0D0;margin:50px auto;">
                                                        
                                                      </div>
                                                      <div style="width:100%;margin:15px 0 0 0;">
                                                          
                                                         <div style="clear:both;"></div>
                                                         
                                                           <p><font color=""> We are having a party and you are invited to attend!
                      So I will see you there. 
                    
                      Party starts ' . $party_details['from_date'] . ', at ' . $party_details['from_time'] . '
                      
                       Party End ' . $party_details['to_date'] . ' , at ' . $party_details['to_time'] . '                                                     
                           </font></p>            </div>
                                                        <div style="width:100%;margin:15px 0 0 0;">
                                                         Address:' . $party_details['address'] . '
                                                                 ' . $party_details['city'] . '
                                                        </div>
                                                        <div style="width:100%;margin:15px 0 0 0;">
                                                        Thank You...
                                                        </div>
                                                       </div>

                                                    </div>
                                                </body>
                                                
                                            </html>';

                    $this->sendEmail($mailBodyDetails, $mail_id, $party_details['host_name'], $subject);
                }
            }
        }
        return $res;
    }

    public function getHostId($id) {
        $this->db->select('host_id');
        $this->db->from('party');
        $this->db->where('id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            return $row->host_id;
        }
    }

    public function getPartyDetails($id) {
        $details = array();
        $this->db->select('from_date,to_date,from_time,to_time,host_id,address,city');
        $this->db->from('party');
        $this->db->where('id', $id);
        $res = $this->db->get();
        foreach ($res->result_array() as $row) {
            $details['from_date'] = $row['from_date'];
            $details['from_time'] = $row['from_time'];
            $details['to_date'] = $row['to_date'];
            $details['to_time'] = $row['to_time'];
            $details['host_id'] = $row['host_id'];
            $details['host_name'] = $this->getHostName($details['host_id']);
            $details['address'] = $row['address'];
            $details['city'] = $row['city'];
        }
        return $details;
    }

    public function getHostName($id) {
        $first_name = '';
        $last_name = '';
        $this->db->select('first_name,last_name');
        $this->db->from('party_host');
        $this->db->where('id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $first_name = $row->first_name;
            $last_name = $row->last_name;
        }
        return $first_name . " " . $last_name;
    }

    public function getGuestMailId($id) {
        $mail_id = "";
        $this->db->select('email');
        $this->db->from('party_guest');
        $this->db->where('guest_id', $id);
        $res = $this->db->get();
        foreach ($res->result() as $row) {
            $mail_id = $row->email;
        }
        return $mail_id;
    }

    public function sendEmail($mailBodyDetails, $email, $host_name, $subject) {
      
        $email_details = array();
        $email_details = $this->validation_model->getCompanyEmail();
       // $email = $this->getUserEmailId($user_id);
        $this->mailObj->From = $email_details["from_email"];

        $this->mailObj->FromName = $email_details["from_name"];

        $this->mailObj->Subject = $subject;
        $this->mailObj->IsHTML(true);

        $this->mailObj->ClearAddresses();
        $this->mailObj->AddAddress($email);


        $this->mailObj->Body = $mailBodyDetails;
        $res = $this->mailObj->send();
        $arr["send_mail"] = $res;
        if (!$res)
            $arr['error_info'] = $this->mailObj->ErrorInfo;

        return $res;
    }

    public function getProductOrder($id) {
        $order = array();
        $this->db->select('*');
        $this->db->from('party_guest_orders');
        $this->db->where('guest_id', $id);
        $res = $this->db->get();
        $i = 0;
        $cnt = $res->num_rows();
        if ($cnt > 0) {
            foreach ($res->result_array() as $row) {
                $order[$i]['party_id'] = $row['party_id'];

                $this->db->select('party_name');
                $this->db->from('party');
                $this->db->where('id', $id);
                $res1 = $this->db->get();
                foreach ($res1->result() as $row1) {
                    $order[$i]['party_name'] = $row1->party_name;
                }
                $order[$i]['product_id'] = $row['product_id'];
                $this->db->select('name');
                $this->db->from('party_product_description');
                $this->db->where('product_id', $order[$i]['product_id']);
                $res3 = $this->db->get();
                foreach ($res3->result() as $row2) {
                    $order[$i]['product_name'] = $row2->name;
                }
                $order[$i]['count'] = $row['product_count'];
                $order[$i]['total_amount'] = $row['total_amount'];
                $order[$i]['date'] = $row['date'];
                $order[$i]['processed'] = $row['processed'];
                $i++;
            }
        }
        return $order;
    }

    public function guestDetails($id) {
        $order = array();
        $this->db->select('*');
        $this->db->from('party_guest');
        $this->db->where('guest_id', $id);
        $res2 = $this->db->get();
        $i = 0;
        foreach ($res2->result() as $row2) {
            $order['first_name'] = $row2->first_name;
            $order['last_name'] = $row2->last_name;
            $order['guest_address'] = $row2->address;
            $order['guest_city'] = $row2->city;
            $order['guest_email'] = $row2->email;
            $i++;
        }
        return $order;
    }

    public function deleteGuest($id) {
        $party_guest = "party_guest";
        $this->db->set('status', 'no');
        $this->db->where('guest_id', $id);
        $res = $this->db->update($party_guest);
        return $res;
    }

    public function getEditGuestDetails($id) {
        $party_guest = "party_guest";
        $query = $this->db->get_where($party_guest, array('guest_id' => $id));
        foreach ($query->result() as $row) {
            return $row;
        }
    }

    public function editGuestDetails($data, $edit_id) {
        $this->db->set('first_name', $data['firstname']);
        $this->db->set('last_name', $data['lastname']);
        $this->db->set('address', $data['address']);
        $this->db->set('city', $data['city']);
        $this->db->set('state', $data['state']);
        $this->db->set('zip', $data['zip']);
        $this->db->set('phone', $data['phone']);
        $this->db->set('email', $data['email']);
        $this->db->set('country', $data['country']);
        $this->db->where('guest_id', $edit_id);
        $res = $this->db->update('party_guest');
        return $res;
    }

    public function getSelectedGuestDetails($id, $party_id) {
        $details = array();
        $final_details = array();
        $details = $this->getGuestDetails($id);

        $j = 0;
        for ($i = 0; $i < count($details); $i++) {
            $this->db->select('*');
            $this->db->from('party_guest_invited');
            $this->db->where('guest_id', $details["$i"]["id"]);
            $this->db->where('party_id', $party_id);
            $res = $this->db->get();
            $cnt = $res->num_rows();
            if ($cnt == 0) {
                $final_details["$j"]["id"] = $details["$i"]["id"];
                $final_details["$j"]["first_name"] = $details["$i"]["first_name"];
                $final_details["$j"]["last_name"] = $details["$i"]["last_name"];
                $final_details["$j"]["address"] = $details["$i"]["address"];
                $final_details["$j"]["city"] = $details["$i"]["city"];
                $final_details["$j"]["state"] = $details["$i"]["state"];
                $final_details["$j"]["zip"] = $details["$i"]["zip"];
                $final_details["$j"]["phone"] = $details["$i"]["phone"];
                $final_details["$j"]["email"] = $details["$i"]["email"];
                $final_details["$j"]["status"] = $details["$i"]["status"];
                $j++;
            }
        }
        return $final_details;
    }

    public function viewState($country_id = '', $option = '') {
        $state = '';
        $where = "status = '1' ORDER BY name";
        $this->db->select('*,');
        $this->db->from('zone');
        $this->db->where('country_id', $country_id);
        $this->db->where($where);
        $query = $this->db->get();

        if ($option == '') {
            $state = "<option value='' selected='selected'>Select State</option>";
        } else {
            $state = "<option value='' selected='selected'>$option</option>";
        }

        $i = 0;
        foreach ($query->result_array() as $row) {
            $State_Id = $row['zone_id'];
            $State_Name = $row['name'];

            if ($option != $State_Name) {
                $state .= "<option value='$State_Id'>$State_Name</option>";
            }
        }

        return $state;
    }

}
