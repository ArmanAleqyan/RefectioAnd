<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function book_proizvoditel(){
        return $this->HasMany(BookProizvoditel::class, 'books_id');
    }

    public function book_designer(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
