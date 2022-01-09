<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_admin', function (Blueprint $table) {
            //$table->id();
            $table->increments('admin_id');
            $table->string('admin_email'); // mặc định bằng 255
            $table->string('admin_password');
            $table->string('admin_name');
            $table->string('admin_phone');
            $table->timestamps(); // thời gian tạo bảng
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_admin');
    }
}
