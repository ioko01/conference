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
            $table->string('name_th');
            $table->string('name_en');
            $table->string('research_name');
            $table->string('group');
            $table->string('group2');
            $table->string('volumn');
            $table->enum('type', ['oral', 'poster']);
            $table->enum('person_type', ['in', 'out', 'kota']);
            $table->text('word')->nullable();
            $table->text('pdf')->nullable();
            $table->text('payment')->nullable();
            $table->string('payment_date')->nullable();
            $table->text('payment_address')->nullable();
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
