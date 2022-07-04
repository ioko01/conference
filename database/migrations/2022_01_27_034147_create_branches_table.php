<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้')->nullable();
            $table->string('name')->comment('ชื่อสาขา');
            $table->integer('faculty_id')->comment('รหัสกลุ่มคณะ');
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
        Schema::dropIfExists('branches');
    }
}