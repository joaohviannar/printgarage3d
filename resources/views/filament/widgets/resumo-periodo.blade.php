@php
    $brl = fn($v) => 'R$ ' . number_format($v, 2, ',', '.');
    $labelPeriodo = $filtros[$filtroAtual] ?? '1 mês';
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Cabecalho: titulo + filtro --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h3 class="text-base font-semibold text-gray-950 dark:text-white">
                    Resumo do período
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Valores consolidados — {{ $labelPeriodo }}
                </p>
            </div>

            <select wire:model.live="filter"
                    class="fi-select-input block w-full sm:w-auto rounded-lg border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-white/10 dark:bg-white/5 dark:text-white">
                @foreach($filtros as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- 3 cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

            {{-- Entradas --}}
            <div class="rounded-xl bg-success-50 dark:bg-success-500/10 p-4 ring-1 ring-success-500/20">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8l-8 8-8-8"/>
                    </svg>
                    <span class="text-xs uppercase tracking-wider font-semibold text-success-700 dark:text-success-300">
                        Entradas
                    </span>
                </div>
                <div class="text-2xl font-bold text-success-700 dark:text-success-400">
                    {{ $brl($entradas) }}
                </div>
            </div>

            {{-- Saidas --}}
            <div class="rounded-xl bg-danger-50 dark:bg-danger-500/10 p-4 ring-1 ring-danger-500/20">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-danger-600 dark:text-danger-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 20V4m-8 8l8-8 8 8"/>
                    </svg>
                    <span class="text-xs uppercase tracking-wider font-semibold text-danger-700 dark:text-danger-300">
                        Saídas
                    </span>
                </div>
                <div class="text-2xl font-bold text-danger-700 dark:text-danger-400">
                    {{ $brl($saidas) }}
                </div>
            </div>

            {{-- Lucro --}}
            @php $corLucro = $lucro >= 0 ? 'info' : 'warning'; @endphp
            <div class="rounded-xl bg-{{ $corLucro }}-50 dark:bg-{{ $corLucro }}-500/10 p-4 ring-1 ring-{{ $corLucro }}-500/20">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-{{ $corLucro }}-600 dark:text-{{ $corLucro }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs uppercase tracking-wider font-semibold text-{{ $corLucro }}-700 dark:text-{{ $corLucro }}-300">
                        Lucro Líquido
                    </span>
                </div>
                <div class="text-2xl font-bold text-{{ $corLucro }}-700 dark:text-{{ $corLucro }}-400">
                    {{ $brl($lucro) }}
                </div>
                @if($entradas > 0)
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Margem: {{ number_format(($lucro / $entradas) * 100, 1, ',', '.') }}%
                    </div>
                @endif
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
