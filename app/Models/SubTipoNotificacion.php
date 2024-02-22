<?php

namespace App\Models;

use App\Models\TipoNotificacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTipoNotificacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[

        'tipo_notificacion_id',
        'nombre',
    ];

    public function tipo_notificacion(){
        return $this->belongsTo(TipoNotificacion::class);
    }

}
