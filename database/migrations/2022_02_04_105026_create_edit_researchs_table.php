<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditResearchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_researchs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->comment('ไอดีผู้เข้าสู่ระบบ');
            $table->text('topic_id')->comment('รหัสบทความ');
            $table->text('new_word')->nullable()->comment('ชื่อไฟล์');
            $table->text('new_pdf')->nullable()->comment('ชื่อไฟล์');
            $table->text('path_word')->nullable()->comment('path ไฟล์');
            $table->text('path_pdf')->nullable()->comment('path ไฟล์');
            $table->string('extension_word')->nullable()->comment('นามสกุลไฟล์');
            $table->string('extension_pdf')->nullable()->comment('นามสกุลไฟล์');
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
        Schema::dropIfExists('edit_researchs');
    }
}
