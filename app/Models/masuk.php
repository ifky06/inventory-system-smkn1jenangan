<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class masuk extends Model
{
    use HasFactory;

    protected $fillable=[
        'id_barang',
        'kode_barang',
        'tanggal',
        'keterangan',
    ];

    public function item(){
        return $this->hasOne(item::class,'id','id_barang');
    }
    public function getTanggalAttribute(){
        return Carbon::parse($this->attributes['tanggal'])->translatedFormat('d M Y');
    }
}
