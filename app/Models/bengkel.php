<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bengkel extends Model
{
    use HasFactory;

    protected $fillable=[
        'bengkel',
        'id_pj',
    ];

    public function item(){
        return $this->belongsTo(item::class);
    }
    public function pj(){
        return $this->hasOne(User::class,'id','id_pj');
    }
}
