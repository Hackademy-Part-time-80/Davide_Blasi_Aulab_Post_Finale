@props(['name', 'id'])

@php
    $fieldMessages = collect($errors->get($name))
        ->flatten()
        ->merge(collect($errors->get($name . '.*'))->flatten())
        ->unique();
@endphp

@if ($fieldMessages->isNotEmpty())
    <div class="invalid-feedback d-block" id="{{ $id }}">
        @foreach ($fieldMessages as $fieldMessage)
            <p class="mb-0">{{ $fieldMessage }}</p>
        @endforeach
    </div>
@endif