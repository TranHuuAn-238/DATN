<div style="background-color: #F0FFFF; padding: 15px;">
    <div style="overflow:hidden;">
        <div style="background-color:#FFFFFF; text-align:left; float:left;"><img src="{{asset('public/frontend/images/logoo.png')}}" width="359" height="69" alt="logo An XĐạp"/></div>
        <div style="padding-top:24px; text-transform:uppercase; text-align:right; float:right; font-size:16px"><b>Shop Xe đạp H.An</b>
            <br>
            <span style="font-style: italic; font-size:13px">ĐC: 3 Đ. Cầu Giấy, Láng Thượng, Đống Đa, Hà Nội</span>
        </div>
    </div>
    <br>

    <div style=" text-align:center; position:relative; color:#280b0b; font-size: 24px; top:1px;">
        <b>THÔNG TIN ĐƠN HÀNG</b>
        <br/>
        -------oOo-------
    </div>
    <div>
        <p>Xin chào, <span style="font-weight: bold; color:red">{{ $customer_name }}</span>!</p>
        <p>Đây là Email tự động được gửi để thông tin cho bạn về đơn hàng bạn đã đặt tại cửa hàng xe đạp của chúng tôi vào thời điểm: <b>{{ date('d/m/Y H:i:s', strtotime($or_date)) }}</b></p>
    </div>
    <p style="font-size: 20px; font-weight: bold; text-align: center">Thông tin vận chuyển</p>
    <div>
        <p>Tên người nhận: <b>{{ $shipping->shipping_name }}</b></p>
        <p>Email: <b>{{ $shipping->shipping_email }}</b></p>
        <p>Địa chỉ nhận hàng: <b>{{ $shipping->shipping_address }}</b></p>
        <p>Số điện thoại người nhận: <b>{{ $shipping->shipping_phone }}</b></p>
        <p>Ghi chú đơn hàng: <b>{!! isset($shipping->shipping_notes) ? $shipping->shipping_notes : "<i>Không có</i>" !!}</b></p>
        <p>Hình thức thanh toán: <b>{{ $payment_option === 1 ? 'Thanh toán bằng thẻ' : 'Thanh toán bằng tiền mặt'}}</b></p>
        <p>Phí vận chuyển: <b>{{ $shipping->shipping_fee }} VNĐ</b></p>
    </div>
    <br/>

    <p style="font-size: 20px; font-weight: bold; text-align: center">Danh sách sản phẩm</p>
    <table style="background:#ffffff; font: 11px; width:100%; border-collapse:collapse; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; border:thin solid #d3d3d3;">
        <thead>
            <tr style="height: 24px; border:thin solid #d3d3d3;">
                <th style="background: rgba(0,0,255,0.1); color: #000; border: solid 1px #ccc; height: 24px; width: 5%">STT</th>
                <th style="background: rgba(0,0,255,0.1); color: #000; border: solid 1px #ccc; height: 24px; width: 40%">Tên sản phẩm</th>
                <th style="background: rgba(0,0,255,0.1); color: #000; border: solid 1px #ccc; height: 24px; width: 10%">Số lượng</th>
                <th style="background: rgba(0,0,255,0.1); color: #000; border: solid 1px #ccc; height: 24px; width: 20%">Đơn giá (VNĐ)</th>
                <th style="background: rgba(0,0,255,0.1); color: #000; border: solid 1px #ccc; height: 24px; width: 25%">Thành tiền (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @php
                 $total = 0;
            @endphp
            @foreach ($cart as $key => $val)
            @php
                $subtotal = $val['product_price']*$val['product_qty'];
                $total += $subtotal;
            @endphp
            <tr style="height: 24px; border:thin solid #d3d3d3;">
                <td style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3; text-align: center">{{ $key+1 }}</td>
                <td style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3;">{{ $val['product_name'] }}</td>
                <td style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3; text-align: center">{{ $val['product_qty'] }}</td>
                <td style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3; text-align: center">{{ number_format($val['product_price']) }}</td>
                <td style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3; text-align: center">{{ number_format($val['product_price']*$val['product_qty']) }}</td>
            </tr>
            @endforeach   
        </tbody>
        <tfoot>
            <tr style="height: 24px; border:thin solid #d3d3d3;">
                <td colspan="5" style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3;">Mã khuyến mãi áp dụng: <b>{!! isset($get_coupon) ? $get_coupon['coupon_code'] : "<i>Không áp dụng</i>" !!}</b></td>
            </tr>
            <tr style="height: 24px; border:thin solid #d3d3d3;">
                <td colspan="4" style="padding-right: 2px; padding-left: 2px; border:thin solid #d3d3d3;">Tổng tiền thanh toán(đã bao gồm phí vận chuyển): </td>
                <td style="text-align: center"><b>{{ number_format($total - $total_coupon + $shipping->shipping_fee) }}</b></td>
            </tr>
        </tfoot>
    </table>
    <br>

    <div style="text-align: center; font-style: italic; color: red">
        <p><u>Chú ý:</u> Hàng mang đổi trả phải còn nguyên vẹn, không trầy xước, hỏng hóc(Nếu không sẽ không được đổi lại)</p>
        <p>Nhân viên tư vấn sẽ sớm liên lạc lại theo SĐT phía trên để xác nhận lần cuối cho đơn hàng của bạn, vui lòng nghe máy</p>
    </div>
    <br>
    <br>

    <div style="font-size: 16px; font-weight: bold; text-align: center; font-style: italic;">
        Cảm ơn bạn đã lựa chọn xe của chúng tôi để đồng hành trên những chặng đường!
    </div>
    <p><i>Ghé thăm Website chúng tôi để lựa chọn thêm các mẫu xe khác tại <a target="_blank" title="Xe đạp H.An" href="http://localhost:8080/shopbanhang/trang-chu">đây</a></i></p>
</div>