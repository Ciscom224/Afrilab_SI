<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class echantillons extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'reference_labo';

}
