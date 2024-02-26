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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_documento_id')
                ->constrainet('tipo_documentos')
                ->cascadeOnDelete();
            $table->string('numero_doc');
            $table->integer('anyo_doc');
            $table->integer('deuda_desde');
            $table->integer('deuda_hasta');
            $table->double('deuda_ip');
            $table->string('codigo');
            $table->string('razon_social');
            $table->string('domicilio'); 
            $table->foreignId('user_id')
                ->constrainet('users')
                ->cascadeOnDelete()->nullable();
            $table->boolean('prico')->nullable()->default(false);         
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
