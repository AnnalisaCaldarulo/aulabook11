<div>
    @if (session()->has('message'))
        <div class="d-flex justify-content-center my-2 alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="saveBook">

        {{-- input titolo --}}
        <div class="mb-3">
            <label id="titleId" class="form-label">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model.live="title"
                for="titleId">
            @error('title')
                <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
            @enderror

        </div>
        {{-- input password --}}
        <div class="mb-3">
            <label id="descriptionId" class="form-label">Descrizione del Libro</label>
            <textarea id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror"
                wire:model.live="description" for="descriptionId"></textarea>
            @error('description')
                <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- input pdf --}}
        <div class="mb-3">
            <label id="pdfId" class="form-label">Carica il tuo PDF</label>
            <input type="file" class="form-control @error('pdf') is-invalid @enderror" wire:model.live="pdf"
                accept=".pdf" for="pdfId">
            @error('pdf')
                <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Inserisci eBook</button>
    </form>
</div>
