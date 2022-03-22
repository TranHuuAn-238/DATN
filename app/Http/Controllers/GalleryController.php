<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use App\Models\Gallery;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class GalleryController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }

    public function add_gallery($product_id) {
        $this->AuthLogin();
        $pro_id = $product_id; // để lát hiển thị, cập nhật ảnh theo $pro_id
        return view('admin.gallery.add_gallery')->with(compact('pro_id'));
    }

    public function update_gallery_name(Request $request) {
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = Gallery::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save(); // lưu, ko cần phải redirect
    }

    public function insert_gallery(Request $request, $pro_id) {
        $this->AuthLogin();
        $get_image = $request->file('file'); // name bên form add_gallery là 'file'
        if($get_image) {
            // có ảnh
            foreach($get_image as $image) {
                // xử lý từng ảnh
                $get_name_image = $image->getClientOriginalName(); // lấy toàn bộ tên ảnh (cả đuôi định dạng ảnh: .jpg, .png, .jpeg...)
                $name_image = current(explode('.', $get_name_image)); // loại bỏ định dạng ảnh ở cuối trong tên, chỉ lấy tên, dùng current() để lấy phần tử đầu tiên(chỉ là tên) của mảng sau khi tách chuỗi bằng explode()
                $new_image = $name_image.rand(0,99). '.' . $image->getClientOriginalExtension(); // getClientOriginalExtension() lấy định dạng ảnh(jpg, png, jpeg...)
                $image->move('public/uploads/gallery', $new_image); // move ~ move_uploaded_file
                $gallery = new Gallery();
                $gallery->gallery_name = $new_image;
                $gallery->gallery_image = $new_image;
                $gallery->product_id = $pro_id;
                $gallery->save();
            }
            Session::put('message','Thêm mới thư viện ảnh thành công');
            return redirect()->back(); // quay lại trang trước (trang add_gallery)
        }
        Session::put('message','Bạn chưa chọn ảnh!');
        return redirect()->back(); // quay lại trang trước (trang add_gallery)
    }

    public function delete_gallery(Request $request) {
        $this->AuthLogin();
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('public/uploads/gallery/'.$gallery->gallery_image); // xóa ảnh trong folder
        $gallery->delete(); // xóa dl về hình ảnh đó trên DB
    }

    public function update_gallery(Request $request) {
        $this->AuthLogin();
        // ~ insert_gallery
        $get_image = $request->file('file'); // name bên form là 'file'
        $gal_id = $request->gal_id;
        if($get_image) {
            // sửa 1 ảnh thôi
            $get_name_image = $get_image->getClientOriginalName(); // lấy toàn bộ tên ảnh (cả đuôi định dạng ảnh: .jpg, .png, .jpeg...)
            $name_image = current(explode('.', $get_name_image)); // loại bỏ định dạng ảnh ở cuối trong tên, chỉ lấy tên, dùng current() để lấy phần tử đầu tiên(chỉ là tên) của mảng sau khi tách chuỗi bằng explode()
            $new_image = $name_image.rand(0,99). '.' . $get_image->getClientOriginalExtension(); // getClientOriginalExtension() lấy định dạng ảnh(jpg, png, jpeg...)
            $get_image->move('public/uploads/gallery', $new_image); // move ~ move_uploaded_file

            $gallery = Gallery::find($gal_id);
            unlink('public/uploads/gallery/'.$gallery->gallery_image); // xóa ảnh cũ trong folder
            $gallery->gallery_image = $new_image; // lưu lại hình ảnh mới trên DB
            $gallery->save();
        }
    }

    public function select_gallery(Request $request) {
        // trả table về cho ajax (ở success)
        $product_id = $request->pro_id;
        $gallery = Gallery::where('product_id',$product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
                    <form>
                        '.csrf_field().'
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Thứ tự</th>
                            <th>Tên hình ảnh</th>
                            <th>Hình ảnh</th>
                            <th>Quản lý</th>
                        </tr>
                        </thead>
                        <tbody>
        ';
        if($gallery_count > 0) {
            // product đó có ảnh
            $i = 0;
            foreach($gallery as $key => $gal) {
                $i++;
                $output .= '
                            <tr>
                                <td>'.$i.'</td>
                                <td contenteditable class="edit_gal_name" data-gal_id="'.$gal->gallery_id.'">'.$gal->gallery_name.'</td>
                                <td>
                                    <img src="'.url('public/uploads/gallery/'.$gal->gallery_image).'" class="img-thumbnail" width="120" height="120">
                                    <input type="file" class="file_image" style="width:40%" data-gal_id="'.$gal->gallery_id.'" id="file-'.$gal->gallery_id.'" name="file" accept="image/*">
                                </td>
                                <td>
                                    <button type="button" data-gal_id="'.$gal->gallery_id.'" class="btn btn-xs btn-danger delete-gallery">Xóa</button>
                                </td>
                            </tr>
                ';
            }
        } else {
            $output .= '<tr>
                            <td colspan="4" align="center">Xe này chưa có thư viện ảnh</td>
                        </tr>

            ';
        }
        $output .= '
                </tbody>
                </table>
                </form>
        ';
        echo $output;
    }
}
