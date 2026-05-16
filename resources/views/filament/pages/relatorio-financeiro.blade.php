<x-filament-panels::page>

    {{-- Formulario de filtros --}}
    <form wire:submit.prevent class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
        {{ $this->form }}
    </form>

    @php
        $r = $this->resumo;
        $brl = fn($v) => 'R$ ' . number_format($v, 2, ',', '.');
        $pct = fn($v) => number_format($v, 1, ',', '.') . '%';
    @endphp

    {{-- Cards de resumo --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
        <div class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <div class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Entradas</div>
            <div class="text-2xl font-bold text-success-600 dark:text-success-400 mt-1">{{ $brl($r['entradas']) }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $r['countVendas'] }} venda{{ $r['countVendas'] != 1 ? 's' : '' }}</div>
        </div>

        <div class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <div class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Saídas</div>
            <div class="text-2xl font-bold text-danger-600 dark:text-danger-400 mt-1">{{ $brl($r['saidas']) }}</div>
        </div>

        <div class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <div class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Lucro Líquido</div>
            <div class="text-2xl font-bold {{ $r['lucro'] >= 0 ? 'text-success-600 dark:text-success-400' : 'text-danger-600 dark:text-danger-400' }} mt-1">
                {{ $brl($r['lucro']) }}
            </div>
            <div class="text-xs text-gray-500 mt-1">Margem: {{ $pct($r['margem']) }}</div>
        </div>

        <div class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <div class="text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">Ticket Médio</div>
            <div class="text-2xl font-bold text-info-600 dark:text-info-400 mt-1">{{ $brl($r['ticketMedio']) }}</div>
        </div>
    </div>

    {{-- Tabelas detalhadas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

        {{-- Por canal --}}
        <div class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-3">📱 Vendas por Canal</h3>
            @if($r['porCanal']->isNotEmpty())
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="text-left py-2 text-gray-500">Canal</th>
                            <th class="text-right py-2 text-gray-500">Qtd</th>
                            <th class="text-right py-2 text-gray-500">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($r['porCanal'] as $linha)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="py-2 capitalize">{{ $linha->canal }}</td>
                                <td class="py-2 text-right">{{ $linha->qtd }}</td>
                                <td class="py-2 text-right font-semibold">{{ $brl($linha->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-500 py-4 text-center">Sem dados no período.</p>
            @endif
        </div>

        {{-- Por forma de pagamento --}}
        <div class="fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-3">💳 Vendas por Forma de Pagamento</h3>
            @if($r['porPagamento']->isNotEmpty())
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="text-left py-2 text-gray-500">Forma</th>
                            <th class="text-right py-2 text-gray-500">Qtd</th>
                            <th class="text-right py-2 text-gray-500">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($r['porPagamento'] as $linha)
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="py-2">{{ str_replace('_', ' ', ucfirst($linha->forma_pagamento)) }}</td>
                                <td class="py-2 text-right">{{ $linha->qtd }}</td>
                                <td class="py-2 text-right font-semibold">{{ $brl($linha->total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-500 py-4 text-center">Sem dados no período.</p>
            @endif
        </div>

        {{-- Despesas por categoria (full width) --}}
        <div class="md:col-span-2 fi-section bg-white dark:bg-gray-900 rounded-xl shadow ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-3">💸 Despesas por Categoria</h3>
            @if($r['despesasPorCategoria']->isNotEmpty())
                <table class="w-full text-sm">
                    <thead class="border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="text-left py-2 text-gray-500">Categoria</th>
                            <th class="text-right py-2 text-gray-500">Lançamentos</th>
                            <th class="text-right py-2 text-gray-500">Total</th>
                            <th class="text-right py-2 text-gray-500">% do total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($r['despesasPorCategoria'] as $linha)
                            @php $pctTotal = $r['saidas'] > 0 ? ($linha->total / $r['saidas']) * 100 : 0; @endphp
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <td class="py-2 flex items-center gap-2">
                                    @if($linha->categoria?->cor)
                                        <span class="inline-block w-3 h-3 rounded-full" style="background: {{ $linha->categoria->cor }}"></span>
                                    @endif
                                    {{ $linha->categoria?->nome ?? 'Sem categoria' }}
                                </td>
                                <td class="py-2 text-right">{{ $linha->qtd }}</td>
                                <td class="py-2 text-right font-semibold text-danger-600 dark:text-danger-400">{{ $brl($linha->total) }}</td>
                                <td class="py-2 text-right text-gray-500">{{ $pct($pctTotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm text-gray-500 py-4 text-center">Sem despesas no período.</p>
            @endif
        </div>
    </div>

</x-filament-panels::page>
