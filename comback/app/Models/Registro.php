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
    public function evento(){
        return $this->belongsTo(Evento::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function histories(){
        return $this->hasMany(History::class);
    }
}
