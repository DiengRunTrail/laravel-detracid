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
    Schema::create('tbl_user_locations', function (Blueprint $table) {
      $table->id();
      $table->string('uid', 100)->collation('utf8mb4_general_ci');
      $table->string('category', 100)->nullable(false)->collation('utf8mb4_general_ci');
      $table->string('fullname', 100)->nullable(false)->collation('utf8mb4_general_ci');
      $table->string('email', 100)->collation('utf8mb4_general_ci');
      $table->string('latitude')->collation('utf8mb4_general_ci');
      $table->string('longitude')->collation('utf8mb4_general_ci');
      $table->string('altitude')->collation('utf8mb4_general_ci');
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
    Schema::dropIfExists('tbl_user_locations');
  }
}
