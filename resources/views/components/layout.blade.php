@props(['title' => 'The Aulab Post', 'errorTargets' => []])
<!DOCTYPE html>
<html lang="it" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="color-scheme" content="dark">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $css ?? ''}}


    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-black text-white">
    <a class="skip-link" href="#main-content">Vai al contenuto</a>
    <x-navbar />
    <x-flash :error-targets="$errorTargets" />

    {{ $slot}}

    {{ $script ?? ''}}
</body>

</html>