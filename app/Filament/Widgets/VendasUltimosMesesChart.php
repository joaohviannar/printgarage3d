<?php

namespace App\Filament\Widgets;

use App\Models\Despesa;
use App\Models\Venda;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

/**
 * Grafico de linha mostrando vendas e despesas com filtro de periodo.
 * Filtros: 1 mes (default, agregacao diaria), 3/6/12 meses e Total (agregacao mensal).
 */
class VendasUltimosMesesChart extends ChartWidget
{
    protected ?string $heading = 'Entradas vs Saídas';

    protected ?string $description = 'Comparativo de vendas pagas e despesas no período selecionado';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    /**
     * Filtro padrao: 1 mes
     */
    public ?string $filter = '1_mes';

    protected function getFilters(): ?array
    {
        return [
            '1_mes'   => '1 mês',
            '3_meses' => '3 meses',
            '6_meses' => '6 meses',
            '1_ano'   => '1 ano',
            'total'   => 'Total',
        ];
    }

    protected function getData(): array
    {
        $filtro = $this->filter ?? '1_mes';

        return match ($filtro) {
            '1_mes'   => $this->dadosDiarios(30),
            '3_meses' => $this->dadosMensais(3),
            '6_meses' => $this->dadosMensais(6),
            '1_ano'   => $this->dadosMensais(12),
            'total'   => $this->dadosTotal(),
            default   => $this->dadosDiarios(30),
        };
    }

    /**
     * Agregacao diaria dos ultimos N dias.
     */
    private function dadosDiarios(int $dias): array
    {
        $labels = [];
        $entradas = [];
        $saidas = [];

        for ($i = $dias - 1; $i >= 0; $i--) {
            $data = Carbon::now()->subDays($i);
            $labels[] = $data->format('d/m');

            $entradas[] = (float) Venda::pagas()
                ->whereDate('data_venda', $data)
                ->sum('total');

            $saidas[] = (float) Despesa::query()
                ->whereDate('data_despesa', $data)
                ->sum('valor');
        }

        return $this->montarDataset($labels, $entradas, $saidas);
    }

    /**
     * Agregacao mensal dos ultimos N meses (incluindo o atual).
     */
    private function dadosMensais(int $meses): array
    {
        $labels = [];
        $entradas = [];
        $saidas = [];

        for ($i = $meses - 1; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $inicio = $data->copy()->startOfMonth();
            $fim    = $data->copy()->endOfMonth();

            $labels[] = ucfirst($data->translatedFormat('M/Y'));

            $entradas[] = (float) Venda::pagas()
                ->whereBetween('data_venda', [$inicio, $fim])
                ->sum('total');

            $saidas[] = (float) Despesa::query()
                ->whereBetween('data_despesa', [$inicio, $fim])
                ->sum('valor');
        }

        return $this->montarDataset($labels, $entradas, $saidas);
    }

    /**
     * Agregacao do total - desde o primeiro registro ate hoje.
     * Por mes, ou por ano se o periodo for muito longo (> 36 meses).
     */
    private function dadosTotal(): array
    {
        // Acha a data mais antiga (entre venda e despesa)
        $primeiraVenda   = Venda::pagas()->min('data_venda');
        $primeiraDespesa = Despesa::query()->min('data_despesa');

        $datas = array_filter([$primeiraVenda, $primeiraDespesa]);
        if (empty($datas)) {
            // Nenhum dado - mostra o mes atual vazio
            return $this->dadosMensais(1);
        }

        $inicio = Carbon::parse(min($datas))->startOfMonth();
        $fim    = Carbon::now()->endOfMonth();

        $totalMeses = $inicio->diffInMonths($fim) + 1;

        // Se mais de 36 meses, agrupa por ano
        if ($totalMeses > 36) {
            return $this->agregarPorAno($inicio, $fim);
        }

        // Caso contrario, agrupa por mes desde o inicio
        $labels = [];
        $entradas = [];
        $saidas = [];

        $cursor = $inicio->copy();
        while ($cursor->lte($fim)) {
            $mesInicio = $cursor->copy()->startOfMonth();
            $mesFim    = $cursor->copy()->endOfMonth();

            $labels[] = ucfirst($cursor->translatedFormat('M/Y'));

            $entradas[] = (float) Venda::pagas()
                ->whereBetween('data_venda', [$mesInicio, $mesFim])
                ->sum('total');

            $saidas[] = (float) Despesa::query()
                ->whereBetween('data_despesa', [$mesInicio, $mesFim])
                ->sum('valor');

            $cursor->addMonth();
        }

        return $this->montarDataset($labels, $entradas, $saidas);
    }

    private function agregarPorAno(Carbon $inicio, Carbon $fim): array
    {
        $labels = [];
        $entradas = [];
        $saidas = [];

        for ($ano = $inicio->year; $ano <= $fim->year; $ano++) {
            $anoInicio = Carbon::create($ano, 1, 1)->startOfDay();
            $anoFim    = Carbon::create($ano, 12, 31)->endOfDay();

            $labels[] = (string) $ano;

            $entradas[] = (float) Venda::pagas()
                ->whereBetween('data_venda', [$anoInicio, $anoFim])
                ->sum('total');

            $saidas[] = (float) Despesa::query()
                ->whereBetween('data_despesa', [$anoInicio, $anoFim])
                ->sum('valor');
        }

        return $this->montarDataset($labels, $entradas, $saidas);
    }

    /**
     * Monta a estrutura de datasets do Chart.js
     */
    private function montarDataset(array $labels, array $entradas, array $saidas): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Entradas (Vendas)',
                    'data' => $entradas,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
                [
                    'label' => 'Saídas (Despesas)',
                    'data' => $saidas,
                    'borderColor' => '#8e1512',
                    'backgroundColor' => 'rgba(142, 21, 18, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "R$ " + value.toLocaleString("pt-BR"); }',
                    ],
                ],
            ],
        ];
    }
}
