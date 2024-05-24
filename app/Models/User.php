<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $primaryKey = 'user_id';

    public function cart(){
        return $this->hasOne(Cart::class , 'user_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'user_id');
    }
}
