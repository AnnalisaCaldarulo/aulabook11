<x-layouts.layout>
    <header class="container my-5 py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 col-lg-6 col-xl-5 order-2 order-lg-1 text-center text-lg-start">
                <h1 class="display-2 font-bold">AulaBook</h1>
                <p class="my-5">
                    Con la nostra piattaforma intuitiva e i nostri servizi
                    professionali, puoi liberare la tua voce, preservando pienamente
                    il tuo stile unico e la tua visione artistica.
                </p>
                <a href="{{ route('book.create') }}" class="btn btn-primary">Pubblica un Libro</a>
            </div>
            <div class="col-12 col-lg-6 col-xl-5 text-center order-1 order-lg-2">
                <img src="{{ asset('header-image.png') }}" alt="aulabit" class="img-fluid">
            </div>
        </div>
    </header>

    <div class="container my-5">
        <div class="row justify-content-center">
            @forelse($books as $book)
                <div class="col-12 col-md-4 d-flex justify-content-center mt-3">
                    <x-book-card :book="$book" />
                </div>
            @empty
                <h2 class="text-center">
                    Non ci sono libri pubblicati
                </h2>
            @endforelse
        </div>
    </div>
</x-layouts.layout>
