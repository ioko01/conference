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
            $table->string('prefix')->comment('คำนำหน้า');
            $table->string('fullname')->comment('ชื่อ - สกุล');
            $table->enum('sex', ['male', 'female'])->comment('เพศ');
            $table->string('phone')->comment('เบอร์โทร');
            $table->text('institution')->comment('สังกัด/หน่วยงาน');
            $table->text('address')->comment('ที่อยู่');
            $table->integer('position_id')->comment('รหัสสถานะการเข้าร่วม');
            $table->integer('kota_id')->nullable()->comment('รหัสโควต้าเจ้าภาพร่วม');
            $table->enum('person_attend', ['send', 'attend'])->comment('รหัสบทความ');
            $table->string('email')->unique()->comment('อีเมล');
            $table->timestamp('email_verified_at')->nullable()->comment('ยืนยันอีเมล');
            $table->boolean('is_admin')->default(0);
            $table->string('password');
            $table->string('year')->comment('ปีที่จัดงานประชุม');
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