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
        Schema::create('notificacion_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')
                ->constrainet('documentos')
                ->cascadeOnDelete();
            $table->foreignId('tipo_documento_id')
                ->constrainet('tipo_documentos')
                ->cascadeOnDelete();
            $table->integer('cantidad_visitas');
            $table->integer('numero_acuse');
            $table->foreignId('tipo_notificacion_id')
                ->constrainet('tipo_notificacions')
                ->cascadeOnDelete();
            $table->foreignId('sub_tipo_notificacion_id')
                ->constrainet('sub_tipo_notificacions')
                ->cascadeOnDelete()->nullable();
            $table->date('fecha_notificacion')->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('user_id')
                ->constrainet('users')
                ->cascadeOnDelete();
            $table->string('telefono_contacto');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion_documentos');
    }
};
