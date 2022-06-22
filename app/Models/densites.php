<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class densites extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'densite_id';
}
