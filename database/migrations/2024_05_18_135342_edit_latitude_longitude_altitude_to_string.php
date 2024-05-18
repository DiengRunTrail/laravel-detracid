<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditLatitudeLongitudeAltitudeToString extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users_location', function (Blueprint $table) {
      $table->string('latitude')->change();
      $table->string('longitude')->change();
      $table->string('altitude')->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    // Schema::table('string', function (Blueprint $table) {
    //   //
    // });
  }
}
