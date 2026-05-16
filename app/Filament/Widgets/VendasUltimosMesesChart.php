<?php

namespace App\Filament\Widgets;

use App\Models\Despesa;
use App\Models\Venda;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

/**
 * Grafico de linha mostrando vendas e despesas dos ultimos 6 meses.
 * Permite visualizar tendencia e comparativo entradas vs saidas.
 */
class VendasUltimosMesesChart extends ChartWidget
{
    protected ?string $heading = 'Entradas vs Saídas — últimos 6 meses';

    protected ?string $description = 'Comparativo mensal de vendas pagas e despesas';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $labels = [];
        $entradas = [];
        $saidas = [];

        for ($i = 5; $i >= 0; $i--) {
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
