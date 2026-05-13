<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->string('nome', 180);
            $table->string('slug', 200)->unique();
            $table->text('descricao')->nullable();
            $table->string('descricao_curta', 255)->nullable();
            $table->string('sku', 50)->nullable()->unique();
            $table->decimal('preco_venda', 10, 2);
            $table->decimal('preco_custo', 10, 2)->default(0);
            $table->integer('estoque_atual')->default(0);
            $table->integer('estoque_minimo')->default(1);
            $table->string('imagem_principal', 255)->nullable();
            $table->boolean('destaque')->default(false);
            $table->boolean('visivel_site')->default(true);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index(['visivel_site', 'ativo']);
            $table->index(['estoque_atual', 'estoque_minimo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
