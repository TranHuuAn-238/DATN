@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Giỏ hàng của bạn</li>
				</ol>
			</div>
				@if(session()->has('message'))
					<div class="alert alert-success">
						{{ session()->get('message') }}
					</div>
				@elseif(session()->has('error'))
					<div class="alert alert-danger">
						{{ session()->get('error') }}
					</div>
				@endif
			<div class="table-responsive cart_info" style="width: 1055px;">
			<form action="{{url('/update-cart')}}" method="POST">
				@csrf
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image" style="width: 17%">Hình ảnh</td>
							<td class="description" style="width: 25%">Sản phẩm</td>
							<td class="price" style="width: 18%">Đơn giá</td>
							<td class="quantity" style="width: 15%">Số lượng</td>
							<td class="total" style="width: 22%">Thành tiền</td>
							<td style="width: 3%"></td>
						</tr>
					</thead>
					<tbody>
						@if(@Session::get('cart'))
						<?php
							$total = 0;
						?>
						@foreach(@Session::get('cart') as $key => $cart)
						<?php
							$subtotal = $cart['product_price']*$cart['product_qty'];
							$total += $subtotal;
						?>
						<tr>
							<td class="cart_product">
								<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
							</td>
							<td class="cart_description">
								<h4><a href=""></a></h4>
								<p>{{$cart['product_name']}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($cart['product_price'],0,',','.')}} VNĐ</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									
								
									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  style="width: 75%">
									<!-- <input type="hidden" value="" name="rowId_cart" class="form-control"> -->
								
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
								{{number_format($subtotal,0,',','.')}} VNĐ
							
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						
						@endforeach
						<tr>
							<td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default"></td>
							<td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa giỏ hàng</a></td>
							
						</tr>

						<tr>
						
							<td colspan="2" class="total_area">
								<h4 style="margin-left: 180px; margin-top: 50px;">Thông tin giá tiền</h4>
							<ul>

								<li>Tổng tiền: <span>{{number_format($total,0,',','.')}} VNĐ</span></li>
								<!-- <li>Thuế <span></span></li> -->
								<li>Phí vận chuyển <span>Free</span></li>
								<li>Thành tiền: <span style="color: red; font-weight: bold;">{{number_format($total,0,',','.')}} VNĐ</li>
								<td>
									<?php
										$customer_id = Session::get('customer_id');
										$shipping_id = Session::get('shipping_id');
										if($customer_id != null && $shipping_id == null) {
									?>
									<a class="btn btn-default check_out" href="{{URL::to('/checkout')}}"> Thanh toán</a>
									<?php
										} elseif($customer_id != null && $shipping_id != null) {
									?>
									<a class="btn btn-default check_out" href="{{URL::to('/payment')}}"> Thanh toán</a>
									<?php
										} else {
									?>
									<a class="btn btn-default check_out" href="{{URL::to('/login-checkout')}}"> Thanh toán</a>
									<?php
										}
									?>
							
								</td>
							</ul>
			
							<!-- <a class="btn btn-default check_out" href="#">Thanh toán</a> -->
							

							</td>
								
						</tr>
						@else
						<tr>
							<td colspan="5"><center>
							<?php
								echo "Hãy thêm sản phẩm vào giỏ trước";
							?>
							</center></td>
						</tr>
						@endif
					</tbody>
					
			</form>
				</table>
				
			</div>
		</div>
	</section> <!--/#cart_items-->

	<!-- <section id="do_action">
		<div class="container">
		
			<div class="row">
			
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							
							<li>Thuế <span></span></li>
							<li>Phí vận chuyển <span>Free</span></li>
							<li>Thành tiền sau giảm <span></span></li>
						</ul>
					
                                <a class="btn btn-default check_out" href="#">Thanh toán</a>
                               
  
							

					</div>
				</div>
			</div>
		</div>
	</section> -->
	<!--/#do_action-->
@endsection