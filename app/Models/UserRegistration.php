<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegistration extends Model
{
    use HasFactory;

    protected $table = 'tbl_registration';

    public function findByUid($uid)
    {
        return $this->where('tbl_registration.id_user', $uid)
                    ->join('tbl_user', 'tbl_user.id_user', '=', 'tbl_registration.id_user')
                    ->join('tbl_bib', 'tbl_bib.phone', '=', 'tbl_user.phone')
                    ->get();
    }
}
