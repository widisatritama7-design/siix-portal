<?php

namespace App\Livewire\PROD\Patrol;

use App\Models\PROD\Patrol\CategoryPatrol;
use Ijpatricio\Mingle\Concerns\InteractsWithMingles;
use Ijpatricio\Mingle\Contracts\HasMingles;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Category Patrol')]
class CategoryPatrolManagement extends Component implements HasMingles
{
    use InteractsWithMingles;

    public int $perPage = 10;
    public int $page = 1;

    // Mount untuk cek akses awal
    public function mount()
    {
        if (!auth()->user()->can('view category patrol')) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function component(): string
    {
        return 'resources/js/mingle/Prod/Patrol/CategoryPatrol/index.js';
    }

    public function mingleData(): array
    {
        // Cek apakah user punya akses edit/delete/create untuk dikirim ke React
        $permissions = [
            'canCreate' => auth()->user()->can('create category patrol'),
            'canEdit'   => auth()->user()->can('edit category patrol'),
            'canDelete' => auth()->user()->can('delete category patrol'),
        ];

        $paginator = CategoryPatrol::query()
            ->select('id', 'category_name', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->page);

        return [
            'rows' => collect($paginator->items())
                ->map(fn ($r) => [
                    'id'            => $r->id,
                    'category_name' => $r->category_name,
                    'created_at'    => optional($r->created_at)->format('d/m/Y H:i'),
                    'updated_at'    => optional($r->updated_at)->format('d/m/Y H:i'),
                ])
                ->toArray(),

            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'per_page'     => $paginator->perPage(),
                'total'        => $paginator->total(),
                'from'         => $paginator->firstItem(),
                'to'           => $paginator->lastItem(),
            ],

            // Kirim status permission ke React
            'permissions' => $permissions,
        ];
    }

    public function gotoPage(int $page): array
    {
        $this->page = max(1, $page);
        return $this->mingleData();
    }

    public function save(array $payload): array
    {
        // Cek Permission: Create atau Edit
        if (empty($payload['id']) && !auth()->user()->can('create category patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to create!'];
        }
        if (!empty($payload['id']) && !auth()->user()->can('edit category patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to edit!'];
        }

        $categoryName = trim($payload['category_name'] ?? '');

        if ($categoryName === '') {
            return ['success' => false, 'message' => 'Nama kategori wajib diisi'];
        }

        // Validasi unik
        $exists = CategoryPatrol::where('category_name', $categoryName)
            ->when(!empty($payload['id']), fn($q) => $q->where('id', '!=', $payload['id']))
            ->exists();

        if ($exists) {
            return ['success' => false, 'message' => 'Nama kategori sudah ada'];
        }

        $data = [
            'category_name' => $categoryName,
            'updated_by'    => auth()->id(),
        ];

        if (!empty($payload['id'])) {
            $row = CategoryPatrol::find($payload['id']);
            if (!$row) {
                return ['success' => false, 'message' => 'Data tidak ditemukan'];
            }
            $row->update($data);
            $message = 'Kategori berhasil diperbarui';
        } else {
            $data['created_by'] = auth()->id();
            CategoryPatrol::create($data);
            $message = 'Kategori berhasil ditambahkan';
        }

        return [
            'success' => true,
            'message' => $message,
            'data'    => $this->mingleData(),
        ];
    }

    public function deleteRow(int $id): array
    {
        // Cek Permission: Delete
        if (!auth()->user()->can('delete category patrol')) {
            return ['success' => false, 'message' => 'You do not have permission to delete!'];
        }

        $row = CategoryPatrol::find($id);
        if (!$row) {
            return ['success' => false, 'message' => 'Data tidak ditemukan'];
        }

        $name = $row->category_name;
        $row->delete();

        return [
            'success' => true,
            'message' => "Kategori '{$name}' berhasil dihapus",
            'data'    => $this->mingleData(),
        ];
    }
}