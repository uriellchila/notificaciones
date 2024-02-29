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
        Schema::create('devolucion_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')
                ->constrainet('documentos')
                ->cascadeOnDelete();
            $table->foreignId('tipo_documento_id')
                ->constrainet('tipo_documentos')
                ->cascadeOnDelete();
            $table->foreignId('motivo_devolucion_id')
                ->constrainet('motivo_devolucions')
                ->cascadeOnDelete();
            $table->integer('cantidad_visitas');
            $table->string('observaciones')->nullable();
            $table->foreignId('user_id')
                ->constrainet('users')
                ->cascadeOnDelete();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devolucion_documentos');
    }
};
