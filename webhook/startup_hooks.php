
<?php
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$final_st=1;
require_once (dirname(__FILE__,2)).'/base.php';
require_once  (dirname(__FILE__,2)).'/'.DIR_INC.'DB_webhook.php';
require_once (dirname(__FILE__,2)).'/'.DIR_INC."WH_CRUD.php";
$wh=new WH_CRUD();
$newwh=new DB_webhook();
$wh_files=array(
array( 'name'=>'app_uninstalled'),
array( 'name'=>'orders_create'),
array( 'name'=>'orders_updated')
// array( 'name'=>'orders_paid'),
// array( 'name'=>'orders_cancelled'),
// array( 'name'=>'orders_updated')
);
$name='';
$PATH2='user/'.$_SESSION['AID'].'/receiver/';


if (!file_exists($PATH2)) {
    mkdir($PATH2, 0777, true);
}



foreach($wh_files as $sfile){


    $php_source = 'receiver-template/'.$sfile['name'].'.php';  

    $php_des = $PATH2.$sfile['name'].'.php'; 


    // $json_source = 'receiver-template/'.$sfile['name'].'.json'; 

    // $json_de = $PATH2.$sfile['name'].'.json'; 


    $text_source = 'receiver-template/'.$sfile['name'].'.txt';  

    $text_des = $PATH2.$sfile['name'].'.txt'; 


    if( !copy($php_source, $php_des) ) {  
        $final_st=0;
    }  
    else {  
        $path=DIR_NGROK.'webhook/'.$PATH2.$sfile['name'].'.php'; 
        $regsiter=$wh->register_wh(str_replace('_', '/', $sfile['name']),$path);
        $insert_wh=$newwh->create_weebhook($regsiter);
        if($insert_wh){
    
            // if(!is_file($json_de)){
              
            //      file_put_contents($json_de,'',LOCK_EX);     
            // }

            if(!is_file($text_des)){
         
                file_put_contents($text_des,'',LOCK_EX);    
    }


        }


    }  
      
    
      


}


$src = 'receiver-template/verify.php';  
$dest = $PATH2.'verify.php'; 
if( !copy($src, $dest) ) {  
    $final_st=0;
} 
echo $final_st;



?>

