<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public $timestamps = false; // set time to false (không sử dụng time stamps)
    protected $fillable = [
        'coupon_name', 'coupon_code', 'coupon_time', 'coupon_discount', 'coupon_condition', 'coupon_status', 'coupon_desc', 'coupon_used', 'coupon_date_start', 'coupon_date_end'
    ];
    protected $primaryKey = 'coupon_id';
    protected $table = 'tbl_coupon'; // bắt buộc
}
