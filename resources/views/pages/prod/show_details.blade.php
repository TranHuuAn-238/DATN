@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img src="{{URL::to('/public/uploads/product/'.$value->product_image)}}" alt="" />
								<h3>ZOOM</h3>
							</div>
							<div id="similar-product" class="carousel slide" data-ride="carousel">
								
								  <!-- Wrapper for slides -->
								    <div class="carousel-inner">
										<div class="item active">
										  <!-- <a href=""><img src="{{URL::to('/public/frontend/images/similar1.jpg')}}" alt=""></a>
										  <a href=""><img src="{{URL::to('/public/frontend/images/similar2.jpg')}}" alt=""></a>
										  <a href=""><img src="{{URL::to('/public/frontend/images/similar3.jpg')}}" alt=""></a> -->
										</div>
										
										
									</div>

								  <!-- Controls -->
								  <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div>

						</div>
						<div class="col-sm-7">
							<div class="product-information"><!--/product-information-->
								<img src="images/product-details/new.jpg" class="newarrival" alt="" />
								<h2>{{$value->product_name}}</h2>
								<p>Mã sản phẩm: {{$value->product_id}}</p>
								<img src="images/product-details/rating.png" alt="" />

								<form action="{{URL::to('/save-cart')}}" method="post">
									{{ csrf_field() }}
									<input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
									<input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
									<input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
									<input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
									<input type="hidden" value="1" class="cart_product_qty_{{$value->product_id}}">
								<span>
									<span>{{number_format($value->product_price) . ' VNĐ'}}</span>
									<!-- <label>Số lượng:</label> -->
									<input name="qty" type="hidden" min="1" value="1" disabled/>
									<input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
									<button type="button" class="btn btn-fefault cart add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm vào giỏ
									</button>
								</span>
								</form>

								<p><b>Trạng thái:</b> Còn hàng</p>
								<p><b>Tình trạng:</b> Hàng mới</p>
								<p><b>Thương hiệu:</b> {{$value->brand_name}}</p>
								<p><b>Danh mục hàng:</b> {{$value->category_name}}</p>
								<a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
							</div><!--/product-information-->
						</div>
	</div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#details" data-toggle="tab">Giới thiệu sản phẩm</a></li>
								<li><a href="#companyprofile" data-toggle="tab">Thông số kỹ thuật</a></li>
								<!-- <li><a href="#tag" data-toggle="tab">Tag</a></li> -->
								<li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
							</ul>
						</div>
						<div class="tab-content active in">
							<div class="tab-pane fade" id="details" >
								<p>{!!$value->product_desc!!}</p>
								
								
								
							</div>
							
							<div class="tab-pane fade" id="companyprofile" >
								<p>{!!$value->product_content!!}</p>
								
								
							</div>
							
							<!-- <div class="tab-pane fade" id="tag" >
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery1.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery2.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery3.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="images/home/gallery4.jpg" alt="" />
												<h2>$56</h2>
												<p>Easy Polo Black Edition</p>
												<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
											</div>
										</div>
									</div>
								</div>
							</div> -->
							
							<div class="tab-pane fade" id="reviews" >
								<div class="col-sm-12">
									<ul>
										<li><a href=""><i class="fa fa-user"></i>User Name</a></li>
										<?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
										<li><a href=""><i class="fa fa-clock-o"></i><?= date('h:i a', time()); ?></a></li>
										<li><a href=""><i class="fa fa-calendar-o"></i><?= date('d-M-Y', time()); ?></a></li>
									</ul>
									<p>Hãy đánh giá sản phẩm để giúp những khách hàng khác chọn được sản phẩm tốt nhất!</p>
									<p><b>Viết đánh giá của bạn</b></p>
									
									<form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
										<textarea name="" ></textarea>
										<b>Bạn cảm thấy sản phẩm này như thế nào? (chọn sao nhé): </b> <img src="{{asset('public/frontend/images/rating.png')}}" alt="" />
										<button type="button" class="btn btn-default pull-right">
											Đánh giá
										</button>
									</form>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
@endforeach
                    <div class="recommended_items"><!--recommended_items-->
						<h2 class="title text-center">Gợi ý cho bạn</h2>
						
						<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
							<div class="carousel-inner">
								<div class="item active">	
								@foreach($relate as $k => $val)
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="{{URL::to('public/uploads/product/'.$val->product_image)}}" alt="" height="200" width="150" />
													<h2>{{number_format($val->product_price).' VNĐ'}}</h2>
													<p>{{$val->product_name}}</p>
													<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a>
												</div>
						
											</div>
										</div>
									</div>
								@endforeach	
									
									
								</div>
								
								
								<!-- <div class="item">	
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="images/home/recommend1.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="images/home/recommend2.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="product-image-wrapper">
											<div class="single-products">
												<div class="productinfo text-center">
													<img src="images/home/recommend3.jpg" alt="" />
													<h2>$56</h2>
													<p>Easy Polo Black Edition</p>
													<button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
												</div>
											</div>
										</div>
									</div>
								</div> -->
							</div>
							 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
								<i class="fa fa-angle-left"></i>
							  </a>
							  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
								<i class="fa fa-angle-right"></i>
							  </a>			
						</div>
					</div><!--/recommended_items-->
@endsection