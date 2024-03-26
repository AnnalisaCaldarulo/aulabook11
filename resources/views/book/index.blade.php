<x-layouts.layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <h1 class="text-center">
                    Tutti i libri
                </h1>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            @forelse ($books as $book)
                <div class="d-flex justify-content-center col-12 col-md-4">
                    <x-book-card :book="$book" />
                </div>
            @empty
                <h1 class="text-center">
                    Non é stato pubblicato ancora nessun libro
                </h1>
            @endforelse
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div>
            {{ $books->links() }}
        </div>
    </div>
</x-layouts.layout>
