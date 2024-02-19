<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TipoNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_notificacions')->insert(['nombre'=>'Notificación por Constancia Administrativa (recepción)']);
        DB::table('tipo_notificacions')->insert(['nombre'=>'Notificación por Cedulon']);
        DB::table('tipo_notificacions')->insert(['nombre'=>'Notificación por Correo']);
        DB::table('tipo_notificacions')->insert(['nombre'=>'Negativa de Recepción']);
        DB::table('tipo_notificacions')->insert(['nombre'=>'Domicilio Inubicable']);

    }
}
