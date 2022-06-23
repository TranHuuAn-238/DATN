<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Huu An">
	<meta name="keywords" content=""/>

    <title><?php if(isset($meta_title)) { ?> {{$meta_title}} <?php } else { ?> Shop Xe Đạp Hữu An <?php } ?></title>
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
	
	<link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">

	<link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet">
	<link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="{{asset('public/frontend/images/xedaptabbar.ico')}}">
   
</head><!--/head-->

<body onload="muahangpopup()">
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> HOTLINE: 09852xxxxx</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> antran@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="{{URL::to('/trang-chu')}}"><img src="{{asset('public/frontend/images/logoo.png')}}" width="359" height="69" alt="logo" /></a>
						</div>
						<!-- <div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									USA
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canada</a></li>
									<li><a href="#">UK</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									DOLLAR
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">Canadian Dollar</a></li>
									<li><a href="#">Pound</a></li>
								</ul>
							</div>
						</div> -->
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								

								<?php
									$customer_id = Session::get('customer_id');
									if($customer_id != null) {
								?>
								<li><a href="{{URL::to('/history')}}"><i class="fa fa-bars"></i> Lịch sử đặt hàng</a></li>
								<?php
									}
								?>

								<li><a href="#"><i class="fa fa-star"></i> Yêu thích</a></li>

								<?php
									$customer_id = Session::get('customer_id');
									$shipping_id = Session::get('shipping_id');
									if($customer_id != null && $shipping_id == null) {
								?>
								<li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									} elseif($customer_id != null && $shipping_id != null) {
								?>
								<li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									} else {
								?>
								<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}
								?>

								<li><a href="{{URL::to('/show-cart')}}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
								<?php
									$customer_id = Session::get('customer_id');
									if($customer_id != null) {
								?>
								<!-- <li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-lock"></i> Đăng xuất</a></li> -->
								<li class="dropdown">
									<a data-toggle="dropdown" class="dropdown-toggle" href="#" style="color: #DC143C; font-weight: bold;">
										<i class="fa fa-user"></i>
										<span class="username">			
											<?php
												$customer_name = Session::get('customer_name');		
												if($customer_name) {
													echo $customer_name;
												}
											?>
										</span>
										<b class="caret"></b>
									</a>
									<ul class="dropdown-menu extended logout">
										<li><a href="#"><i class=" fa fa-suitcase"></i> Quản lý tài khoản</a></li>
										<li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li>
										<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
									</ul>
								</li>
								<?php
									} else {
								?>
								<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
								<?php
									}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="{{URL::to('/trang-chu')}}" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
							
									@foreach($category as $key => $cate)						
										<li><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></li>						
									@endforeach
										
                                    </ul>
                                </li> 
								<li class="dropdown"><a href="#">Tin tức</a>
                                    
                                </li> 
								<li><a href="#">Khuyến mãi</a></li>
								<li><a href="#">Dịch vụ</a></li>
								<li><a href="contact-us.html">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<form action="{{URL::to('/tim-kiem')}}" method="post">
							{{csrf_field()}}
							<div class="search_box pull-right">
								<input type="text" name="keywords_submit" value="{{ $keywords ?? '' }}" placeholder="Tìm kiếm sản phẩm..."/>
								<button type="submit" style="margin-top: 0;" name="search_items" class="btn btn-secondary btn-sm"><img src="{{asset('public/frontend/images/searchicon.png')}}" width="20" height="23" alt="" /></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>

						<style type="text/css">
                            img.img.img-responsive.img-slider {
                                height: 370px;
								/* padding-right: 75px; */
								margin-left: -50px;
                            }
                        </style>
						<div class="carousel-inner">
						<?php
							$i = 0;
						?>
						@foreach($slider as $key => $slide)
							<?php $i++; ?>
							<div class="item {{$i==1 ? 'active' : '' }}">
								<div class="col-sm-12">
									<img alt="{{$slide->slider_desc}}" src="{{asset('public/uploads/slider/'.$slide->slider_image)}}" width="100%" class="img img-responsive img-slider">
									
								</div>
							</div>
						@endforeach
						
							<!-- <div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>100% Responsive Design</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="{{('public/frontend/images/girl2.jpg')}}" class="girl img-responsive" alt="" />
									<img src="{{('public/frontend/images/pricing.png')}}"  class="pricing" alt="" />
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-6">
									<h1><span>E</span>-SHOPPER</h1>
									<h2>Free Ecommerce Template</h2>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
									<button type="button" class="btn btn-default get">Get it now</button>
								</div>
								<div class="col-sm-6">
									<img src="{{('public/frontend/images/girl3.jpg')}}" class="girl img-responsive" alt="" />
									<img src="{{('public/frontend/images/pricing.png')}}" class="pricing" alt="" />
								</div>
							</div> -->
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục sản phẩm</h2>
						<div class="panel-group category-products" id="accordian" style="border-color: #DEB887"><!--category-productsr-->
							@foreach($category as $key => $cate)
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title" style="text-align: center;"><a href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></a></h4>
								</div>
							</div>
							@endforeach
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu</h2>
							<div class="brands-name" style="border-color: #DEB887;">
								<ul class="nav nav-pills nav-stacked" style="text-align: center; font-weight: bold;">
									@foreach($brand as $key => $brand)
									<li><a href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> {{$brand->brand_name}}</a></li>
									@endforeach
								</ul>
							</div>
						</div><!--/brands_products-->
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					
					@yield('content')
					
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<!-- <div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>e</span>-shopper</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('public/frontend/images/iframe1.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('public/frontend/images/iframe2.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('public/frontend/images/iframe3.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
						
						<div class="col-sm-3">
							<div class="video-gallery text-center">
								<a href="#">
									<div class="iframe-img">
										<img src="{{('public/frontend/images/iframe4.png')}}" alt="" />
									</div>
									<div class="overlay-icon">
										<i class="fa fa-play-circle-o"></i>
									</div>
								</a>
								<p>Circle of Hands</p>
								<h2>24 DEC 2014</h2>
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{('public/frontend/images/map.png')}}" alt="" />
							<p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
						</div>
					</div>
				</div>
			</div>
		</div> -->
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<!-- <div class="col-sm-2">
						<div class="single-widget">
							<h2>Service</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Online Help</a></li>
								<li><a href="#">Contact Us</a></li>
								<li><a href="#">Order Status</a></li>
								<li><a href="#">Change Location</a></li>
								<li><a href="#">FAQ’s</a></li>
							</ul>
						</div>
					</div> -->
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Thông tin</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Giới thiệu về chúng tôi</a></li>
								<li><a href="#">Tin tức</a></li>
								<li><a href="#">Tuyển dụng</a></li>

							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Dịch vụ hậu mãi</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Chính sách bảo hành</a></li>
								<li><a href="#">Chính sách bảo mật</a></li>
								<li><a href="#">Chính sách đổi trả</a></li>
								<li><a href="#">Hình thức thanh toán</a></li>

							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="single-widget">
							<h2>Tổng đài hỗ trợ (Miễn phí gọi)</h2>
							<ul class="nav nav-pills nav-stacked">
								<li>Gọi mua: 1800.1061 (7:30 - 22:00)</li>
								<li>Kỹ thuật: 1800.1764 (7:30 - 22:00)</li>
								<li>Khiếu nại: 1800.1063 (8:00 - 21:30)</li>
								<li>Bảo hành: 1800.1065 (8:00 - 21:00)</li>

							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.1131663032347!2d105.80211910060017!3d21.028157472333213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab424a50fff9%3A0xbe3a7f3670c0a45f!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBHaWFvIHRow7RuZyBW4bqtbiB04bqjaQ!5e0!3m2!1svi!2s!4v1642262366636!5m2!1svi!2s" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
							<!-- <h2>About Shopper</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Your email address" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Get the most recent updates from <br />our site and be updated your self...</p>
							</form> -->
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row" >
					<!-- <marquee behavior="" direction="" scrollamount="3"> -->
					<p class="pull-left">Copyright © 2022. <b>Công ty cổ phần một thành viên Hữu An</b> <br> Địa chỉ: Số 3 Đ. Cầu Giấy, Láng Thượng, Đống Đa, Hà Nội, Việt Nam</p>
					<p class="pull-right"> Visit me <span><a target="_blank" href="https://www.facebook.com/profile.php?id=100012935530972">Tran Huu An</a></span></p>
					<!-- </marquee> -->
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
	

  
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
	<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>

	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
	<script src="{{asset('public/frontend/js/simple.money.format.js')}}"></script>

	<script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
	<script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
	<script src="{{asset('public/frontend/js/prettify.js')}}"></script>

	<script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>
	<script type="text/javascript">
	// $(document).ready(function() {
			$(document).on('click','.add-to-cart', function(){
				var id = $(this).data('id_product');
				var cart_product_id = $('.cart_product_id_' + id).val();
				var cart_product_name = $('.cart_product_name_' + id).val();
				var cart_product_image = $('.cart_product_image_' + id).val();
				var cart_product_price = $('.cart_product_price_' + id).val();
				var cart_product_qty = $('.cart_product_qty_' + id).val();
				var cart_product_quantity = $('.cart_product_quantity_' + id).val();
				var _token = $('input[name="_token"]').val();
				
				if(parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
					window.location.reload();
					alert('Không thành công, hãy đặt số lượng nhỏ hơn và thử lại');
				} else if(!parseInt(cart_product_qty)) {
					window.location.reload();
					alert('Không thành công, vui lòng nhập số lượng');
				} else if(parseInt(cart_product_qty) <= 0) {
				g	window.location.reload();
					alert('Không thành công, số lượng sản phẩm tối thiểu là 1');
				} else {
					$.ajax({
						url: '{{url('/add-cart-ajax')}}',
						method: 'POST',
						data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,_token:_token,cart_product_quantity:cart_product_quantity},
						success:function(data){
							swal({
									title: "Đã thêm vào giỏ hàng",
									text: "Bạn có thể chọn sản phẩm tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
									showCancelButton: true,
									cancelButtonText: "Xem tiếp",
									confirmButtonClass: "btn-success",
									confirmButtonText: "Giỏ hàng",
									closeOnConfirm: false
								},
								function() {
									window.location.href = "{{url('/show-cart')}}";
								});

						}
					});
				}
			});
		// });
			// redirect cart trong modal 
			$(document).on('click','.redirect-cart', function(){
				window.location.href = "{{url('/show-cart')}}";
			});

	</script>

	<script type="text/javascript">
		function muahangpopup() {
			let getId = document.getElementById('showpopup');
			if(getId) {
				swal("Thành công!", "Đơn hàng của bạn đã được đặt!", "success");
			}		
		}
	</script>

	<script type="text/javascript">
		$(document).ready(function(){
			$( "#slider-range" ).slider({
				orientation: "horizontal",
				range: true,
				min:{{$min_price_range}},
				max:{{$max_price_range}},
				values: [ {{$min_price}}, {{$max_price}} ],
				step:10000,
				slide: function( event, ui ) {
					$( "#amount_start" ).val(ui.values[ 0 ]).simpleMoneyFormat();
					$( "#amount_end" ).val(ui.values[ 1 ]).simpleMoneyFormat();

					$( "#start_price" ).val(ui.values[ 0 ]);
					$( "#end_price" ).val(ui.values[ 1 ]);
				}
				});

				$( "#amount_start" ).val($( "#slider-range" ).slider( "values", 0 )).simpleMoneyFormat();
				$( "#amount_end" ).val($( "#slider-range" ).slider( "values", 1 )).simpleMoneyFormat();
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$( "#slider-range2" ).slider({
				orientation: "horizontal",
				range: true,
				min:{{$min_price_range}},
				max:{{$max_price_range}},
				values: [ {{$min_price}}, {{$max_price}} ],
				step:10000,
				slide: function( event, ui ) {
					$( "#amount_start2" ).val(ui.values[ 0 ]).simpleMoneyFormat(); // input hiển thị khi slide
					$( "#amount_end2" ).val(ui.values[ 1 ]).simpleMoneyFormat();

					$( "#start_price2" ).val(ui.values[ 0 ]); // input hidden khi slide
					$( "#end_price2" ).val(ui.values[ 1 ]);
				}
				});

				$( "#amount_start2" ).val($( "#slider-range2" ).slider( "values", 0 )).simpleMoneyFormat(); // hiển thị ban đầu
				$( "#amount_end2" ).val($( "#slider-range2" ).slider( "values", 1 )).simpleMoneyFormat();
		});
	</script>
	
	<script src="{{asset('public/frontend/js/jquery.elevatezoom.min.js')}}"></script>
	<script>
		//<![CDATA[
		window.addEventListener('load', function() {
			$("#zoom_01").elevateZoom({
				zoomType: "lens",
				lensShape: "round",
				lensSize: 150
			});
		})
		//]]>
	</script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				gallery:true,
				item:1,
				loop:true,
				thumbItem:3,
				slideMargin:0,
				enableDrag: false,
				currentPagerPosition:'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
        		}   
    		});  
  		});
	</script>

	<!-- xem nhanh -->
	<script type="text/javascript">
		$('.xemnhanh').click(function() {
			var urll = location.href; // hoặc pathname (lấy url hiện tại)
			var product_id = $(this).data('id_product');
			var _token = $('input[name="_token"]').val();
			$.ajax({
				url:"{{url('/quickview')}}",
				method:"POST",
				dataType:"JSON",
				data:{urll:urll, product_id:product_id, _token:_token},
				success:function(data) {
					$('#product_quickview_title').html(data.product_name);
					$('#product_quickview_id').html(data.product_id);
					$('#product_quickview_price').html(data.product_price);
					$('#product_quickview_image').html(data.product_image);
					// $('#product_quickview_gallery').html(data.product_gallery);
					$('#product_quickview_desc').html(data.product_desc);
					$('#product_quickview_content').html(data.product_content);
					$('#product_quickview_value').html(data.product_quickview_value);
					$('#product_quickview_button').html(data.product_button);
				}
			});
		});
	</script>

	{{-- tích hợp bộ lọc select chọn nhanh Tỉnh, Thành & Quận, Huyện bằng Plugin districts.min.js --}}
	{{-- <script src="{{asset('public/frontend/js/districts.min.js')}}"></script>
	<script>
		//<![CDATA[
		if (address_2 = localStorage.getItem('address_2_saved')) {
			$('select[name="calc_shipping_district"] option').each(function() {
				if ($(this).text() == address_2) {
					$(this).attr('selected', '')
				}
			})
			$('input.billing_address_2').attr('value', address_2)
		}
		if (district = localStorage.getItem('district')) {
			$('select[name="calc_shipping_district"]').html(district)
			$('select[name="calc_shipping_district"]').on('change', function() {
				var target = $(this).children('option:selected')
				target.attr('selected', '')
				$('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
				address_2 = target.text()
				$('input.billing_address_2').attr('value', address_2)
				district = $('select[name="calc_shipping_district"]').html()
				localStorage.setItem('district', district)
				localStorage.setItem('address_2_saved', address_2)
			})
		}
		$('select[name="calc_shipping_provinces"]').each(function() {
			var $this = $(this),
			stc = ''
			c.forEach(function(i, e) {
				e += +1
				stc += '<option value=' + e + '>' + i + '</option>'
				$this.html('<option value="" selected disabled hidden>Tỉnh / Thành phố</option>' + stc)
				if (address_1 = localStorage.getItem('address_1_saved')) {
					$('select[name="calc_shipping_provinces"] option').each(function() {
						if ($(this).text() == address_1) {
							$(this).attr('selected', '')
						}
					})
					$('input.billing_address_1').attr('value', address_1)
				}
				$this.on('change', function(i) {
					i = $this.children('option:selected').index() - 1
					var str = '',
					r = $this.val()
					if (r != '') {
						arr[i].forEach(function(el) {
							str += '<option value="' + el + '">' + el + '</option>'
							$('select[name="calc_shipping_district"]').html('<option value="" selected disabled hidden>Quận / Huyện</option>' + str)
						})
						var address_1 = $this.children('option:selected').text()
						var district = $('select[name="calc_shipping_district"]').html()
						localStorage.setItem('address_1_saved', address_1)
						localStorage.setItem('district', district)
						$('select[name="calc_shipping_district"]').on('change', function() {
							var target = $(this).children('option:selected')
							target.attr('selected', '')
							$('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
							var address_2 = target.text()
							$('input.billing_address_2').attr('value', address_2)
							district = $('select[name="calc_shipping_district"]').html()
							localStorage.setItem('district', district)
							localStorage.setItem('address_2_saved', address_2)
						})
					} else {
						$('select[name="calc_shipping_district"]').html('<option value="" selected disabled hidden>Quận / Huyện</option>')
						district = $('select[name="calc_shipping_district"]').html()
						localStorage.setItem('district', district)
						localStorage.removeItem('address_1_saved', address_1)
					}
				})
			})
		})
		//]]>
	</script> --}}

	<script type="text/javascript">
		$(document).ready(function() {
			$('.choose').on('change',function(){
				var action = $(this).attr('id'); // lấy giá trị của thuộc tính id của select tỉnh/tp hoặc select quận/huyện để so sánh
				var ma_id = $(this).val(); // lấy value trong option
				var _token = $('input[name="_token"]').val();
				var result = '';
				if(action == 'city') {
					result = 'province';
				} else {
					result = 'wards';
				}
				$.ajax({
					url: "{{url('/select-delivery-home')}}",
					method: 'post',
					data: {action:action,ma_id:ma_id,_token:_token},
					success:function(data) {
						$('#' + result).html(data);
					}
				});
			});
		});
	</script>
</body>
</html>