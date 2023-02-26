<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fund extends Model
{
    use HasFactory;

    protected $fillable=[
        'nama',
    ];

    public function item(){
        return $this->belongsTo(item::class);
    }
    public function perbaikan(){
        return $this->belongsTo(rusak::class);
    }
}
