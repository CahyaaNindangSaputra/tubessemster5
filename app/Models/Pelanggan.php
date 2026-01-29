<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan'; 
    protected $primaryKey = 'ID_PELANGGAN';

    public $timestamps = false; 
    protected $keyType = 'string'; 

    protected $guarded = []; 
}