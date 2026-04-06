<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class PostModal extends Component
{
    public $post = null;

    #[On('postSelected')]
    public function show($id)
    {
        $this->post = [
            'id' => $id,
            'title' => "Post $id",
            'description' => "Full details of post $id"
        ];
    }

    public function close()
    {
        $this->post = null;
    }

    public function render()
    {
        return view('livewire.post-modal');
    }
}
