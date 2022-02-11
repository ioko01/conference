<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendPdfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_edit_pdf', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('ไอดีผู้เข้าสู่ระบบ');
            $table->text('topic_id')->comment('รหัสบทความ');
            $table->text('name')->comment('ชื่อไฟล์');
            $table->text('path')->comment('path ไฟล์');
            $table->string('extension')->comment('นามสกุลไฟล์');
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
        Schema::dropIfExists('send_edit_pdf');
    }
}
