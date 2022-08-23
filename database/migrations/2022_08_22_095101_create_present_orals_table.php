<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentOralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('present_orals', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->text('topic_th')->comment('ชื่อบทความ');
            $table->string('present_oral_id')->comment('รหัสการนำเสนอ');
            $table->string('faculty_id')->comment('รหัสกลุ่มคณะ');
            $table->time('time_start')->comment('เวลาเริ่มนำเสนอ');
            $table->time('time_end')->comment('เวลาจบการนำเสนอ');
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
        Schema::dropIfExists('present_orals');
    }
}
