@props([
    'label'   => 'Metric',
    'value'   => '0',
    'trend'   => null,        // e.g. "+12% this month"
    'trendUp' => true,        // controls trend color
    'color'   => 'blue',      // tailwind color name: blue, emerald, amber, red, violet...
])

@php
    $iconBg = match ($color) {
        'emerald' => 'bg-emerald-50 text-emerald-600',
        'amber'   => 'bg-amber-50 text-amber-600',
        'red'     => 'bg-red-50 text-red-600',
        'violet'  => 'bg-violet-50 text-violet-600',
        default   => 'bg-blue-50 text-blue-600',
    };
@endphp

<div class="group rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition-all duration-200
            hover:-translate-y-0.5 hover:shadow-md">
    <div class="flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-gray-500">{{ $label }}</p>
            <p class="mt-1 text-2xl font-semibold text-gray-900">{{ $value }}</p>
        </div>

        @isset($icon)
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $iconBg }}">
                {{ $icon }}
            </span>
        @endisset
    </div>

    @if($trend)
        <p class="mt-3 flex items-center gap-1 text-xs font-medium {{ $trendUp ? 'text-emerald-600' : 'text-red-600' }}">
            <svg class="h-3.5 w-3.5 {{ $trendUp ? '' : 'rotate-180' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z" clip-rule="evenodd"/>
            </svg>
            {{ $trend }}
        </p>
    @endif
</div>
