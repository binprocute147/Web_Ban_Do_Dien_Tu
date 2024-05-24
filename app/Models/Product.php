<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $primaryKey = 'product_id';
    public function protype(){
        return $this->belongsTo(Protype::class , 'type_id');
    }
    
    public function manufacturer(){
        return $this->belongsTo(Manufacturer::class , 'manu_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class, 'product_id');
    }
}
