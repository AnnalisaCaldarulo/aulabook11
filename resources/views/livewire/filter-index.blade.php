<div class="row justify-content-around">
    <div class="col-12 my-5" wire:ignore>
        <h1 class="text-center mb-4">Catalogo</h1>
        <div class="d-flex d-lg-none flex-wrap justify-content-center justify-content-lg-start align-items-center">
            <button class=" btn btn-primary-custom mb-3" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-expanded="false" aria-controls="collapseExample" id="btnArrow">
                Ricerca avanzata <i class="bi bi-funnel ms-2"></i><i class="bi bi-arrow-down" id="arrow"></i>
            </button>
        </div>
    </div>

    <div class="col-12 col-lg-4" wire:ignore>

        <form class="padding-custom-20y-30x br-15 my-3 collapse show d-lg-block" id="collapseExample">

            {{-- Ricerca --}}
            <div class="mb-3 padding-custom-20y-30x br-15">
                <h2 class="fw-bold mb-1 fs-3">Ricerca</h2>
                <input id="inputSearch" type="text" name="search" wire:model.live="search"
                    placeholder="Ricerca per titolo o per autore..."
                    class="form-control @error($search) is-invalid @enderror">
                @error($search)
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <hr>
            {{-- Scelta categoria --}}
            <div class="mb-3 ">
                <h2 class="fw-bold mb-3 fs-3">Categoria</h2>
                <div class="d-flex flex-wrap">
                    @foreach ($categories as $category)
                        <label class="px-3 py-2">
                            <input type="checkbox" wire:model.live="categoryChecked" value="{{ $category->id }}">
                            <p class="ms-2 d-inline-block mb-0">{{ $category->name }}</p>
                        </label>
                        @error('categoryChecked')
                            <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
                        @enderror
                    @endforeach
                </div>
            </div>
            <hr>
            {{-- input price --}}
            <div class="mb-3 ">
                <h2 class="fw-bold mb-3 fs-3">Prezzo</h2>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <label for="inputPrice" class="form-label fw-bold">Minimo</label>
                        <input id="inputPrice" type="number" name="minPrice" wire:model.live="minPrice"
                            placeholder="Da..." class="form-control @error($minPrice) is-invalid @enderror">
                        @error($minPrice)
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="inputPrice" class="form-label fw-bold">Massimo</label>
                        <input id="inputPrice" type="number" name="maxPrice" wire:model.live="maxPrice"
                            placeholder="A..." class="form-control @error($maxPrice) is-invalid @enderror">
                        @error($maxPrice)
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3 pt-4">
                <button class=" btn btn-primary d-block btn-clear-filter" wire:click.prevent="clearQueryString">Elimina
                    filtri</button>
            </div>
        </form>

    </div>

    <div class="col-12 col-lg-8 px-lg-5">
        <div class="row justify-content-center">
            <hr>
            <div class="mb-3">
                <h2 class="fw-bold mb-1 fs-3">Ordina</h2>
                <label for="inputCategory" class="form-label fw-bold"></label>
                <select class="form-control" id="inputCategory" type="number" name="orderValue"
                    wire:model.live="orderValue" placeholder="Ordina per..."
                    class="form-control @error($orderValue) is-invalid @enderror">
                    <option value="createAsc">Data di pubblicazione crescente</option>
                    <option value="createDesc">Data di pubblicazione decrescente</option>
                    <option value="priceAsc">Prezzo crescente</option>
                    <option value="priceDesc">Prezzo decrescente</option>
                    <option value="alfaOrderAsc">Ordine alfabetico A-Z</option>
                    <option value="alfaOrderADesc">Ordine alfabetico Z-A</option>
                </select>
                @error($orderValue)
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <hr>
            @forelse ($searched as $book)
                <div class="col-12 col-md-6 col-lg-3 m-3">
                    <x-book-card :book="$book" />
                </div>
            @empty
                <div>
                    <h3 class="text-center">
                        Non ci sono corrispondenze per le tue ricerche
                    </h3>
                </div>
            @endforelse
        </div>
    </div>
</div>
