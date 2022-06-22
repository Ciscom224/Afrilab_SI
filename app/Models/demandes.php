<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class demandes extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'demande_id';


    // protected $attributes = [
    //     'aa_id' => NULL,
    //     'icp_id' => NULL,
    // ];
}
