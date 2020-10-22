<?php

if(isset($_POST)){

    $pagiantion=$_POST['pagination'];
    if (is_array($pagiantion)) {
        extract($pagiantion);
      
     }

    } 
?>