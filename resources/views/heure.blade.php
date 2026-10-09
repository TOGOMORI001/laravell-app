<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Heure actuelle</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 text-slate-900">
        <main class="flex min-h-screen items-center justify-center">
            <div class="rounded-xl bg-white p-8 shadow-lg ring-1 ring-slate-200">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-700">Heure actuelle</p>
                <h1 class="mt-4 text-4xl font-bold text-slate-900">{{ $heure }}</h1>
                <p class="mt-4 text-sm text-slate-600">Cette page est accessible sur <code class="rounded bg-slate-100 px-2 py-1 text-xs">/heure</code>.</p>
            </div>
        </main>
    </body>
</html>
