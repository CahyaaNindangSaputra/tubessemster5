<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetilPemesanan extends Model
{
    
    protected $table = 'detil_pemesanan';

   
    protected $primaryKey = 'detil_pemesanan';

 
    public $timestamps = false;

   
    protected $fillable = [
        'id_pesanan',
        'id_menu',
        'qty',
        'subtotal'
    ];

 
    public function menu()
{
    
    return $this->belongsTo(Menu::class, 'ID_MENU', 'ID_MENU');
}
}