<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            // B2C - Para Pessoas
            ['nome' => 'Bonecos e Action Figures', 'tipo' => 'B2C', 'ordem' => 1],
            ['nome' => 'Suportes e Organizadores',  'tipo' => 'B2C', 'ordem' => 2],
            ['nome' => 'Itens do Dia a Dia',        'tipo' => 'B2C', 'ordem' => 3],
            ['nome' => 'Peças Personalizadas',      'tipo' => 'B2C', 'ordem' => 4],
            ['nome' => 'Decoração',                 'tipo' => 'B2C', 'ordem' => 5],

            // B2B - Para Empresas
            ['nome' => 'Combos Empresariais',       'tipo' => 'B2B', 'ordem' => 1],
            ['nome' => 'Logo 3D',                   'tipo' => 'B2B', 'ordem' => 2],
            ['nome' => 'Placas Instagram',          'tipo' => 'B2B', 'ordem' => 3],
            ['nome' => 'Placas PIX',                'tipo' => 'B2B', 'ordem' => 4],
            ['nome' => 'Brindes Corporativos',      'tipo' => 'B2B', 'ordem' => 5],
        ];

        foreach ($categorias as $cat) {
            DB::table('categorias')->updateOrInsert(
                ['slug' => Str::slug($cat['nome'])],
                [
                    'nome' => $cat['nome'],
                    'slug' => Str::slug($cat['nome']),
                    'tipo' => $cat['tipo'],
                    'ordem' => $cat['ordem'],
                    'ativo' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
