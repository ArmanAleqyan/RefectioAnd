<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookProizvoditel extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function book_proizvoditel(){
        return $this->belongsTo(book::class);
    }

    public function book_proizvoditel_user(){
        return $this->belongsTo(User::class,'proizvoditel_id');
    }
}
