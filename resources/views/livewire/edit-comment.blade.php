<div>
    @if (session()->has('message'))
        <div class="d-flex justify-content-center my-2 alert alert-danger">
            {{ session('message') }}
        </div>
    @endif
    @if ($comment)
        <div class="br-15 mt-4 bg-glass shadow-lg  p-4">
            <div class="border-bottom">
                <p class="fs-5 mt-3 fw-bold">{{ $comment->user->name }}</p>
                <p class="fst-italic">{{ date('d-m-Y H:i', strtotime($comment->created_at)) }}</p>
            </div>
            <div class="text-white-custom mt-2">
                <p class="{{ $is_edit ? 'd-none' : '' }}">{{ $comment->content }}</p>

                <form wire:submit="update" class="{{ $is_edit ? '' : 'd-none' }} d-flex align-items-center w-100">
                    @csrf
                    @method('PUT')
                    <textarea wire:model="content" class="form-control me-2"></textarea>
                    <button type="submit" class="btn btn-primary">Modifica</button>
                </form>
            </div>
            <div class="d-flex justify-content-between">

                @if (auth()->check() && $comment->user_id === auth()->user()->id)
                    <div>
                        <a type="button" wire:click="editButton" class="btn btn-primary"><i
                                class="{{ $is_edit ? 'bi bi-backspace' : 'bi bi-pencil' }} text-light"></i></a>

                        <a wire:click="delete"  wire:confirm="Are you sure you want to delete this post?" class="btn btn-danger"><i class="bi bi-trash text-light"></i></a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
