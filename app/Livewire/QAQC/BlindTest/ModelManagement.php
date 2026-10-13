<?php

namespace App\Livewire\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\Customer;
use App\Models\QAQC\BlindTest\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ModelManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $model_id;
    public $customer_id = '';
    public $model_name = '';
    public $pcb_type = []; // array: SINGLE, LH, RH
    public $search = '';
    public $modalTitle = 'Add New Model';
    public $modelToDelete = null;

    // View
    public $viewData = null;

    // Tab
    public $activeTab = 'all';

    // ===== IMPORT =====
    public $importFile = null;
    public $importPreview = []; // hasil parsing + validasi
    public $importSummary = [
        'total'    => 0,
        'valid'    => 0,
        'invalid'  => 0,
        'duplicate' => 0,
    ];
    public $importStep = 'upload'; // upload | preview | done

    // ==================== RULES ====================

    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:tb_qaqc_customer,id',
            'model_name'  => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('tb_qaqc_model', 'model_name')
                    ->where(fn ($q) => $q->where('customer_id', $this->customer_id))
                    ->ignore($this->model_id),
            ],
            'pcb_type'   => [
                'required',
                'array',
                'min:1',
                function ($attribute, $value, $fail) {
                    $value = array_unique($value ?? []);
                    $hasSingle = in_array('SINGLE', $value, true);
                    $hasLhRh   = count(array_intersect(['LH', 'RH'], $value)) > 0;

                    if ($hasSingle && $hasLhRh) {
                        $fail('PCB Type SINGLE tidak bisa digabung dengan LH / RH.');
                    }
                },
            ],
            'pcb_type.*' => 'in:SINGLE,LH,RH',
        ];
    }

    protected $messages = [
        'customer_id.required' => 'Customer is required.',
        'customer_id.exists'   => 'Selected customer is invalid.',
        'model_name.required'  => 'Model name is required.',
        'model_name.unique'    => 'Model name sudah dipakai untuk customer ini.',
        'pcb_type.required'    => 'PCB Type wajib dipilih minimal 1.',
        'pcb_type.min'         => 'PCB Type wajib dipilih minimal 1.',
        'pcb_type.*.in'        => 'PCB Type tidak valid.',
    ];

    // ==================== BASIC ====================

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function resetForm()
    {
        $this->reset(['model_id', 'customer_id', 'model_name', 'pcb_type']);
        $this->pcb_type = [];
        $this->modalTitle = 'Add New Model';
        $this->resetValidation();
    }

    /**
     * Logika saling-kunci antar pilihan PCB Type.
     */
    public function updatedPcbType($value, $key)
    {
        $selected = array_values(array_unique($this->pcb_type ?? []));

        if (in_array('SINGLE', $selected, true)) {
            $this->pcb_type = ['SINGLE'];
        } else {
            $this->pcb_type = array_values(array_intersect(['LH', 'RH'], $selected));
        }
    }

    // ==================== HELPER: CEK MODEL DIPAKAI ====================

    protected function getUsedModelIds(): array
    {
        $used = [];

        $rows = DB::table('tb_qaqc_blind_test')
            ->select('question_snapshot', 'model_id')
            ->get();

        foreach ($rows as $row) {
            if ($row->question_snapshot) {
                $snapshots = json_decode($row->question_snapshot, true) ?? [];
                foreach ($snapshots as $snap) {
                    if (!empty($snap['model_id'])) {
                        $used[] = (int) $snap['model_id'];
                    }
                }
            }

            if (!empty($row->model_id)) {
                $used[] = (int) $row->model_id;
            }
        }

        $questionUsed = DB::table('tb_qaqc_question')
            ->whereNotNull('model_id')
            ->pluck('model_id')
            ->map(fn ($id) => (int) $id)
            ->toArray();

        $used = array_merge($used, $questionUsed);

        return array_values(array_unique($used));
    }

    public function isUsedInBlindTest(int $modelId): bool
    {
        return in_array($modelId, $this->getUsedModelIds(), true);
    }

    // ==================== SAVE (CREATE / UPDATE) ====================

    public function save()
    {
        if ($this->model_id) {
            if (!auth()->user()->can('edit model')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }

            if ($this->isUsedInBlindTest((int) $this->model_id)) {
                $this->dispatch('notify', message: 'Model sudah dipakai di Blind Test / Master Question, tidak bisa diedit!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create model')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $order    = array_keys(Model::PCB_TYPES);
        $pcbTypes = array_values(array_intersect($order, array_unique($this->pcb_type)));

        if ($this->model_id) {
            $model = Model::find($this->model_id);
            if (!$model) {
                $this->dispatch('notify', message: 'Model not found!', type: 'error');
                return;
            }

            $model->update([
                'customer_id' => $this->customer_id,
                'model_name'  => strtoupper($this->model_name),
                'pcb_type'    => $pcbTypes,
                'updated_by'  => auth()->id(),
            ]);

            $message = 'Model updated successfully!';
        } else {
            Model::create([
                'customer_id' => $this->customer_id,
                'model_name'  => strtoupper($this->model_name),
                'pcb_type'    => $pcbTypes,
                'created_by'  => auth()->id(),
                'updated_by'  => auth()->id(),
            ]);

            $message = 'Model created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal-model');
    }

    // ==================== EDIT ====================

    public function edit($id)
    {
        if (!auth()->user()->can('edit model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        if ($this->isUsedInBlindTest((int) $model->id)) {
            $this->dispatch(
                'notify',
                message: "Model '{$model->model_name}' sudah dipakai di Blind Test / Master Question, tidak bisa diedit!",
                type: 'error'
            );
            return;
        }

        $this->model_id    = $model->id;
        $this->customer_id = $model->customer_id;
        $this->model_name  = $model->model_name;
        $this->pcb_type    = $model->pcb_type ?? [];
        $this->modalTitle  = 'Edit Model';
        $this->dispatch('open-modal-model');
    }

    // ==================== VIEW ====================

    public function view($id)
    {
        $model = Model::with(['customer', 'creator', 'updater'])->find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        $this->viewData = $model;
        $this->dispatch('open-modal-view');
    }

    // ==================== DELETE ====================

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $model = Model::find($id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            return;
        }

        if ($this->isUsedInBlindTest((int) $model->id)) {
            $this->dispatch(
                'notify',
                message: "Model '{$model->model_name}' sudah dipakai di Blind Test / Master Question, tidak bisa dihapus!",
                type: 'error'
            );
            return;
        }

        $this->modelToDelete = $model;
        $this->dispatch('open-modal-delete');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (!$this->modelToDelete) {
            $this->dispatch('close-modal-delete');
            return;
        }

        $model = Model::find($this->modelToDelete->id);
        if (!$model) {
            $this->dispatch('notify', message: 'Model not found!', type: 'error');
            $this->modelToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

        if ($this->isUsedInBlindTest((int) $model->id)) {
            $this->dispatch(
                'notify',
                message: "Model '{$model->model_name}' sudah dipakai di Blind Test / Master Question, tidak bisa dihapus!",
                type: 'error'
            );
            $this->modelToDelete = null;
            $this->dispatch('close-modal-delete');
            return;
        }

        $name = $model->model_name;
        $model->delete();

        $this->modelToDelete = null;
        $this->dispatch('notify', message: "Model '{$name}' has been deleted successfully!");
        $this->dispatch('close-modal-delete');
    }

    public function cancelDelete()
    {
        $this->modelToDelete = null;
        $this->dispatch('close-modal-delete');
    }

    // ==================== IMPORT: RESET ====================

    public function resetImport()
    {
        $this->reset(['importFile', 'importPreview']);
        $this->importSummary = [
            'total'     => 0,
            'valid'     => 0,
            'invalid'   => 0,
            'duplicate' => 0,
        ];
        $this->importStep = 'upload';
        $this->resetValidation();
    }

    // ==================== IMPORT: DOWNLOAD TEMPLATE ====================

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="template_import_model.csv"',
        ];

        $callback = function () {
            $out = fopen('php://output', 'w');

            // BOM biar Excel baca UTF-8 dengan benar
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['customer_name', 'model_name', 'pcb_type']);
            fputcsv($out, ['CUSTOMER A', 'MODEL-X100', 'SINGLE']);
            fputcsv($out, ['CUSTOMER A', 'MODEL-X200', 'LH']);
            fputcsv($out, ['CUSTOMER B', 'MODEL-Y300', 'RH']);
            fputcsv($out, ['CUSTOMER B', 'MODEL-Y400', 'LH;RH']);

            fclose($out);
        };

        return Response::streamDownload($callback, 'template_import_model.csv', $headers);
    }

    // ==================== IMPORT: PARSE & PREVIEW ====================

    /**
     * Dipanggil otomatis saat user selesai upload file.
     * Membaca CSV, validasi, deteksi duplikat (dalam file & database),
     * lalu simpan hasilnya ke $importPreview untuk ditampilkan.
     */
    public function updatedImportFile()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'importFile.required' => 'File CSV wajib dipilih.',
            'importFile.mimes'    => 'File harus berformat CSV.',
            'importFile.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        $this->parsePreview();
    }

    protected function parsePreview()
    {
        $path = $this->importFile->getRealPath();
        $handle = fopen($path, 'r');

        if (!$handle) {
            $this->dispatch('notify', message: 'Gagal membuka file.', type: 'error');
            return;
        }

        // Deteksi delimiter
        $firstLine = fgets($handle);
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
        rewind($handle);

        $header = fgetcsv($handle, 0, $delimiter);
        if (!$header) {
            fclose($handle);
            $this->dispatch('notify', message: 'File CSV kosong / tidak valid.', type: 'error');
            return;
        }

        // Normalisasi header
        $header = array_map(function ($h) {
            $h = preg_replace('/^\xEF\xBB\xBF/', '', $h);
            return strtolower(trim($h));
        }, $header);

        $required = ['customer_name', 'model_name', 'pcb_type'];
        $missing  = array_diff($required, $header);
        if (!empty($missing)) {
            fclose($handle);
            $this->dispatch('notify', message: 'Kolom wajib tidak ditemukan: ' . implode(', ', $missing), type: 'error');
            return;
        }

        $idx = array_flip($header);

        // Cache customer (case-insensitive)
        $customers = Customer::all()->keyBy(fn ($c) => strtoupper(trim($c->customer_name)));

        // Set model yang sudah ada di database: key "CUSTOMER_ID|MODEL_NAME"
        $existingModels = Model::select('customer_id', 'model_name')
            ->get()
            ->map(fn ($m) => $m->customer_id . '|' . strtoupper($m->model_name))
            ->flip()
            ->toArray();

        $preview = [];
        $summary = ['total' => 0, 'valid' => 0, 'invalid' => 0, 'duplicate' => 0];
        $rowNum  = 1;

        // Untuk deteksi duplikat di dalam file CSV
        $seenInFile = [];

        while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rowNum++;

            // Skip baris kosong
            if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }

            $summary['total']++;

            $customerName = strtoupper(trim((string) ($row[$idx['customer_name']] ?? '')));
            $modelName    = strtoupper(trim((string) ($row[$idx['model_name']] ?? '')));
            $pcbRaw       = strtoupper(trim((string) ($row[$idx['pcb_type']] ?? '')));

            $pcbTypes = preg_split('/[;,]/', $pcbRaw);
            $pcbTypes = array_values(array_unique(array_filter(array_map('trim', $pcbTypes))));

            $errors    = [];
            $isDup     = false;

            // ===== Validasi customer =====
            $customer = null;
            if ($customerName === '') {
                $errors[] = 'Customer name kosong.';
            } elseif (!$customers->has($customerName)) {
                $errors[] = "Customer '{$customerName}' tidak ditemukan.";
            } else {
                $customer = $customers->get($customerName);
            }

            // ===== Validasi model name =====
            if ($modelName === '') {
                $errors[] = 'Model name kosong.';
            }

            // ===== Validasi PCB =====
            if (empty($pcbTypes)) {
                $errors[] = 'PCB Type kosong.';
            } else {
                $invalid = array_diff($pcbTypes, ['SINGLE', 'LH', 'RH']);
                if (!empty($invalid)) {
                    $errors[] = 'PCB Type tidak valid: ' . implode(', ', $invalid);
                }
                $hasSingle = in_array('SINGLE', $pcbTypes, true);
                $hasLhRh   = count(array_intersect(['LH', 'RH'], $pcbTypes)) > 0;
                if ($hasSingle && $hasLhRh) {
                    $errors[] = 'SINGLE tidak boleh digabung dengan LH/RH.';
                }
            }

            // ===== Deteksi duplikat =====
            if ($customer && $modelName !== '' && empty($errors)) {
                $key = $customer->id . '|' . $modelName;

                // 1) Duplikat di database
                if (isset($existingModels[$key])) {
                    $errors[] = 'Model sudah ada di database untuk customer ini.';
                    $isDup = true;
                }

                // 2) Duplikat di dalam file CSV
                if (isset($seenInFile[$key])) {
                    $errors[] = 'Duplikat di file CSV (baris ' . $seenInFile[$key] . ').';
                    $isDup = true;
                } else {
                    $seenInFile[$key] = $rowNum;
                }
            }

            $status = empty($errors) ? 'valid' : ($isDup ? 'duplicate' : 'invalid');

            if ($status === 'valid') {
                $summary['valid']++;
            } elseif ($status === 'duplicate') {
                $summary['duplicate']++;
                $summary['invalid']++;
            } else {
                $summary['invalid']++;
            }

            $order    = array_keys(Model::PCB_TYPES);
            $pcbFinal = array_values(array_intersect($order, $pcbTypes));

            $preview[] = [
                'row'         => $rowNum,
                'customer'    => $customerName,
                'model'       => $modelName,
                'pcb'         => implode('; ', $pcbFinal),
                'pcb_array'   => $pcbFinal,
                'customer_id' => $customer?->id,
                'status'      => $status,
                'errors'      => $errors,
            ];
        }

        fclose($handle);

        $this->importPreview = $preview;
        $this->importSummary = $summary;
        $this->importStep    = 'preview';
    }

    // ==================== IMPORT: CONFIRM (SIMpan) ====================

    public function confirmImport()
    {
        if (!auth()->user()->can('create model')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (empty($this->importPreview)) {
            $this->dispatch('notify', message: 'Tidak ada data untuk di-import.', type: 'error');
            return;
        }

        $validRows = array_filter($this->importPreview, fn ($r) => $r['status'] === 'valid');

        if (empty($validRows)) {
            $this->dispatch('notify', message: 'Tidak ada baris valid untuk di-import.', type: 'error');
            return;
        }

        $success = 0;
        $failed  = 0;

        DB::beginTransaction();
        try {
            // Re-check duplikat tepat sebelum insert (race condition)
            $existingModels = Model::select('customer_id', 'model_name')
                ->get()
                ->map(fn ($m) => $m->customer_id . '|' . strtoupper($m->model_name))
                ->flip()
                ->toArray();

            foreach ($this->importPreview as $i => $row) {
                if ($row['status'] !== 'valid') {
                    continue;
                }

                $key = $row['customer_id'] . '|' . $row['model'];

                if (isset($existingModels[$key])) {
                    // Skip — sudah diinsert baris sebelumnya di batch ini
                    $this->importPreview[$i]['status']   = 'duplicate';
                    $this->importPreview[$i]['errors'][] = 'Duplikat terdeteksi saat import.';
                    $failed++;
                    continue;
                }

                Model::create([
                    'customer_id' => $row['customer_id'],
                    'model_name'  => $row['model'],
                    'pcb_type'    => $row['pcb_array'],
                    'created_by'  => auth()->id(),
                    'updated_by'  => auth()->id(),
                ]);

                $existingModels[$key] = true;
                $this->importPreview[$i]['status']   = 'imported';
                $success++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->dispatch('notify', message: 'Import gagal: ' . $e->getMessage(), type: 'error');
            return;
        }

        $this->importSummary['success'] = $success;
        $this->importSummary['failed']  = $failed;
        $this->importStep = 'done';

        $this->dispatch('notify', message: "Import selesai: {$success} berhasil, {$failed} gagal.");
        $this->resetPage();
    }

    // ==================== RENDER ====================

    public function render()
    {
        if (!auth()->user()->can('view model')) {
            abort(403, 'Unauthorized access.');
        }

        $query = Model::with(['customer', 'creator', 'updater']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('model_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('customer', function ($cq) {
                        $cq->where('customer_name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        $models = $query->orderByDesc('id')->paginate(10);

        $usedIds = $this->getUsedModelIds();

        return view('livewire.qaqc.blind-test.model-management', [
            'models'      => $models,
            'customers'   => Customer::orderBy('customer_name')->get(),
            'usedIds'     => $usedIds,
            'pcbTypeOpts' => Model::PCB_TYPES,
        ]);
    }
}