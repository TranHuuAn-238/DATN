<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class CheckoutController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }


    public function login_checkout() {
        $meta_title = "Đăng nhập";

        // lấy slide
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

        // lấy danh mục và thương hiệu sp vào layout
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
    }

    public function add_customer(Request $request) {
        // đăng kí tk
        // $data = array();
        // $data['customer_name'] = $request->customer_name;
        // $data['customer_phone'] = $request->customer_phone;
        // $data['customer_email'] = $request->customer_email;
        // $data['customer_password'] = md5($request->customer_password);

        $dataGetFromForm = $request->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'customer_email' => 'required|email',
            'customer_password' => 'required',
            'customer_password_repeat' => 'required|same:customer_password'
        ],[
            'customer_name.required' => 'Bạn phải nhập tên tài khoản',
            'customer_email.required' => 'Bạn phải nhập Email',
            'customer_email.email' => 'Định dạng Email chưa đúng',
            'customer_phone.required' => 'Bạn phải nhập số điện thoại',
            'customer_password.required' => 'Bạn phải nhập mật khẩu',
            'customer_password_repeat.required' => 'Bạn phải xác thực lại mật khẩu',
            'customer_password_repeat.same' => 'Mật khẩu nhập lại không khớp, hãy nhập lại'
        ]);
        $data = array();
        $data['customer_name'] = $request->customer_name; // $dataGetFromForm['customer_name']
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);

        $customer_id = DB::table('tbl_customer')->insertGetId($data); // insertGetId: insert va lay id vua insert cho vao $customer_id de truyen qua view

        Session::put('customer_id',$customer_id); // ktra dang xuat, dang nhap
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/trang-chu');
    }

    public function checkout() {
        $meta_title = "Thông tin nhận hàng";

        // lấy slide
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

        // lấy danh mục và thương hiệu sp vào layout
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

        $cart =  Session::get('cart');
        if($cart != null) {
            return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
        } else {
            return Redirect::to('/show-cart');
        }
    }

    public function save_checkout_customer(Request $request) {
        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address;

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data); // insertGetId: insert va lay id vua insert cho vao $shipping_id de truyen qua view

        Session::put('shipping_id',$shipping_id);

        return Redirect::to('/payment');
    }

    public function payment() {
        $meta_title = "Xác nhận thanh toán";

        // lấy slide
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

        // lấy danh mục và thương hiệu sp vào layout
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
    }

    public function order_place(Request $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $meta_title = "Đặt hàng thành công";

        // thanh toán cuối cùng
        // lấy slide
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

        // lấy danh mục và thương hiệu sp vào layout
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        // echo "<pre>";
        // print_r(Session::get('cart'));

        // insert hình thức thanh toán(payment method), bảng tbl_payment
        $data = array();
        $data['payment_method'] = $request->payment_option;
        $data['payment_status'] = 'Đang chờ xử lý';
        $payment_id = DB::table('tbl_payment')->insertGetId($data); // insertGetId: insert va lay id vua insert cho vao $payment_id de truyen qua view

        // insert order, bảng tbl_order
        $cart = Session::get('cart');
        $total = 0;
        foreach($cart as $value_content) {
            $subtotal = $value_content['product_price']*$value_content['product_qty'];
			$total += $subtotal;
        }
        $order_data = array();
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['payment_id'] = $payment_id;
        $order_data['order_total'] = $total;
        $order_data['order_status'] = 'Đang chờ xử lý';
        $order_data['order_date'] = date('Y-m-d H:i:s');
        $order_id = DB::table('tbl_order')->insertGetId($order_data);

        // insert order_details, bảng tbl_order_details
        // foreach lấy lần lượt từng sản phẩm trong giỏ hàng
        foreach($cart as $value_content) {
            //$order_d_data = array();
            $order_d_data['order_id'] = $order_id;
            $order_d_data['product_id'] = $value_content['product_id'];
            $order_d_data['product_name'] = $value_content['product_name'];
            $order_d_data['product_price'] = $value_content['product_price'];
            $order_d_data['product_sales_quantity'] = $value_content['product_qty'];
            DB::table('tbl_order_details')->insert($order_d_data); 
        }
        if($data['payment_method'] == 1) {
            echo "Thanh toán bằng thẻ tín dụng";
        } else {
            Session::forget('cart'); // xóa session cart
            Session::forget('shipping_id'); // xóa luôn session thông tin nhận hàng

            // lấy slide
            $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

            // lấy danh mục và thương hiệu sp vào layout
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
        }

        //return Redirect::to('/payment');
    }

    public function logout_checkout() {
        //Session::flush(); // xóa toàn bộ session($request->session()->flush())
        Session::forget('customer_id');
        Session::forget('shipping_id');
        Session::forget('customer_name');
        return Redirect::to('/login-checkout');
    }

    public function login_customer(Request $request) {
        // đăng nhập
        // $email = $request->email_account;
        // $password = md5($request->password_account);
        // $result = DB::table('tbl_customer')->where('customer_email', $email)->where('customer_password',$password)->first();

        $data = $request->validate([
            'email_account' => 'required|email',
            'password_account' => 'required'
        ],[
            'email_account.required' => 'Bạn phải nhập Email',
            'email_account.email' => 'Định dạng Email chưa đúng',
            'password_account.required' => 'Bạn phải nhập mật khẩu'
        ]);
        $result = DB::table('tbl_customer')->where('customer_email', $data['email_account'])->where('customer_password', md5($data['password_account']))->first();
        
        if($result) {
            // nhập đúng tài khoản
            Session::put('customer_id',$result->customer_id); // ktra dang xuat, dang nhap(customer_id phai co khi dang nhap/dang ky)
            Session::put('customer_name',$result->customer_name);
            return Redirect::to('/trang-chu');
        } else {
            return Redirect::to('/login-checkout')->with('fail','Tài khoản hoặc mật khẩu không đúng, hãy thử lại');
        }

        Session::save();
    }

    public function manage_order() {
        // ~ all_product() trong ProductController
        $this->AuthLogin();
        $all_order = DB::table('tbl_order')
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->select('tbl_order.*','tbl_customer.customer_name')
        ->orderby('tbl_order.order_id','desc')->paginate(10);
        $manager_order = view('admin.manage_order')->with('all_order',$all_order);
        return view('admin_layout')->with('admin.manage_order', $manager_order);
    }

    public function view_order($orderId) {
        $this->AuthLogin();
        $order_by_id = DB::table('tbl_order')->where('tbl_order.order_id', $orderId)
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->get();
        $manager_order_by_id = view('admin.view_order')->with('order_by_id',$order_by_id);
        return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
    }
}
