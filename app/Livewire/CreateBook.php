<?php

namespace App\Livewire;

use OpenAI;
use App\Models\Book;
use App\Models\User;
use Livewire\Component;
use App\Models\Category;
use App\Mail\ReviewRequest;
use Livewire\WithFileUploads;
use App\Models\GeneratedImage;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Jobs\GenerateOpenAiCoverImageJob;

class CreateBook extends Component
{
    use WithFileUploads;
    #[Validate('required|min:5')]
    public $title;
    #[Validate('required')]
    public $description;
    #[Validate('required_if:oldPdf,!=,null|file|mimes:pdf|nullable')]
    public $pdf;
    #[Validate('required')]
    public $selectedCategory;
    #[Validate('required')]
    public $cover;
    public $oldTitle;
    public $oldPdf;
    public $promptToken,  $book, $style, $subject, $topic, $otherDetails, $mainColor;
    public  $didacticsId, $nonFictionId;
    public $step = 1;

    public $editMode;

    #[Validate('required|min:0|numeric')]
    public $price;

    protected $queryString = ['step'];

    public $styles = [
        'Gothic', 'Disney', 'Storybook', '3D render', 'Kodachrome', 'Steampuk',
        'Realistic', 'Realismo', 'Futuristico', 'Pencil drawing'
    ];


    public $askReview = false;


    public $isDidactics_nonFiction = false;
    public $isOtherCategory = false;

    //US 12

    public $generatedImage;
    public $isGeneratingImage = false;

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
            'pdf' => 'file',
            'price' => 'prezzo'
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
                'pdf' => 'required_if:oldPdf,!=,null',
                'selectedCategory' => 'required',
                'price' => 'required|min:0|numeric',
            ], $this->messages());

            $this->step++;
            return;
        }

        if ($this->step == 2) {

            if (!$this->cover  && !$this->editMode) {
                session()->flash('error', "Devi prima generare la copertina del libro");
                $this->validate([
                    'style' => 'required|max:1000',
                    'subject' => 'required',
                    'topic' => 'required|max:1000',
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
            'topic' => 'required|max:1000',
            'style' => 'required|max:1000',
            'subject' => 'required',
        ]);

        // $default = config('app.imagegen_default_prompt');
        // $this->promptToken = "$default,
        // use style: $this->style,
        // the book subject is: $this->subject,
        // the other details here: $this->otherDetails,
        // the book main ambience is: $this->ambience,
        // the book main color is: $this->mainColor";

        $this->promptToken = $this->generatePromptTokenForCategory($this->selectedCategory);
        // $this->cover = Book::generateImage($this->cover, $this->promptToken);

        if ($this->generatedImage) {
            Storage::disk('public')->delete($this->generatedImage->image);
            $this->generatedImage->delete();
            $this->generatedImage = null;
        }

        // Creazione del nuovo oggett GeneratedImage e sua memorizzaizione
        $this->generatedImage = GeneratedImage::create([
            'prompt' => $this->promptToken,
        ]);

        dispatch(new GenerateOpenAiCoverImageJob($this->generatedImage));
        $this->isGeneratingImage = true;
    }


    // public  function generateImage2()
    // {

    //     $this->promptToken = "
    //     use style: $this->style,
    //     the book subject is: $this->subject,
    //     the other details here: $this->otherDetails,
    //     the book main color is: $this->mainColor";
    //     //OpenAI
    //     $client = OpenAI::client(config('app.open_ai_key'));
    //     try {
    //         $response = $client->images()->create([
    //             'prompt' => $this->promptToken,
    //             'n' => 1,
    //             'size' => config('app.open_ai_size'),
    //             'response_format' => 'b64_json',
    //         ]);
    //         // $this->cover = $response->data[0]->url;
    //         // $book = Book::find(7);
    //     } catch (\Exception $e) { //recupero errori generati dall'API
    //         $message = $e->getMessage();
    //         session()->flash('errorMessage', "$message");
    //         $this->cover = null;
    //     }
    // }

    public function checkGeneratedImage()
    {
        if ($this->generatedImage->error) {
            $this->isGeneratingImage = false;

            session()->flash('errorMessage', $this->generatedImage->error);
            $this->generatedImage = null;
            return;
        }

        if ($this->generatedImage->image) {
            $this->cover = $this->generatedImage->image;
            $this->isGeneratingImage = false;
        }
    }

    public function saveBook()
    {
        // Validate
        $this->validate();
        //modifica book

        if ($this->editMode) {
            // Aggiornamento book
            $this->book->update(
                [
                    'title' => $this->title,
                    'description' => $this->description,
                    'pdf' => $this->pdf ? $this->pdf->store('public/files') : $this->book->pdf,
                    'cover' => $this->cover ? $this->cover : $this->book->cover,
                    'is_published' => !$this->askReview,
                    'price' => $this->price,
                    'category_id' => $this->selectedCategory,
                    'review_status' => $this->askReview ? 'pending' : 'completed',
                ]
            );

            $message = "Libro modificato correttamente";
        } else {
            // Creazione book
            $book = Book::create(
                [
                    'title' => $this->title,
                    'description' => $this->description,
                    'pdf' => $this->pdf->store('public/files'),
                    'user_id' => Auth::user()->id,
                    'category_id' => $this->selectedCategory,
                    'cover' => $this->cover,
                    // 'cover_url' => $this->cover,
                    'price' => $this->price,
                    'is_published' => !$this->askReview,
                    'review_status' => $this->askReview ? 'pending' : 'completed',
                ]
            );

            $message = "Libro creato correttamente";
        }
        if ($this->askReview) {
            $revisors = User::where('role_id', 2)->where('id', '<>', Auth::id())->get();
            foreach ($revisors as $revisor) {
                Mail::to($revisor->email)->queue(new ReviewRequest($book));
            }
            return redirect()->route('homepage')->with('message', 'Libro inviato per la recesione correttamente');
        }
        session()->flash('message', $message);
    }

    public function mount($book = null)
    {
        $this->step = 1;


        if ($book) {
            $this->editMode = true;

            $this->book = $book;
            $this->title = $book->title;
            $this->oldTitle = $book->title;
            $this->description = $book->description;
            $this->cover = $book->cover;
            $this->selectedCategory = $book->category->id;
            $this->price = $book->price;
            $this->oldPdf = $book->pdf;
        }

        $didactics = Category::where('name', 'Didattica')->first();
        $nonFiction = Category::where('name', 'Saggistica')->first();
        $this->didacticsId = $didactics->id;
        $this->nonFictionId = $nonFiction->id;
    }

    public function generatePromptTokenForCategory($category)
    {
        $default = config('app.imagegen_default_prompt');
        $finalPrompt = "$default, use style: $this->style";

        if ($category == $this->didacticsId || $category == $this->nonFictionId) {
            $finalPrompt .= ", the book subject is:$this->subject , the book main topic is:$this->topic";
        } else {
            $finalPrompt .= ", the book main character is: $this->subject , the book main ambience is: $this->topic";
        }

        if ($this->otherDetails) {
            $finalPrompt .= ", other details here: $this->otherDetails";
        }
        if ($this->mainColor) {
            $finalPrompt .= ", use main color: $this->mainColor";
        }
        return $finalPrompt;
    }

    public function render()
    {

        $didacticsAndNonFictionPrompt = [$this->didacticsId, $this->nonFictionId];

        if (in_array($this->selectedCategory, $didacticsAndNonFictionPrompt)) {
            $this->isDidactics_nonFiction = true;
        } else {
            $this->isDidactics_nonFiction = false;
        }
        return view('livewire.create-book');
    }
}
