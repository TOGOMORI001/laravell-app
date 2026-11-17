<x-layout>
    <x-slot:title>Article introuvable - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Article introuvable</h1>
    <p class="mt-2 mb-8 text-gray-600">Cet article n'existe pas ou a été déplacé.</p>

    <x-alert type="warning" title="Erreur 404" class="max-w-2xl">
        Vérifiez l'adresse, ou retournez à la liste des articles.
    </x-alert>

    <p class="mt-6">
        <a href="{{ route('posts.index') }}" class="font-medium text-indigo-600 hover:underline">Voir les articles</a>
    </p>

    @if ($recentPosts->isNotEmpty())
        <section class="mt-12" aria-labelledby="recent-posts-title">
            <h2 id="recent-posts-title" class="mb-4 text-2xl font-bold">Articles récents</h2>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($recentPosts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
        </section>
    @endif
</x-layout>
