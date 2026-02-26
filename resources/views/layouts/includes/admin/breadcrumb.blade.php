{{-- Verificar  si hay un elemento en ek arreglo de breadcrumbs --}}
@if (count($breadcrumbs))
    {{-- Display:block --}}
    <nav class="mb-2 block">
        <ol class="flex flex-wrap text-slate-700 text-sm">
            @foreach ($breadcrumbs as $item)
                <li class="flex items-center">
                    {{-- Si No es el primer elemento, pinta el separador con espacio --}}
                    @unless ($loop->first)
                        {{-- El span crean el separadorn con margen lateral --}}
                        <span class="px-2 text-gray-400">
                            /
                        </span>
                    @endunless
                    {{-- -Revisa si existe una llave/propiedad llamada 'href' --}}
                    @isset($item['href'])
                        {{-- Si existe, se muestra como enlace con opacidad reducida --}}
                        <a href="{{ $item['href'] }}" class="opacity-60 hover:opacity-100 transition">
                            {{ $item['name'] }}
                        </a>
                    @else
                        {{ $item['name'] }}
                    @endisset
                </li>
            @endforeach
        </ol>
        {{-- Ultimo eemento aparezca resaltado --}}
        @if (count($breadcrumbs) > 1)
            <h6 class="font-bold mt-2">
                {{ end($breadcrumbs)['name'] }}
            </h6>
        @endif
    </nav>
@endif
