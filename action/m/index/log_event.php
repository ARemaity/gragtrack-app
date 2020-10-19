<?php
#get all webhook except private as json to ajax callback 
if(isset($_POST)&&$_POST['get_log']==1){
@ob_end_clean();
require_once (dirname(__FILE__, 4)) . '/base.php';
require_once (dirname(__FILE__, 4)). '/' . DIR_INC . 'functions.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'API_Event.php';
$response=array();
$response['logs']=array();
$handler=array();
$message=array();
$time=0;
$isdata=0;
$api=new API_Event();
$getevent=$api->get_all_event();
if(!is_null($getevent)){

    $isdata=1;
    $response['isdata']=$isdata;
foreach($getevent as $event){

$time=timeago($event['created_at']);  

    $handler=array(
'id'=>$event['id'],
'sub_id'=>$event['subject_id'],
'subject_type'=>$event['subject_type'],
'verb'=>$event['verb'],
'message'=>$event['message'],
'time'=>$time
    );
    array_push($response['logs'],$handler);


}


echo json_encode($response);
}else{

    $response['isdata']=$isdata;
    echo json_encode($response);
}









}

