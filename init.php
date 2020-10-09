

<?php


require_once 'base.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['AID'])):
    
    require_once 'base.php';
    require_once DIR_INC.'DB_init.php';
    $db = new DB_init();
    $bool='False';
    $booln=False;
    $plan_name=$db->get_shop_plan($_SESSION['AID'])['plan'];
		if($plan_name=='unlimited'|| $plan_name=='enterprise'){
            $bool='TRUE';
            $booln=TRUE;
            
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
    <p class="font-size-h4  font-weight-normal">
	Lorem ipsum dolor sit amet consectetur adipisicing elit. Assumenda, illum veritatis! Ab recusandae nobis laudantium sed asperiores maxime doloribus aliquid. Porro error sint maxime, reiciendis nulla quam. Error, ex deserunt.
    </p>
    <p class="font-size-h3 text-muted font-weight-bold">
    Eligibility For advance report : 
    <?= $bool ?>
    </p>
    
    
	<!--end::Content-->
</div>
<!--end::Error-->
	</div>
<!--end::Main-->


<!--begin::Card-->
<div class="card card-custom"id="kt_blockui_card">
    <div class="card-header">
        <div class="card-title">
            <span class="card-icon"><i class="flaticon2-box-1 text-success"></i></span>
            <h3 class="card-label">Purchase</h3>
        </div>
    </div>
    <div class="card-body">

    <div id="plan_form_loader" class="alert alert-success" role="alert" style="display:none;">
            <div class="alert-text"><div class="spinner spinner-primary spinner-lg mr-15"></div></div>
        </div>
     
        <div class="row my-10">
            <!--begin: Pricing-->
            <div class="col-md-4 col-xxl-4 border-right-0 border-right-md border-bottom border-bottom-xxl-0">
                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                    <div class="d-flex flex-center position-relative mb-25">
                        <span class="svg svg-fill-primary opacity-4 position-absolute">
                            <svg width="175" height="200">
                                <polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
                            </svg>
                        </span>
                        <span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Safe.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M6.5,16 L7.5,16 C8.32842712,16 9,16.6715729 9,17.5 L9,19.5 C9,20.3284271 8.32842712,21 7.5,21 L6.5,21 C5.67157288,21 5,20.3284271 5,19.5 L5,17.5 C5,16.6715729 5.67157288,16 6.5,16 Z M16.5,16 L17.5,16 C18.3284271,16 19,16.6715729 19,17.5 L19,19.5 C19,20.3284271 18.3284271,21 17.5,21 L16.5,21 C15.6715729,21 15,20.3284271 15,19.5 L15,17.5 C15,16.6715729 15.6715729,16 16.5,16 Z" fill="#000000" opacity="0.3"/>
        <path d="M5,4 L19,4 C20.1045695,4 21,4.8954305 21,6 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,6 C3,4.8954305 3.8954305,4 5,4 Z M15.5,15 C17.4329966,15 19,13.4329966 19,11.5 C19,9.56700338 17.4329966,8 15.5,8 C13.5670034,8 12,9.56700338 12,11.5 C12,13.4329966 13.5670034,15 15.5,15 Z M15.5,13 C16.3284271,13 17,12.3284271 17,11.5 C17,10.6715729 16.3284271,10 15.5,10 C14.6715729,10 14,10.6715729 14,11.5 C14,12.3284271 14.6715729,13 15.5,13 Z M7,8 L7,8 C7.55228475,8 8,8.44771525 8,9 L8,11 C8,11.5522847 7.55228475,12 7,12 L7,12 C6.44771525,12 6,11.5522847 6,11 L6,9 C6,8.44771525 6.44771525,8 7,8 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>                    </div>
                    <span class="font-size-h1 d-block font-weight-boldest text-dark-75 py-2">Free</span>
                    <h4 class="font-size-h6 d-block font-weight-bold mb-7 text-dark-50">1 End Product License</h4>
                    <p class="mb-15 d-flex flex-column">
                        <span>Lorem ipsum</span>
                        <span>sed do eiusmod</span>
                        <span>magna siad enim aliqua</span>
                    </p>
                    <form method="post" action="action/ini/plan_regs.php" id="plan_regs">
                    <?php  
                    // tp:
                    ?>
                   <input id="submit_btn" type="hidden" name="tp" value="1">
              <?php

if($booln){

// if capable or not 
// isc:iscable
    echo '<input type="hidden" name="isc" value="1">';
}else{

    echo '<input type="hidden" name="isc" value="0">';

}

?>
      
                    <div class="d-flex justify-content-center">
                        <button type="submit" name="submit" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
                    </div>
    </form>
                </div>
            </div>
            <!--end: Pricing-->

            <!--begin: Pricing-->
            <div class="col-md-4 col-xxl-4 border-right-0 border-right-xxl border-bottom border-bottom-xxl-0">
                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                    <div class="d-flex flex-center position-relative mb-25">
                        <span class="svg svg-fill-primary opacity-4 position-absolute">
                            <svg width="175" height="200">
                                <polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
                            </svg>
                        </span>
                        <span class="svg-icon svg-icon-5x svg-icon-success"><!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Box3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M20.4061385,6.73606154 C20.7672665,6.89656288 21,7.25468437 21,7.64987309 L21,16.4115967 C21,16.7747638 20.8031081,17.1093844 20.4856429,17.2857539 L12.4856429,21.7301984 C12.1836204,21.8979887 11.8163796,21.8979887 11.5143571,21.7301984 L3.51435707,17.2857539 C3.19689188,17.1093844 3,16.7747638 3,16.4115967 L3,7.64987309 C3,7.25468437 3.23273352,6.89656288 3.59386153,6.73606154 L11.5938615,3.18050598 C11.8524269,3.06558805 12.1475731,3.06558805 12.4061385,3.18050598 L20.4061385,6.73606154 Z" fill="#000000" opacity="0.3"/>
        <polygon fill="#000000" points="14.9671522 4.22441676 7.5999999 8.31727912 7.5999999 12.9056825 9.5999999 13.9056825 9.5999999 9.49408582 17.25507 5.24126912"/>
    </g>
</svg><!--end::Svg Icon--></span>                    </div>
                    <span class="font-size-h1 d-block font-weight-boldest text-dark-75 py-2">69<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
                    <h4 class="font-size-h6 d-block font-weight-bold mb-7 text-dark-50">Business License</h4>
                    <p class="mb-15 d-flex flex-column">
                        <span>Lorem ipsum</span>
                        <span>sed do eiusmod</span>
                        <span>magna siad enim aliqua</span>
                    </p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
                    </div>
                </div>
            </div>
            <!--end: Pricing-->

            <!--begin: Pricing-->
            <div class="col-md-4 col-xxl-4 border-right-0 border-right-md border-bottom border-bottom-md-0">
                <div class="pt-30 pt-md-25 pb-15 px-5 text-center">
                    <div class="d-flex flex-center position-relative mb-25">
                        <span class="svg svg-fill-primary opacity-4 position-absolute">
                            <svg width="175" height="200">
                                <polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
                            </svg>
                        </span>
                        <span class="svg-icon svg-icon-5x svg-icon-danger"><!--begin::Svg Icon | path:assets/media/svg/icons/Home/Home-heart.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 C2.99998155,19.0000663 2.99998155,19.0000652 2.99998155,19.0000642 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z" fill="#000000" opacity="0.3"/>
        <path d="M13.8,12 C13.1562,12 12.4033,12.7298529 12,13.2 C11.5967,12.7298529 10.8438,12 10.2,12 C9.0604,12 8.4,12.8888719 8.4,14.0201635 C8.4,15.2733878 9.6,16.6 12,18 C14.4,16.6 15.6,15.3 15.6,14.1 C15.6,12.9687084 14.9396,12 13.8,12 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>                    </div>
                    <span class="font-size-h1 d-block font-weight-boldest text-dark-75 py-2">548<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
                    <h4 class="font-size-h6 d-block font-weight-bold mb-7 text-dark-50">Enterprise License</h4>
                    <p class="mb-15 d-flex flex-column">
                        <span>Lorem ipsum</span>
                        <span>sed do eiusmod</span>
                        <span>magna siad enim aliqua</span>
                    </p>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-danger text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
                    </div>
                </div>
            </div>
            <!--end: Pricing-->

     
            <!--end: Pricing-->
        </div>
    </div>
    <div class="modal fade" id="fetch_order_modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Fetch All Order</h5>
                </div>
                <div class="modal-body">
                    <p>We Need to fetch the Store's Order </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success font-weight-bold" id="fetch_choice1" value="0">Later</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="fetch_choice2" value="1">Fetch Now</button>
            
                </div>
            </div>
        </div>
</div>

        <!--begin::Global Config(global config for global JS scripts)-->
        <script>
            var KTAppSettings = {
    "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1200
    },
    "colors": {
        "theme": {
            "base": {
                "white": "#ffffff",
                "primary": "#6993FF",
                "secondary": "#E5EAEE",
                "success": "#1BC5BD",
                "info": "#8950FC",
                "warning": "#FFA800",
                "danger": "#F64E60",
                "light": "#F3F6F9",
                "dark": "#212121"
            },
            "light": {
                "white": "#ffffff",
                "primary": "#E1E9FF",
                "secondary": "#ECF0F3",
                "success": "#C9F7F5",
                "info": "#EEE5FF",
                "warning": "#FFF4DE",
                "danger": "#FFE2E5",
                "light": "#F3F6F9",
                "dark": "#D6D6E0"
            },
            "inverse": {
                "white": "#ffffff",
                "primary": "#ffffff",
                "secondary": "#212121",
                "success": "#ffffff",
                "info": "#ffffff",
                "warning": "#ffffff",
                "danger": "#ffffff",
                "light": "#464E5F",
                "dark": "#ffffff"
            }
        },
        "gray": {
            "gray-100": "#F3F6F9",
            "gray-200": "#ECF0F3",
            "gray-300": "#E5EAEE",
            "gray-400": "#D6D6E0",
            "gray-500": "#B5B5C3",
            "gray-600": "#80808F",
            "gray-700": "#464E5F",
            "gray-800": "#1B283F",
            "gray-900": "#212121"
        }
    },
    "font-family": "Poppins"
};
        </script>
        <!--end::Global Config-->

    	<!--begin::Global Theme Bundle(used by all pages)-->
    	    	   <script src="assets/plugins/global/plugins.bundle.js?v=7.0.6"></script>
		    	   <script src="assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6"></script>
                   <script src="assets/js/scripts.bundle.js?v=7.0.6"></script>

             
                   <script src="assets/js/pages/my-script/ini/jquery_cookie.js" type="text/javascript"></script>
<script>
  $.cookie('shop_name', '<?= $_SESSION['shop_name']?>');
</script>
                   
				<!--end::Global Theme Bundle-->

                <script src="assets/js/pages/features/miscellaneous/blockui.js?v=7.0.6"></script>

                <script src="assets/js/pages/my-script/ini/init-script.js" type="text/javascript" ></script>
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