<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $fillable=[
        "categoria",
        "evento_id",
        "user_id",

    ];
//    public function evento(){
//        return $this->belongsTo(Evento::class);
//    }
//    public function player(){
//        return $this->belongsTo(Player::class);
//    }
}
