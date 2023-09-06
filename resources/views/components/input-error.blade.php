@props(['messages'])

@if ($messages)
    {{-- <ul {{ $attributes->merge(['class' => 'uk-text-danger']) }}> --}}
    @foreach ((array) $messages as $message)
        <small class="uk-text-danger">{{ $message }}</small>
    @endforeach
    {{-- </ul> --}}
@endif
