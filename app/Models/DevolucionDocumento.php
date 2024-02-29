<?php

namespace App\Models;

use App\Models\User;
use App\Models\Documento;
use App\Models\TipoDocumento;
use App\Models\MotivoDevolucion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DevolucionDocumento extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable=[
        'documento_id',
        'tipo_documento_id',
        'motivo_devolucion_id',
        'observaciones',
        'user_id',
        'cantidad_visitas',

    ];
    public function documento(){
        return $this->belongsTo(Documento::class);
    }
    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class);
    }
    public function motivo_devolucion(){
        return $this->belongsTo(MotivoDevolucion::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
