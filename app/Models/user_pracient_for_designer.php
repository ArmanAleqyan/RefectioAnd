<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_pracient_for_designer extends Model
{
    use HasFactory;
    protected  $guarded =[];

    public function user_pracient_for_user(){
        return $this->belongsto(User::class, 'user_id');
    }


}
