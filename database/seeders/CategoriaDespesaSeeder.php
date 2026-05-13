<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaDespesaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            ['nome' => 'Insumos (Filamento/Resina)', 'cor' => '#3B82F6'],
            ['nome' => 'Energia Elétrica',           'cor' => '#F59E0B'],
            ['nome' => 'Manutenção de Equipamentos', 'cor' => '#EF4444'],
            ['nome' => 'Marketing e Publicidade',    'cor' => '#8B5CF6'],
            ['nome' => 'Embalagens',                 'cor' => '#10B981'],
            ['nome' => 'Frete e Entregas',           'cor' => '#06B6D4'],
            ['nome' => 'Software e Assinaturas',     'cor' => '#6366F1'],
            ['nome' => 'Impostos e Taxas',           'cor' => '#DC2626'],
            ['nome' => 'Outros',                     'cor' => '#6B7280'],
        ];

        foreach ($categorias as $cat) {
            DB::table('categorias_despesa')->updateOrInsert(
                ['nome' => $cat['nome']],
                ['cor' => $cat['cor'], 'ativo' => true]
            );
        }
    }
}
