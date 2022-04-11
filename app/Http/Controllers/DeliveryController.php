<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB; // sử dụng database
use Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Feeship;
session_start();

class DeliveryController extends Controller
{
    public function AuthLogin() {
        $admin_id = Session::get('admin_id'); // nếu có 1 session admin_id đã tạo ở public function dashboard
        if($admin_id) {
            return Redirect::to('dashboard');
        } else {
            return Redirect::to('admin')->send();
        }
    }
    public function update_delivery(Request $request) {
        $this->AuthLogin();
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'], '.'); //
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
    public function select_feeship() {
        $feeship = Feeship::orderby('fee_id','desc')->get();
        $output = '';
        $output .= '<div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên thành phố</th>
                                    <th>Tên quận huyện</th>
                                    <th>Tên xã phường</th>
                                    <th>Phí ship (vnđ)</th>
                                    <th>Quản lý</th>
                                </tr>
                            </thead>
                            <tbody>
                            ';
                        foreach($feeship as $key => $fee) {
                            $url = "http://localhost:8080/shopbanhang/delete-fee/$fee->fee_id";
                            $output .= '
                                <tr>
                                    <td>'.$fee->city->name_city.'</td>
                                    <td>'.$fee->province->name_quanhuyen.'</td>
                                    <td>'.$fee->wards->name_xaphuong.'</td>
                                    <td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
                                    <td><a onclick="return confirm(\'Bạn chắc chắn muốn xóa thông tin về phí vận chuyển này?\')" href="'.$url.'" class="active styling-edit" ui-toggle-class="">  
                                    <i class="fa fa-times text-danger text"></i>
                                  </a></td>
                                </tr>
                                ';
                        }
                        $output .= '
                            </tbody>
                        </table>
                    </div>
        ';

        echo $output;
    }
    public function delete_fee($feeship_id) {
        $this->AuthLogin();
        DB::table('tbl_feeship')->where('fee_id',$feeship_id)->delete();
        Session::put('message','Xóa thông tin phí vận chuyển thành công');
        return redirect()->back();
    }
    public function insert_delivery(Request $request) {
        $this->AuthLogin();
        $data = $request->all();
        $fee_ship = new Feeship();
        $fee_ship->fee_matp = $data['city'];
        $fee_ship->fee_maqh = $data['province'];
        $fee_ship->fee_xaid = $data['wards'];
        $fee_ship->fee_feeship = $data['fee_ship'];
        $fee_ship->save();
    }
    public function delivery(Request $request) {
        $this->AuthLogin();
        $city = City::orderby('matp', 'asc')->get();
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request) {
        $data = $request->all();
        if($data['action']) {
            $output = '';
            if($data['action'] == "city") {
                // chọn tỉnh/tp thì hiện quận/huyện tương ứng
                $select_province = Province::where('matp', $data['ma_id'])->orderby('maqh','asc')->get(); // ma_id là matp
                    $output .= '<option selected disabled hidden>--Chọn quận huyện--</option>';
                foreach($select_province as $key => $province) {
                    $output .= '<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }
                
            } else {
                // chọn quận huyện thì hiện xã/phường tương ứng
                $select_wards = Wards::where('maqh', $data['ma_id'])->orderby('xaid','asc')->get();
                    $output .= '<option selected disabled hidden>--Chọn xã phường--</option>';
                foreach($select_wards as $key => $ward) {
                    $output .= '<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
        }
        echo $output;
    }
}
