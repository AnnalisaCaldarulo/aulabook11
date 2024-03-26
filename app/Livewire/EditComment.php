<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditComment extends Component
{

    public $comment;
    public $content = '';
    public $is_edit = false;


    public function editButton()
    {
        $this->is_edit = !$this->is_edit;
    }

    public function update()
    {
        if ($this->comment->user_id != Auth::id()) {
            return redirect(route('welcome'))->with('message', 'Hey! non puoi modificar il commento di un altro utente!');
        }

        $this->comment->update([
            'content' => $this->content,
        ]);
        $this->is_edit = false;
    }


    public function delete()
    {
        if ($this->comment->user_id != Auth::id()) {
            return redirect(route('welcome'))->with('message', 'Hey! non puoi cancellare il commento di un altro utente!');
        }
        $this->comment->delete();
        $this->comment = null;
        session()->flash('message', 'Il commento è stato eliminato con successo.');
    }


    public function mount($comment)
    {
        $this->comment = $comment;
        $this->content = $comment->content;
    }
    public function render()
    {
        return view('livewire.edit-comment');
    }
}
