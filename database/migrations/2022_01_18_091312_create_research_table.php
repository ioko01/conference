<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->sttring('user_id');
            $table->string('topic_id');
            $table->text('topic_th');
            $table->text('topic_en');
            $table->text('topic_status');
            $table->text('presenter');
            $table->string('group');
            $table->string('group2');
            $table->string('volumn');
            $table->enum('type', ['oral', 'poster']);
            $table->enum('person_type', ['in', 'out', 'kota']);
            $table->text('file_word')->nullable();
            $table->text('file_pdf')->nullable();
            $table->text('file_poster')->nullable();
            $table->text('video_file')->nullable();
            $table->text('video_link')->nullable();
            $table->text('payment')->nullable();
            $table->string('payment_date')->nullable();
            $table->text('payment_address')->nullable();
            $table->text('payment_status')->nullable();
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
        Schema::dropIfExists('research');
    }
}