<?php

namespace App\Filament\Widgets;

use App\Models\Despesa;
use App\Models\Venda;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

/**
 * Cards de KPIs do dashboard - Entradas, Saidas, Lucro e Ticket Medio do mes.
 * Cada card mostra variacao percentual em relacao ao mes anterior.
 */
class DashboardStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $inicioMesAtual    = Carbon::now()->startOfMonth();
        $fimMesAtual       = Carbon::now()->endOfMonth();
        $inicioMesAnterior = Carbon::now()->subMonth()->startOfMonth();
        $fimMesAnterior    = Carbon::now()->subMonth()->endOfMonth();

        // ==== ENTRADAS (Vendas pagas) ====
        $entradasMes = (float) Venda::pagas()
            ->whereBetween('data_venda', [$inicioMesAtual, $fimMesAtual])
            ->sum('total');

        $entradasAnterior = (float) Venda::pagas()
            ->whereBetween('data_venda', [$inicioMesAnterior, $fimMesAnterior])
            ->sum('total');

        // ==== SAIDAS (Despesas) ====
        $saidasMes = (float) Despesa::query()
            ->whereBetween('data_despesa', [$inicioMesAtual, $fimMesAtual])
            ->sum('valor');

        $saidasAnterior = (float) Despesa::query()
            ->whereBetween('data_despesa', [$inicioMesAnterior, $fimMesAnterior])
            ->sum('valor');

        // ==== LUCRO ====
        $lucroMes      = $entradasMes - $saidasMes;
        $lucroAnterior = $entradasAnterior - $saidasAnterior;

        // ==== TICKET MEDIO ====
        $countVendas = Venda::pagas()
            ->whereBetween('data_venda', [$inicioMesAtual, $fimMesAtual])
            ->count();

        $ticketMedio = $countVendas > 0 ? $entradasMes / $countVendas : 0;

        return [
            Stat::make('Entradas no mês', $this->formatBRL($entradasMes))
                ->description($this->descricaoVariacao($entradasMes, $entradasAnterior, 'vs mês anterior'))
                ->descriptionIcon($this->iconeVariacao($entradasMes, $entradasAnterior))
                ->color('success')
                ->chart($this->miniChartVendas()),

            Stat::make('Saídas no mês', $this->formatBRL($saidasMes))
                ->description($this->descricaoVariacao($saidasMes, $saidasAnterior, 'vs mês anterior'))
                ->descriptionIcon($this->iconeVariacao($saidasMes, $saidasAnterior, invertido: true))
                ->color('danger'),

            Stat::make('Lucro Líquido', $this->formatBRL($lucroMes))
                ->description($this->descricaoVariacao($lucroMes, $lucroAnterior, 'vs mês anterior'))
                ->descriptionIcon($this->iconeVariacao($lucroMes, $lucroAnterior))
                ->color($lucroMes >= 0 ? 'success' : 'danger'),

            Stat::make('Ticket Médio', $this->formatBRL($ticketMedio))
                ->description("{$countVendas} venda" . ($countVendas !== 1 ? 's' : '') . ' no mês')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('info'),
        ];
    }

    /**
     * Mini grafico para o card de entradas (ultimos 7 dias).
     */
    private function miniChartVendas(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $dia = Carbon::now()->subDays($i);
            $total = (float) Venda::pagas()
                ->whereDate('data_venda', $dia)
                ->sum('total');
            $data[] = round($total, 2);
        }
        return $data;
    }

    private function formatBRL(float $valor): string
    {
        return 'R$ ' . number_format($valor, 2, ',', '.');
    }

    private function descricaoVariacao(float $atual, float $anterior, string $sufixo): string
    {
        if ($anterior == 0) {
            return $atual > 0 ? "Novo no período" : "Sem dados";
        }

        $variacao = (($atual - $anterior) / abs($anterior)) * 100;
        $sinal = $variacao >= 0 ? '+' : '';
        return sprintf('%s%.1f%% %s', $sinal, $variacao, $sufixo);
    }

    private function iconeVariacao(float $atual, float $anterior, bool $invertido = false): string
    {
        $subiu = $atual > $anterior;

        if ($invertido) {
            return $subiu ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
        }

        return $subiu ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
    }

    private function corVariacao(float $atual, float $anterior, bool $invertido = false): string
    {
        $subiu = $atual > $anterior;

        if ($invertido) {
            // Para saidas, subir e RUIM
            return $subiu ? 'danger' : 'success';
        }

        return $subiu ? 'success' : 'danger';
    }
}
