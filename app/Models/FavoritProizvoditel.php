<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritProizvoditel extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function FavoritUsers(){
        return $this->Belongsto(User::class, 'proizvoditel_id');
    }
}
