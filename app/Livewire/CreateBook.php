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
    #[Validate('required')]
    public $selectedCategory;
    #[Validate('required')]
    public $cover;

    public $promptToken,  $book, $style, $subject, $ambience, $otherDetails, $mainColor;
    public $step = 1;

    protected $queryString = ['step'];

    public $styles = [
        'Gothic', 'Disney', 'Storybook', '3D render', 'Kodachrome', 'Steampuk',
        'Realistic', 'Realismo', 'Futuristico', 'Pencil drawing'
    ];

    public function messages()
    {
        return [
            '*.required' => 'Il campo :attribute è obbligatorio',
            '*.min' => 'Il campo :attribute deve avere almeno :min caratteri',
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


    public function changeStep($newStep)
    {
        $this->step = $newStep;
    }


    public function nextStep()
    {
        // if ($this->step == 1 || $this->step ==2) {
        //     $this->step++;
        // } 

        if ($this->step == 1) {
            $this->validate([
                'title' => 'required',
                'description' => 'required',
                'pdf' => 'required',
                'selectedCategory' => 'required',
            ], $this->messages());

            $this->step++;
            return;
        }

        if ($this->step == 2) {

            if (!$this->cover) {
                session()->flash('error', "Devi prima generare la copertina del libro");
                $this->validate([
                    'style' => 'required|max:1000',
                    'subject' => 'required',
                    'ambience' => 'required|max:1000',
                ]);
                return;
            }

            $this->step++;
        }
    }
    //funzione di controllo degli step prew
    public function prevStep()
    {
        if ($this->step == 3 || $this->step == 2) {
            $this->step--;
        }
    }
    public function generate()
    {
        $this->validate([
            'ambience' => 'required|max:1000',
            'style' => 'required|max:1000',
            'subject' => 'required',
        ]);

        $default = config('app.imagegen_default_prompt');
        $this->promptToken = "$default,
        use style: $this->style,
        the book subject is: $this->subject,
        the book main ambience is: $this->ambience,
        the other details here: $this->otherDetails,
        the book main color is: $this->mainColor";
        $this->cover = Book::generateImage($this->cover, $this->promptToken);
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
                'category_id' => $this->selectedCategory,
                'cover' => $this->cover ?? 'header-image.png'
            ]
        );
        return redirect()->route('homepage')->with('message', 'eBook inserito correttamente');
    }
    public function render()
    {
        return view('livewire.create-book');
    }
}
