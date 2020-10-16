<?php
#get all webhook except private as json to ajax callback 
if(isset($_POST)&&$_POST['get_log']==1){
@ob_end_clean();
require_once (dirname(__FILE__, 4)) . '/base.php';
require_once (dirname(__FILE__, 4)). '/' . DIR_INC . 'functions.php';
require_once (dirname(__FILE__, 4)) . '/' . DIR_INC . 'DB_logger.php';
$response=array();
$response['logs']=array();
$handler=array();
$message=array();
$time=0;
$isdata=0;
$newlogger=new DB_logger();
$get_log=$newlogger->get_webhook_log();
if(!empty($get_log)){

    $isdata=1;
    $response['isdata']=$isdata;
foreach($get_log as $log){

$time=timeago($log['created_at']);  

    $handler=array(

        'title'=>$log['tag'],
        'sub_title'=>$log['sub_tag'],
        'id'=>$log['Identifier'],
        'type'=>$log['type'],
        'time'=>$time



    );
    array_push($response['logs'],$handler);


}


echo json_encode($response);
}else{

    $message=array(
    
    
        'msg'=>$isdata,
    
    
    );
    array_push($response['isdata'],$message);
    echo json_encode($response);
}









}

