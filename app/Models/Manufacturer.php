<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;
    public $primaryKey = 'manu_id';
    public function manu_product(){
        return $this->hasMany(Product::class , 'manu_id');
    }
}
