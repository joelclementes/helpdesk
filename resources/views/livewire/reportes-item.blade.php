<div class="bg-white shadow rounded-lg overflow-hidden border border-gray-300 mb-4">
    {{-- Header --}}
    <div class="px-4 py-3 bg-slate-100 flex flex-col justify-between items-start">
        <h3 class="font-semibold text-gray-800 text-sm">{{ $reporte->categoria->name }}</h3>
        {{-- Capturó y Asignación en una sola línea --}}
        <div class="flex justify-between w-full text-xs text-gray-500">
            <span>Capt: <strong>{{ $reporte->capturista->name }}</strong></span>
            <span>Asig: <strong>{{ $reporte->tecnico->name }} - {{ $reporte->tiempo_transcurrido }}</strong></span>
            <span>Est: <strong>{{ $reporte->estado->name }}</strong></span>
        </div>
    </div>

    {{-- Body --}}
    <div class="px-4 py-4 ">
        <p class="font-serif text-gray-800 text-2xl">{{ $reporte->descripcion }}</p>
    </div>
    <div class="px-4 py-1 bg-slate-100 flex flex-col justify-between items-start">
        <span class="text-xs text-gray-500">Solicitó: <strong>{{ $reporte->solicitante }}</strong></span>
    </div>
    @if ($reporte->comentarios->count() > 0)
        {{-- Comentarios --}}
        <div class="px-4 py-3 bg-white border-t">
            <h4 class="text-xs uppercase tracking-wider text-gray-500 mb-2">
                Comentarios
                <span class="text-gray-400">
                    ({{ $reporte->comentarios->count() }})
                </span>
            </h4>

            <ul class="space-y-3">
                @foreach ($reporte->comentarios as $c)
                    <li class="flex items-start gap-3">
                        <div
                            class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-sm font-semibold">
                            {{ mb_substr($c->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="flex-1 bg-gray-100 p-2 rounded-2xl">
                            <div class="flex items-center gap-2">
                                <span
                                    class="font-semibold text-sm text-gray-800">{{ $c->user->name ?? 'Usuario' }}</span>
                                {{-- <span class="text-xs text-gray-500">{{ $c->created_at->diffForHumans() }}</span> --}}
                            </div>
                            <p class="text-sm text-gray-700">
                                {{ $c->comentario }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif



    {{-- Footer --}}
    <div class="px-0 bg-gray-50 border-t flex divide-x text-sm text-gray-600">
        <button wire:click="atender"
            class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 transition">
            <i class="fa-solid fa-check text-green-600"></i>
            <span>Atendido</span>
        </button>

        <button wire:click="cerrar"
            class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 transition">
            <i class="fa-solid fa-lock text-blue-600"></i>
            <span>Cerrado</span>
        </button>

        <button wire:click="cancelar"
            class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 transition">
            <i class="fa-solid fa-xmark text-red-600"></i>
            <span>Cancelar</span>
        </button>

        <button wire:click="comentar"
            class="flex-1 flex items-center justify-center gap-2 py-2 hover:bg-gray-100 transition">
            <i class="fa-regular fa-comment-dots text-gray-600"></i>
            <span>Comentar</span>
        </button>
    </div>
</div>
