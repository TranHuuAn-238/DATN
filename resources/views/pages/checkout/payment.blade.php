@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán</li>
				</ol>
			</div><!--/breadcrums-->

			
			<div class="review-payment">
				<h2><b>Xác nhận thanh toán</b></h2>
			</div>
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
									
								
									<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  style="width: 75%" disabled >
									<!-- <input type="hidden" value="" name="rowId_cart" class="form-control"> -->
								
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
								{{number_format($subtotal,0,',','.')}} VNĐ
							
								</p>
							</td>
							
						</tr>
						
						@endforeach
						<tr>
							
							<td colspan="2" class="total_area">
							<h4 style="margin-left: 180px; margin-top: 50px;">Tổng đơn</h4>
								<ul>
								<li>Thành tiền: <span>{{number_format($total,0,',','.')}} VNĐ</span></li>
								<!-- <li>Thuế <span></span></li> -->
								<li>Phí vận chuyển: <span>
													@php
													if(Session::get('fee')) {
														echo number_format(Session::get('fee'),0,',','.') . ' VNĐ';
													}
													@endphp
													</span>
								</li>
								<li>Tổng tiền: <span style="color: red; font-weight: bold;">{{number_format(($total+Session::get('fee')),0,',','.')}} VNĐ</span></li>
								
								</ul>
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
            <h4 style="margin: 40px; font-size: 20px;">Chọn hình thức thanh toán</h4>
            <form action="{{URL::to('/order-place')}}" method="post">
                {{ csrf_field() }}
			<div class="payment-options">
					<span>
						<label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ</label>
					</span>
					<span>
						<label><input name="payment_option" value="2" type="checkbox"> Thanh toán khi nhận hàng</label>
					</span>
					<!-- <span>
						<label><input type="checkbox"> Paypal</label>
					</span> -->
                    @foreach($errors->get('payment_option') as $message)
						<p style="color: red;"><i>{{$message}}</i></p>
					@endforeach
			</div>
                    <input type="submit" value="Đặt hàng" name="send_order_place" class="btn btn-primary btn-sm" style="margin-top: -175px;">
            </form>
		</div>
	</section> <!--/#cart_items-->

@endsection