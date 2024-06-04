<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
  use HasFactory;

  protected $table = 'tbl_user_locations';

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
    return $this->where('tbl_user_locations.category', $category)
                ->join('tbl_user', 'tbl_user.id_user', '=', 'tbl_user_locations.uid')
                ->join('tbl_bib', 'tbl_bib.email', '=', 'tbl_user.email')
                ->select(['tbl_bib.bib', 'tbl_user.id_user', 'tbl_user.email','tbl_user.first_name', 'tbl_user.last_name', 
                'tbl_user_locations.latitude', 'tbl_user_locations.longitude', 'tbl_user_locations.altitude',
                'tbl_user_locations.updated_at'])
                ->get();
  }
}
