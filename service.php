

<?php

require 'vendor/autoload.php';
require_once 'base.php';
Sentry\init(['dsn' => 'https://f2ecff31c1454b4580e2e5b9fe19896c@o470315.ingest.sentry.io/5500784' ]);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['AID'])):
require_once 'base.php';
require_once DIR_INC.'DB_init.php';
$db=new DB_init();
$get_setup=$db->get_setup($_SESSION['AID'])['setup_level'];
switch ($get_setup) {
    case 2:



     break;
     case 3:
     
        break;
}

?>

<!DOCTYPE html>

<html lang="en" >
    <!--begin::Head-->
    <head>
        <meta charset="utf-8"/>
        <title>Metronic | Welcome page</title>
        <meta name="description" content=""/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->



        <!--begin::Global Theme Styles(used by all pages)-->
                    <link href="assets/plugins/global/plugins.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="assets/css/style.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->
                <!--end::Layout Themes-->

        <link rel="shortcut icon" href="assets/media/logos/favicon.ico"/>

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body id="kt_blockui_body" id="kt_body" style="background-color: #000"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading"  >
        
    	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Error-->
    <div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url(assets/media/error/bg1.jpg);">
	<!--begin::Content-->
	
	<p class="font-size-h1 text-muted font-weight-bold">
	Welcome to Gracktrack  
    </p>
    
    
    
	<!--end::Content-->
</div>
<!--end::Error-->
	</div>
<!--end::Main-->




    


    	<!--begin::Global Theme Bundle(used by all pages)-->
    	    	   <script src="assets/plugins/global/plugins.bundle.js?v=7.0.6"></script>
		    	   <script src="assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6"></script>
                   <script src="assets/js/scripts.bundle.js?v=7.0.6"></script>

        
            
            </body>
    <!--end::Body-->
</html>
<?php
else:
    //header("Location:".DIR_ROOT."error.php");
    echo "error:init.php:149";
    exit();
    
    
endif;
?>