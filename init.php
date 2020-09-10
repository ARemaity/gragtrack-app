

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION['AID'])):
    
    require_once 'base.php';
    require_once DIR_INC.'DB_init.php';
    $db = new DB_init();
    $bool='False';
    $plan_name=$db->get_shop_plan($_SESSION['AID'])['plan'];

		if($plan_name=='unlimited'|| $plan_name=='enterprise'){
            $bool='TRUE';
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
    <body  id="kt_body" style="background-color: #000"  class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading"  >

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

<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container ">
							<!--begin::Card-->
<div class="card">
	<!-- begin: custom background-->
	<div class="position-absolute w-100 h-50 rounded-card-top" style="background-color: #22B9FF"></div>
	<!-- end: custom background-->

	<div class="card-body position-relative">
		<h3 class="7 text-white text-center my-10 my-lg-15">Transparent & Simple Pricing</h3>

		<!-- begin: Tabs-->
		<div class="d-flex justify-content-center">
			<ul class="nav nav-pills nav-primary mb-10 mb-lg-20 bg-white rounded" id="pills-tab" role="tablist">
				<li class="nav-item p-0 m-0">
					<a class="nav-link active font-weight-bolder rounded-right-0 px-8 py-5" id="pills-tab-1" data-toggle="pill" href="#kt-pricing-2_content1"  aria-expanded="true" aria-controls="kt-pricing-2_content1" >
						Annual Plans
					</a>
				</li>
				<li class="nav-item p-0 m-0">
					<a class="nav-link font-weight-bolder rounded-left-0 px-8 py-5" id="pills-tab-2" data-toggle="pill" href="#kt-pricing-2_content2"  aria-expanded="true" aria-controls="kt-pricing-2_content2" >
						Monthly Plans
					</a>
				</li>
			</ul>
		</div>
		<!-- end: Tabs-->

		<div class="tab-content">
			<!-- begin: Tab pane-->
			<div class="tab-pane show active row text-center" id="kt-pricing-2_content1" role="tabpanel" aria-labelledby="pills-tab-1">
				<div class="card-body bg-white col-11 col-lg-12 col-xxl-10 mx-auto">
					<div class="row">
						<!-- begin: Pricing-->
						<div class="col-md-4">
							<div class="pt-30 pt-md-25 pb-15 px-5 text-center">
								<!--begin::Icon-->
								<div class="d-flex flex-center position-relative mb-25">
									<span class="svg svg-fill-primary opacity-4 position-absolute">
										<svg width="175" height="200">
											<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
										</svg>
									</span>
									<span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Home/Flower3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M1.4152146,4.84010415 C11.1782334,10.3362599 14.7076452,16.4493804 12.0034499,23.1794656 C5.02500006,22.0396582 1.4955883,15.9265377 1.4152146,4.84010415 Z" fill="#000000" opacity="0.3"/>
        <path d="M22.5950046,4.84010415 C12.8319858,10.3362599 9.30257403,16.4493804 12.0067693,23.1794656 C18.9852192,22.0396582 22.5146309,15.9265377 22.5950046,4.84010415 Z" fill="#000000" opacity="0.3"/>
        <path d="M12.0002081,2 C6.29326368,11.6413199 6.29326368,18.7001435 12.0002081,23.1764706 C17.4738192,18.7001435 17.4738192,11.6413199 12.0002081,2 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>								</div>
								<!--end::Icon-->

								<!--begin::Content-->
								<h4 class="font-size-h3 mb-10">Basic Plan</h4>
								<div class="d-flex flex-column line-height-xl pb-10">
									<span>1 Domain</span>
									<span>10 Users</span>
									<span>20 Copies</span>
									<span>Free Assets</span>
								</div>
								<span class="font-size-h1 d-block font-weight-boldest text-dark">69<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
								<div class="mt-7">
									<button type="button" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
								</div>
								<!--end::Content-->
							</div>
						</div>
						<!-- end: Pricing-->

						<!-- begin: Pricing-->
						<div class="col-md-4 border-x-0 border-x-md border-y border-y-md-0">
							<div class="pt-30 pt-md-25 pb-15 px-5 text-center">
								<!--begin::Icon-->
								<div class="d-flex flex-center position-relative mb-25">
									<span class="svg svg-fill-primary opacity-4 position-absolute">
										<svg width="175" height="200">
											<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
										</svg>
									</span>
									<span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
        <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>								</div>
								<!--end::Icon-->

								<!--begin::Content-->
								<h4 class="font-size-h3 mb-10">For Business</h4>
								<div class="d-flex flex-column line-height-xl mb-10">
									<span>10 Domains</span>
									<span>Unlimited Users</span>
									<span>Unlimited Copies</span>
									<span>Free Assets</span>
								</div>
								<span class="font-size-h1 d-block font-weight-boldest text-dark">169<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
								<div class="mt-7">
									<button type="button" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
								</div>
								<!--end::Content-->
							</div>
						</div>
						<!-- end: Pricing-->

						<!-- begin: Pricing-->
						<div class="col-md-4">
							<div class="pt-30 pt-md-25 pb-15 px-5 text-center">
								<!--begin::Icon-->
								<div class="d-flex flex-center position-relative mb-25">
									<span class="svg svg-fill-primary opacity-4 position-absolute">
										<svg width="175" height="200">
											<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
										</svg>
									</span>
									<span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>								</div>
								<!--end::Icon-->

								<!--begin::Content-->
								<h4 class="font-size-h3 mb-10">Enterprise</h4>
								<div class="d-flex flex-column line-height-xl mb-10">
									<span>Unlimited Domain</span>
									<span>Unlimited Users</span>
									<span>Unlimited Copies</span>
									<span>Free Assets</span>
								</div>
								<span class="font-size-h1 d-block font-weight-boldest text-dark">669<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
								<div class="mt-7">
									<button type="button" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
								</div>
								<!--end::Content-->
							</div>
						</div>
						<!-- end: Pricing-->
					</div>
				</div>
			</div>
			<!-- end: Tab pane-->

			<!-- begin: Tab pane-->
			<div class="tab-pane row text-center" id="kt-pricing-2_content2" role="tabpanel" aria-labelledby="pills-tab-2">
				<div class="card-body bg-white col-11 col-lg-12 col-xxl-10 mx-auto">
					<div class="row justify-content-center">
						<!-- begin: Pricing-->
						<div class="col-md-4">
							<div class="pt-30 pt-md-25 pb-15 px-5 text-center">
								<!--begin::Icon-->
								<div class="d-flex flex-center position-relative mb-25">
									<span class="svg svg-fill-primary opacity-4 position-absolute">
										<svg width="175" height="200">
											<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
										</svg>
									</span>
									<span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Home/Flower3.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <path d="M1.4152146,4.84010415 C11.1782334,10.3362599 14.7076452,16.4493804 12.0034499,23.1794656 C5.02500006,22.0396582 1.4955883,15.9265377 1.4152146,4.84010415 Z" fill="#000000" opacity="0.3"/>
        <path d="M22.5950046,4.84010415 C12.8319858,10.3362599 9.30257403,16.4493804 12.0067693,23.1794656 C18.9852192,22.0396582 22.5146309,15.9265377 22.5950046,4.84010415 Z" fill="#000000" opacity="0.3"/>
        <path d="M12.0002081,2 C6.29326368,11.6413199 6.29326368,18.7001435 12.0002081,23.1764706 C17.4738192,18.7001435 17.4738192,11.6413199 12.0002081,2 Z" fill="#000000" opacity="0.3"/>
    </g>
</svg><!--end::Svg Icon--></span>								</div>
								<!--end::Icon-->

								<!--begin::Content-->
								<h4 class="font-size-h3 mb-10">Basic Plan</h4>
								<div class="d-flex flex-column line-height-xl mb-10">
									<span>1 Domain</span>
									<span>10 Users</span>
									<span>20 Copies</span>
									<span>Free Assets</span>
								</div>
								<span class="font-size-h1 d-block font-weight-boldest text-dark">19<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
								<div class="mt-7">
									<button type="button" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
								</div>
								<!--end::Icon-->
							</div>
						</div>
						<!-- end: Pricing-->

						<!-- begin: Pricing-->
						<div class="col-md-4 border-x-0 border-x-md border-y border-y-md-0">
							<div class="pt-30 pt-md-25 pb-15 px-5 text-center">
								<!--begin::Icon-->
								<div class="d-flex flex-center position-relative mb-25">
									<span class="svg svg-fill-primary opacity-4 position-absolute">
										<svg width="175" height="200">
											<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
										</svg>
									</span>
									<span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"/>
        <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg><!--end::Svg Icon--></span>								</div>
								<!--end::Icon-->

								<!--begin::Content-->
								<h4 class="font-size-h3 mb-10">For Business</h4>
								<div class="d-flex flex-column line-height-xl mb-10">
									<span>10 Domains</span>
									<span>Unlimited Users</span>
									<span>Unlimited Copies</span>
									<span>Free Assets</span>
								</div>
								<span class="font-size-h1 d-block font-weight-boldest text-dark">49<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
								<div class="mt-7">
									<button type="button" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
								</div>
								<!--end::Content-->
							</div>
						</div>
						<!-- end: Pricing-->

						<!-- begin: Pricing-->
						<div class="col-md-4">
							<div class="pt-30 pt-md-25 pb-15 px-5 text-center">
								<!--begin::Icon-->
								<div class="d-flex flex-center position-relative mb-25">
									<span class="svg svg-fill-primary opacity-4 position-absolute">
										<svg width="175" height="200">
											<polyline points="87,0 174,50 174,150 87,200 0,150 0,50 87,0" />
										</svg>
									</span>
									<span class="svg-icon svg-icon-5x svg-icon-primary"><!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart2.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M3.28077641,9 L20.7192236,9 C21.2715083,9 21.7192236,9.44771525 21.7192236,10 C21.7192236,10.0817618 21.7091962,10.163215 21.6893661,10.2425356 L19.5680983,18.7276069 C19.234223,20.0631079 18.0342737,21 16.6576708,21 L7.34232922,21 C5.96572629,21 4.76577697,20.0631079 4.43190172,18.7276069 L2.31063391,10.2425356 C2.17668518,9.70674072 2.50244587,9.16380623 3.03824078,9.0298575 C3.11756139,9.01002735 3.1990146,9 3.28077641,9 Z M12,12 C11.4477153,12 11,12.4477153 11,13 L11,17 C11,17.5522847 11.4477153,18 12,18 C12.5522847,18 13,17.5522847 13,17 L13,13 C13,12.4477153 12.5522847,12 12,12 Z M6.96472382,12.1362967 C6.43125772,12.2792385 6.11467523,12.8275755 6.25761704,13.3610416 L7.29289322,17.2247449 C7.43583503,17.758211 7.98417199,18.0747935 8.51763809,17.9318517 C9.05110419,17.7889098 9.36768668,17.2405729 9.22474487,16.7071068 L8.18946869,12.8434035 C8.04652688,12.3099374 7.49818992,11.9933549 6.96472382,12.1362967 Z M17.0352762,12.1362967 C16.5018101,11.9933549 15.9534731,12.3099374 15.8105313,12.8434035 L14.7752551,16.7071068 C14.6323133,17.2405729 14.9488958,17.7889098 15.4823619,17.9318517 C16.015828,18.0747935 16.564165,17.758211 16.7071068,17.2247449 L17.742383,13.3610416 C17.8853248,12.8275755 17.5687423,12.2792385 17.0352762,12.1362967 Z" fill="#000000"/>
    </g>
</svg><!--end::Svg Icon--></span>								</div>
								<!--end::Icon-->

								<!--end::Content-->
								<h4 class="font-size-h3 mb-10">Enterprise</h4>
								<div class="d-flex flex-column line-height-xl mb-10">
									<span>Unlimited Domain</span>
									<span>Unlimited Users</span>
									<span>Unlimited Copies</span>
									<span>Free Assets</span>
								</div>
								<span class="font-size-h1 d-block font-weight-boldest text-dark">29<sup class="font-size-h3 font-weight-normal pl-1">$</sup></span>
								<div class="mt-7">
									<button type="button" class="btn btn-primary text-uppercase font-weight-bolder px-15 py-3">Purchase</button>
								</div>
								<!--end::Content-->
							</div>
						</div>
						<!-- end: Pricing-->
					</div>
				</div>
			</div>
			<!-- end: Tab pane-->
		</div>
	</div>
</div>
<!--end::Card-->
					</div>
        <!--end::Container-->
        <!-- HACK: this  -->
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
				<!--end::Global Theme Bundle-->


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