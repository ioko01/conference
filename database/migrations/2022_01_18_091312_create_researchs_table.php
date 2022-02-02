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
            $table->string('user_id')->comment('ไอดีผู้เข้าสู่ระบบ');
            $table->string('topic_id')->comment('รหัสบทความ');
            $table->text('topic_th')->comment('ชื่อบทความภาษาไทย');
            $table->text('topic_en')->comment('ชื่อบทความภาษาอังกฤษ');
            $table->string('topic_status')->default(1)->comment('สถานะของบทความ');
            $table->text('presenter')->comment('ชื่อผู้นำเสนอ');
            $table->string('faculty_id')->comment('ไอดีกลุ่มคณะ');
            $table->string('branch_id')->comment('ไอดีสาขา');
            $table->integer('degree_id')->comment('รหัสระดับบทความ');
            $table->integer('present_id')->comment('รหัสชนิดการนำเสนอ');
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