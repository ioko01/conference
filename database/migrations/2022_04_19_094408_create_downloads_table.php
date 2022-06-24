<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('downloads', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('ไอดีผู้เข้าสู่ระบบ');
            $table->string('name')->comment('ชื่อหัวข้อดาวน์โหลด');
            $table->string('link')->nullable()->comment('ลิงค์ดาวน์โหลด');
            $table->string('name_file')->nullable()->comment('ชื่อไฟล์ดาวน์โหลด');
            $table->string('path_file')->nullable()->comment('ไฟล์ดาวน์โหลด');
            $table->string('ext_file')->nullable()->comment('นามสกุลไฟล์ดาวน์โหลด');
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
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
        Schema::dropIfExists('downloads');
    }
}
