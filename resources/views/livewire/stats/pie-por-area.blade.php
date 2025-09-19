<div>
    <div wire:ignore
         x-data
         x-init="$nextTick(() => window.renderPie('{{ $chartId }}', @js($labels), @js($values)))">
        <canvas id="{{ $chartId }}" class="w-full h-64"></canvas>
    </div>

    @once
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                window._pies = window._pies || {};
                window.renderPie = function(id, labels, values) {
                    const el = document.getElementById(id);
                    if (!el) return;
                    const ctx = el.getContext('2d');
                    if (window._pies[id]) window._pies[id].destroy();
                    window._pies[id] = new Chart(ctx, {
                        type: 'pie',
                        data: { labels: labels, datasets: [{ data: values }] },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { position: 'bottom' },
                                tooltip: { callbacks: {
                                    label: (ctx) => {
                                        const v = ctx.parsed || 0;
                                        const total = (ctx.dataset.data || []).reduce((a,b)=>a+(+b||0),0) || 1;
                                        const pct = Math.round((v*100)/total);
                                        return `${ctx.label}: ${v} (${pct}%)`;
                                    }
                                }}
                            }
                        }
                    });
                };
            </script>
        @endpush
    @endonce
</div>
