<div class="card" style="width: 18rem;">
    <img src="{{ $book->cover ? Storage::url($book->cover) : '/header-image.png' }}" class="card-img-top"
        alt="Picsum photo">
    <div class="card-body">
        <h5 class="card-title">{{ $book->title }}</h5>
        <p class="card-text">{{ $book->getDescriptionSubstring() }}</p>
        @if ($book->category)
            <a href="{{ route('book.category', ['category' => $book->category]) }}" style="font-size: 14px;"
                class="">{{ $book->category->name }}</a>
        @endif
        <a href="{{ route('book.show', compact('book')) }}" class="btn btn-primary w-100">Vedi di piú</a>
    </div>

    <div class="card-footer">
        <div class="media">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="my-0 text-white">{{ $book->user->name }}</h6>
                <div class="mt-2">
                    @if ($book->price == 0)
                        <p class="fs-3 fw-bold">Free</p>
                    @else
                        <p class="fs-3 fw-bold">€ {{ $book->price }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
