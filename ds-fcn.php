<?php


function delete_session(){
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();

session_destroy();

}
?>