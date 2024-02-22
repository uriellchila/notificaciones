<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoNotificacion extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'nombre',
    ];
    public function documento_notificadors(): HasMany{
        return $this->hasMany(DocumentoNotificador::class);
    }
    public function sub_tipo_notificacions(): HasMany{
        return $this->hasMany(SubTipoNotificacion::class);
    }
}
