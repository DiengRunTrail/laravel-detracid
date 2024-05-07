<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
  use HasFactory;

  protected $table = 'users_location';

  protected $fillable = [
    'uid',
    'category',
    'fullname',
    'email',
    'latitude',
    'longitude',
    'altitude',
  ];

  public function findByEmail($email)
  {
    return $this->where('email', $email)->first();
  }

  public function findByCategory($category)
  {
    return $this->where('category', $category)->get();
  }
}
