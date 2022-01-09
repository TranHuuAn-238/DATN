<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function index() {
        return view('admin_login');
    }

    public function show_dashboard() {
        $this->AuthLogin(); // kiểm tra đăng nhập admin chưa
        return view('admin.dashboard');  // ~ folder admin/dashboard
    }

    public function dashboard(Request $request) { // request gửi lên từ form đến dashboard
        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);

        $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first(); // first() lấy 1 user thôi
        //return view('admin.dashboard');
        if($result) {
            // lấy admin_name và admin_id ở DB và trả về trang dashboard
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboard');
        } else {
            // người dùng nhập sai tài khoản
            Session::put('message','Bạn đã nhập sai tên tài khoản hoặc mật khẩu. Hãy nhập lại');
            return Redirect::to('/admin');
        }
    }

    public function logout() {
        $this->AuthLogin(); // đăng nhập rồi ms có logout
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}

