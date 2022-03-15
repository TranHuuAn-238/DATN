@extends('layout')
@section('content')

    <section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2><b>Bạn đã có tài khoản? Đăng nhập ngay</b></h2>
						<form action="{{URL::to('/login-customer')}}" method="post">
							{{ csrf_field() }}
							@if(Session::has('fail'))
								<div class="alert alert-danger">
									{{Session::get('fail')}}
									@php
										Session::forget('fail');
									@endphp
								</div>
							@endif
							<input type="text" name="email_account" placeholder="Email đăng nhập" />
							@foreach($errors->get('email_account') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<input type="password" name="password_account" placeholder="Mật khẩu" />
							@foreach($errors->get('password_account') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<span>
								<input type="checkbox" class="checkbox"> 
								Nhớ đăng nhập
							</span>
							<button type="submit" class="btn btn-default">Đăng nhập</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">Chưa?</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2><b>Đăng kí ngay!</b></h2>
						<form action="{{URL::to('/add-customer')}}" method="post">
							{{ csrf_field() }}
							<input type="text" name="customer_name" placeholder="Tên tài khoản"/>
							@foreach($errors->get('customer_name') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<input type="email" name="customer_email" placeholder="Email"/>
							@foreach($errors->get('customer_email') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<input type="text" name="customer_phone" placeholder="Số điện thoại"/>
							@foreach($errors->get('customer_phone') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<input type="password" name="customer_password" placeholder="Mật khẩu"/>
							@foreach($errors->get('customer_password') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<input type="password" name="customer_password_repeat" placeholder="Nhập lại mật khẩu"/>
							@foreach($errors->get('customer_password_repeat') as $message)
								<p style="color: red;"><i>{{$message}}</i></p>
							@endforeach
							<button type="submit" class="btn btn-default">Đăng ký</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->

@endsection