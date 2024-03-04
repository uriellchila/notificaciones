<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'tipo_documento_id',
        'numero_doc',
        'anyo_doc',
        'deuda_desde',
        'deuda_hasta',
        'deuda_ip',
        'codigo',
        'dni',
        'razon_social',
        'domicilio',
        'user_id',
        'fecha_para',
        'prico',
    ];

    public function tipo_documento(){
        return $this->belongsTo(TipoDocumento::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
 