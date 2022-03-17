<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->text('head')->comment('หัวข้อคำแนะนำ');
            $table->text('detail')->comment('รายละเอียดคำแนะนำ');
            $table->text('image')->comment('รูปภาพ');
            $table->integer('group')->comment('กลุ่มที่');
            $table->string('year')->comment('ปีที่จัดงานประชุม');
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
        Schema::dropIfExists('tips');
    }
}