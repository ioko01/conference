<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkOralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link_orals', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->text('room')->comment('ชื่อห้อง');
            $table->text('link')->comment('ลิงค์');
            $table->text('name')->comment('ชื่อไฟล์');
            $table->text('path')->comment('แหล่งที่อยู่');
            $table->string('extension')->comment('นามสกุล');
            $table->string('faculty_id')->comment('รหัสกลุ่มคณะ');
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
        Schema::dropIfExists('link_orals');
    }
}
