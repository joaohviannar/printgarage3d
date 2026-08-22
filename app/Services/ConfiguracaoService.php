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
     * Número real da empresa, usado quando a configuração está vazia ou ainda
     * com o placeholder do seed (5500000000000).
     */
    private const WHATSAPP_FALLBACK = '5561994129384';

    /**
     * Retorna o número de WhatsApp em formato E.164 sem símbolos (5561XXXXXXXXX).
     *
     * O WhatsApp é o principal canal de conversão do site: um número inválido
     * quebra silenciosamente o footer, as páginas de produto e as landings.
     * Por isso a configuração é validada e, se não for um celular brasileiro
     * plausível, cai no número real da empresa.
     */
    public static function whatsappNumero(): string
    {
        $numero = preg_replace('/\D/', '', (string) self::get('whatsapp_numero', ''));

        $valido = preg_match('/^55\d{10,11}$/', $numero)
            && ! preg_match('/^(\d)\1+$/', substr($numero, 2)); // rejeita 5500000000000

        return $valido ? $numero : self::WHATSAPP_FALLBACK;
    }

    /**
     * Número formatado para exibição: (61) 99412-9384.
     */
    public static function whatsappExibicao(): string
    {
        return preg_replace('/^55(\d{2})(\d{4,5})(\d{4})$/', '($1) $2-$3', self::whatsappNumero());
    }

    /**
     * Gera o link do WhatsApp dinâmico com mensagem pré-preenchida.
     *
     * @param  string|null  $produto  Nome do produto para inserir na mensagem
     * @return string  URL completa do WhatsApp
     */
    public static function whatsappLink(?string $produto = null): string
    {
        $numero = self::whatsappNumero();
        $template = self::get('whatsapp_mensagem_padrao', 'Olá! Tenho interesse em saber mais.');

        $mensagem = $produto
            ? str_replace('{produto}', $produto, $template)
            : 'Olá! Vim pelo site, gostaria de mais informações.';

        return 'https://wa.me/' . $numero . '?text=' . urlencode($mensagem);
    }

    /**
     * Limpa o cache (útil quando admin editar configurações).
     */
    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
