<x-layout>
    <x-slot:title>Catégorie introuvable - Mini-CMS</x-slot:title>

    <h1 class="text-3xl font-bold text-gray-900">Catégorie introuvable</h1>
    <p class="mt-2 mb-8 text-gray-600">Cette catégorie n'existe pas ou a été déplacée.</p>

    <x-alert type="warning" title="Erreur 404" class="max-w-2xl">
        Choisissez une catégorie existante pour découvrir ses articles.
    </x-alert>

    @if ($categories->isNotEmpty())
        <section class="mt-8" aria-labelledby="categories-title">
            <h2 id="categories-title" class="mb-4 text-2xl font-bold">Catégories disponibles</h2>
            <ul class="flex flex-wrap gap-3">
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('posts.category', ['category' => $category->slug]) }}" class="inline-block rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-indigo-600 hover:border-indigo-600">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif

    <p class="mt-8">
        <a href="{{ route('home') }}" class="font-medium text-indigo-600 hover:underline">Retour à l'accueil</a>
    </p>
</x-layout>
