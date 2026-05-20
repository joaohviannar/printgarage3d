@php
    $brl = fn($v) => 'R$ ' . number_format($v, 2, ',', '.');
    $labelPeriodo = $filtros[$filtroAtual] ?? '1 mês';
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Cabecalho: titulo + filtro --}}
        <div class="fi-section-header" style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; margin-bottom: 1.25rem;">
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin: 0;">
                    Resumo do período
                </h3>
                <p style="font-size: 0.875rem; color: rgb(107 114 128); margin: 0.25rem 0 0 0;">
                    Valores consolidados — {{ $labelPeriodo }}
                </p>
            </div>

            <select wire:model.live="filter"
                    style="border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); padding: 0.5rem 0.75rem; font-size: 0.875rem; color: inherit; min-width: 8rem;">
                @foreach($filtros as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- 3 cards --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">

            {{-- Entradas --}}
            <div style="background: rgba(16, 185, 129, 0.08); border: 1px solid rgba(16, 185, 129, 0.25); border-radius: 0.75rem; padding: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg width="18" height="18" fill="none" stroke="#10B981" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5M5 12l7-7 7 7"/>
                    </svg>
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; color: #10B981;">
                        Entradas
                    </span>
                </div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #10B981; line-height: 1.2;">
                    {{ $brl($entradas) }}
                </div>
            </div>

            {{-- Saidas --}}
            <div style="background: rgba(239, 68, 68, 0.08); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 0.75rem; padding: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg width="18" height="18" fill="none" stroke="#EF4444" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12l7 7 7-7"/>
                    </svg>
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; color: #EF4444;">
                        Saídas
                    </span>
                </div>
                <div style="font-size: 1.5rem; font-weight: 700; color: #EF4444; line-height: 1.2;">
                    {{ $brl($saidas) }}
                </div>
            </div>

            {{-- Lucro --}}
            @php
                $corLucro = $lucro >= 0 ? '#0EA5E9' : '#F59E0B';
                $bgLucro  = $lucro >= 0 ? 'rgba(14, 165, 233, 0.08)' : 'rgba(245, 158, 11, 0.08)';
                $brLucro  = $lucro >= 0 ? 'rgba(14, 165, 233, 0.25)' : 'rgba(245, 158, 11, 0.25)';
            @endphp
            <div style="background: {{ $bgLucro }}; border: 1px solid {{ $brLucro }}; border-radius: 0.75rem; padding: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <svg width="18" height="18" fill="none" stroke="{{ $corLucro }}" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink: 0;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; color: {{ $corLucro }};">
                        Lucro Líquido
                    </span>
                </div>
                <div style="font-size: 1.5rem; font-weight: 700; color: {{ $corLucro }}; line-height: 1.2;">
                    {{ $brl($lucro) }}
                </div>
                @if($entradas > 0)
                    <div style="font-size: 0.75rem; color: rgb(107 114 128); margin-top: 0.25rem;">
                        Margem: {{ number_format(($lucro / $entradas) * 100, 1, ',', '.') }}%
                    </div>
                @endif
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
