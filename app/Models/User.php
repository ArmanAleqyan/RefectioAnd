<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [ ];

    public function user_pracient_for_designer(){
        return $this->HasMany(user_pracient_for_designer::class, 'user_id');
    }

    public function user_category_product(){
        return $this->HasMany(user_category_product::class, 'user_id');
    }

    public function city_of_sales_manufacturer(){
        return $this->HasMany(city_of_sales_manufacturer::class, 'user_id');
    }

    public function user_product(){
        return $this->HasMany(ProductProizvoditel::class, 'user_id')->limit(1);
    }

    public function user_product_limit1(){
        return $this->HasMany(ProductProizvoditel::class, 'user_id');
    }


    public function book_proizvoditel_user(){
        return $this->HasMany(BookProizvoditel::class, 'proizvoditel_id');
    }
    public function user_role_id(){
        return $this->belongsTo(Role::class,'role_id');
    }

    public function user_designer_Order(){
        return $this->HasMany(OrderSuccses::class, 'designer_id');
    }

    public function book_designer(){
        return $this->HasMany(book::class, 'books_id');
    }


    public function FavoritUsers(){
        return $this->HasMany(FavoritProizvoditel::class, 'proizvoditel_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
