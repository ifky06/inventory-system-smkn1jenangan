<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class dataPinjam extends Model
{
    use HasFactory;

    protected $fillable=[
        'kode_peminjaman',
        'nama',
        'id_barang',
        'kode_barang',
        'tanggal_pinjam',
        'tenggat',
        'tanggal_kembali',
    ];

    public function item(){
        return $this->hasOne(item::class,'id','id_barang');
    }
    public function getTanggalPinjamAttribute(){
        return Carbon::parse($this->attributes['tanggal_pinjam'])->translatedFormat('d M Y');
    }
    public function getTenggatAttribute(){
        return Carbon::parse($this->attributes['tenggat'])->translatedFormat('d M Y');
    }
    public function getTanggalKembaliAttribute(){
        if ($this->attributes['tanggal_kembali'] != null) {
            return Carbon::parse($this->attributes['tanggal_kembali'])->translatedFormat('d M Y');
        }
    }
}
