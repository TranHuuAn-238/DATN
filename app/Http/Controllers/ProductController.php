<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use App\Models\Gallery;
use File; // dùng class này copy file ảnh từ folder product sang gallery
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class ProductController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function quickview(Request $request) {
        $product_id = $request->product_id;
        $product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->first(); // ~ details_product

        $output['product_name'] = $product->product_name;
        $output['product_id'] = $product->product_id;
        $output['product_desc'] = $product->product_desc;
        $output['product_content'] = $product->product_content;
        $output['product_price'] = number_format($product->product_price,0,',','.') . ' VNĐ';
        // $uri = $_SERVER['HTTP_HOST']; // localhost:8080
        // $uri = $_SERVER['QUERY_STRING'];
        // $uri = $_SERVER['REQUEST_URI']; // /shopbanhang/chi-tiet-san-pham/8
        $url = $request->urll;
        if($url == 'http://localhost:8080/shopbanhang/' || $url == 'http://localhost:8080/shopbanhang/trang-chu' || $url == 'http://localhost:8080/shopbanhang/tim-kiem') {
            // location.pathname thì /shopbanhang/ và /shopbanhang/trang-chu
            $output['product_image'] = '<p><img width="100%" src="public/uploads/product/' . $product->product_image . '"></p>';
        } else {
            $output['product_image'] = '<p><img width="100%" src="../public/uploads/product/' . $product->product_image . '"></p>';
        }

        $output['product_button'] = '<button type="button" class="btn btn-fefault cart add-to-cart" data-id_product="'. $product->product_id .'" name="add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        Mua ngay
                                    </button>
        ';
        $output['product_quickview_value'] = ' 
        <input type="hidden" value="' . $product->product_id . '" class="cart_product_id_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_name . '" class="cart_product_name_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_image . '" class="cart_product_image_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_price . '" class="cart_product_price_' . $product->product_id . '">
        <input type="hidden" value="1" class="cart_product_qty_' . $product->product_id . '">
        <input type="hidden" value="' . $product->product_quantity . '" class="cart_product_quantity_' . $product->product_id . '">
        ';

        echo json_encode($output); // mã hóa $output thành json, trả dl về cho ajax dưới dạng json
    }

    public function add_product() {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
    }

    public function all_product() {
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->orderby('tbl_product.product_id','desc')->paginate(10);
        $manager_product = view('admin.all_product')->with('all_product',$all_product); // 'all_brand_product' sẽ chứa dl để in ra ở view
        //return view('admin.all_brand_product');
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function save_product(Request $request) { // lấy dl từ form gửi lên vào hàm này để xử lý
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT); // lọc kí tự số, loại bỏ dấu ',' trong giá trước khi insert
        $product_quantity = filter_var($request->product_quantity, FILTER_SANITIZE_NUMBER_INT);
        // lấy dl theo thuộc tính name ở form trong view
        $data['product_name'] = $request->product_name; //$data['tên cột trong DB'] = $request->giá trị của thuộc tính name;
        $data['product_price'] = $product_price;
        $data['product_quantity'] = $product_quantity;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_image'] = $request->product_image;
        $get_image = $request->file('product_image'); // người dùng chọn ảnh ko

        $path = 'public/uploads/product/'; // khi thêm 1 sản phẩm thì mặc định lấy luôn 1 ảnh sản phẩm đó vào gallery
        $path_gallery = 'public/uploads/gallery/';
        
        // người dùng phải chọn ảnh
        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); // lấy toàn bộ tên ảnh (cả đuôi định dạng ảnh: .jpg, .png, .jpeg...)
            $name_image = current(explode('.', $get_name_image)); // loại bỏ định dạng ảnh ở cuối trong tên, chỉ lấy tên, dùng current() để lấy phần tử đầu tiên(chỉ là tên) của mảng sau khi tách chuỗi bằng explode()
            $new_image = $name_image.rand(0,99). '.' . $get_image->getClientOriginalExtension(); // getClientOriginalExtension() lấy định dạng ảnh(jpg, png, jpeg...)
            $get_image->move($path, $new_image); // move ~ move_uploaded_file
            File::copy($path.$new_image,$path_gallery.$new_image); // copy ảnh từ product->gallery với tên $new_image
            $data['product_image'] = $new_image;
            
        }
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();
        Session::put('message','Thêm mới sản phẩm thành công');
        return Redirect::to('all-product');

        // else ko thêm ảnh
        // $data['product_image'] = '';
        // DB::table('tbl_product')->insert($data);
        // Session::put('message','Thêm mới sản phẩm thành công');
        // return Redirect::to('all-product');
    }

    public function unactive_product($product_id) {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Đã ẩn sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function active_product($product_id) {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Đã hiển thị sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id) {
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->orderby('brand_id','desc')->get();
        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get(); // nếu có product_id = tham số $product_id truyền vào thì lấy dl danh mục đó ra
        $manager_product = view('admin.edit_product')->with('edit_product',$edit_product)->with('cate_product',$cate_product)->with('brand_product',$brand_product);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }
    public function update_product(Request $request, $product_id) {
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT); // lọc kí tự số, loại bỏ dấu ',' trong giá trước khi insert
        $product_quantity = filter_var($request->product_quantity, FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name; //$data['tên cột trong DB'] = $request->giá trị của thuộc tính name;
        $data['product_price'] = $product_price;
        $data['product_quantity'] = $product_quantity;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $get_image = $request->file('product_image'); // người dùng chọn ảnh ko

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); // lấy toàn bộ tên ảnh (cả đuôi định dạng ảnh: .jpg, .png, .jpeg...)
            $name_image = current(explode('.', $get_name_image)); // loại bỏ định dạng ảnh ở cuối trong tên, chỉ lấy tên, dùng current() để lấy phần tử đầu tiên(chỉ là tên) của mảng sau khi tách chuỗi bằng explode()
            $new_image = $name_image.rand(0,99). '.' . $get_image->getClientOriginalExtension(); // getClientOriginalExtension() lấy định dạng ảnh(jpg, png, jpeg...)
            $get_image->move('public/uploads/product', $new_image); // move ~ move_uploaded_file
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id',$product_id)->update($data);
            Session::put('message','Cập nhật sản phẩm thành công');
            return Redirect::to('all-product');
        }
        // else ko thêm ảnh thì để nguyên
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }
    public function delete_product($product_id) {
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    // end admin page

    public function details_product($product_id) {
        //slide
        $slider = Slider::orderBy('slider_id','DESC')->where('slider_status','1')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status','1')->orderby('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status','1')->orderby('brand_id','desc')->get();
        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        // sản phẩm liên quan gợi ý - cùng danh mục - loại trừ sản phẩm đang xem thì ko cần gợi ý, for nhưng chỉ có 1 sp do dùng get()
        foreach($details_product as $k => $val) {
            $category_id = $val->category_id;
            $meta_title = $val->product_name; // seo
            $product_id = $val->product_id; // để lấy gallery theo product_id
        }
        // gallery
        $gallery = Gallery::where('product_id',$product_id)->get();


        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand','tbl_brand.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('pages.prod.show_details')->with('category',$cate_product)->with('brand',$brand_product)->with('product_details',$details_product)->with('relate',$related_product)->with('slider',$slider)->with('meta_title',$meta_title)->with('gallery',$gallery);
    }
}
