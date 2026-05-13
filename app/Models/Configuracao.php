<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';

    public $timestamps = false;

    protected $fillable = [
        'chave',
        'valor',
    ];

    /**
     * Mapeamento de chave -> rotulo amigavel para a UI.
     */
    public const LABELS = [
        'empresa_nome'              => 'Nome da Empresa',
        'empresa_email'             => 'Email da Empresa',
        'whatsapp_numero'           => 'Número do WhatsApp',
        'whatsapp_mensagem_padrao'  => 'Mensagem padrão do WhatsApp',
        'instagram_url'             => 'URL do Instagram',
        'instagram_handle'          => 'Usuário do Instagram (@)',
        'site_titulo'               => 'Título do Site (SEO)',
        'site_descricao'            => 'Descrição do Site (SEO)',
    ];

    /**
     * Descricao/ajuda exibida no formulario para cada chave.
     */
    public const HELPERS = [
        'empresa_nome'              => 'Nome que aparece no rodapé e no email.',
        'empresa_email'             => 'Email institucional exibido no rodapé.',
        'whatsapp_numero'           => 'Apenas números, com código do país. Ex: 5561994129384',
        'whatsapp_mensagem_padrao'  => 'Use {produto} para inserir o nome do produto automaticamente.',
        'instagram_url'             => 'URL completa, ex: https://www.instagram.com/printgarage_3d/',
        'instagram_handle'          => 'Com @, ex: @printgarage_3d',
        'site_titulo'               => 'Aparece na aba do navegador e no Google.',
        'site_descricao'            => 'Descrição que aparece nos resultados de busca e ao compartilhar.',
    ];

    public function getLabelAttribute(): string
    {
        return self::LABELS[$this->chave] ?? $this->chave;
    }

    public function getHelperAttribute(): ?string
    {
        return self::HELPERS[$this->chave] ?? null;
    }

    protected static function booted(): void
    {
        static::saved(function () {
            \App\Services\ConfiguracaoService::flush();
        });
    }
}
