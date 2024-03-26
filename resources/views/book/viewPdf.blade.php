<x-layouts.layout>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6 text-center">
                <h1>
                    Titolo : {{ $book->title }}
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid my-5">
        <div class="row ">
            <div class="col">
                <iframe id="myIframe" class="w-100" src="{{ Storage::url($book->pdf) }}"></iframe>
            </div>
        </div>
    </div>
</x-layouts.layout>
