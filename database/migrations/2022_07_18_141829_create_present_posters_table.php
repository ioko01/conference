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
            $table->text('topic_th')->comment('ชื่อบทความ');
            $table->string('present_poster_id')->comment('รหัสการนำเสนอ');
            $table->string('faculty_id')->comment('รหัสกลุ่มคณะ');
            $table->text('link')->comment('ลิงค์คลิปวิดีโอ')->nullable();
            $table->text('path')->comment('แหล่งที่อยู่ไฟล์')->nullable();
            $table->text('extension')->comment('นามสกุลไฟล์')->nullable();
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
