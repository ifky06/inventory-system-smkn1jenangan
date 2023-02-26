<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class perbaikan extends Model
{
    use HasFactory;
        protected $fillable=[
        'kode_perbaikan',
        'id_rusak',
        'id_barang',
        'kode_barang',
        'id_fund',
        'tanggal_pengajuan',
        'tanggal_persetujuan',
        'tanggal_selesai'
    ];
    public function item(){
        return $this->hasOne(item::class,'id','id_barang');
    }
    public function sumber_dana(){
        return $this->hasOne(fund::class,'id','id_fund');
    }
    public function rusak(){
        return $this->hasOne(rusak::class,'id','id_rusak');
    }
    public function getTanggalPengajuanAttribute(){
        return Carbon::parse($this->attributes['tanggal_pengajuan'])->translatedFormat('d M Y');
    }
    public function getTanggalPersetujuanAttribute(){
        if ($this->attributes['tanggal_persetujuan'] != null) {
            return Carbon::parse($this->attributes['tanggal_persetujuan'])->translatedFormat('d M Y');
        }
    }
    public function getTanggalSelesaiAttribute(){
        if ($this->attributes['tanggal_selesai'] != null) {
            return Carbon::parse($this->attributes['tanggal_selesai'])->translatedFormat('d M Y');
        }
    }
}
