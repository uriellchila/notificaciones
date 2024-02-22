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
        DB::table('tipo_notificacions')->insert(['id'=>1,'nombre'=>'Por Constancia Administrativa (recepción)']);
        DB::table('tipo_notificacions')->insert(['id'=>2,'nombre'=>'Por Cedulon']);
        DB::table('tipo_notificacions')->insert(['id'=>3,'nombre'=>'Por Correo']);
        DB::table('tipo_notificacions')->insert(['id'=>4,'nombre'=>'Negativa de Recepción']);


        DB::table('sub_tipo_notificacions')->insert(['id'=>1,'tipo_notificacion_id'=>4,'nombre'=>'Rechazó la recepcion']);
        DB::table('sub_tipo_notificacions')->insert(['id'=>2,'tipo_notificacion_id'=>4,'nombre'=>'Recibió y se nego a sucribir.']);
        DB::table('sub_tipo_notificacions')->insert(['id'=>3,'tipo_notificacion_id'=>4,'nombre'=>'Recibió y se nego a identificarse.']);

    }
}
