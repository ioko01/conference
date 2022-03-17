<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conferences', function (Blueprint $table) {
            $table->id();
            $table->text('name')->comment('ชื่องานประชุม');
            $table->tinyInteger('status')->comment('สถานะงานประชุม')->default(0);
            $table->string('year')->comment('ปีที่จัดงานประชุม');
            $table->datetime('start')->comment('วันที่เริ่มจัดงานประชุม');
            $table->datetime('end')->comment('วันที่สิ้นสุดการจัดงานประชุม');
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
        Schema::dropIfExists('conferences');
    }
}
