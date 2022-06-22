<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class humidite extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'humidite_id';

}
