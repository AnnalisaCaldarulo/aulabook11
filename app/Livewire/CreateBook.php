<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class CreateBook extends Component
{
    use WithFileUploads;
    #[Validate('required|min:5')]
    public $title;
    #[Validate('required')]
    public $description;
    #[Validate('required|file|mimes:pdf')]
    public $pdf;

    public function messages()
    {
        return [
            '*.required' => 'Il campo :attribute è obbligatorio',
            '*.min'=> 'Il campo :attribute deve avere almeno :min caratteri',
            'pdf.file' => 'Il campo :attribute deve essere di tipo file.',
            'pdf.mimes' => 'Il campo :attribute deve essere di tipo pdf.',
        ];
    }
    public function validationAttributes()
    {
        return [
            'title' => 'titolo',
            'description' => 'descrizione',
            'pdf' => 'file'
        ];
    }

    public function saveBook()
    {
        // Validate
        $this->validate();
        // Creazione book
        Book::create(
            [
                'title' => $this->title,
                'description' => $this->description,
                'pdf' => $this->pdf->store('public/files'),
                'user_id' => Auth::user()->id,
            ]
        );
        return redirect()->route('homepage')->with('message', 'eBook inserito correttamente');
    }
    public function render()
    {
        return view('livewire.create-book');
    }
}
