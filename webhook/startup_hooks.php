
<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once (dirname(__FILE__,2)).'/base.php';
require_once  (dirname(__FILE__,2)).'/'.DIR_INC.'DB_webhook.php';
require_once (dirname(__FILE__,2)).'/'.DIR_INC."WH_CRUD.php";
$wh=new WH_CRUD();
$newwh=new DB_webhook();
$wh_files=array();
$handler=array(

    'name'=>'app_uninstalled'
);
array_push($wh_files,$handler);
$name='';
$message='';
$PATH2=$_SESSION['AID'].'/receiver/';


if (!file_exists($PATH2)) {
    mkdir($PATH2, 0777, true);
}



foreach($wh_files as $sfile){


    $php_source = 'receiver-template/'.$sfile['name'].'.php';  

    $php_des = $PATH2.$sfile['name'].'.php'; 


    $json_source = 'receiver-template/'.$sfile['name'].'.json'; 

    $json_de = $PATH2.$sfile['name'].'.json'; 


    $text_source = 'receiver-template/'.$sfile['name'].'.txt';  

    $text_des = $PATH2.$sfile['name'].'.txt'; 


    if( !copy($php_source, $php_des) ) {  
    $message.='0';
    }  
    else {  
        $path=DIR_NGROK.'webhook/'.$PATH2.$sfile['name'].'.php'; 
        $message.='1';
        $regsiter=$wh->register_wh("app/uninstalled",$path);
        $insert_wh=$newwh->create_weebhook($regsiter);
        if($insert_wh){
            if( !copy($json_source, $json_de) ) {  
                $message.='0';
            }  
            else { 
                $message.='1';
                if( !copy($text_source, $text_des) ) {  
                    $message.='0';
                }  
                else { 
                    $message.='1';
                }
            }
        }


    }  
      
    
      


}


$src = 'receiver-template/verify.php';  
$dest = $PATH2.'verify.php'; 
if( !copy($src, $dest) ) {  
    $message.='0';
}  else{

    $message.='1';    
}

echo $message;



?>

