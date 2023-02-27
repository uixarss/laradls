{{-- @props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-600']) }}>
        {{ $status }}
    </div>
@endif --}}

@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-warning alert-dismissible fade show']) }} role="alert">
        {{ $status }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
