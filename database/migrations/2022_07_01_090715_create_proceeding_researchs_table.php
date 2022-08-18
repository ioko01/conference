<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceedingResearchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceeding_researchs', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->string('number')->comment('เลขหน้า');
            $table->text('topic')->comment('ชื่อบทความ');
            $table->string('faculty_id')->comment('ไอดีกลุ่มคณะ');
            $table->string('branch_id')->comment('ไอดีกลุ่มสาขา')->nullable();
            $table->string('degree_id')->comment('ไอดีระดับบทความ')->nullable();
            $table->string('present_id')->comment('ไอดีชนิดการนำเสนอ');
            $table->string('name')->comment('ชื่อไฟล์บทความ Proceeding')->nullable();
            $table->string('path')->comment('ที่อยู่ไฟล์บทความ Proceeding')->nullable();
            $table->string('extension')->comment('นามสกุลไฟล์บทความ Proceeding')->nullable();
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
        Schema::dropIfExists('proceeding_researchs');
    }
}
