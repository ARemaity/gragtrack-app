<?php

@require_once (dirname(__FILE__, 5)) . '/base.php';
@require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'SP_Product.php';
@require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'API_Product.php';
@require_once (dirname(__FILE__, 5)) . '/' . DIR_INC . 'API_Product_variant.php';

$apipr=new API_Product();
$apiprvr=new API_Product_variant();
$newpr=new SP_Product();
$best_seller=$newpr->best_seller();

$response=array();
$response['data']=array();
$data=array();
if(!is_null($best_seller)):
    $response['isdata']=1;
foreach($best_seller as $seller):
$name='no name';
$price=0;
$sales=0;
$imageURL=0;
$getpr=$apipr->get_pr_prp($seller['product_id']);
 $name=$getpr['title'];
 $variant_prp=$apiprvr->get_variant_prp2($seller['variant_id']);
 if(!is_null($variant_prp)){
     if(!empty($variant_prp['name'])){
         $name=$name.' '.$variant_prp['name'];
     }
     if(!empty($variant_prp['price'])){
        $price=$variant_prp['price'];
    }
    
 }
 $imageURL=$apipr->get_pr_image($seller['product_id'])['src'];
$sales=$seller['counts'];
 $data=array(
"title"=>$name,
"price"=>$price,
"sales"=>$sales,
"url"=>$imageURL
 );

 array_push($response['data'],$data);
endforeach;
else:
    $response['isdata']=0; 
endif;
echo json_encode($response);





