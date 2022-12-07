<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researchs', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->string('topic_id')->comment('รหัสบทความ');
            $table->text('topic_th')->comment('ชื่อบทความภาษาไทย');
            $table->text('topic_en')->comment('ชื่อบทความภาษาอังกฤษ');
            $table->string('topic_status')->default(1)->comment('สถานะของบทความ');
            $table->text('presenter')->comment('ชื่อผู้นำเสนอ');
            $table->string('faculty_id')->comment('ไอดีกลุ่มคณะ');
            $table->string('branch_id')->comment('ไอดีสาขา');
            $table->integer('degree_id')->comment('รหัสระดับบทความ');
            $table->integer('present_id')->comment('รหัสชนิดการนำเสนอ');
            $table->tinyInteger('research_passed')->default(0)->comment('บทความที่ผ่านการพิจารณา 0=ตรวจสอบ 1=ผ่าน 2=ไม่ผ่าน');
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
        Schema::dropIfExists('researchs');
    }
}
