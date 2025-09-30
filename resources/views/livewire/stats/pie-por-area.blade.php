<div class="flex items-start justify-between gap-3">
  <div>

    <div class="flex-1" wire:ignore x-data x-init="$nextTick(() => window.renderPie('{{ $chartId }}', @js($labels), @js($values), '{{ $title }}'))">
      <canvas id="{{ $chartId }}" class="w-full h-64"></canvas>
    </div>
    
    {{-- Botones Exportar --}}
    <div class="shrink-0 space-y-2">
      <button type="button"
      class="inline-flex items-center rounded-md border px-3 py-1.5 text-xs font-semibold hover:bg-gray-50"
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
</div>
