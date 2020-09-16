<?php
//Get base class
require_once '../../'.'base.php';
//Get Reports class
require_once  '../../'.DIR_INC.'DB_init.php';
$insert_st=0;
$setup_st=0;

$plan=$_POST['tp'];
$iscapable=$_POST['isc'];
$db = new DB_init();
$Get_plan_att=$db->get_plan_att($plan);
// timezone from store prp then create datetime 
$date = new DateTime("now", new DateTimeZone($db->get_shop_timezone()['timezone']));
/// Hack: date will diff +4 sec to query be excuted
$current=$date->format('Y-m-d H:i:s');
$duration=$Get_plan_att['duration'];
$expired=date('Y-m-d H:i:s', strtotime($current. ' + '.$duration.' days'));
if($Get_plan_att['cost']<=0){


$insert=$db->insert_into_account($plan,$iscapable,$current,$expired);
    // thus trasnaction by default is zero no need to redirect to payment order 


  if($insert){
    $insert_st=1;
// update setup in 
  if($db->update_setup(2)){
    $setup_st=1;
    $link=DIR_ROOT;
    echo $insert_st.":".$setup_st;
  }else{

    echo $insert_st.":".$setup_st;
  }




}else{
// inserted failed/maybe its exist return false for the foreign key constraint
echo $insert_st.":".$setup_st;
  }

}else{



    // redirect to trasn by js file 
}

exit();
?>