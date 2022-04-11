<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostShippingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipping_name' => 'required',
            'shipping_email' => 'required|email',
            // 'calc_shipping_provinces' => 'required',
            // 'calc_shipping_district' => 'required',
            'city' => 'required',
            'province' => 'required',
            'wards' => 'required',
            'shipping_address' => 'required',
            'shipping_phone' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'shipping_name.required' => 'Tên người nhận không được bỏ trống',
            'shipping_email.required' => 'Địa chỉ Email không được bỏ trống',
            'shipping_email.email' => 'Phải là định dạng Email',
            // 'calc_shipping_provinces.required' => 'Bạn chưa chọn Tỉnh / Thành', // cũng ko thể lấy từ input vì imput đã lưu sẵn dl mình chọn từ trước đó rồi
            // 'calc_shipping_district.required' => 'Bạn chưa chọn Quận / Huyện',
            'city.required' => 'Bạn chưa chọn Tỉnh / Thành',
            'province.required' => 'Bạn chưa chọn Quận / Huyện',
            'wards.required' => 'Bạn chưa chọn Xã / Phường',
            'shipping_address.required' => 'Địa chỉ nhận hàng không được bỏ trống',
            'shipping_phone.required' => 'Số điện thoại không được bỏ trống'
        ];
    }
}
