<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSuccses extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function user_designer_Order(){
        return $this->belongsTo(User::class,'designer_id');
    }
}
