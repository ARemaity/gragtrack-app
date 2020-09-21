<?php

require_once 'base.php';
// Set variables for our request
$shop = $_GET['shop'];
$api_key = "63c2fe83585200119d5aed905e2580a0";
$scopes = "read_orders,write_orders,read_products,write_products,write_reports";
$redirect_uri = DIR_ROOT."update-token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();