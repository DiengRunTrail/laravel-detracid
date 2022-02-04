<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaceRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('race_requirements', function (Blueprint $table) {
            $table->id();
            // 1st method
            // $table->bigInteger('race_id')->unsigned();
            $table->foreignId('race_id')->constrained();
            $table->string('name');
            $table->timestamps();
            
            // 1st method
            // $table->foreign('race_id')->references('id')->on('races')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('race_requirements');
    }
}
