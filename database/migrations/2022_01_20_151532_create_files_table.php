<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('topic_id')->comment('รหัสบทความ');
            $table->text('file_word')->nullable()->comment('ไฟล์ word');
            $table->text('file_pdf')->nullable()->comment('ไฟล์ pdf');
            $table->text('file_poster')->nullable()->comment('ไฟล์โปรสเตอร์');
            $table->text('video_file')->nullable()->comment('ไฟล์ video');
            $table->text('video_link')->nullable()->comment('ลิงค์ video');
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
        Schema::dropIfExists('files');
    }
}
