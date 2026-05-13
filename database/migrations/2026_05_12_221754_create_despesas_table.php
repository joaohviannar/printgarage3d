<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_despesa_id')->constrained('categorias_despesa');
            $table->foreignId('user_id')->constrained('users');
            $table->string('descricao', 200);
            $table->decimal('valor', 10, 2);
            $table->date('data_despesa');
            $table->enum('forma_pagamento', ['pix', 'dinheiro', 'cartao_credito', 'cartao_debito', 'boleto', 'outro'])->nullable();
            $table->boolean('recorrente')->default(false);
            $table->string('anexo', 255)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('data_despesa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('despesas');
    }
};
