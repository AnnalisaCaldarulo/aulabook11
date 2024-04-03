<x-layouts.layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <h1 class="text-center">
                    Tutti i libri per la categoria {{ $category->name }}
                </h1>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            @forelse ($category->books as $book)
                <div class="d-flex justify-content-center col-12 col-md-4">
                    <x-book-card :book="$book" />
                </div>
            @empty
                <h2 class="text-center">
                    Non é stato pubblicato ancora nessun libro per questa categoria
                </h2>
            @endforelse
        </div>
    </div>

</x-layouts.layout>
