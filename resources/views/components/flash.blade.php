@props(['errorTargets' => []])
@if (session('success') || session('error') || $errors->any())
<div class="home-container home-flash pt-3">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-2" role="status" aria-live="polite">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Chiudi"></button>
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger mb-2" role="alert">
        <p class="fw-semibold mb-1">Controlla i dati inseriti:</p>
        <ul class="mb-0 ps-3">
            @foreach ($errors->messages() as $field => $messages)
            @php($target = $errorTargets[$field] ?? $errorTargets[Str::before($field, '.')] ?? null)
            @foreach ($messages as $error)
            <li>
                @if ($target)
                <a class="alert-link" href="#{{ $target }}">{{ $error }}</a>
                @else
                {{ $error }}
                @endif
            </li>
            @endforeach
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endif