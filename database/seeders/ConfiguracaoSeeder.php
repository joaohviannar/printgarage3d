<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfiguracaoSeeder extends Seeder
{
    public function run(): void
    {
        $configuracoes = [
            ['chave' => 'empresa_nome',              'valor' => 'Print Garage 3D'],
            ['chave' => 'empresa_email',             'valor' => 'contato@printgarage3d.com.br'],
            ['chave' => 'whatsapp_numero',           'valor' => '5500000000000'],
            ['chave' => 'whatsapp_mensagem_padrao',  'valor' => 'Olá! Tenho interesse no produto: {produto}'],
            ['chave' => 'instagram_url',             'valor' => 'https://www.instagram.com/printgarage_3d/'],
            ['chave' => 'instagram_handle',          'valor' => '@printgarage_3d'],
            ['chave' => 'site_titulo',               'valor' => 'Print Garage 3D | Impressão 3D Personalizada'],
            ['chave' => 'site_descricao',            'valor' => 'Especialistas em impressão 3D: bonecos, suportes, peças personalizadas e soluções empresariais.'],
        ];

        foreach ($configuracoes as $cfg) {
            DB::table('configuracoes')->updateOrInsert(
                ['chave' => $cfg['chave']],
                ['valor' => $cfg['valor'], 'updated_at' => now()]
            );
        }
    }
}
