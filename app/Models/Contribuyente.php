<?php

namespace App\Models;

use App\Models\DocumentoNotificador;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contribuyente extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'codigo',
        'dni_ruc',
        'razon_social',
        'domicilio',
    ];
    public function documento_notificadors(): HasMany{
        return $this->hasMany(DocumentoNotificador::class);
    }
}
