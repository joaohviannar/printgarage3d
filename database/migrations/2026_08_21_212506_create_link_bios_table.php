<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('link_bios', function (Blueprint $table) {
            $table->id();
            $table->string('icone', 8);            // WA, B2C, B2B, PAR, IG, @, URL, PIX
            $table->string('label', 40);
            $table->string('url', 500);
            $table->string('hint', 80)->nullable();
            $table->unsignedInteger('cliques')->default(0);
            $table->unsignedSmallInteger('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->index(['ativo', 'ordem']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('link_bios');
    }
};
