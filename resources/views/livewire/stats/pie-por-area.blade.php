{{-- <div class="flex items-start justify-between gap-3">
    <div>

        <div class="flex-1" wire:ignore x-data x-init="$nextTick(() => window.renderPie('{{ $chartId }}', @js($labels), @js($values), '{{ $title }}'))">
            <canvas id="{{ $chartId }}" class="w-full h-64"></canvas>
        </div>

        {{-- Botones Exportar --}} {{--
        <div class="shrink-0 space-y-2">
            <button type="button"
                class="inline-flex items-center rounded-md border px-3 py-1.5 text-xs font-semibold hover:bg-gray-50"
                :disabled="!hasData"
                x-on:click="window.exportPie('{{ $chartId }}','png','{{ $title }}')">
                Exportar PNG
            </button>
            <button type="button"
                class="inline-flex items-center rounded-md border px-3 py-1.5 text-xs font-semibold hover:bg-gray-50"
                x-on:click="window.exportPie('{{ $chartId }}','jpeg','{{ $title }}')">
                Exportar JPG
            </button>
        </div>
    </div>
</div> --}}
<div class="flex items-start justify-between gap-3">
  <div
    wire:ignore
    x-data="{
      hasData: (@js($values) || []).some(v => +v > 0),
    }"
    x-init="$nextTick(() => {
      window.renderPie('{{ $chartId }}', @js($labels), @js($values), @js($title));
    })"
    x-on:render-pie.window="
      if ($event.detail.id === '{{ $chartId }}') {
        window.renderPie('{{ $chartId }}', $event.detail.labels, $event.detail.values, $event.detail.title || '');
        hasData = ($event.detail.values || []).some(v => +v > 0);
      }
    "
  >
    <canvas id="{{ $chartId }}" class="w-full h-64"></canvas>

    {{-- Botones Exportar --}}
    <div class="shrink-0 space-y-2 mt-2">
      <button type="button"
        class="inline-flex items-center rounded-md border px-3 py-1.5 text-xs font-semibold
               hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="!hasData"
        x-on:click="window.exportPie('{{ $chartId }}','png', @js($title))">
        Exportar PNG
      </button>

      <button type="button"
        class="inline-flex items-center rounded-md border px-3 py-1.5 text-xs font-semibold
               hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
        :disabled="!hasData"
        x-on:click="window.exportPie('{{ $chartId }}','jpeg', @js($title))">
        Exportar JPG
      </button>
    </div>
  </div>
</div>
