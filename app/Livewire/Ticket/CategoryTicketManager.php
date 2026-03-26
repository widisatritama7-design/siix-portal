<?php

namespace App\Livewire\Ticket;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Ticket\CategoryTicket;

class CategoryTicketManager extends Component
{
    use WithPagination;

    public $category_id;
    public $name;
    public $description;
    
    public $search = '';
    public $modalTitle = 'Tambah Kategori Baru';
    public $categoryToDelete = null;

    protected function rules()
    {
        return [
            'name' => 'required|min:3|max:100|unique:tb_tc_category_tickets,name,' . $this->category_id,
            'description' => 'nullable|max:255',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama kategori wajib diisi.',
        'name.min' => 'Nama kategori minimal 3 karakter.',
        'name.max' => 'Nama kategori maksimal 100 karakter.',
        'name.unique' => 'Nama kategori sudah digunakan.',
        'description.max' => 'Deskripsi maksimal 255 karakter.',
    ];

    public function resetForm()
    {
        $this->reset(['category_id', 'name', 'description']);
        $this->modalTitle = 'Tambah Kategori Baru';
        $this->resetValidation();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->category_id) {
            if (!auth()->user()->can('edit categories')) {
                $this->dispatch('notify', message: 'Anda tidak memiliki izin!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create categories')) {
                $this->dispatch('notify', message: 'Anda tidak memiliki izin!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        if ($this->category_id) {
            $category = CategoryTicket::find($this->category_id);
            if (!$category) {
                $this->dispatch('notify', message: 'Kategori tidak ditemukan!', type: 'error');
                return;
            }

            $category->update($data);
            $message = 'Kategori berhasil diperbarui!';
        } else {
            CategoryTicket::create($data);
            $message = 'Kategori berhasil ditambahkan!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'category-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit categories')) {
            $this->dispatch('notify', message: 'Anda tidak memiliki izin!', type: 'error');
            return;
        }

        $category = CategoryTicket::find($id);

        if (!$category) {
            $this->dispatch('notify', message: 'Kategori tidak ditemukan!', type: 'error');
            return;
        }

        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->modalTitle = 'Edit Kategori';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete categories')) {
            $this->dispatch('notify', message: 'Anda tidak memiliki izin!', type: 'error');
            return;
        }

        $category = CategoryTicket::find($id);

        if (!$category) {
            $this->dispatch('notify', message: 'Kategori tidak ditemukan!', type: 'error');
            return;
        }

        if ($category->tickets()->count() > 0) {
            $this->dispatch('notify', message: 'Tidak dapat menghapus kategori yang masih memiliki tiket!', type: 'error');
            return;
        }

        $this->categoryToDelete = $category;
        $this->dispatch('open-modal', 'delete-category-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete categories')) {
            $this->dispatch('notify', message: 'Anda tidak memiliki izin!', type: 'error');
            return;
        }

        $category = CategoryTicket::find($this->categoryToDelete->id);

        if (!$category) {
            $this->dispatch('notify', message: 'Kategori tidak ditemukan!', type: 'error');
            $this->categoryToDelete = null;
            return;
        }

        $categoryName = $category->name;
        $category->delete();

        $this->categoryToDelete = null;
        $this->dispatch('notify', message: "Kategori '{$categoryName}' berhasil dihapus!");
        $this->dispatch('close-modal', 'delete-category-modal');
    }

    public function cancelDelete()
    {
        $this->categoryToDelete = null;
        $this->dispatch('close-modal', 'delete-category-modal');
    }

    public function render()
    {
        if (!auth()->user()->can('view categories')) {
            abort(403, 'Unauthorized access.');
        }

        $categories = CategoryTicket::withCount('tickets')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('livewire.ticket.category-ticket-manager', [
            'categories' => $categories,
        ]);
    }
}