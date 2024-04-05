<x-layouts.layout>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center">
                <hs class="display-2 text-center">
                    Le mie pubblicazioni: {{ Auth::user()->name }}
                </hs>
            </div>
        </div>
    </div>
    @if (count($books) > 0)
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">

                    <table class="table table-bordered border-dark shadow ">
                        <thead>
                            <tr>
                                <th scope="col">Titolo</th>
                                <th scope="col">Descrizione</th>
                                <th scope="col">Cover</th>
                                <th scope="col">Actions</th>
                                <th scope="col">Publish</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Price</th>
                                <th scope="col">Revisor review</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->getDescriptionSubstring() }}</td>
                                    <td class="d-flex justify-content-center">
                                        @if ($book->cover)
                                            <img src="{{ Storage::url($book->cover) }}" alt="" width="95%" height="95%"
                                                class="rounded-circle ">
                                        @else
                                            immagine
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('book.viewPdf', compact('book')) }} class="btn
                                                btn-primary"><i class="bi bi-eye"></i></a>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-between">
                                            @if ($book->is_published)
                                                <form action="{{ route('user.unpublish', compact('book')) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit"
                                                        class="btn btn-danger mx-3 shadow">Nascondi</button>
                                                </form>
                                            @else
                                                <form action="{{ route('user.publish', compact('book')) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('patch')
                                                    <button type="submit"
                                                        class="btn btn-success mx-3 shadow">Pubblica</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        @if ($book->category)
                                            {{ $book->category->name }}
                                        @else
                                            Nessuna categoria selezionata
                                        @endif
                                    </td>
                                    <td>
                                        @if ($book->price > 0)
                                            {{ $book->price }} €
                                        @else
                                            Free
                                        @endif
                                    </td>

                                    <td>
                                        <div class="container">
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-md-6 d-flex justify-content-center">
                                                    <button type="button" class="btn btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal_{{ $book->id }}">
                                                        <i class="bi bi-chat-right-quote"></i>
                                                    </button>
                                                </div>
                                            </div>
                                    </td>

                                    <div class="modal fade" id="exampleModal_{{ $book->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Recensione
                                                        Revisore</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @forelse ($book->reviews as $review)
                                                        <p class="mb-1">Revisore
                                                            {{ date('d-m-Y H:i', strtotime($review->created_at)) }} :
                                                        </p>
                                                        <p>{{ $review->content }}</p>
                                                    @empty
                                                        <h2>Non ci sono recensioni</h2>
                                                    @endforelse
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- versione per il telefono --}}
            </div>
        </div>
    @endif

    <div class="container my-5">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="display-2 text-center font-bold">
                    Libri acquistati
                </h2>
            </div>
        </div>
    </div>
    @if (count($purchasedBooks) > 0)
        <div class="container-fluid my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 d-none d-sm-block">
                    {{-- tabella --}}
                    <table class="table table-bordered border-dark shadow ">
                        <thead>
                            <tr>
                                <th scope="col">Titolo</th>
                                <th scope="col">Descrizione</th>
                                <th scope="col">Cover</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchasedBooks as $pBook)
                                <tr>
                                    <td>{{ $pBook->book->title }}</td>
                                    <td>{{ $pBook->getDescriptionSubstring() }}</td>
                                    <td class="d-flex justify-content-center">
                                        @if ($pBook->book->cover)
                                            <img src="{{ Storage::url($pBook->book->cover) }}" class="rounded-circle "
                                                width="20%" height="20%" alt="">
                                        @else
                                            <img src="{{ $pBook->book->cover }}" class="rounded-circle " width="20%"
                                                height="20%" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pBook->book->category)
                                            {{ $pBook->book->category->name }}
                                        @else
                                            Nessuna categoria selezionata
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pBook->book->price > 0)
                                            {{ $pBook->book->price }} €
                                        @else
                                            Free
                                        @endif
                                    </td>
                                    <td class="ps-3">
                                        <div class="dropdown">
                                            <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu bg-custom-dark p-2">
                                                <li>
                                                    <a class="dropdown-item text-decoration-none"
                                                        href="{{ route('book.download', ['book' => $pBook->book]) }}">
                                                        <i class="bi bi-box-arrow-down px-2"></i>
                                                        Scarica
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-decoration-none"
                                                        href="{{ route('book.show', ['book' => $pBook->book]) }}">
                                                        <i class="bi bi-eye px-2"></i>
                                                        Visualizza
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</x-layouts.layout>
