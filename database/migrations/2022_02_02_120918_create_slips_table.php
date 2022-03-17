<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('ไอดีผู้เข้าสู่ระบบ');
            $table->string('topic_id')->comment('รหัสบทความ');
            $table->text('name')->comment('ชื่อไฟล์');
            $table->text('path')->comment('path ไฟล์');
            $table->string('extension')->comment('นามสกุลไฟล์');
            $table->text('address')->nullable()->comment('ที่อยู่ผู้ชำระเงิน');
            $table->datetime('date')->nullable()->comment('วันที่ชำระเงิน');
            $table->string('year')->comment('ปีที่จัดงานประชุม');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slips');
    }
}
