<x-layouts.layout>

    @if (session()->has('message'))
        <div class="d-flex justify-content-center my-2 alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <h1 class="text-center">
                    Titolo del libro: {{ $book->title }}
                </h1>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="d-flex justify-content-center col-12 col-md-4">
                <div class="card" style="width: 18rem;">
                    <img src="https://picsum.photos/200/200" class="card-img-top" alt="Picsum photo">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->title }}</h5>
                        <p class="card-text">{{ $book->description }}</p>
                        <a href="{{ route('book.category', ['category' => $book->category]) }}"></a>
                        <a href="{{ route('book.viewPdf', compact('book')) }}"
                            class="btn btn-primary w-100 mb-2 d-none d-sm-block">Visualizza</a>
                        <a href="{{ Storage::url($book->pdf) }}"
                            class="btn btn-primary w-100 mb-2 d-block d-sm-none">Visualizza</a>
                        <a href="{{ route('book.download', compact('book')) }}" class="btn btn-primary">Scarica</a>
                        <a href="{{ route('book.index') }}" class="btn btn-primary">Torna indietro</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-5">
                <div class="card-custom-glass card-show-height align-items-center padding-custom-20y-30x">
                    <h2 class="text-center">Vuoi lasciare una recensione?</h2>
                    <p class="text-center">Condividi il tuo pensiero con altri lettori!</p>
                    <form method="POST" action="{{ route('comments.store', compact('book')) }}" class="w-100 mt-3">
                        @csrf
                        <label class="form-label fw-bold">Inserisci una recensione</label>
                        <textarea id="inputComment" cols="30" rows="5" name="content" placeholder="Inserisci una recensione..."
                            class="form-control"></textarea>
                        <button type="submit" class="btn btn-primary my-3">Commenta</button>
                    </form>
                    @if ($book->comments->isNotEmpty())
                        @foreach ($book->comments as $comment)
                            <livewire:edit-comment :comment="$comment" />
                        @endforeach
                    @else
                        <p class="text-white-custom fw-bold fs-3">Non ci sono recensioni</p>
                    @endif
                </div>
            </div>
        </div>
    </div>


</x-layouts.layout>
