<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'ID_MENU';
    public $incrementing = false;
    protected $keyType = 'string';

   
    public $timestamps = false; 

    protected $fillable = [
        'ID_MENU', 
        'NAMA_MENU', 
        'HARGA_SATUAN', 
        'ID_KATEGORI', 
        'STATUS_TESEDIA', 
        'FOTO'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'ID_KATEGORI', 'ID_KATEGORI');
    }
}