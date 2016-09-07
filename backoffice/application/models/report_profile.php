<?php
class report_profile extends Model
    {
        public function __construct()
            {
                $path_to_root = "../";
                require_once '../header/user_session.php';
                $report_name="Profile Report";
                include 'header.php';
                require_once '../class/Register.php';
                require_once '../class/Validation.php';
                require_once '../class/ToolTip.php';
                require_once '../class/Validation.php';
            }
        public function includeProfile($profileUpdate)
            {
                 $obj_vali=new Validation();
 $sess_obj->checkAdminLogged();
 $user_name=$_POST['user_name'];
 $user_id=$obj_vali->userNameToID($user_name);


$obj_reg=new Register();
$get_profile=new ToolTip();
$obj_sponser=new Validation();

$u_name=$_POST['user_name'];
$user_id=$obj_sponser->userNameToID($u_name);
$table_prefix=$_SESSION['table_prefix'];

       $user_details=$table_prefix."user_details";
        $ft_individual=$table_prefix."ft_individual";
$qr="select u.* from $user_details AS u
    INNER JOIN $ft_individual AS f ON u.user_detail_refid=f.id
    where user_detail_refid='".$user_id."'";
//echo $qr;
$details=$get_profile->getUserData($qr);
$sponser=$obj_sponser->getSponserIdName($u_name);

            }
    }