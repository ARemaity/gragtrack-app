<?php
require_once (dirname(__FILE__,2)).'/base.php';
require_once (dirname(__FILE__,2)) . '/vendor/autoload.php';
require_once __DIR__ . '/oauthn.php';

$newdb=new DB_init();

$client=getOauth2Client();


  $analytics = new Google_Service_Analytics($client); //versin v3 (for realtime api )

  $optParams = array(
     'dimensions' => 'rt:medium');
 
 try {
   $results = $analytics->data_realtime->get(
       'ga:118245634',
       'rt:activeUsers',
       $optParams);
   // Success. 
 } catch (apiServiceException $e) {
   // Handle API service exceptions.
   $error = $e->getMessage();
 }
 
 
 printRealtimeReport($results);
 
 /**
  * 2. Print out the Real-Time Data
  * The components of the report can be printed out as follows:
  */
 
 function printRealtimeReport($results) {

    $totals = $results->getTotalsForAllResults();
 
   foreach ($totals as $metricName => $metricTotal) {
 
     $html =$metricTotal;
   }
 
   print $html;
 }
 
 

?>