<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DevolucionDocumento extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable=[
        'contribuyente_id',
        'tipo_documento_id',
        'codigo',
        'dni',
        'razon_social',
        'domicilio',
        'anyo',
        'numero_doc',
        'motivo_devolucion_id',
        'observaciones',
        'user_id',
    ];
    public function contribuyente(){
        return $this->belongsTo(Contribuyente::class);
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
