<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcerias', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150);
            $table->string('logo', 255)->nullable();
            $table->string('contato', 255)->nullable();
            $table->text('descricao_curta')->nullable();
            $table->longText('descricao_completa')->nullable();
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index(['ativo', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcerias');
    }
};
