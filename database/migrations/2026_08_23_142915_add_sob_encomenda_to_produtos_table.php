<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Produtos impressos sob encomenda não têm peça pronta na prateleira:
     * a impressão só começa depois da venda. Para eles, a validação de
     * estoque não faz sentido e impedia a venda de ser concluída.
     *
     * Default false: todos os produtos existentes seguem com controle de
     * estoque exatamente como antes.
     */
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->boolean('sob_encomenda')->default(false)->after('estoque_minimo');
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('sob_encomenda');
        });
    }
};
