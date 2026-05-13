<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->foreignId('user_id')->constrained('users');
            $table->date('data_venda');
            $table->enum('canal', ['whatsapp', 'instagram', 'presencial', 'outro'])->default('whatsapp');
            $table->enum('forma_pagamento', ['pix', 'dinheiro', 'cartao_credito', 'cartao_debito', 'transferencia', 'outro']);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('desconto', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('status', ['pendente', 'pago', 'cancelado'])->default('pago');
            $table->text('observacoes')->nullable();
            $table->timestamps();

            $table->index('data_venda');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};
