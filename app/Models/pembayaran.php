<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'ID_PEMBAYARAN';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'ID_PEMBAYARAN',
        'ID_PESANAN',
        'ID_METODE',
        'STATUS_PEMBAYARAN',
        'WAKTU_PEMBAYARAN', 
        'TOTAL_BAYAR'
    ];
}