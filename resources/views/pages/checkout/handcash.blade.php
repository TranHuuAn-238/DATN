@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container" id="showpopup">
			
			<div class="review-payment">
				<h2 style="font-weight: bold;"><b>Cảm ơn bạn vì đã lựa chọn xe của chúng tôi!</b></h2>
				<h3><i>Đơn hàng sẽ được xác nhận và giao cho bạn trong thời gian sớm nhất</i></h3>
				<a href="{{URL::to('/trang-chu')}}" class="btn btn-info" style="text-transform: uppercase;"><b>Về trang chủ</b></a>
			</div>
            
		</div>
	</section> <!--/#cart_items-->

@endsection