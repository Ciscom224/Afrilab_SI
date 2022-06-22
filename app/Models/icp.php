<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class icp extends Model
{
    use HasFactory;
    protected $primaryKey = 'icp_id';
    public $timestamps = false;
      protected $fillable=[
        'Al2O3(%)',
        'CaO(%)',
        'Fe2O3(%)',
        'K2O(%)',
        'MgO(%)',
        'MnO(%)',
        'P2O5(%)',
        'S(%)',
        'ASiO2(%)',
        'TiO2(%)',
        'As(ppm)',
        'B(ppm)',
        'Ba(ppm)',
        'Be(ppm)',
        'Bi(ppm)',
        'Cd(ppm)',
        'Co(ppm)',
        'Cr(ppm)',
        'Cu(ppm)',
        'Ge(ppm)',
        'Li(ppm)',
        'Mo(ppm)',
        'Ni(ppm)',
        'Pb(ppm)',
        'Sb(ppm)',
        'Se(ppm)',
        'Sn(ppm)',
        'Sr(ppm)',
        'Ta(ppm)',
        'Y(ppm)',
        'Zn(ppm)'
      ];

}
