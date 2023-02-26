<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listPinjam extends Model
{
    use HasFactory;

    protected $fillable=[
        'nama',
        'id_barang',
        'kode_barang',
    ];

    public function item(){
        return $this->hasOne(item::class,'id','id_barang');
    }
}
