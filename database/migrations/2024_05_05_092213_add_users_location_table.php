<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsersLocationTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    // add user location table
    Schema::create('users_location', function (Blueprint $table) {
      $table->id();
      $table->string('uid', 255)->unique();
      $table->string('category', 255)->nullable(false);
      $table->string('fullname', 255)->nullable(false);
      $table->string('email', 255);
      $table->string('latitude');
      $table->string('longitude');
      $table->string('altitude');
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
    Schema::dropIfExists('users_location');
  }
}
