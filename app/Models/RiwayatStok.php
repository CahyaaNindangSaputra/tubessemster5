<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    use HasFactory;

    protected $table = 'riwayat_stok_masuk';
    protected $primaryKey = 'id_riwayat';
    public $timestamps = false;

    protected $fillable = [
        'id_bahan',
        'nama_bahan',
        'foto',
        'jumlah_masuk',
        'satuan',
        'harga_satuan',
        'tanggal_masuk'
    ];
}