<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('ชื่องานประชุม');

            $table->tinyInteger('status')->comment('สถานะงานประชุม')->default(0);
            $table->string('year')->comment('ปีที่จัดงานประชุม');
            $table->datetime('start')->comment('วันเปิดงานประชุม');
            $table->datetime('final')->comment('สิ้นสุดการจัดงานประชุม');

            $table->tinyInteger('status_research')->comment('สถานะการเปิดรับบทความ')->default(0);
            $table->datetime('start_research')->comment('วันเปิดรับบทความ');
            $table->datetime('end_research')->comment('วันสิ้นสุดการรับบทความ');

            $table->tinyInteger('status_payment')->comment('สถานะการเปิดให้ชำระเงิน')->default(0);
            $table->datetime('end_payment')->comment('วันสิ้นสุดการชำระเงิน');

            $table->tinyInteger('status_attend')->comment('สถานะการลงทะเบียนเข้าร่วมงาน')->default(0);
            $table->datetime('end_attend')->comment('วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน');

            $table->tinyInteger('status_research_edit')->comment('สถานะการรับบทความฉบับแก้ไข')->default(0);
            $table->datetime('end_research_edit')->comment('วันสิ้นสุดการรับบทความฉบับแก้ไข');

            $table->tinyInteger('status_research_edit_two')->comment('สถานะการรับบทความฉบับแก้ไขครั้งที่ 2')->default(0);
            $table->datetime('end_research_edit_two')->comment('วันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 2');

            $table->tinyInteger('status_poster_and_video')->comment('สถานะการส่งไฟล์โปสเตอร์และวิดีโอ')->default(0);
            $table->datetime('end_poster_and_video')->comment('วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ');

            $table->tinyInteger('status_poster_and_video_two')->comment('สถานะการส่งไฟล์โปสเตอร์และวิดีโอครั้งที่ 2')->default(0);
            $table->datetime('end_poster_and_video_two')->comment('วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอครั้งที่ 2');

            
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
        Schema::dropIfExists('conferences');
    }
}
