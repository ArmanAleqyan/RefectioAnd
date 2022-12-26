<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected  $guarded = [];

    const ADMIN_ID = 1;
    const Designer_id = 2;
    const MANUFACTURER_ID =3;


    public function user_role_id(){
        return $this->hasMany(User::class, 'role_id');
    }
}
