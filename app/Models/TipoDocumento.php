<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoDocumento extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'nombre',
        'plazo',
        'cantidad',
    ];
    public function documento_notificadors(): HasMany{
        return $this->hasMany(DocumentoNotificador::class);
    }
}
