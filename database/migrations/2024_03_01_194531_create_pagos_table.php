<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->integer('anyo');
            $table->integer('recepcion');
            $table->string('codigo');
            $table->string('dni');
            $table->string('razon_social');
            $table->integer('periodo');
            $table->string('trimestre')->nullable();
            $table->date('fecha_pago')->nullable(); 
            $table->double('monto_ip');
            $table->double('monto_am');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
