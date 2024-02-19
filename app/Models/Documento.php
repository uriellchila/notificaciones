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
        'numero',
        'anyo',
        'codigo',
        'razon_social',
        'domicilio',
    ];
}
