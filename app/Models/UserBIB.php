<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBIB extends Model
{
    use HasFactory;

    protected $table = 'tbl_bib';

    public function user($email)
    {
        return $this->where('email', $email)->first();
    }
}
