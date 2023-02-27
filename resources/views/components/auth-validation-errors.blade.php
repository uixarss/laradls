{{-- @props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

@props(['errors'])

@if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>{{ __('Whoops! Something went wrong.') }}</strong>
        @foreach ($errors->all() as $error)
            {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
