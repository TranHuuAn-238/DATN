<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class BrandProduct extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_brand_product() {
        $this->AuthLogin();
        return view('admin.add_brand_product');
    }

    public function all_brand_product() {
        $this->AuthLogin();
        $all_brand_product = DB::table('tbl_brand')->paginate(10); // lấy dl từ csdl
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product); // 'all_brand_product' sẽ chứa dl để in ra ở view
        //return view('admin.all_brand_product');
        return view('admin_layout')->with('admin.all_brand_product', $manager_brand_product);
    }

    public function save_brand_product(Request $request) { // lấy dl từ form gửi lên vào hàm này để xử lý
        $this->AuthLogin();
        $data = array();
        // lấy dl theo thuộc tính name ở form trong view
        $data['brand_name'] = $request->brand_product_name; //$data['tên cột trong DB'] = $request->giá trị của thuộc tính name;
        $data['brand_desc'] = $request->brand_product_desc;
        $data['brand_status'] = $request->brand_product_status;

        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm mới thành công thương hiệu sản phẩm');
        return Redirect::to('add-brand-product');
    }

    public function unactive_brand_product($brand_product_id) {
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        Session::put('message','Đã ẩn danh mục thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }
    public function active_brand_product($brand_product_id) {
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        Session::put('message','Đã hiển thị danh mục thương hiệu thành công');
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($brand_product_id) {
        $this->AuthLogin();
        $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get(); // nếu có brand_id = tham số brand_product_id truyền vào thì lấy dl danh mục đó ra
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product', $manager_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id) {
        $this->AuthLogin();
        $data = array();
        $data['brand_name'] = $request->brand_product_name; //$data['tên cột trong DB'] = $request->giá trị của thuộc tính name;
        $data['brand_desc'] = $request->brand_product_desc;
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id) {
        $this->AuthLogin();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->delete();
        Session::put('message','Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }
    // end function admin page


    public function show_brand_home($brand_id) {
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();

        $min_price = DB::table('tbl_product')->min('product_price'); // biến tạm
        $min_price_range = $min_price - 500000;
        $max_price = DB::table('tbl_product')->max('product_price');
        $max_price_range = $max_price + 1000000;
        if(isset($_GET['start_price']) && isset($_GET['end_price'])) {
            $min_price = $_GET['start_price']; // lấy dl từ thẻ input có name start_price và end_price ở form trong show_category
            $max_price = $_GET['end_price'];

            if($min_price != '' && $max_price != '') {
                $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_id)->whereBetween('product_price',[$min_price,$max_price])->orderBy('product_price','asc')->paginate(9);
            } else {
                $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_id)->paginate(9); // ko chọn thì trả về all sản phẩm theo id brand
            }
           
        } else {
            $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_id)->paginate(9);
        }
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->limit(1)->get();

        foreach($brand_name as $key => $val){
            $meta_title = $val->brand_name;
        }

        return view('pages.brand.show_brand')->with('category',$cate_product)->with('brand',$brand_product)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)->with('slider',$slider)->with('meta_title',$meta_title)->with('min_price',$min_price)->with('max_price',$max_price)->with('min_price_range',$min_price_range)->with('max_price_range',$max_price_range);
    }
}
