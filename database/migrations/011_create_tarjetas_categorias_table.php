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
        Schema::create('tarjetas_categorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tarjeta_id');
            $table->unsignedBigInteger('categoria_id');
            $table->unique(['tarjeta_id', 'categoria_id']);
            $table->timestamps();

            $table->foreign('tarjeta_id')->references('id')->on('tarjetas')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarjetas_categorias');
    }
};
