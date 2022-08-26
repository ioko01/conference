<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->string('topic_id')->comment('รหัสบทความ');
            $table->text('name')->nullable()->comment('ชื่อ video');
            $table->text('file')->nullable()->comment('ไฟล์ video');
            $table->text('path')->nullable()->comment('แหล่งที่อยู่ไฟล์');
            $table->text('link')->nullable()->comment('ลิงค์ video');
            $table->string('extension')->nullable()->comment('นามสกุล video');
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
        Schema::dropIfExists('videos');
    }
}
