
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
);
$json_files=array(
    array( 'name'=>'abond_cart'),
    );
$name='';
$PATH2_rec='user/'.$_SESSION['AID'].'/receiver/';
$PATH2_json='user/'.$_SESSION['AID'].'/json/';

if (!file_exists($PATH2_rec)) {
    mkdir($PATH2_rec, 0777, true);
}

if (!file_exists($PATH2_json)) {
    mkdir($PATH2_json, 0777, true);
}

// create json file if not found
foreach($json_files as $jsfile){
    $path_json=$PATH2_json.$jsfile['name'].'.json';
    if(!file_exists($path_json)){

        file_put_contents($path_json,'',LOCK_EX);    
    
    }else{
        if (!unlink($path_json)) {  
            echo ("0");  
        }  
        else {  
            file_put_contents($path_json,'',LOCK_EX);
        }  
    }


}

foreach($wh_files as $sfile){


    $php_source = 'receiver-template/'.$sfile['name'].'.php';  

    $php_des = $PATH2_rec.$sfile['name'].'.php'; 


    // $json_source = 'receiver-template/'.$sfile['name'].'.json'; 

    // $json_de = $PATH2.$sfile['name'].'.json'; 


    $text_source = 'receiver-template/'.$sfile['name'].'.txt';  

    $text_des = $PATH2_rec.$sfile['name'].'.txt'; 

    

    if( !copy($php_source, $php_des) ) {  
        $final_st=0;
    }  
    else {  
        $path=DIR_NGROK.'webhook/'.$PATH2_rec.$sfile['name'].'.php'; 
        $regsiter=$wh->register_wh(str_replace('_', '/', $sfile['name']),$path);
        $insert_wh=$newwh->create_weebhook($regsiter);
        if($insert_wh){
    
            if(!is_file($text_des)){
         
                file_put_contents($text_des,'',LOCK_EX);    
    }


        }


    }  
      
    
      


}


$src = 'receiver-template/verify.php';  
$dest = $PATH2_rec.'verify.php'; 
if( !copy($src, $dest) ) {  
    $final_st=0;
} 
echo $final_st;



?>

