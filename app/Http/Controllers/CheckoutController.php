<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PostShippingRequest; // validate shipping
session_start();
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
use App\Models\Coupon;
use Mail;

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

    public function select_delivery_home(Request $request) {
        $data = $request->all();
        if($data['action']) {
            $output = '';
            if($data['action'] == "city") {
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh','asc')->get(); // ma_id là matp của tp đã chọn
                    $output .= '<option selected disabled hidden>--Chọn quận huyện--</option>';
                foreach($select_province as $key => $province) {
                    $output .= '<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
                
            } else {
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid','asc')->get();
                    $output .= '<option selected disabled hidden>--Chọn xã phường--</option>';
                foreach($select_wards as $key => $ward) {
                    $output .= '<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
        }
        echo $output;
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

        $city = City::orderby('matp','asc')->get();

        $cart =  Session::get('cart');
        if($cart != null) {
            return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title)->with('city',$city);
        } else {
            return Redirect::to('/show-cart');
        }
    }

    public function save_checkout_customer(PostShippingRequest $request) {
        $data = array();
        // tính phí vận chuyển
        $feeship = Feeship::where('fee_matp',$request->city)->where('fee_maqh',$request->province)->where('fee_xaid',$request->wards)->get(); // get() thì luôn tồn tại mảng(ko có phần tử thì mảng rỗng nhưng vẫn tồn tại mảng), first() nếu ko có phần tử thì sẽ ko tồn tại(là null)
        $fee = '';
        if($feeship) {
            $fee_count = $feeship->count();
            if($fee_count > 0) {
                foreach($feeship as $key => $fee) {
                    $data['shipping_fee'] = $fee->fee_feeship;
                    $fee = $fee->fee_feeship;
                }
            } else {
                $data['shipping_fee'] = '30000';
                $fee = '30000';
            }    
        } // nếu $feeship là ->first() thì else { $data['shipping_fee'] = '30000'; $fee = '30000'; } phải ở đây và trong if ko cần foreach và ko cần $fee_count  

        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_email'] = $request->shipping_email; 
        $data['shipping_province'] = $request->txt_city; // $data['shipping_province'] = $request->text_province;
        $data['shipping_district'] = $request->txt_province; // $data['shipping_district'] = $request->text_district;
        $data['shipping_ward'] = $request->txt_ward;
        $data['shipping_notes'] = $request->shipping_notes;
        $data['shipping_address'] = $request->shipping_address . ', ' . $request->txt_ward . ', ' . $request->txt_province . ', ' . $request->txt_city . '.';

        $shipping_id = DB::table('tbl_shipping')->insertGetId($data); // insertGetId: insert va lay id vua insert cho vao $shipping_id de truyen qua view

        Session::put('shipping_id',$shipping_id);
        Session::put('fee',$fee);


        return Redirect::to('/payment');
    }

    public function payment() {
        $meta_title = "Xác nhận thanh toán";

        // lấy slide
        $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

        // lấy danh mục và thương hiệu sp vào layout
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

        $shipping = Session::get('shipping_id');
        if($shipping) {
            return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
        }
        return Redirect::to('/checkout');
       
    }

    public function order_place(Request $request) {
        // validate textbox
        $dataGetFromForm = $request->validate([
            'payment_option' => 'required|in:1,2' // hoặc 'required_without_all' hoặc 'required_with_all' (checkbox validate ~ radio button)
        ],[
            'payment_option.required' => 'Bạn phải chọn phương thức thanh toán'
        ]);

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
        $payment_option = $request->payment_option;
        $data['payment_method'] = $payment_option;
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

        $get_coupon = Session::get('coupon');
        if($get_coupon) {
            // có dùng coupon
            $cou_code = $get_coupon['coupon_code'];
            $coupon = Coupon::where('coupon_code', $cou_code)->first();
            $coupon->coupon_time = $coupon->coupon_time - 1; // cập nhật lại số lượng coupon sau khi áp dụng
            $coupon->coupon_used = $coupon->coupon_used . ',s' . Session::get('customer_id') . 'e'; // đánh dấu mã này đã đc user này sử dụng - 1 khách hàng chỉ đc dùng mã 1 lần duy nhất
            $coupon->save();
            
            if($get_coupon['coupon_condition'] == 1) {
                $total_coupon = ($total * $get_coupon['coupon_discount']) / 100;
    
            } elseif($get_coupon['coupon_condition'] == 2) {
                $total_coupon = $get_coupon['coupon_discount'];
    
            }
            $order_data['order_coupon'] = $get_coupon['coupon_code'];
        } else {
            $total_coupon = 0;
        }   

        $feeship = Session::get('fee');
        $order_data['order_total'] = $total + $feeship - $total_coupon; // tổng tiền hàng + phí vận chuyển - giảm giá
        $order_data['order_status'] = 'Đang chờ xử lý';
        $or_date = date('Y-m-d H:i:s');
        $order_data['order_date'] = $or_date;
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
            echo "Thanh toán bằng thẻ tín dụng - Danh sách các thẻ:";
        } else {
            // lấy slide
            $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

            // lấy danh mục và thương hiệu sp vào layout
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

            // send mail
            $shipping = DB::table('tbl_shipping')->where('shipping_id', Session::get('shipping_id'))->first();
            $shipping_email = $shipping->shipping_email;
            $customer_name = Session::get('customer_name');
            Mail::send('pages.mail.order_mail', compact('cart', 'shipping', 'get_coupon','total_coupon', 'or_date', 'customer_name', 'payment_option'), function($email) use($shipping_email, $customer_name) {
                $email->subject('Thông tin đơn hàng');
                $email->to($shipping_email, $customer_name);
            });

            Session::forget('cart'); // xóa session cart
            Session::forget('shipping_id'); // xóa luôn session thông tin nhận hàng
            Session::forget('fee');
            Session::forget('coupon');
            return view('pages.checkout.handcash')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
        }

        //return Redirect::to('/payment');
    }

    public function logout_checkout() {
        //Session::flush(); // xóa toàn bộ session($request->session()->flush())
        Session::forget('customer_id');
        Session::forget('shipping_id');
        Session::forget('fee');
        Session::forget('coupon');
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

    public function accept_order($orderId)
    {
        $this->AuthLogin();
        DB::table('tbl_order')->where('tbl_order.order_id', $orderId)->update(['order_status'=>'Đã xác nhận']);
        Session::put('message','Xác nhận đơn hàng thành công');
        // update lại số lượng
        $order_by_id = DB::table('tbl_order')->where('tbl_order.order_id', $orderId)
        ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
        ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
        ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
        ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->get();
        $product = DB::table('tbl_product')->get();
        foreach($order_by_id as $key => $val) {
            foreach($product as $k => $v) {
                if($val->product_id === $v->product_id) {
                    DB::table('tbl_product')->where('tbl_product.product_id', $v->product_id)->update(['product_quantity'=>$v->product_quantity-$val->product_sales_quantity]);
                }
            }
        }
        return Redirect::to('manage-order');
    }
    public function cancel_order($orderId)
    {
        $this->AuthLogin();
        DB::table('tbl_order')->where('tbl_order.order_id', $orderId)->update(['order_status'=>'Đã hủy']);
        Session::put('message','Đơn hàng đã hủy');
        return Redirect::to('manage-order');
    }
}
