<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    
    protected $table = 'kategori'; 


    protected $primaryKey = 'ID_KATEGORI'; 

 
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = ['ID_KATEGORI', 'NAMA_KATEGORI'];

   
    public function menus()
    {
        return $this->hasMany(Menu::class, 'ID_KATEGORI', 'ID_KATEGORI');
    }
}