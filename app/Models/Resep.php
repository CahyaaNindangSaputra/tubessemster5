<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;

    protected $table = 'resep'; 
    protected $guarded = [];
    public $timestamps = false; 

    // Gunakan nama kolom asli dari database
    protected $primaryKey = 'id_resep'; 

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'ID_MENU'); 
    }

    public function stokBahan()
    {
        return $this->belongsTo(Stokbahan::class, 'ID_BAHAN_STOK', 'id_bahan');
    }
    
}