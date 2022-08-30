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
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->text('name')->comment('ชื่องานประชุม');

            $table->tinyInteger('status')->comment('สถานะงานประชุม')->default(0);
            $table->string('year')->primary()->comment('ปีที่จัดงานประชุม');
            $table->datetime('start')->comment('วันเปิดงานประชุม');
            $table->datetime('final')->comment('สิ้นสุดการจัดงานประชุม');

            $table->tinyInteger('status_research')->comment('สถานะการเปิดรับบทความ')->default(0);
            $table->datetime('end_research')->comment('วันสิ้นสุดการรับบทความ (Call for Paper)');

            $table->tinyInteger('status_payment')->comment('สถานะการเปิดให้ชำระเงิน')->default(0);
            $table->datetime('end_payment')->comment('วันสิ้นสุดการชำระเงิน');

            $table->tinyInteger('status_consideration')->comment('สถานะประกาศผลพิจารณา')->default(0);
            $table->datetime('consideration')->comment('ประกาศผลพิจารณา');

            $table->tinyInteger('status_research_edit')->comment('สถานะการรับบทความฉบับแก้ไข')->default(0);
            $table->datetime('end_research_edit')->comment('วันสิ้นสุดการรับบทความฉบับแก้ไข');

            $table->tinyInteger('status_attend')->comment('สถานะการลงทะเบียนเข้าร่วมงาน')->default(0);
            $table->datetime('end_attend')->comment('วันสิ้นสุดการลงทะเบียนเข้าร่วมงาน');

            $table->tinyInteger('status_research_edit_two')->comment('สถานะการรับบทความฉบับแก้ไขครั้งที่ 2')->default(0);
            $table->datetime('end_research_edit_two')->comment('วันสิ้นสุดการรับบทความฉบับแก้ไขครั้งที่ 2')->nullable();

            $table->tinyInteger('status_poster_and_video')->comment('สถานะการส่งไฟล์โปสเตอร์และวิดีโอ')->default(0);
            $table->datetime('end_poster_and_video')->comment('วันสิ้นสุดการส่งไฟล์โปสเตอร์และวิดีโอ');

            $table->tinyInteger('status_present_poster')->comment('สถานะผลงานนำเสนอ Poster')->default(0);
            $table->tinyInteger('status_present_oral')->comment('สถานะผลงานนำเสนอ Oral')->default(0);

            $table->tinyInteger('status_notice_attend')->comment('สถานะประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด')->default(0);
            $table->datetime('notice_attend')->comment('ประกาศรายชื่อผู้เข้าร่วมงานทั้งหมด');

            $table->tinyInteger('status_present')->comment('สถานะนำเสนอผลงาน')->default(0);
            $table->datetime('present')->comment('นำเสนอผลงาน');

            $table->tinyInteger('status_proceeding')->comment('สถานะเผยแพร่ Proceeding')->default(0);
            $table->datetime('proceeding')->comment('เผยแพร่ Proceeding');

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
