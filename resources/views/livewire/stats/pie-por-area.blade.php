<div>
  <div wire:ignore
       x-data
       x-init="$nextTick(() => window.renderPie('{{ $chartId }}', @js($labels), @js($values), @js($title)))"
       x-on:render-pie.window="
         if ($event.detail.id === '{{ $chartId }}') {
           window.renderPie('{{ $chartId }}', $event.detail.labels, $event.detail.values, $event.detail.title ?? '')
         }
       ">
    <canvas id="{{ $chartId }}" class="w-full h-64"></canvas>
  </div>
</div>

