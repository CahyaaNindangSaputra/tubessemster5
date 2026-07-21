<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stokbahan extends Model
{
    use HasFactory;

    protected $table = 'stok_bahan'; 
    protected $primaryKey = 'id_bahan'; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    public $timestamps = false; 

    protected $fillable = [
        'id_bahan',
        'nama_bahan',
        'foto',
        'JUMLAH_BAHAN',
        'satuan',
        'harga',
        'tanggal_masuk',
        'tanggal_keluar'
    ];
}