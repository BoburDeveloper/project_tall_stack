<?php

namespace App\Livewire;

use Livewire\Component;

class PostList extends Component
{
    public $posts = [];
    public $limit = 6;
    public $search = '';
    public $hasMore = true;

    public $maxCount = 60;

    public function mount()
    {
        $this->loadPosts();
    }

    public function loadPosts()
    {
        $all = collect(range(1, $this->maxCount))->map(function ($i) {
            return [
                'id' => $i,
                'title' => "Post $i",
                'description' => "Description for post $i"
            ];
        });

        $this->posts = $all->take($this->limit)->toArray();

        if ($this->limit >= $all->count()) {
            $this->hasMore = false;
        }
    }

    public function loadMore()
    {
        if (!$this->hasMore) return;

        $this->limit += 6;
        $this->loadPosts();
    }

    public function getFilteredPostsProperty()
    {
        return collect($this->posts)
            ->filter(function ($post) {
                return str_contains(
                    strtolower($post['title']),
                    strtolower($this->search)
                );
            })
            ->values()
            ->toArray();
    }

    public function getCountProperty()
    {
        return count($this->posts);
    }

    public function selectPost($id)
    {
        $this->dispatch('postSelected', id: $id);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
