<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendSuggestionResearchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('send_suggestion_researchs', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_send_id')->comment('ไอดีส่งไฟล์');
            $table->string('user_receive_id')->comment('ไอดีผู้รับไฟล์');
            $table->string('topic_id')->comment('รหัสบทความ');

            $table->text('file_admin_send')->comment('ชื่อไฟล์ตอนแอดมินส่ง')->nullable();
            $table->text('path_admin_send')->comment('แหล่งที่อยู่ไฟล์ล์ตอนแอดมินส่ง')->nullable();
            $table->string('extension_admin_send')->comment('นามสกุลไฟล์ล์ตอนแอดมินส่ง')->nullable();

            $table->text('file_expert_receive')->comment('ชื่อไฟล์ตอนแอดมินรับ')->nullable();
            $table->text('path_expert_receive')->comment('แหล่งที่อยู่ไฟล์ล์ตอนแอดมินรับ')->nullable();
            $table->string('extension_expert_receive')->comment('นามสกุลไฟล์ล์ตอนแอดมินรับ')->nullable();
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
        Schema::dropIfExists('send_suggestion_researchs');
    }
}
