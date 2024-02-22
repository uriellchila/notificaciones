<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MotivoDevolucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('motivo_devolucions')->insert(['nombre'=>'Domicilio Inubicable']);
        DB::table('motivo_devolucions')->insert(['nombre'=>'No corresponde']);
        DB::table('motivo_devolucions')->insert(['nombre'=>'Emision Erronea']);
        DB::table('motivo_devolucions')->insert(['nombre'=>'Otro']);
    }
}
