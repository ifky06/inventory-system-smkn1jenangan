<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class item extends Model
{
    use HasFactory;
    
    protected $fillable=[
        'kode',
        'nama',
        'id_bengkel',
        'id_fund',
        'kondisi',
        'tanggal_cek',
        'status',
        'gambar',
    ];

    public function bengkel(){
        return $this->hasOne(bengkel::class,'id','id_bengkel');
    }
    public function sumber_dana(){
        return $this->hasOne(fund::class,'id','id_fund');
    }
    public function masuk(){
        return $this->belongsTo(masuk::class);
    }
    public function keluar(){
        return $this->belongsTo(keluar::class);
    }
    public function listPinjam(){
        return $this->belongsTo(listPinjam::class);
    }
    public function dataPinjam(){
        return $this->belongsTo(dataPinjam::class);
    }
    public function rusak(){
        return $this->belongsTo(rusak::class);
    }
    public function perbaikan(){
        return $this->belongsTo(rusak::class);
    }
    public function getTanggalCekAttribute(){
        // if (Carbon::today()->toDateString() != $this->attributes['tanggal_cek']) {
        // }
        return Carbon::parse($this->attributes['tanggal_cek'])->translatedFormat('d M Y');
    }
}
