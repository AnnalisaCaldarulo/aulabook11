 <div class="pb-5">
     @if (session()->has('message'))
         <div class="d-flex justify-content-center my-2 alert alert-success">
             {{ session('message') }}
         </div>
     @endif

     @if (session()->has('errorMessage'))
         <div class="d-flex justify-content-center my-2 alert alert-danger">
             {{ session('errorMessage') }}
         </div>
     @endif
     @if (session()->has('errorMessage'))
         <div class="d-flex justify-content-center my-2 alert alert-danger">
             {{ session('error') }}
         </div>
     @endif
     <nav>
         <div class="nav nav-tabs" id="nav-tab" role="tablist">
             <button class="nav-link {{ $step === 1 ? 'active' : '' }} " id="nav-home-tab" data-bs-toggle="tab"
                 data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"
                 wire:click="changeStep(1)">UPLOAD</button>
             <button class="nav-link {{ $step === 2 ? 'active' : '' }}" id="nav-profile-tab" data-bs-toggle="tab"
                 data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                 aria-selected="false" wire:click="changeStep(2)" {{ $title ? '' : 'disabled' }}>COVER</button>
             <button class="nav-link {{ $step === 3 ? 'active' : '' }} " id="nav-contact-tab" data-bs-toggle="tab"
                 data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                 aria-selected="false" wire:click="changeStep(3)" {{ $cover ? '' : 'disabled' }}>Salvataggio</button>

         </div>
     </nav>
     <div class="tab-content" id="nav-tabContent">
         {{-- primo tab --}}
         <div class=" {{ $step !== 1 ? 'd-none' : '' }}" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
             tabindex="0">
             <form wire:submit="saveBook">
                 <div class="mb-3">
                     <label id="titleId" class="form-label">Titolo</label>
                     <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title"
                         for="titleId">
                     @error('title')
                         <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
                     @enderror

                 </div>
                 <div class="mb-3">
                     <label id="descriptionId" class="form-label">Descrizione del Libro</label>
                     <textarea id="" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror"
                         wire:model="description" for="descriptionId"></textarea>
                     @error('description')
                         <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
                     @enderror
                 </div>
                 {{-- categoria US 5 --}}
                 <div class="mb-3">
                     <label for="inputCategory" class="form-label">Categoria</label>
                     <select name="inputCategory" id="inputCategory" name="selectedCategory"
                         wire:model="selectedCategory" class="form-control">
                         @foreach ($categories as $category)
                             <option value="{{ $category->id }}">{{ $category->name }}</option>
                         @endforeach
                     </select>
                     @error('pdf')
                         <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
                     @enderror
                 </div>
                 <div class="mb-3">
                     <label id="pdfId" class="form-label">Carica il tuo PDF</label>
                     <input type="file" class="form-control @error('pdf') is-invalid @enderror" wire:model="pdf"
                         accept=".pdf" for="pdfId">
                     @error('pdf')
                         <div class="p-0 small fst-italic text-danger">{{ $message }}</div>
                     @enderror
                 </div>
             </form>
         </div>
         {{-- secondo tab --}}
         <div class=" {{ $step !== 2 ? 'd-none' : '' }}" id="nav-profile" role="tabpanel"
             aria-labelledby="nav-profile-tab" tabindex="0">
             {{-- Form generazione immagine --}}
             <div class="container">
                 <div class="row justify-content-center">
                     <div class="col-12 col-lg-10 pt-2">
                         <h2 class="text-center">Descrivi la tua immagine di copertina</h2>
                     </div>
                 </div>
             </div>
             <form wire:submit="generate">
                 @if ($errors->any())
                     <div class="alert alert-danger">
                         <ul>
                             @foreach ($errors->all() as $error)
                                 <li>{{ $error }}</li>
                             @endforeach
                         </ul>
                     </div>
                 @endif
                 <div class="mb-3">
                     <label for="idStyle" class="form-label">Stile*</label>
                     <select wire:model="style" class="form-control @error('style') is-invalid @enderror">
                         <option value="">Scegli uno stile:</option>
                         @foreach ($styles as $style)
                             <option value="{{ $style }}">{{ $style }}</option>
                         @endforeach
                     </select>
                 </div>

                 {{-- Input categoria default --}}

                 <div class="mb-3">
                     <label for="idSubject" class="form-label">Soggetto principale*</label>
                     <textarea class="form-control @error('subject') is-invalid @enderror" id="idSubject" aria-describedby=""
                         wire:model="subject" cols="30" rows="5"></textarea>
                 </div>
                 {{-- ! DOPO LA MODIFICA DI AMBIENCE->TOPIC --}}
                 <div class="mb-3">
                     <label for="idSubject"
                         class="form-label">{{ $isDidactics_nonFiction ? 'Argomento/descrizione *' : 'Ambientazione *' }}</label>
                     <textarea class="form-control @error('subject') is-invalid @enderror" id="idSubject" aria-describedby=""
                         wire:model="topic" cols="30" rows="5"
                         placeholder="{{ $isDidactics_nonFiction ? 'Descrivi brevemente l\'argomento del tuo libro' : 'Descrivi brevemente l\'ambientazione del tuo libro' }}"></textarea>
                 </div>

                 {{--
                    !PRIMA DELLA MODIFICA DI AMBIENCE->TOPIC
                     <div class="mb-3">
                     <label for="idAmbience" class="form-label">Ambientazione*</label>
                     <textarea class="form-control @error('ambience') is-invalid @enderror" id="idAmbience" aria-describedby=""
                         wire:model="ambience" cols="30" rows="5"></textarea>
                 </div> --}}
                 <div class="mb-3">
                     <label for="idOtherDetails" class="form-label">Altri dettagli</label>
                     <textarea class="form-control @error('otherDetails') is-invalid @enderror" id="idOtherDetails" aria-describedby=""
                         wire:model="otherDetails" cols="30" rows="5"></textarea>
                 </div>
                 <div class="mb-3">
                     <label for="idMainColor" class="form-label">Colore principale</label>
                     <input type="text" class="form-control @error('idMainColor') is-invalid @enderror"
                         id="idMainColor" aria-describedby="" wire:model="mainColor">
                 </div>
                 <div class="d-flex justify-content-center">
                     @if ($isGeneratingImage)
                         {{-- <div wire:loading wire:target="generate"> --}}
                         <x-loader />
                         <span wire:poll.visible="checkGeneratedImage"></span>
                         {{-- </div> --}}
                     @endif
                     @if ($cover)
                         <img src="{{Storage::url($cover)}}" alt="cover" class="img-fluid mx-auto">
                     @endif
                     {{-- ! codice prima della us 12
                         @if ($cover)
                         <img src="{{ Storage::url($cover) }}" alt="cover">
                     @endif --}}
                 </div>
                 <div class="row justify-content-center">
                     <div class="col-12 col-lg-10 pt-2 d-flex justify-content-center">
                         <button type="submit"
                             class="btn btn-danger mt-2">{{ $cover ? 'Rigenera' : 'Genera' }}</button>
                     </div>
                 </div>

             </form>
         </div>
     </div>
     {{-- salvataggio --}}
     <div class="{{ $step !== 3 ? 'd-none' : '' }}" id="nav-contact" role="tabpanel"
         aria-labelledby="nav-contact-tab" tabindex="0">

         @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
         @endif
         <x-preview-card title="{{ $title }}" description="{{ $description }}" cover="{{ $cover }}"
             author="{{ Auth::user()->name }}" category="{{ $categories->find($selectedCategory)?->name }}"
             url="#" />
     </div>
     <div class="container">
         <div class="row justify-content-center">
             <div
                 class="col-12 d-flex {{ $step == 2 || $step == 3 ? 'justify-content-between' : 'justify-content-center' }}">
                 <button type="button" class="btn btn-success {{ $step == 1 ? 'd-none' : '' }}"
                     wire:click="prevStep">Indietro</button>
                 <button type="button" wire:click="nextStep"
                     class=" btn btn-success {{ $step == 3 ? 'd-none' : '' }}"
                     {{ $step == 2 && !$cover ? 'disabled' : '' }}>Avanti</button>
                 <div class="{{ $step == 3 ? '' : 'd-none' }}">
                     <form wire:submit="saveBook">
                         <button type="submit" class=" {{ $step == 3 ? '' : 'd-none' }} btn btn-info">Inserisci
                             eBook</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 </div>
