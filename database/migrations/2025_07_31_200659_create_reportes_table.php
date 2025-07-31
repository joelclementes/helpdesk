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
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('departamento_congreso_id')->unsigned();
            $table->string('solicitante');
            $table->string('descripcion');
            $table->bigInteger('categoria_id')->unsigned();
            $table->bigInteger('capturo_user_id')->unsigned();
            $table->bigInteger('tecnico_user_id')->nullable();
            $table->bigInteger('estado_id')->unsigned();
            $table->timestamps();
            $table->timestamp('closed_at')->nullable();
            $table->foreign('departamento_congreso_id')->references('id')->on('departamentos_congreso')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
