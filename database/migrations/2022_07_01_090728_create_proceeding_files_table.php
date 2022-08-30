<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceedingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceeding_files', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->string('topic_id')->comment('ไอดี Proceeding');
            $table->text('name')->comment('ชื่อหัวข้อไฟล์ Proceedings');
            $table->text('link')->nullable()->comment('ลิงค์ไฟล์ Proceedings');
            $table->text('path')->nullable()->comment('ที่อยู่ไฟล์ Proceedings');
            $table->string('extension')->nullable()->comment('นามสกุลไฟล์ Proceedings');
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
        Schema::dropIfExists('proceeding_files');
    }
}
