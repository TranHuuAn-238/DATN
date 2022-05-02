<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Slider;
use Session;
use Illuminate\Support\Facades\Redirect;

class SliderController extends Controller
{
    //
    // xác thực đã đăng nhập vào admin chưa
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function manage_slider() {
        $all_slide = Slider::orderBy('slider_id' ,'DESC')->paginate(10); // slide thêm sau mới nhất lên đầu
        return view('admin.slider.list_slider')->with(compact('all_slide'));
    }
    public function add_slider() {
        return view('admin.slider.add_slider');
    }
    public function unactive_slide($slide_id) {
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slide_id)->update(['slider_status'=>0]);
        Session::put('message','Đã ẩn slider thành công');
        return Redirect::to('manage-slider');
    }
    public function active_slide($slide_id) {
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slide_id)->update(['slider_status'=>1]);
        Session::put('message','Đã hiển thị slider thành công');
        return Redirect::to('manage-slider');
    }
    public function insert_slider(Request $request) {
        $data = $request->all();
        //dd($data);
        $this->AuthLogin();
        // $data = array();
        // lấy dl theo thuộc tính name ở form trong view
        
        $get_image = $request->file('slider_image'); // người dùng chọn ảnh ko
        
        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName(); // lấy toàn bộ tên ảnh (cả đuôi định dạng ảnh: .jpg, .png, .jpeg...)
            $name_image = current(explode('.', $get_name_image)); // loại bỏ định dạng ảnh ở cuối trong tên, chỉ lấy tên, dùng current() để lấy phần tử đầu tiên(chỉ là tên) của mảng sau khi tách chuỗi bằng explode()
            $new_image = $name_image.rand(0,99). '.' . $get_image->getClientOriginalExtension(); // getClientOriginalExtension() lấy định dạng ảnh(jpg, png, jpeg...)
            $get_image->move('public/uploads/slider', $new_image); // move ~ move_uploaded_file
            
            $slider =  new Slider();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_status = $data['slider_status'];
            $slider->slider_desc = $data['slider_desc'];
            $slider->save();
            Session::put('message','Thêm mới slider thành công');
            return Redirect::to('add-slider');
        } else {
            // else ko thêm ảnh
            Session::put('message','Hãy thêm hình ảnh trước');
            return Redirect::to('add-slider');
        }
        
        // nếu có ảnh thì thêm những dữ liệu còn lại
        
    }

    public function delete_slider($slider_id) {
        $this->AuthLogin();
        $image = DB::table('tbl_slider')->where('slider_id',$slider_id)->first();
        unlink('public/uploads/slider/'.$image->slider_image); // xóa ảnh trong folder
        DB::table('tbl_slider')->where('slider_id',$slider_id)->delete();
        Session::put('message','Xóa slider thành công');
        return Redirect::to('manage-slider');
    }
}
