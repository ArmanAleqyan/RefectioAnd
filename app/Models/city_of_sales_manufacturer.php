<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city_of_sales_manufacturer extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function city_of_sales_manufacturer(){
        return $this->belongsto(User::class, 'user_id');
    }

}
