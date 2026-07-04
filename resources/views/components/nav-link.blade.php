@props([
    'href'   => '#',
    'active' => false,
    'accent' => 'bg-blue-600', // active background, matches sidebar accent
])

<a
    href="{{ $href }}"
    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
           focus:outline-none focus-visible:ring-2 focus-visible:ring-white/70
           {{ $active ? 'text-white ' . $accent : 'text-slate-300 hover:bg-white/10 hover:text-white' }}"
    {!! $active ? 'aria-current="page"' : '' !!}
>
    {{ $slot }}
</a>
