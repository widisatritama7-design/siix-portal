<?php

namespace App\Livewire\Inbox;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DCC\Submission;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function render()
    {
        $submissions = Submission::query()
            ->with(['department', 'creator'])
            ->when($this->search, function($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.inbox.index-inbox', [
            'submissions' => $submissions
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}