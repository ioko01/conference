<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProceedingTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceeding_topics', function (Blueprint $table) {
            $table->id();
            $table->integer('conference_id')->comment('ไอดีการจัดงานประชุมวิชาการ')->nullable();
            $table->string('user_id')->comment('ไอดีผู้สร้างหัวข้อนี้');
            $table->text('name')->comment('ชื่อหัวข้อไฟล์ Proceedings');
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
        Schema::dropIfExists('proceeding_topics');
    }
}
