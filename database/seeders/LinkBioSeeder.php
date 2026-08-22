<?php

namespace Database\Seeders;

use App\Models\LinkBio;
use App\Services\ConfiguracaoService;
use Illuminate\Database\Seeder;

/**
 * Links iniciais da página /links (bio do Instagram).
 *
 * Idempotente: usa o label como chave, então rodar de novo não duplica
 * nem sobrescreve ordem/cliques de links já existentes.
 */
class LinkBioSeeder extends Seeder
{
    public function run(): void
    {
        $wa = ConfiguracaoService::whatsappNumero();
        $email = ConfiguracaoService::get('empresa_email', 'contato@printgarage3d.com.br');
        $instagram = ConfiguracaoService::get('instagram_url', 'https://instagram.com/printgarage_3d');
        $instagramHandle = ConfiguracaoService::get('instagram_handle', '@printgarage_3d');

        $links = [
            [
                'icone' => 'WA',
                'label' => 'Falar no WhatsApp',
                'url'   => 'https://wa.me/' . $wa,
                'hint'  => 'wa.me/' . $wa,
            ],
            [
                'icone' => 'B2C',
                'label' => 'Catálogo para Você',
                // O handoff sugeria /catalogo/pessoal; a rota real do site é por query string.
                'url'   => '/catalogo?tipo=B2C',
                'hint'  => 'Presentes, decoração, peças sob medida',
            ],
            [
                'icone' => 'B2B',
                'label' => 'Catálogo para Empresas',
                'url'   => '/catalogo?tipo=B2B',
                'hint'  => 'Protótipos, brindes, peças técnicas',
            ],
            [
                'icone' => 'PAR',
                'label' => 'Parcerias',
                'url'   => '/parcerias',
                'hint'  => 'Makers, lojas e agências',
            ],
            [
                'icone' => 'IG',
                'label' => 'Instagram',
                'url'   => $instagram,
                'hint'  => $instagramHandle,
            ],
            [
                'icone' => '@',
                'label' => 'E-mail',
                'url'   => 'mailto:' . $email,
                'hint'  => $email,
            ],
        ];

        foreach ($links as $i => $link) {
            LinkBio::firstOrCreate(
                ['label' => $link['label']],
                $link + ['ordem' => $i + 1, 'ativo' => true, 'cliques' => 0]
            );
        }
    }
}
