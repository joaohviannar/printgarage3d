<?php

namespace App\Filament\Pages;

use App\Models\Despesa;
use App\Models\Venda;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Relatorio financeiro customizado com filtro de periodo, agrupamento por
 * categoria/canal/produto e export CSV.
 */
class RelatorioFinanceiro extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $navigationLabel = 'Relatório Financeiro';

    protected static ?string $title = 'Relatório Financeiro';

    protected static string|\UnitEnum|null $navigationGroup = 'Financeiro';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.relatorio-financeiro';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'inicio' => Carbon::now()->startOfMonth()->toDateString(),
            'fim'    => Carbon::now()->endOfMonth()->toDateString(),
            'canal'  => null,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Grid::make(3)->schema([
                    DatePicker::make('inicio')
                        ->label('Data Inicial')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),

                    DatePicker::make('fim')
                        ->label('Data Final')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),

                    Select::make('canal')
                        ->label('Canal de Venda')
                        ->options([
                            'whatsapp' => 'WhatsApp',
                            'instagram' => 'Instagram',
                            'presencial' => 'Presencial',
                            'outro' => 'Outro',
                        ])
                        ->placeholder('Todos os canais'),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportar')
                ->label('Exportar CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(fn () => $this->exportar()),
        ];
    }

    /**
     * Dados computados do relatorio para a view.
     */
    public function getResumoProperty(): array
    {
        $data = $this->form->getState();
        $inicio = $data['inicio'] ?? Carbon::now()->startOfMonth()->toDateString();
        $fim    = $data['fim']    ?? Carbon::now()->endOfMonth()->toDateString();
        $canal  = $data['canal']  ?? null;

        $vendasQuery = Venda::pagas()->whereBetween('data_venda', [$inicio, $fim]);
        if ($canal) {
            $vendasQuery->where('canal', $canal);
        }

        $entradas    = (float) $vendasQuery->sum('total');
        $countVendas = (clone $vendasQuery)->count();
        $ticketMedio = $countVendas > 0 ? $entradas / $countVendas : 0;

        $saidas = (float) Despesa::query()
            ->whereBetween('data_despesa', [$inicio, $fim])
            ->sum('valor');

        $lucro = $entradas - $saidas;
        $margem = $entradas > 0 ? ($lucro / $entradas) * 100 : 0;

        // Por canal
        $porCanal = (clone $vendasQuery)
            ->selectRaw('canal, COUNT(*) as qtd, SUM(total) as total')
            ->groupBy('canal')
            ->orderByDesc('total')
            ->get();

        // Por forma de pagamento
        $porPagamento = (clone $vendasQuery)
            ->selectRaw('forma_pagamento, COUNT(*) as qtd, SUM(total) as total')
            ->groupBy('forma_pagamento')
            ->orderByDesc('total')
            ->get();

        // Despesas por categoria
        $despesasPorCategoria = Despesa::query()
            ->whereBetween('data_despesa', [$inicio, $fim])
            ->selectRaw('categoria_despesa_id, COUNT(*) as qtd, SUM(valor) as total')
            ->with('categoria')
            ->groupBy('categoria_despesa_id')
            ->orderByDesc('total')
            ->get();

        return [
            'inicio' => $inicio,
            'fim' => $fim,
            'canal' => $canal,
            'entradas' => $entradas,
            'saidas' => $saidas,
            'lucro' => $lucro,
            'margem' => $margem,
            'countVendas' => $countVendas,
            'ticketMedio' => $ticketMedio,
            'porCanal' => $porCanal,
            'porPagamento' => $porPagamento,
            'despesasPorCategoria' => $despesasPorCategoria,
        ];
    }

    public function exportar(): StreamedResponse
    {
        $resumo = $this->getResumoProperty();

        return response()->streamDownload(function () use ($resumo) {
            $out = fopen('php://output', 'w');

            // BOM UTF-8 para Excel ler acentos
            fwrite($out, "\xEF\xBB\xBF");

            // Cabecalho
            fputcsv($out, ['Relatório Financeiro Print Garage 3D']);
            fputcsv($out, ['Período', date('d/m/Y', strtotime($resumo['inicio'])) . ' a ' . date('d/m/Y', strtotime($resumo['fim']))]);
            if ($resumo['canal']) {
                fputcsv($out, ['Canal filtrado', ucfirst($resumo['canal'])]);
            }
            fputcsv($out, []);

            // Resumo
            fputcsv($out, ['RESUMO']);
            fputcsv($out, ['Entradas', 'R$ ' . number_format($resumo['entradas'], 2, ',', '.')]);
            fputcsv($out, ['Saídas',   'R$ ' . number_format($resumo['saidas'],   2, ',', '.')]);
            fputcsv($out, ['Lucro',    'R$ ' . number_format($resumo['lucro'],    2, ',', '.')]);
            fputcsv($out, ['Margem',   number_format($resumo['margem'], 2, ',', '.') . '%']);
            fputcsv($out, ['Vendas',   $resumo['countVendas']]);
            fputcsv($out, ['Ticket Médio', 'R$ ' . number_format($resumo['ticketMedio'], 2, ',', '.')]);
            fputcsv($out, []);

            // Por canal
            fputcsv($out, ['VENDAS POR CANAL']);
            fputcsv($out, ['Canal', 'Quantidade', 'Total']);
            foreach ($resumo['porCanal'] as $linha) {
                fputcsv($out, [
                    ucfirst($linha->canal),
                    $linha->qtd,
                    'R$ ' . number_format($linha->total, 2, ',', '.'),
                ]);
            }
            fputcsv($out, []);

            // Por pagamento
            fputcsv($out, ['VENDAS POR FORMA DE PAGAMENTO']);
            fputcsv($out, ['Forma', 'Quantidade', 'Total']);
            foreach ($resumo['porPagamento'] as $linha) {
                fputcsv($out, [
                    str_replace('_', ' ', ucfirst($linha->forma_pagamento)),
                    $linha->qtd,
                    'R$ ' . number_format($linha->total, 2, ',', '.'),
                ]);
            }
            fputcsv($out, []);

            // Despesas por categoria
            fputcsv($out, ['DESPESAS POR CATEGORIA']);
            fputcsv($out, ['Categoria', 'Quantidade', 'Total']);
            foreach ($resumo['despesasPorCategoria'] as $linha) {
                fputcsv($out, [
                    $linha->categoria?->nome ?? 'Sem categoria',
                    $linha->qtd,
                    'R$ ' . number_format($linha->total, 2, ',', '.'),
                ]);
            }

            fclose($out);
        }, "relatorio_financeiro_{$resumo['inicio']}_a_{$resumo['fim']}.csv", [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
