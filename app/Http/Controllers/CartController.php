<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Cart;
session_start();

class CartController extends Controller
{
    public function show_cart(Request $request) {
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        // $meta_desc = "Giỏ hàng của bạn"; 
        // $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        //--seo
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get(); 
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('meta_title',$meta_title);
    }
    public function delete_product($session_id) {
        // lấy session giỏ hàng
        $cart = Session::get('cart');
        if($cart == true) {
            foreach($cart as $key => $val) {
                if($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart); // đặt lại giá trị cart mới sau khi delete
            return redirect()->back()->with('message','Đã bỏ sản phẩm khỏi giỏ hàng');
        } else {
            return redirect()->back()->with('message','Bỏ sản phẩm khỏi giỏ hàng thất bại');

        }
    }
    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        if($cart == true) {
            $message = '';

            // $data['cart_qty'] chứa value là số lượng sản phẩm ở thẻ input với key là session_id
            foreach($data['cart_qty'] as $key => $qty) {
                $i = 0;
                // mỗi session cart là 1 sản phẩm trong giỏ
                foreach($cart as $session => $val) {
                    $i++;

                    // nếu session id là giống nhau thì mới cập nhật lại số lượng
                    if($val['session_id'] == $key && $qty <= $cart[$session]['product_quantity']) {
                        $cart[$session]['product_qty'] = $qty;
                        $message .= '<p style="color: blue;">' . $i . '. Đã cập nhật lại số lượng sản phẩm "' . $cart[$session]['product_name'] . '" trong giỏ hàng</p>';
                    } elseif($val['session_id'] == $key && $qty > $cart[$session]['product_quantity']) {
                        $message .= '<p style="color: red;">' . $i . '. Không thể cập nhật số lượng sản phẩm "' . $cart[$session]['product_name'] . '" <i>(Hãy chọn số lượng thấp hơn và thử lại)</i></p>';
                    }
                }
            }
            Session::put('cart',$cart); // đặt lại giá trị cart mới sau khi update
            return redirect()->back()->with('message',$message);
        } else {
            return redirect()->back()->with('message','Cập nhật số lượng sản phẩm trong giỏ hàng thất bại');
        }
    }
    public function delete_all_product()
    {
        $cart = Session::get('cart');
        if($cart == true) {
            //Session::destroy();
            Session::forget('cart'); // xóa session cart
            Session::forget('shipping_id'); // xóa luôn session thông tin nhận hàng
            return redirect()->back()->with('message','Đã xóa giỏ hàng');
        }
    }
    public function add_cart_ajax(Request $request) {
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5); // mỗi sản phẩm thêm vào giỏ có 1 session_id để xóa sửa sản phẩm trong giỏ sau này, microtime() lấy timestamp của thời điểm hiện tại bao gồm cả microseconds, substr cắt chuỗi mã md5 của microtime() từ vị trí ngẫu nhiên 0-26 rand() và cắt 5 phần tử => cho ra chuỗi $session_id gồm có 5 ký tự
        $cart = Session::get('cart'); // tạo 1 session ktra Session cart tồn tại chưa
        if($cart == true) {
            $is_avaiable = 0;
            // tồn tại session cart
            foreach($cart as $key => $val) {
                if($val['product_id'] == $data['cart_product_id']) {
                    $is_avaiable++;
                }
            }
            // nếu $is_avaiable vẫn = 0 tức là ko có cái id nào trùng thì tạo lại 1 cart mới và put, tức sp này chưa đc thêm vào cart
            if($is_avaiable == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                    'product_quantity' => $data['cart_product_quantity'],
                );
                Session::put('cart',$cart);
            }
        } else {
            // chưa tồn tại Session cart thì tạo 1 Session cart mới
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'product_quantity' => $data['cart_product_quantity'],
            );
        }
        Session::put('cart',$cart);
        Session::save(); // save giỏ hàng
    }
    public function save_cart(Request $request) {
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

        // lấy dl từ show_details
        $productId = $request->productid_hidden;
        $quantity = $request->qty; // số lượng trong giỏ hàng
        $data = DB::table('tbl_product')->where('product_id',$productId)->get();
        
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider);
        // $productId = $request->productid_hidden;
        // $quantity = $request->qty;
        // $product_info = DB::table('tbl_product')->where('product_id',$productId)->first(); 

    
        // // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        // // Cart::destroy();
        // $data['id'] = $product_info->product_id;
        // $data['qty'] = $quantity;
        // $data['name'] = $product_info->product_name;
        // $data['price'] = $product_info->product_price;
        // $data['weight'] = $product_info->product_price;
        // $data['options']['image'] = $product_info->product_image;
        // Cart::add($data);
        // // Cart::destroy();
        // return Redirect::to('/show-cart');
     //Cart::destroy();
    }
}
