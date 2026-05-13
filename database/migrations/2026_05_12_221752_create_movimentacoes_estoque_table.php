<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos');
            $table->enum('tipo', ['entrada', 'saida', 'ajuste']);
            $table->integer('quantidade');
            $table->integer('estoque_anterior');
            $table->integer('estoque_posterior');
            $table->enum('origem', ['venda', 'producao', 'ajuste_manual', 'perda', 'venda_cancelada']);
            $table->unsignedBigInteger('referencia_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('observacao', 255)->nullable();
            $table->timestamp('created_at')->nullable();

            $table->index(['produto_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};
