<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rusak extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_barang',
        'kode_barang',
        'detail',
        'status',
    ];
    public function item(){
        return $this->hasOne(item::class,'id','id_barang');
    }
    public function perbaikan(){
        return $this->belongsTo(perbaikan::class);
    }
}
