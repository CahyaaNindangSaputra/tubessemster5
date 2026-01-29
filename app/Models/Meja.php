<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    protected $table = 'meja';
    protected $primaryKey = 'ID_MEJA';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    
    protected $fillable = ['ID_MEJA', 'QR_MENU'];
}