<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protype extends Model
{
    public $primaryKey = 'type_id';
    public function products(){
        return $this->hasMany(Product::class , 'type_id');
    }
    use HasFactory;
}
