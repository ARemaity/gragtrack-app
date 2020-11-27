<?php
require_once (dirname(__FILE__,2)).'/base.php';
require_once (dirname(__FILE__,2)) . '/vendor/autoload.php';
require_once __DIR__ . '/oauthn.php';

$newdb=new DB_init();

$client=getOauth2Client();

// $analytics = new Google_Service_AnalyticsReporting($client); //version v4 (main api)
  $analytics = new Google_Service_Analytics($client); //versin v3 (for realtime api )
// include __DIR__.'/get_account_summary.php';
// include __DIR__.'/get_organic.php';
include __DIR__.'/get_realtime.php';
?>