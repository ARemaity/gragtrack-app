<?php
error_reporting(E_ALL & ~E_NOTICE); 
require  'vendor/autoload.php';
Sentry\init(['dsn' => 'https://f2ecff31c1454b4580e2e5b9fe19896c@o470315.ingest.sentry.io/5500784',
'traces_sample_rate' => 1.0  ]);
define("DIR_ROOT", "https://localhost/gragtrack2/");
define("DIR_INC", "include/");
define("DIR_ADMIN", "admin/");
define("DIR_USER", "member/");
define("DIR_API", "API/");
define("APP_Name", "grag_app");
define("Parents","../");
define("Grand_Parents"," ../../");
define("parent_Grand_Parents","../../../");
define("DIR_NGROK",'https://6d67528ee341.ngrok.io/gragtrack2/');

?>