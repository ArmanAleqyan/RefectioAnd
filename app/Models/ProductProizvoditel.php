<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProizvoditel extends Model
{
    use HasFactory;
    protected  $guarded = [];

    public function user_product(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function product_image(){
        return $this->HasMAny(ProductImage::class,'product_id');
    }
    public function product_image_limit1(){
        return $this->HasMAny(ProductImage::class,'product_id');
    }
}
