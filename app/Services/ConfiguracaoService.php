<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Service para ler e cachear configurações da empresa
 * armazenadas na tabela `configuracoes`.
 */
class ConfiguracaoService
{
    private const CACHE_KEY = 'configuracoes_site';
    private const CACHE_TTL = 3600; // 1 hora

    /**
     * Retorna o valor de uma configuração pela chave.
     */
    public static function get(string $chave, ?string $default = null): ?string
    {
        $configs = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return DB::table('configuracoes')->pluck('valor', 'chave')->toArray();
        });

        return $configs[$chave] ?? $default;
    }

    /**
     * Gera o link do WhatsApp dinâmico com mensagem pré-preenchida.
     *
     * @param  string|null  $produto  Nome do produto para inserir na mensagem
     * @return string  URL completa do WhatsApp
     */
    public static function whatsappLink(?string $produto = null): string
    {
        $numero = self::get('whatsapp_numero', '5500000000000');
        $template = self::get('whatsapp_mensagem_padrao', 'Olá! Tenho interesse em saber mais.');

        $mensagem = $produto
            ? str_replace('{produto}', $produto, $template)
            : 'Olá! Vim pelo site, gostaria de mais informações.';

        return 'https://wa.me/' . preg_replace('/\D/', '', $numero) . '?text=' . urlencode($mensagem);
    }

    /**
     * Limpa o cache (útil quando admin editar configurações).
     */
    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
