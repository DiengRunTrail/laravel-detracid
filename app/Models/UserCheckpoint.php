<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCheckpoint extends Model
{
  use HasFactory;

  protected $table = 'users_checkpoints';

  protected $fillable = [
    'user_id',
    'checkpoint',
  ];

  public function insertCheckpoint($userId, $checkpoint)
  {
    // check if row with same user id and checkpoint is already

    $row = $this->where('checkpoint', $checkpoint)
      ->where('user_id', $userId)
      ->first();

    if ($row) {
      return false;
    }

    return $this->create([
      'user_id' => $userId,
      'checkpoint' => $checkpoint,
    ]);
  }

  public function getUserCheckpoints($userId)
  {
    return $this->get();
  }
}
