<?php

class complaint extends Model {

    public function __construct() {

        parent::__construct();

        $this->load->model('validation_model');
    }

    public function getUserDatils($user_id) {
        $details = array();

        $arr = $this->getMobNumberAndEmail($user_id);
        $details["name"] = $arr["user_detail_name"];
        $details["mobile"] = $arr["user_detail_mobile"];
        $details["e_mail"] = $arr["user_detail_email"];

        return $details;
    }

    public function getMobNumberAndEmail($user_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }//IF ENDS [  if($this->table_prefix=="")  ]

        $user_details = $this->table_prefix . "user_details";
        $qr = "SELECT user_detail_name,user_detail_mobile,user_detail_email  FROM $user_details WHERE user_detail_refid = $user_id";
        $result = $this->selectData($qr, "ERROR ON USER DETAILS -56468485-033");
        $row = mysql_fetch_array($result);

        return $row;
    }

//FUNCTION ENDS [  public function getMobNumberAndEmail($user_id)   ]

    public function SubmitTicket($user_id, $priority, $dept, $query) {
        $this->begin();
        $date = date("Y-m-d");
        $ticket_number = $this->getTicketNumber($dept);
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }//IF ENDS  [ if($this->table_prefix=="")  ]

        $complaint_ticket_table = $this->table_prefix . "ticket_complaint_ticket_table";

        $qr = "INSERT INTO $complaint_ticket_table SET  ticket_no = '$ticket_number',
                                                        owner_id = $user_id ,
                                                        prority = ' $priority' ,
                                                        dept = '$dept',
                                                        status = 'registered',
                                                        date = '$date'";
        $res1 = $this->insertData($qr, "ERROR-67765557444444-44");

        $last_insert_id = mysql_insert_id();
        $complaint_query_table = $this->table_prefix . "complaint_query_table";

        $qr = "INSERT INTO $complaint_query_table SET    complaint_ref_id=$last_insert_id ,
                                                        query_text='you:$query'";
        $res2 = $this->insertData($qr, "ERROR-3ds3333-33");

        if ($res1 && $res2) {
            $this->commit();
            return $ticket_number;
        }//IF ENDS [  if($res1 && $res2)  ]
        else {
            $this->rollBack();
            return "fslse";
        }
    }

//FUNCTION ENDS [ public function SubmitTicket($user_id,$priority,$dept,$query)  ]

    public function getTicketNumber($dept) {
        $str = substr($dept, 0, 2);
        $str_up = strtoupper($str);
        do {
            $rand_no = rand(10000000, 99999999);
            $ticket_no = $str_up . $rand_no;
        } while ($this->ticketAvailable($ticket_no)); //DO WHILE ENDS


        return $ticket_no;
    }

//FUNCTION ENDS [ public function getTicketNumber($dept)   ]

    public function getMyTictkets($user_id) {
        $ticket_details = array();
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }

        $complaint_ticket_table = $this->table_prefix . "ticket_complaint_ticket_table";
        $qr = "SELECT complaint_id,ticket_no,dept,status,date FROM $complaint_ticket_table WHERE owner_id = $user_id ";
        $query = $this->selectData($qr, "ERROR-895670-4499400-4");
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $ticket_details[$i]["id"] = $row["complaint_id"];
            $ticket_details[$i]["ticket_no"] = $row["ticket_no"];
            $ticket_details[$i]["dept"] = $row["dept"];
            $ticket_details[$i]["date"] = $row["date"];
            $ticket_details[$i]["status"] = $row["status"];
            $i++;
        }//WHILE LOOP ENDS [  while ($row = mysql_fetch_array($query))  ]

        return $ticket_details;
    }

//FUNCTION ENDS [ public function getMyTictkets()  ]

    public function getComplaintDetails($ticket_id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }

        $complaint_ticket_table = $this->table_prefix . "ticket_complaint_ticket_table";
        $complaint_query_table = $this->table_prefix . "complaint_query_table";

        $qr = "SELECT ct.ticket_no,ct.prority,ct.dept,ct.status,ct.date,cq.query_text   FROM $complaint_ticket_table AS ct 
                                                                                        INNER JOIN  $complaint_query_table AS cq 
                                                                                        ON ct.complaint_id = cq.complaint_ref_id 
                                                                                        WHERE ct.complaint_id = '$ticket_id' 
                                                                                        ";
        $result = $this->selectData($qr, "ERROR-09803-30093");
        $row = mysql_fetch_array($result);

        return $row;
    }

//FUNCTION ENDS [ public function getComplaintDetails($ticket_id)  ]

    public function updateQueryDetails($ticket_id, $post_query, $query, $speeker) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }//IF ENDS [ if($this->table_prefix=="") ]

        $new_query = $query . "\n----------------------------------------------------------------------\n$speeker:" . $post_query;
        $new_query = addslashes($new_query);

        $complaint_query_table = $this->table_prefix . "complaint_query_table";

        $qr = "UPDATE $complaint_query_table SET query_text = '$new_query' WHERE complaint_ref_id  = $ticket_id";

        $res = $this->updateData($qr, "ERROR-094033-33");
        return $res;
    }

//FUNCTION ENDS [ public function updateQueryDetails($ticket_id,$post_query,$query,$speeker)  ]

    public function ticketAvailable($ticket_no) {
        $flag = FALSE;
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }//IF ENDS  [ if($this->table_prefix == "") ]

        $complaint_ticket_table = $this->table_prefix . "ticket_complaint_ticket_table";

        $qr = "SELECT count(*) as count FROM $complaint_ticket_table WHERE  ticket_no='$ticket_no' AND 	status != 'completed' AND status != 'rejected' ";
        $result = $this->selectData($qr, "ERROR-3238293823");
        $row = mysql_fetch_array($result);
        if ($row["count"] > 1) {
            $flag = TRUE;
        }// IF ENDS [ if($row["count"]> 1) ]

        return $flag;
    }

//FUNCTION ENDS [ public function ticketAvailable($ticket_no) ]

    public function getAllTickets() {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }

        $complaint_ticket_table = $this->table_prefix . "ticket_complaint_ticket_table";

        $qr = "SELECT complaint_id,ticket_no,owner_id,prority,dept,status,date FROM $complaint_ticket_table ORDER BY date DESC";
        $query = $this->selectData($qr, "ERROR-895670-4499400-4");
        $i = 0;
        while ($row = mysql_fetch_array($query)) {
            $ticket_details[$i]["id"] = $row["complaint_id"];
            $ticket_details[$i]["ticket_no"] = $row["ticket_no"];
            $ticket_details[$i]["owner_id"] = $row["owner_id"];

            $ticket_details[$i]["owner_user_name"] = $this->validation_model->IdToUserName($ticket_details[$i]["owner_id"]);
            $ticket_details[$i]["owner_full_name"] = $this->validation_model->getFullName($ticket_details[$i]["owner_id"]);

            $ticket_details[$i]["prority"] = $row["prority"];
            $ticket_details[$i]["dept"] = $row["dept"];
            $ticket_details[$i]["date"] = $row["date"];
            $ticket_details[$i]["status"] = $row["status"];
            $i++;
        }//WHILE LOOP ENDS [  while ($row = mysql_fetch_array($query))  ]

        return $ticket_details;
    }

//FUNCTION ENDS [ public function getAllTictkets()  ]

    public function UpdateComplaintStatus($ticket_id, $priority, $status) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION["table_prefix"];
        }

        $complaint_ticket_table = $this->table_prefix . "ticket_complaint_ticket_table";

        $qr = "UPDATE $complaint_ticket_table SET prority ='$priority' , status = '$status' WHERE complaint_id = $ticket_id";
        $res = $this->updateData($qr, "ERROR-576679404-44");

        return $res;
    }

//FUNCTION ENDS [ public function UpdateComplaintStatus($ticket_id,$priority,$status) ]
}

//CLASS ENDS [ class Complaint extends Model ]