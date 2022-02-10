<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    public $timestamps = false; // set time to false (không sử dụng time stamps)
    protected $fillable = [
        'slider_name', 'slider_image', 'slider_status', 'slider_desc'
    ];
    protected $primaryKey = 'slider_id';
    protected $table = 'tbl_slider'; // bắt buộc
}
