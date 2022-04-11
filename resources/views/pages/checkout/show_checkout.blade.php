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

			<!-- <div class="step-one">
				<h2 class="heading">Step1</h2>
			</div> -->
			<!-- <div class="checkout-options">
				<h3>New User</h3>
				<p>Checkout options</p>
				<ul class="nav">
					<li>
						<label><input type="checkbox"> Register Account</label>
					</li>
					<li>
						<label><input type="checkbox"> Guest Checkout</label>
					</li>
					<li>
						<a href=""><i class="fa fa-times"></i>Cancel</a>
					</li>
				</ul>
			</div> -->

			<div class="register-req">
				<p><i>Tạo tài khoản và đăng nhập để thanh toán giỏ hàng của bạn và xem lại lịch sử mua hàng</i></p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<!-- <div class="col-sm-3">
						<div class="shopper-info">
							<p>Shopper Information</p>
							<form>
								<input type="text" placeholder="Display Name">
								<input type="text" placeholder="User Name">
								<input type="password" placeholder="Password">
								<input type="password" placeholder="Confirm password">
							</form>
							<a class="btn btn-primary" href="">Get Quotes</a>
							<a class="btn btn-primary" href="">Continue</a>
						</div>
					</div> -->
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p><b>Thông tin nhận hàng</b></p>
							<div class="form-one">
								<form action="{{URL::to('/save-checkout-customer')}}" method="post">
									{{ csrf_field() }}
									<label for=""><b>Họ và tên người nhận <span style="color: red;">*</span></b></label>
									<input type="text" name="shipping_name" placeholder="Tên người nhận hàng">
									@error('shipping_name')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<label for=""><b>Địa chỉ email <span style="color: red;">*</span></b></label>
									<input type="text" name="shipping_email" placeholder="Email">
									@error('shipping_email')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror

									{{-- <label for=""><b>Chọn Tỉnh / Thành <span style="color: red;">*</span></b></label>
									<select name="calc_shipping_provinces" onchange="document.getElementById('text_content').value=this.options[this.selectedIndex].text" required="">
										<option value="">Tỉnh / Thành phố</option>
									</select>
									@error('calc_shipping_provinces')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<br><br>
									<label for=""><b>Chọn Quận / Huyện <span style="color: red;">*</span></b></label>
									<select name="calc_shipping_district" required="">
										<option value="">Quận / Huyện</option>
									</select>
									@error('calc_shipping_district')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<br><br>
									<input class="billing_address_1" name="text_province" id="text_content" type="hidden" value="">
									<input class="billing_address_2" name="text_district" type="hidden" value=""> --}}

									
									
									<label><b>Chọn Tỉnh / Thành phố <span style="color: red;">*</span></b></label>
									<select name="city" id="city" class="choose city" onchange="document.getElementById('get_city').value=this.options[this.selectedIndex].text">
										<option value="" selected disabled hidden>--Chọn tỉnh thành--</option>
										@foreach ($city as $key => $ci)
											<option value="{{ $ci->matp }}">{{ $ci->name_city }}</option>
										@endforeach			
									</select>
									@error('city')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<br><br>
									<label><b>Chọn Quận / Huyện <span style="color: red;">*</span></b></label>
									<select name="province" id="province" class="province choose" onchange="document.getElementById('get_province').value=this.options[this.selectedIndex].text">
										<option value="" selected disabled hidden>--Chọn quận huyện--</option>				
									</select>
									@error('province')
									<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<br><br>
									<label><b>Chọn Xã / Phường <span style="color: red;">*</span></b></label>
									<select name="wards" id="wards" class="wards" onchange="document.getElementById('get_ward').value=this.options[this.selectedIndex].text">
										<option value="" selected disabled hidden>--Chọn xã phường--</option>				
									</select>
									@error('wards')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<br><br>
									<input name="txt_city" id="get_city" type="hidden" value="">
									<input name="txt_province" id="get_province" type="hidden" value="">
									<input name="txt_ward" id="get_ward" type="hidden" value="">
						

									
									<label for=""><b>Địa chỉ nhận hàng <span style="color: red;">*</span></b></label>
									<input type="text" name="shipping_address" placeholder="Địa chỉ">
									@error('shipping_address')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<label for=""><b>Số điện thoại <span style="color: red;">*</span></b></label>
									<input type="text" name="shipping_phone" placeholder="Số điện thoại">
									@error('shipping_phone')
										<p style="color: red; font-size: 15px;"><i>{{ $message }}</i></p>
									@enderror
									<label for=""><b>Ghi chú đơn hàng (tuỳ chọn) </b></label>
									<textarea name="shipping_notes" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn" rows="10"></textarea>
									<input type="submit" value="Xác nhận" name="send_order" class="btn btn-primary btn-sm">
								</form>
							</div>
							<!-- <div class="form-two">
								<form>
									<input type="text" placeholder="Zip / Postal Code *">
									<select>
										<option>-- Country --</option>
										<option>United States</option>
										<option>Bangladesh</option>
										<option>UK</option>
										<option>India</option>
										<option>Pakistan</option>
										<option>Ucrane</option>
										<option>Canada</option>
										<option>Dubai</option>
									</select>
									<select>
										<option>-- State / Province / Region --</option>
										<option>United States</option>
										<option>Bangladesh</option>
										<option>UK</option>
										<option>India</option>
										<option>Pakistan</option>
										<option>Ucrane</option>
										<option>Canada</option>
										<option>Dubai</option>
									</select>
									<input type="password" placeholder="Confirm password">
									<input type="text" placeholder="Phone *">
									<input type="text" placeholder="Mobile Phone">
									<input type="text" placeholder="Fax">
								</form>
							</div> -->
						</div>
					</div>
					<!-- <div class="col-sm-4">
						<div class="order-message">
							<p>Ghi chú</p>
							
						</div>	
					</div>					 -->
				</div>
			</div>
			<!-- <div class="review-payment">
				<h2>Giỏ hàng của bạn</h2>
			</div> -->

			<!-- <div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/one.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>

						<tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/two.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<tr>
							<td class="cart_product">
								<a href=""><img src="images/cart/three.png" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">Colorblock Scuba</a></h4>
								<p>Web ID: 1089772</p>
							</td>
							<td class="cart_price">
								<p>$59</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_up" href=""> + </a>
									<input class="cart_quantity_input" type="text" name="quantity" value="1" autocomplete="off" size="2">
									<a class="cart_quantity_down" href=""> - </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">$59</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td>$59</td>
									</tr>
									<tr>
										<td>Exo Tax</td>
										<td>$2</td>
									</tr>
									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td>Free</td>										
									</tr>
									<tr>
										<td>Total</td>
										<td><span>$61</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div> -->

			<!-- <div class="payment-options">
					<span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
					<span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
					<span>
						<label><input type="checkbox"> Paypal</label>
					</span>
			</div> -->
		</div>
	</section> <!--/#cart_items-->

@endsection