<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class OrderController extends Controller
{
    public function history() {
        if(!Session::get('customer_id')) {
            return redirect('login-checkout');
        } else {
            // lấy slide
            $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

            $meta_title = "Lịch sử đơn hàng";

            // lấy danh mục và thương hiệu sp vào layout
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

            // ~ manage_order
            $all_order = DB::table('tbl_order')->where('tbl_customer.customer_id', Session::get('customer_id'))
            ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
            ->select('tbl_order.*','tbl_customer.customer_name')
            ->orderby('tbl_order.order_id','desc')->paginate(10);

            return view('pages.history.history')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('all_order',$all_order)->with('meta_title',$meta_title);
        }
    }

    public function view_history_order($orderId) {
        if(!Session::get('customer_id')) {
            return redirect('login-checkout');
        } else {
            // lấy slide
            $slider = Slider::orderBy('slider_id','desc')->where('slider_status', '1')->take(4)->get();

            $meta_title = "Chi tiết đơn hàng đã đặt";

            // lấy danh mục và thương hiệu sp vào layout
            $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
            $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

            // ~ view_order
            $order_by_id = DB::table('tbl_order')->where('tbl_order.order_id', $orderId)
            ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
            ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
            ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
            ->select('tbl_order.*','tbl_customer.*','tbl_shipping.*','tbl_order_details.*')->get();

            return view('pages.history.view_history_order')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider)->with('order_by_id',$order_by_id)->with('meta_title',$meta_title);
        }
    }
}
