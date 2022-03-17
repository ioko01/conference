<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('ไอดีผู้เข้าสู่ระบบ');
            $table->string('topic_id')->comment('รหัสบทความ');
            $table->text('name')->nullable()->comment('ชื่อไฟล์');
            $table->text('path')->nullable()->comment('path');
            $table->string('extension')->nullable()->comment('นามสกุลไฟล์');
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
        Schema::dropIfExists('comments');
    }
}
