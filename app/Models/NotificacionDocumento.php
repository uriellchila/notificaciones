<?php

namespace App\Models;

use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\TipoNotificacion;
use App\Models\SubTipoNotificacion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotificacionDocumento extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable=[
        'documento_id',
        'tipo_documento_id',
        'cantidad_visitas',
        'numero_acuse',
        'tipo_notificacion_id',
        'sub_tipo_notificacion_id',
        'fecha_notificacion',
        'observaciones',
        'telefono_contacto',
        'user_id',

    ];
    public function documento(){
        return $this->belongsTo(Documento::class);
    }
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class);
    }
    public function tipo_notificacion(){
        return $this->belongsTo(TipoNotificacion::class);
    }
    public function sub_tipo_notificacion(){
        return $this->belongsTo(SubTipoNotificacion::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
