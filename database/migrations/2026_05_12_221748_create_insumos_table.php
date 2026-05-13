<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->enum('tipo', ['filamento', 'resina', 'outro'])->default('filamento');
            $table->string('cor', 50)->nullable();
            $table->string('marca', 80)->nullable();
            $table->enum('unidade', ['g', 'kg', 'ml', 'L', 'un'])->default('g');
            $table->decimal('quantidade_atual', 10, 3)->default(0);
            $table->decimal('quantidade_minima', 10, 3)->default(0);
            $table->decimal('custo_unitario', 10, 4)->default(0);
            $table->string('fornecedor', 150)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
