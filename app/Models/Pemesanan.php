<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'ID_PESANAN';
    public $timestamps = false; 
    protected $guarded = []; 
    public function detail() {
        return $this->hasMany(DetilPemesanan::class, 'ID_PESANAN', 'ID_PESANAN');
    }
    public function pembayaran() {
        return $this->hasOne(Pembayaran::class, 'ID_PESANAN', 'ID_PESANAN');
    }
}