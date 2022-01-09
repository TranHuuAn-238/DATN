<?php

namespace App\Http\Controllers;
use DB; // sử dụng database
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        // lấy danh mục và thương hiệu sp vào layout
        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

        // 
        // $all_product = DB::table('tbl_product')
        // ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        // ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        // ->orderby('tbl_product.product_id','desc')->get();

        $all_product = DB::table('tbl_product')->where('product_status','1')->orderby('product_id','desc')->limit(4)->get(); // limit(4) lấy 4 sản phẩm

        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)->with('all_product',$all_product);
    }
}
