<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attends', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('prefix')->comment('คำนำหน้า');
            $table->text('fullname')->comment('ชื่อ - สกุล');
            $table->enum('sex', ['male', 'female'])->comment('เพศ');
            $table->string('phone')->comment('เบอร์โทร');
            $table->text('institution')->comment('สังกัด/หน่วยงาน');
            $table->integer('position_id')->comment('รหัสสถานะการเข้าร่วม');
            $table->integer('kota_id')->nullable()->comment('รหัสโควต้าเจ้าภาพร่วม');
            $table->enum('person_attend', ['send', 'attend'])->comment('ชนิดการเข้าร่วม "send=ส่งผลงาน attend=เข้าร่วมงานทั่วไป"');
            $table->string('email')->unique()->comment('อีเมล');
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
        Schema::dropIfExists('attends');
    }
}
