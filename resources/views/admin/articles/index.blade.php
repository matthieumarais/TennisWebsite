@section('title', 'Articles')

<x-app-layout>
<div class="container mt-4">
    <div>
        <x-link-button href="{{ route('admin.articles.create') }}">Créer un article</x-link-button>
    </div>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Titres
                </th>
                <th scope="col" class="px-6 py-3">
                    Contenus
                </th>
                <th scope="col" class="px-6 py-3">
                    Images
                </th>
                <th scope="col" class="px-6 py-3">
                    Dates de création
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $article->title }}
                </th>
                <td class="px-6 py-4">
                    {{ Str::limit($article->content, 20) }}
                </td>
                <td class="px-6 py-4">
                    {{ $article->image ? 'Oui' : 'Non' }}
                </td>
                <td class="px-6 py-4">
                    {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y à H\hi') }}
                </td>
                <td class="px-6 py-4 d-flex justify-content-between">
                    <x-link-button href="{{ route('admin.articles.edit', $article) }}">Editer</x-link-button>
                    <form class="inline-block" action="{{ route('admin.articles.destroy', $article) }}" method="post">
                        @csrf
                        @method('delete')
                        <x-danger-button>Supprimer</x-danger-button>
                    </form>
                </td>
            </tr>
            @endforeach

            {{ $articles->links() }}
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
