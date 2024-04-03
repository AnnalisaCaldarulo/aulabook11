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
</div>
