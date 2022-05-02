@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật mã khuyến mãi
                        </header>
                        <?php
                            $message = Session::get('message');
                            if($message) {
                                echo '<span class="text-alert">' . $message . '</span>';
                                Session::put('message',null);
                                // hiển thị thông báo 1 lần thôi
                            }
                        ?>
                        <div class="panel-body">
                            <div class="position-center">
                                <form role="form" action="{{URL::to('/update-coupon/'.$coupon->coupon_id)}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã</label>
                                    <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1" value="{{ $coupon->coupon_name }}">
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                    <input type="text" name="coupon_date_start" class="form-control" id="datepickereditstart" value="{{ $coupon->coupon_date_start }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày kết thúc</label>
                                    <input type="text" name="coupon_date_end" class="form-control" id="datepickereditend"  value="{{ $coupon->coupon_date_end }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã giảm</label>
                                    <input type="text" class="form-control" name="coupon_code" value="{{ $coupon->coupon_code }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng mã</label>
                                    <input type="text" class="form-control" name="coupon_time" value="{{ $coupon->coupon_time }}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Loại mã</label>
                                    <select name="coupon_condition" class="form-control input-sm m-bot15">
                                        @if($coupon->coupon_condition == 1)
                                        <option selected value="1">Giảm %</option>
                                        <option value="2">Giảm tiền (VNĐ)</option>
                                        @else
                                        <option value="1">Giảm %</option>
                                        <option selected value="2">Giảm tiền (VNĐ)</option>
                                        @endif

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Giảm</label>
                                    <input type="text" class="form-control" name="coupon_discount" value="{{ $coupon->coupon_discount }}">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="coupon_desc" id="editcoupondesc" placeholder="Mô tả danh mục">{{ $coupon->coupon_desc }}</textarea>
                                    
                                </div>
                                <button type="submit" name="update_coupon" class="btn btn-info">Cập nhật mã</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection