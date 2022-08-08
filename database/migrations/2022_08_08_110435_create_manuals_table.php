<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuals', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->integer('notice')->default(0)->comment('เอาลงประชาสัมพันธ์? 1=เอาลง 0=ไม่เอาลง');
            $table->string('name')->comment('ชื่อคู่มือ');
            $table->string('link')->nullable()->comment('ลิงค์ดาวน์โหลด');
            $table->string('name_file')->nullable()->comment('ชื่อไฟล์ดาวน์โหลด');
            $table->string('path_file')->nullable()->comment('ไฟล์ดาวน์โหลด');
            $table->string('ext_file')->nullable()->comment('นามสกุลไฟล์ดาวน์โหลด');
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
        Schema::dropIfExists('manuals');
    }
}
