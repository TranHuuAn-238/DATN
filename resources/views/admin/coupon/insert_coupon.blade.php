@extends('admin_layout')
@section('admin_content')
<div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm mã khuyến mãi
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
                                <form role="form" action="{{URL::to('/insert-coupon-code')}}" method="post">
                                    @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên mã</label>
                                    <input type="text" name="coupon_name" class="form-control" id="exampleInputEmail1">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                    <input type="text" name="coupon_date_start" class="form-control" id="datepickeraddstart" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Ngày kết thúc</label>
                                    <input type="text" name="coupon_date_end" class="form-control" id="datepickeraddend" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mã giảm</label>
                                    <input type="text" class="form-control" name="coupon_code">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Số lượng mã</label>
                                    <input type="text" class="form-control" name="coupon_time">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Loại mã</label>
                                    <select name="coupon_condition" class="form-control input-sm m-bot15">
                                        <option value="0" selected disabled hidden>Chọn loại mã</option>
                                        <option value="1">Giảm %</option>
                                        <option value="2">Giảm tiền (VNĐ)</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Giảm</label>
                                    <input type="text" class="form-control" name="coupon_discount">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Trạng thái</label>
                                    <select name="coupon_status" class="form-control input-sm m-bot15">
                                        <option value="0">Khóa</option>
                                        <option value="1">Kích hoạt mã</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea style="resize: none" rows="8" class="form-control" name="coupon_desc" id="insertcoupondesc" placeholder="Mô tả danh mục"></textarea>
                                </div>
                                <button type="submit" name="add_coupon" class="btn btn-info">Thêm mã</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
@endsection