<?php

namespace App\Filament\Resources\Configuracaos\Schemas;

use App\Models\Configuracao;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfiguracaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->heading(fn ($record) => $record?->label ?? 'Configuração')
                    ->description(fn ($record) => $record?->helper)
                    ->schema([
                        Placeholder::make('chave_display')
                            ->label('Chave (sistema)')
                            ->content(fn ($record) => $record?->chave ?? '-'),

                        // Para mensagens longas: Textarea
                        Textarea::make('valor')
                            ->label('Valor')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->visible(fn ($record) => in_array($record?->chave, [
                                'whatsapp_mensagem_padrao',
                                'site_descricao',
                            ])),

                        // Para numero de telefone: TextInput com mascara visual
                        TextInput::make('valor')
                            ->label('Número (apenas dígitos com DDI/DDD)')
                            ->required()
                            ->maxLength(20)
                            ->placeholder('5561994129384')
                            ->prefix('+')
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record?->chave === 'whatsapp_numero'),

                        // Para email
                        TextInput::make('valor')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record?->chave === 'empresa_email'),

                        // Para URL
                        TextInput::make('valor')
                            ->label('URL')
                            ->url()
                            ->required()
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record?->chave === 'instagram_url'),

                        // Para handle Instagram
                        TextInput::make('valor')
                            ->label('Usuário')
                            ->required()
                            ->placeholder('@printgarage_3d')
                            ->columnSpanFull()
                            ->visible(fn ($record) => $record?->chave === 'instagram_handle'),

                        // Default para nome empresa e titulo site
                        TextInput::make('valor')
                            ->label('Valor')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->visible(fn ($record) => in_array($record?->chave, [
                                'empresa_nome',
                                'site_titulo',
                            ])),
                    ]),
            ]);
    }
}
