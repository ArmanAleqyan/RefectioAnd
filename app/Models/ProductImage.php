<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function product_image(){
        return $this->belongsTo(ProductProizvoditel::class,'product_id');
    }
    public function product_image_limit1(){
        return $this->belongsTo(ProductProizvoditel::class,'product_id');
    }
}
