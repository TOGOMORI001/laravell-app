<x-layout>
    <x-slot:title>{{ $post['title'] }} - Mini-CMS</x-slot:title>

    <article>
        <h1 class="text-3xl font-bold">{{ $post['title'] }}</h1>
        <p class="mt-1 text-sm text-gray-500">Par {{ $post['author'] }} · {{ $post['date'] }}</p>
        <div class="mt-6 space-y-4 leading-relaxed text-gray-700">
            @foreach ($post['body'] as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>
    </article>
    <p class="mt-8">
        <a href="{{ route('posts.index') }}" class="text-red-600 underline">Retour à la liste des articles</a>
    </p>
</x-layout>
