{{-- Como definicmos ´error como props eso debemos usar en nustras link ´ --}}
@props(['tab', 'error' => false])
<div x-show="tab === '{{ $tab }}'" style="display: none">
    {{ $slot }}

</div>
