@extends('layout')
@section('content')
@foreach($product_details as $key => $value)
<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<!-- <div class="view-product">
								<img id="zoom_01" src="{{URL::to('/public/uploads/product/'.$value->product_image)}}" data-zoom-image="{{URL::to('/public/uploads/product/'.$value->product_image)}}" alt="" /> -->
								<!-- <h3>ZOOM</h3> -->
							<!-- </div> -->
							<!-- <div id="similar-product" class="carousel slide" data-ride="carousel"> -->
								
								  <!-- Wrapper for slides -->
								    <!-- <div class="carousel-inner">
										<div class="item active"> -->
										  <!-- <a href=""><img src="{{URL::to('/public/frontend/images/similar1.jpg')}}" alt=""></a>
										  <a href=""><img src="{{URL::to('/public/frontend/images/similar2.jpg')}}" alt=""></a>
										  <a href=""><img src="{{URL::to('/public/frontend/images/similar3.jpg')}}" alt=""></a> -->
										<!-- </div> -->
										
										
									<!-- </div> -->

								  <!-- Controls -->
								  <!-- <a class="left item-control" href="#similar-product" data-slide="prev">
									<i class="fa fa-angle-left"></i>
								  </a>
								  <a class="right item-control" href="#similar-product" data-slide="next">
									<i class="fa fa-angle-right"></i>
								  </a>
							</div> -->

							<style>
								/* cho thumbnail */
								.lSSlideOuter .lSPager.lSGallery img {
									display: block;
									height: 100px;
									max-width: 100%;
								}
								li.active {
									border: 1px solid #cccccc;
								}
							</style>
							<ul id="imageGallery">
							@foreach($gallery as $key => $gal)
								<li data-thumb="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" data-src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}">
									<img width="100%" height="285" src="{{asset('public/uploads/gallery/'.$gal->gallery_image)}}" alt="{{$gal->gallery_name}}" />
								</li>
							@endforeach
								
							</ul>
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
									<input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">
								<span>
									<span>{{number_format($value->product_price) . ' VNĐ'}}</span>
									<label>Số lượng:</label>
									<input name="qty" type="number" min="1" value="1" class="cart_product_qty_{{$value->product_id}}" required/>
									<input name="productid_hidden" type="hidden" value="{{$value->product_id}}" />
									<button type="button" class="btn btn-fefault cart add-to-cart" data-id_product="{{$value->product_id}}" name="add-to-cart">
										<i class="fa fa-shopping-cart"></i>
										Thêm vào giỏ
									</button>
								</span>
								</form>

								<p><b>Trạng thái: </b>
									<?php if($value->product_quantity > 0) { 
										echo 'Còn hàng'; 
									} else {
									?>
										<i style="color: red;">Tạm hết hàng</i>
									<?php
									}
									?>
								</p>
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
										<li><a href=""><i class="fa fa-user"></i><b>
											<?php
												$customer_name = Session::get('customer_name');		
												if($customer_name) {
													echo $customer_name;
												} else {
													echo 'User Name';
												}
											?>
										</b></a></li>
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
												<form>
													@csrf
													<input type="hidden" value="{{$val->product_id}}" class="cart_product_id_{{$val->product_id}}">
													<input type="hidden" value="{{$val->product_name}}" class="cart_product_name_{{$val->product_id}}">
													<input type="hidden" value="{{$val->product_image}}" class="cart_product_image_{{$val->product_id}}">
													<input type="hidden" value="{{$val->product_price}}" class="cart_product_price_{{$val->product_id}}">
													<input type="hidden" value="1" class="cart_product_qty_{{$val->product_id}}">
													<input type="hidden" value="{{$val->product_quantity}}" class="cart_product_quantity_{{$val->product_id}}">
												<a href="{{URL::to('/chi-tiet-san-pham/'.$val->product_id)}}">
													<img src="{{URL::to('public/uploads/product/'.$val->product_image)}}" alt="" height="200" width="150" />
													<h2>{{number_format($val->product_price).' VNĐ'}}</h2>
													<p>{{$val->product_name}}</p>
												</a>
													<!-- <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ</a> -->
													<input type="button" value="Thêm vào giỏ" class="btn btn-default add-to-cart" data-id_product="{{$val->product_id}}" name="add-to-cart">
                        
                            						<input style="margin-top: -25px;" type="button" data-toggle="modal" data-target="#xemnhanh" class="btn btn-default xemnhanh" data-id_product="{{$val->product_id}}" name="add-to-cart" value="Xem nhanh">
												</form>
												</div>
						
											</div>
											<div class="choose">
												<ul class="nav nav-pills nav-justified">
													<li><a href="#"><i class="fa fa-plus-square"></i>Thêm vào yêu thích</a></li>
													<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
												</ul>
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
					<!-- Modal -->
					<div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
							<div class="modal-header">
								<h5 style="text-align: center;" class="modal-title" id="">
									<span style="color: brown; font-size: 25px; font-weight: bold;" id="product_quickview_title"></span>
								</h5>
								<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button> -->
							</div>
							<div class="modal-body">
								<style type="text/css">
									span#product_quickview_content img {
										width: 100%;
									}

									/* điện thoại */
									@media screen and (min-width: 768px) {
										.modal-dialog {
											width: 700px;
										}
										.modal-sm {
											width: 350px;
										}
									}

									/* ipad trở lên */
									@media screen and (min-width: 992px) {
										.modal-lg {
											width: 1200px;
										}
									}
								</style>
								<div class="row">
									<div class="col-md-5">
										<span id="product_quickview_image"></span>
									</div>

									<form action="">
										@csrf
										<div id="product_quickview_value"></div>
										
									<div class="col-md-7">
										<p style="color: brown; font-size: 20px; font-weight: bold;">Giá sản phẩm: <span id="product_quickview_price"></span></p>
										<div id="product_quickview_button"></div>

										<hr>
										<h4 >Mô tả sản phẩm</h4>
										<p><span id="product_quickview_desc"></span></p>
										<p><span id="product_quickview_content"></span></p>
										
									</div>
									</form>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
								<button style="margin-top: 0;" type="button" class="btn btn-primary redirect-cart">Tới giỏ hàng</button>
							</div>
							</div>
						</div>
						</div>
						
@endsection