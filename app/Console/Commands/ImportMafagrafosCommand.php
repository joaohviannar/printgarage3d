<?php

namespace App\Console\Commands;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportMafagrafosCommand extends Command
{
    protected $signature = 'import:mafagrafos
                            {colecao=qrcode-plaques : Slug da coleção no Mafagrafos}
                            {--categoria=placas-pix : Slug da categoria destino no banco}
                            {--preco=0 : Preço de venda inicial (0 = rascunho para revisar)}
                            {--publicar : Publica imediatamente (visivel_site=true)}
                            {--force : Sobrescreve produtos já existentes}';

    protected $description = 'Importa produtos de uma coleção do Mafagrafos';

    private const CDN = 'https://dyi8lrgme5gvu.cloudfront.net/';
    private const API = 'https://api.mafagrafos.com/api/';

    public function handle(): int
    {
        $colecaoSlug = $this->argument('colecao');
        $categoriaSlug = $this->option('categoria');
        $preco = (float) $this->option('preco');
        $publicar = $this->option('publicar');
        $force = $this->option('force');

        // 1. Busca categoria
        $categoria = Categoria::where('slug', $categoriaSlug)->first();
        if (!$categoria) {
            $this->error("Categoria '{$categoriaSlug}' não encontrada. Rode php artisan db:seed --class=CategoriaSeeder primeiro.");
            return self::FAILURE;
        }

        // 2. Busca IDs da coleção
        $this->info("Buscando coleção: {$colecaoSlug}...");
        $colRes = Http::withHeaders(['Accept' => 'application/json'])
            ->get(self::API . "collections/{$colecaoSlug}");

        if (!$colRes->ok()) {
            $this->error("Falha ao buscar coleção: HTTP {$colRes->status()}");
            return self::FAILURE;
        }

        $modelIds = $colRes->json('collection.modelIds', []);
        $total = count($modelIds);
        $this->info("Encontrados {$total} modelos. Iniciando importação...\n");

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $criados = 0;
        $ignorados = 0;
        $erros = 0;

        foreach ($modelIds as $uuid) {
            // 3. Busca dados do modelo
            $res = Http::withHeaders(['Accept' => 'application/json'])
                ->get(self::API . "models/{$uuid}");

            if (!$res->ok()) {
                $this->newLine();
                $this->warn("  Falha ao buscar modelo {$uuid}: HTTP {$res->status()}");
                $erros++;
                $bar->advance();
                continue;
            }

            $d = $res->json();
            $slugProduto = Str::slug($d['title']['pt-br'] ?? $d['slug']);

            // Pula se já existe e --force não foi passado
            if (!$force && Produto::where('slug', $slugProduto)->exists()) {
                $ignorados++;
                $bar->advance();
                continue;
            }

            // 4. Baixa imagem thumbnail
            $imagemPath = $this->baixarImagem($d['coverImage'] ?? null, $d['slug']);

            // 5. Cria ou atualiza produto
            Produto::updateOrCreate(
                ['slug' => $slugProduto],
                [
                    'categoria_id'   => $categoria->id,
                    'nome'           => $d['title']['pt-br'] ?? $d['slug'],
                    'descricao_curta'=> Str::limit($d['subtitle']['pt-br'] ?? '', 255),
                    'descricao'      => $this->limparMarkdown($d['description']['pt-br'] ?? ''),
                    'preco_venda'    => $preco,
                    'preco_custo'    => 0,
                    'estoque_atual'  => 0,
                    'estoque_minimo' => 1,
                    'imagem_principal'=> $imagemPath,
                    'destaque'       => false,
                    'visivel_site'   => $publicar,
                    'ativo'          => true,
                ]
            );

            $criados++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->table(
            ['Criados/Atualizados', 'Ignorados', 'Erros'],
            [[$criados, $ignorados, $erros]]
        );

        if (!$publicar) {
            $this->info('Os produtos foram criados como RASCUNHO (visivel_site=false).');
            $this->info('Acesse o Filament, defina os preços e publique-os.');
        }

        return self::SUCCESS;
    }

    private function baixarImagem(?string $coverImage, string $slug): ?string
    {
        if (!$coverImage) {
            return null;
        }

        $urlThumb = self::CDN . preg_replace('/-thumb-\w+\./', '-thumb-md.', $coverImage);

        try {
            $response = Http::timeout(30)->get($urlThumb);
            if (!$response->ok()) {
                return null;
            }

            $path = "produtos/qr-{$slug}.jpg";
            $absPath = Storage::disk('public')->path($path);

            // Converte e otimiza via GD (PNG→JPG, max 900px, qualidade 82)
            if (extension_loaded('gd')) {
                $body = $response->body();
                $src = @imagecreatefromstring($body);
                if ($src) {
                    $w = imagesx($src); $h = imagesy($src);
                    if ($w > 900) { $nh = intval($h * 900 / $w); $nw = 900; } else { $nw = $w; $nh = $h; }
                    $dst = imagecreatetruecolor($nw, $nh);
                    imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
                    Storage::disk('public')->makeDirectory('produtos');
                    imagejpeg($dst, $absPath, 82);
                    imagedestroy($src);
                    imagedestroy($dst);
                    return $path;
                }
            }

            // Fallback: salva o arquivo original sem otimização
            Storage::disk('public')->put($path, $response->body());
            return $path;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->warn("  Falha ao baixar imagem de {$slug}: {$e->getMessage()}");
            return null;
        }
    }

    private function limparMarkdown(string $markdown): string
    {
        // Remove cabeçalhos (#, ##, ###) mas mantém o texto
        $text = preg_replace('/^#{1,6}\s+/m', '', $markdown);
        // Remove marcadores de negrito/itálico (**texto** e *texto*)
        $text = preg_replace('/\*{1,2}(.+?)\*{1,2}/s', '$1', $text);
        // Remove sublinhado __texto__
        $text = preg_replace('/_{1,2}(.+?)_{1,2}/s', '$1', $text);
        // Limpa linhas em branco excessivas
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }
}
