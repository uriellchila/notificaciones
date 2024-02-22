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
        Schema::create('sub_tipo_notificacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_notificacion_id')
                ->constrainet('tipo_notificacions')
                ->cascadeOnDelete();
            $table->string('nombre');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_tipo_notificacions');
    }
};
