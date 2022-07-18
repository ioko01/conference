<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentPostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('present_posters', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->string('poster_id')->comment('รหัสการนำเสนอ');
            $table->text('topic')->comment('ชื่อบทความ');
            $table->text('link')->comment('ลิงค์คลิปวิดีโอ')->nullable();
            $table->text('name')->comment('ชื่อไฟล์')->nullable();
            $table->text('path')->comment('ที่อยู่ไฟล์ Poster')->nullable();
            $table->text('extension')->comment('นามสกุลไฟล์ Poster')->nullable();
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
        Schema::dropIfExists('present_posters');
    }
}
