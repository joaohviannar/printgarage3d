<?php

namespace App\Filament\Widgets;

use App\Models\Despesa;
use App\Models\Venda;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Livewire\Attributes\On;

/**
 * Widget que aparece logo abaixo do grafico Entradas vs Saidas, mostrando
 * 3 cards (Entradas, Saidas, Lucro) calculados dinamicamente pelo periodo
 * selecionado no proprio filtro OU sincronizado com o grafico via evento Livewire.
 */
class ResumoPeriodoWidget extends Widget
{
    protected string $view = 'filament.widgets.resumo-periodo';

    protected static ?int $sort = 3; // logo apos o chart (sort 2)

    protected int|string|array $columnSpan = 'full';

    /**
     * Filtro padrao: 1 mes (sincronizado com o chart).
     */
    public ?string $filter = '1_mes';

    /**
     * Quando o usuario mudar o filtro deste widget, propaga para o chart.
     */
    public function updatedFilter(): void
    {
        $this->dispatch('resumo-filtro-alterado', filter: $this->filter);
    }

    /**
     * Recebe a mudanca de filtro vinda do grafico para manter sincronizado.
     */
    #[On('chart-filtro-alterado')]
    public function sincronizarComChart(string $filter): void
    {
        $this->filter = $filter;
    }

    public function getFiltrosDisponiveis(): array
    {
        return [
            '1_mes'   => '1 mês',
            '3_meses' => '3 meses',
            '6_meses' => '6 meses',
            '1_ano'   => '1 ano',
            'total'   => 'Total',
        ];
    }

    /**
     * Computa o periodo (data inicial e final) com base no filtro selecionado.
     */
    protected function getPeriodo(): array
    {
        $fim = Carbon::now()->endOfDay();

        $inicio = match ($this->filter) {
            '1_mes'   => Carbon::now()->subDays(30)->startOfDay(),
            '3_meses' => Carbon::now()->subMonths(3)->startOfDay(),
            '6_meses' => Carbon::now()->subMonths(6)->startOfDay(),
            '1_ano'   => Carbon::now()->subYear()->startOfDay(),
            'total'   => Carbon::create(2000, 1, 1)->startOfDay(),
            default   => Carbon::now()->subDays(30)->startOfDay(),
        };

        return ['inicio' => $inicio, 'fim' => $fim];
    }

    /**
     * Dados consolidados do periodo (passados para a view).
     */
    protected function getViewData(): array
    {
        $periodo = $this->getPeriodo();

        $entradas = (float) Venda::pagas()
            ->whereBetween('data_venda', [$periodo['inicio'], $periodo['fim']])
            ->sum('total');

        $saidas = (float) Despesa::query()
            ->whereBetween('data_despesa', [$periodo['inicio'], $periodo['fim']])
            ->sum('valor');

        $lucro = $entradas - $saidas;

        return [
            'entradas' => $entradas,
            'saidas'   => $saidas,
            'lucro'    => $lucro,
            'filtros'  => $this->getFiltrosDisponiveis(),
            'filtroAtual' => $this->filter,
        ];
    }
}
