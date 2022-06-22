<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class aas extends Model
{
   
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['lecture','pd','vid','reference_labo','code_element'];
}
