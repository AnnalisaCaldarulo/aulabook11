<x-layouts.layout>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12 p-4">
                <h2 class="text-center fs-1">
                    Libri da revisionare:
                </h2>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-glass py-5">
        <div class="row justify-content-center">
            @forelse ($books as $book)
                <div class="col-12 mt-5 d-flex justify-content-center">
                    <div class="card p-4">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                @if (Storage::disk('public')->exists($book->cover))
                                    <img src="{{ Storage::url($book->cover) }}" class="img-glass-card img-fluid"
                                        alt="Picsum photo">
                                @else
                                    <img src="{{ $book->cover }}" class="card-img-top img-glass-card "
                                        alt="Picsum photo">
                                @endif
                            </div>
                            <div class="col-12 col-lg-6 d-flex flex-column gap-4 justify-content-center">
                                <h4>Titolo: </h4>
                                <p>{{ $book->title }}</p>
                                <h4> Descrizione: </h4>
                                <p>{{ $book->description }}</p>
                                <a href="{{ route('book.download', compact('book')) }}">Scarica per revisionare</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 mt-5">
                    {{-- <form method="POST" action="{{ route('response.review', compact('book')) }}" class=" w-100"> --}}
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="review-label">Recensione</label>
                            <textarea name="content" id="review-label" cols="50" class="form-control" placeholder="Recensisci l'ebook"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Invia recensione</button>
                    {{-- </form> --}}
                </div>
            @empty
                <h2 class="text-center">
                    Non ci sono libri da revisionare
                </h2>
            @endforelse
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <div>
            {{ $books->links() }}
        </div>
    </div>
</x-layouts.layout>
