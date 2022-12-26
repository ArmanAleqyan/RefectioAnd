<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_category_product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user_category_product(){
        return $this->belongsto(User::class, 'user_id');
    }
}
