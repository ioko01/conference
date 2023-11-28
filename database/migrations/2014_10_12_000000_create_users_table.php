<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('prefix')->comment('คำนำหน้า');
            $table->text('fullname')->comment('ชื่อ - สกุล');
            $table->enum('sex', ['male', 'female'])->comment('เพศ');
            $table->string('phone')->comment('เบอร์โทร');
            $table->text('institution')->comment('สังกัด/หน่วยงาน');
            $table->text('address')->comment('ที่อยู่ (ใช้ในการออกใบเสร็จรับเงิน และส่งเอกสาร)')->nullable();
            $table->enum('check_requirement', ['before', 'after'])->comment('ความต้องการในการรับใบเสร็จรับเงิน')->nullable();
            $table->integer('position_id')->comment('รหัสสถานะการเข้าร่วม');
            $table->integer('kota_id')->nullable()->comment('รหัสโควต้าเจ้าภาพร่วม');
            $table->enum('person_attend', ['send', 'attend', 'expert'])->comment('ชนิดการเข้าร่วม "send=ส่งผลงาน attend=เข้าร่วมงานทั่วไป" expert=ผู้ทรงคุณวุฒิ');
            $table->string('email')->unique()->comment('อีเมล');
            $table->timestamp('email_verified_at')->nullable()->comment('ยืนยันอีเมล');
            $table->boolean('is_admin')->default(0)->comment('0=ผู้ลงทะเบียนทั่วไป, 1=แอดมินเฉพาะเอาไว้ดูข้อมูล, 2=แอดมิน, 3=ซุปเปอร์แอดมิน');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
