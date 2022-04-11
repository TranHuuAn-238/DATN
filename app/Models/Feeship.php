<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    use HasFactory;

    public $timestamps = false; // set time to false (không sử dụng time stamps)
    protected $fillable = [
        'fee_matp', 'fee_maqh', 'fee_xaid', 'fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_feeship'; // bắt buộc

    public function city() {
        // tạo mối quan hệ
        // freeship này thuộc về model city dựa vào fee_matp, id matp của City sẽ so sánh vs fee_matp để đối chứng, 1 fee_matp thuộc 1 id matp tương ứng
        return $this->belongsTo('App\Models\City', 'fee_matp');
    }
    public function province() {
        return $this->belongsTo('App\Models\Province', 'fee_maqh');
    }
    public function wards() {
        return $this->belongsTo('App\Models\Wards', 'fee_xaid');
    }
}
