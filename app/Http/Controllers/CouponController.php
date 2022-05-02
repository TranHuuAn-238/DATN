<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();

class CouponController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function unset_coupon() {
        // xóa mã km
        $coupon = Session::get('coupon');
        if($coupon == true) {
            Session::forget('coupon');
            return redirect()->back()->with('message','Đã xóa mã khuyến mãi áp dụng'); // ~ session flash
        }
    }
    public function insert_coupon() {
        $this->AuthLogin();
        return view('admin.coupon.insert_coupon');
    }
    public function list_coupon() {
        $this->AuthLogin();
        $coupon = Coupon::orderby('coupon_id','desc')->paginate(10); //->get()
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = date("Y-m-d");
        return view('admin.coupon.list_coupon')->with(compact('coupon', 'today'));
    }
    public function delete_coupon($coupon_id) {
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id); // find mặc định tìm theo id, nếu muốn tìm theo trường khác id thì dùng where
        $coupon->delete();
        Session::put('message','Đã xóa mã khuyến mãi');
        return Redirect::to('list-coupon');
    }
    public function insert_coupon_code(Request $request) {
        $this->AuthLogin();
        $data = $request->all();
        $coupon = new Coupon;
        $coupon->coupon_name = $data['coupon_name'];
        $coupon->coupon_date_start = $data['coupon_date_start'];
        $coupon->coupon_date_end = $data['coupon_date_end'];
        $coupon->coupon_discount = $data['coupon_discount'];
        $coupon->coupon_code = $data['coupon_code'];
        $coupon->coupon_time = $data['coupon_time'];
        $coupon->coupon_condition = $data['coupon_condition'];
        $coupon->coupon_status = $data['coupon_status'];
        $coupon->coupon_desc = $data['coupon_desc'];
        $coupon->save();
        Session::put('message','Thêm mới mã khuyến mãi thành công');
        return Redirect::to('insert-coupon');
    }

    public function active_coupon($coupon_id) {
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id);
        $coupon->coupon_status = 1;
        $coupon->save();
        Session::put('message','Đã kích hoạt mã khuyến mãi ' . $coupon->coupon_code);
        return Redirect::to('list-coupon');
    }
    public function unactive_coupon($coupon_id) {
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id);
        $coupon->coupon_status = 0;
        $coupon->save();
        Session::put('message','Đã khóa mã khuyến mãi ' . $coupon->coupon_code);
        return Redirect::to('list-coupon');
    }

    public function edit_coupon($coupon_id) {
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id);
        return view('admin.coupon.edit_coupon', compact('coupon'));
    }

    public function update_coupon(Request $request, $coupon_id) {
        $this->AuthLogin();
        $coupon = Coupon::find($coupon_id);
        $coupon->coupon_name = $request->coupon_name;
        $coupon->coupon_date_start = $request->coupon_date_start;
        $coupon->coupon_date_end = $request->coupon_date_end;
        $coupon->coupon_time = $request->coupon_time;
        $coupon->coupon_condition = $request->coupon_condition;
        $coupon->coupon_discount = $request->coupon_discount;
        $coupon->coupon_code = $request->coupon_code;
        $coupon->coupon_desc = $request->coupon_desc;
        $coupon->save();
        Session::put('message','Cập nhật mã khuyến mãi thành công');
        return Redirect::to('list-coupon');
    }
}
