<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $fillable=[
        'fecha',
        'hora',
        'categoria',
        'horas',
        'minutos',
        'segundos',
        'milisegundos',
        'metros1',
        'centimetros1',
        'metros2',
        'centimetros2',
        'metros3',
        'centimetros3',
        'metros4',
        'centimetros4',
        'metros5',
        'centimetros5',
        'user_id',
        'evento_id',
        'registro_id',
        'mstotales',
        'cntotales',
    ];
    public function evento(){
        return $this->belongsTo(Evento::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
