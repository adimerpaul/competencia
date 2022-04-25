<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;
    protected $fillable=[
        "fecha",
        "edad",
        "dato1",
        "dato2",
        "dato3",
        "dato4",
        "dato5",
        "evento_id",
        "player_id",

    ];
    public function evento(){
        return $this->belongsTo(Evento::class);
    }
    public function player(){
        return $this->belongsTo(Player::class);
    }
}
