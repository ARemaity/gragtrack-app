<?php
error_reporting(0); 
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
require  'vendor/autoload.php';
Sentry\init(['dsn' => 'https://39d1d0eb85fe44398afacfc9b6b57230@o471153.ingest.sentry.io/5502794',
'traces_sample_rate' => 1.0  ]);

    Sentry\configureScope(function (Sentry\State\Scope $scope): void {
        $scope->setUser(['username' =>'localhost']);
      });

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