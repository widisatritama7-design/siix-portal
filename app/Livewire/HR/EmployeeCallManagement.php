<?php

namespace App\Livewire\HR;

use App\Models\HR\EmployeeCall;
use App\Models\HR\Employee;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class EmployeeCallManagement extends Component
{
    use WithPagination, WithFileUploads;
    
    // Properties untuk filter dan search
    public $search = '';
    public $categoryFilter = '';
    public $dateFrom = '';
    public $dateUntil = '';
    public $perPage = 10;
    
    // Properties untuk modals
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showImportModal = false;
    
    // Properties untuk form
    public $editId = null;
    public $nik = '';
    public $category = '';
    public $date_call = '';
    public $employeeName = '';
    public $employeeNik = '';
    public $employeeDept = '';
    public $employeeStatus = '';
    public $infoMessage = '';
    
    // Properties untuk delete
    public $deleteId = null;
    public $deleteName = '';
    
    // Properties untuk import
    public $importFile = null;
    public $importPreview = [];
    public $importErrors = [];
    public $importValidData = [];
    public $importFileName = '';
    public $importStep = 'upload'; // upload, preview, confirm
    public $importing = false;
    
    // Employees for dropdown
    public $employees = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateUntil' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];
    
    protected $rules = [
        'nik' => 'required',
        'category' => 'required',
        'date_call' => 'required|date',
    ];
    
    protected $messages = [
        'nik.required' => 'Please select an employee',
        'category.required' => 'Category is required',
        'date_call.required' => 'Date is required',
    ];
    
    public function getCategoryOptionsProperty()
    {
        return [
            'Violation' => 'Violation',
            'Comelate' => 'Comelate',
        ];
    }
    
    public function loadEmployees()
    {
        $this->employees = Employee::query()
            ->whereIn('status', [1, 2, 3])
            ->orderBy('nik')
            ->get()
            ->mapWithKeys(fn ($employee) => [
                $employee->id => $employee->nik . ' - ' . $employee->name,
            ])
            ->toArray();
    }
    
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    
    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    
    public function updatingDateUntil()
    {
        $this->resetPage();
    }
    
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    
    public function updatedDateCall()
    {
        $this->updateInfoMessage();
        $this->loadEmployees();
    }
    
    public function updatedNik()
    {
        $this->updateInfoMessage();
    }
    
    public function updatedCategory()
    {
        $this->updateInfoMessage();
    }
    
    public function updateInfoMessage()
    {
        $status = [];
        
        if ($this->date_call) {
            $dateFormatted = Carbon::parse($this->date_call)->format('d M Y');
            $status[] = "✓ Tanggal: " . $dateFormatted;
        }
        
        if ($this->nik) {
            $employee = Employee::find($this->nik);
            if ($employee) {
                $this->employeeName = $employee->name;
                $this->employeeNik = $employee->nik;
                $this->employeeDept = $employee->department;
                $this->employeeStatus = match($employee->status) {
                    1 => 'Permanent',
                    2 => 'Contract',
                    3 => 'Magang',
                    default => 'Unknown',
                };
                $status[] = "✓ Karyawan: " . $employee->nik . ' - ' . $employee->name;
            }
        }
        
        if ($this->category) {
            $status[] = "✓ Kategori: " . $this->category;
        }
        
        if (count($status) === 3) {
            $this->infoMessage = "✅ " . implode(' | ', $status) . " - Siap disimpan";
        } elseif (count($status) > 0) {
            $this->infoMessage = "⏳ " . implode(' | ', $status) . " - Lengkapi data";
        } else {
            $this->infoMessage = "📅 Silahkan pilih tanggal terlebih dahulu";
        }
    }
    
    public function openCreateModal()
    {
        if (!auth()->user()->can('create employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to create employee call!', type: 'error');
            return;
        }
        
        $this->resetForm();
        $this->date_call = Carbon::now()->format('Y-m-d');
        $this->loadEmployees();
        $this->updateInfoMessage();
        $this->showCreateModal = true;
    }
    
    public function openEditModal($id)
    {
        if (!auth()->user()->can('edit employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to edit employee call!', type: 'error');
            return;
        }
        
        $call = EmployeeCall::findOrFail($id);
        $this->editId = $call->id;
        $this->nik = $call->nik;
        $this->category = $call->category;
        $this->date_call = $call->date_call;
        
        $employee = Employee::find($call->nik);
        if ($employee) {
            $this->employeeName = $employee->name;
            $this->employeeNik = $employee->nik;
            $this->employeeDept = $employee->department;
            $this->employeeStatus = match($employee->status) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
        }
        
        $this->loadEmployees();
        $this->updateInfoMessage();
        $this->showEditModal = true;
    }
    
    public function openDeleteModal($id)
    {
        if (!auth()->user()->can('delete employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to delete employee call!', type: 'error');
            return;
        }
        
        $call = EmployeeCall::findOrFail($id);
        $this->deleteId = $call->id;
        $this->deleteName = $call->employee->name ?? '-';
        $this->showDeleteModal = true;
    }
    
    public function save()
    {
        if (!auth()->user()->can('create employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to create employee call!', type: 'error');
            return;
        }
        
        $this->validate();
        
        $existsToday = EmployeeCall::where('nik', $this->nik)
            ->whereDate('date_call', $this->date_call)
            ->exists();
        
        if ($existsToday) {
            $this->addError('nik', 'Employee ini sudah dipanggil hari ini!');
            return;
        }
        
        EmployeeCall::create([
            'nik' => $this->nik,
            'category' => $this->category,
            'date_call' => $this->date_call,
            'time_call' => now()->format('H:i:s'),
        ]);
        
        session()->flash('message', 'Employee call record created successfully.');
        $this->resetForm();
        $this->showCreateModal = false;
        $this->dispatch('notify', message: 'Record created successfully', type: 'success');
    }
    
    public function update()
    {
        if (!auth()->user()->can('edit employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to edit employee call!', type: 'error');
            return;
        }
        
        $this->validate();
        
        $call = EmployeeCall::findOrFail($this->editId);
        $call->update([
            'nik' => $this->nik,
            'category' => $this->category,
            'date_call' => $this->date_call,
        ]);
        
        session()->flash('message', 'Employee call record updated successfully.');
        $this->resetForm();
        $this->showEditModal = false;
        $this->dispatch('notify', message: 'Record updated successfully', type: 'success');
    }
    
    public function delete()
    {
        if (!auth()->user()->can('delete employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to delete employee call!', type: 'error');
            return;
        }
        
        $call = EmployeeCall::findOrFail($this->deleteId);
        $call->delete();
        
        session()->flash('message', 'Employee call record deleted successfully.');
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->deleteName = '';
        $this->dispatch('notify', message: 'Record deleted successfully', type: 'success');
    }
    
    public function resetForm()
    {
        $this->reset(['editId', 'nik', 'category', 'date_call', 'employeeName', 'employeeNik', 'employeeDept', 'employeeStatus', 'infoMessage']);
        $this->resetValidation();
    }
    
    public function clearFilters()
    {
        $this->reset(['search', 'categoryFilter', 'dateFrom', 'dateUntil']);
        $this->resetPage();
    }
    
    // ============ IMPORT METHODS ============

    public function openImportModal()
    {
        if (!auth()->user()->can('create employee call')) {
            $this->dispatch('notify', message: 'You do not have permission to import data!', type: 'error');
            return;
        }
        
        $this->resetImport();
        $this->showImportModal = true;
        $this->importStep = 'upload';
    }

    public function resetImport()
    {
        $this->importFile = null;
        $this->importPreview = [];
        $this->importErrors = [];
        $this->importValidData = [];
        $this->importFileName = '';
        $this->importStep = 'upload';
        $this->importing = false;
    }

    public function updatedImportFile()
    {
        $this->validate([
            'importFile' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);
        
        $this->importFileName = $this->importFile->getClientOriginalName();
        $this->processExcelFile();
    }

    public function processExcelFile()
    {
        $this->importing = true;
        $this->importErrors = [];
        $this->importValidData = [];
        $this->importPreview = [];
        
        try {
            $file = $this->importFile->getRealPath();
            
            // Parse Excel file
            $data = $this->parseExcelFile($file);
            
            if (empty($data)) {
                $this->importErrors[] = ['row' => 0, 'nik' => '-', 'errors' => ['File is empty or invalid format']];
                $this->importing = false;
                return;
            }
            
            // Validate and process each row
            $rowNumber = 1;
            foreach ($data as $row) {
                $rowNumber++;
                $this->validateImportRow($row, $rowNumber);
            }
            
            $this->importStep = 'preview';
            
        } catch (\Exception $e) {
            $this->importErrors[] = ['row' => 0, 'nik' => '-', 'errors' => ['Error processing file: ' . $e->getMessage()]];
        }
        
        $this->importing = false;
    }

    private function parseExcelFile($filePath)
    {
        $data = [];
        $extension = $this->importFile->getClientOriginalExtension();
        
        if ($extension == 'csv') {
            return $this->parseCSV($filePath);
        }
        
        // For XLSX/XLS files
        if (in_array($extension, ['xlsx', 'xls'])) {
            return $this->parseExcelWithSimpleXML($filePath);
        }
        
        return $data;
    }

    private function parseCSV($filePath)
    {
        $data = [];
        
        if (($handle = fopen($filePath, 'r')) !== false) {
            // Get headers
            $headers = fgetcsv($handle);
            if ($headers) {
                $headers = array_map('strtolower', array_map('trim', $headers));
                
                while (($row = fgetcsv($handle)) !== false) {
                    $rowData = [];
                    foreach ($headers as $index => $header) {
                        $rowData[$header] = $row[$index] ?? '';
                    }
                    $data[] = $rowData;
                }
            }
            fclose($handle);
        }
        
        return $data;
    }

    private function parseExcelWithSimpleXML($filePath)
    {
        $data = [];
        
        try {
            // Create temp copy
            $tempFile = tempnam(sys_get_temp_dir(), 'excel');
            copy($filePath, $tempFile);
            
            // Use ZipArchive to read xlsx
            $zip = new \ZipArchive();
            if ($zip->open($tempFile) === true) {
                // Read shared strings
                $sharedStrings = [];
                $xml = $zip->getFromName('xl/sharedStrings.xml');
                if ($xml) {
                    $stringsXml = simplexml_load_string($xml);
                    if ($stringsXml) {
                        foreach ($stringsXml->si as $si) {
                            $sharedStrings[] = (string)$si->t;
                        }
                    }
                }
                
                // Read worksheet
                $xml = $zip->getFromName('xl/worksheets/sheet1.xml');
                $zip->close();
                
                if ($xml) {
                    $sheetXml = simplexml_load_string($xml);
                    if ($sheetXml) {
                        $headers = [];
                        $firstRow = true;
                        
                        foreach ($sheetXml->sheetData->row as $row) {
                            $rowData = [];
                            $colIndex = 0;
                            
                            foreach ($row->c as $cell) {
                                $value = (string)$cell->v;
                                // Check if it's a shared string
                                if ($cell['t'] == 's' && isset($sharedStrings[(int)$value])) {
                                    $value = $sharedStrings[(int)$value];
                                }
                                $rowData[$colIndex] = $value;
                                $colIndex++;
                            }
                            
                            if ($firstRow) {
                                // Headers
                                foreach ($rowData as $index => $header) {
                                    $headers[$index] = strtolower(trim($header));
                                }
                                $firstRow = false;
                            } else {
                                // Data row
                                $mappedRow = [];
                                foreach ($rowData as $index => $value) {
                                    if (isset($headers[$index])) {
                                        $mappedRow[$headers[$index]] = trim($value);
                                    }
                                }
                                if (!empty(array_filter($mappedRow))) {
                                    $data[] = $mappedRow;
                                }
                            }
                        }
                    }
                }
            }
            unlink($tempFile);
        } catch (\Exception $e) {
            $this->importErrors[] = ['row' => 0, 'nik' => '-', 'errors' => ['Error parsing Excel: ' . $e->getMessage()]];
        }
        
        return $data;
    }

    private function validateImportRow($row, $rowNumber)
    {
        $errors = [];
        
        // Check NIK
        if (empty($row['nik'])) {
            $errors[] = 'NIK is required';
        }
        
        // Check Category
        if (empty($row['category'])) {
            $errors[] = 'Category is required';
        } elseif (!in_array($row['category'], ['Violation', 'Comelate'])) {
            $errors[] = 'Category must be Violation or Comelate';
        }
        
        // Check Date Call
        if (empty($row['date_call'])) {
            $errors[] = 'Date Call is required';
        } else {
            // Validate date format
            $date = strtotime($row['date_call']);
            if (!$date) {
                $errors[] = 'Invalid date format. Use YYYY-MM-DD';
            }
        }
        
        // Validate employee exists by NIK
        $employee = null;
        if (!empty($row['nik'])) {
            $employee = Employee::where('nik', trim($row['nik']))->first();
            if (!$employee) {
                $errors[] = "Employee with NIK '{$row['nik']}' not found";
            }
        }
        
        // Check for duplicate call on same date
        if ($employee && !empty($row['date_call'])) {
            $dateCall = date('Y-m-d', strtotime($row['date_call']));
            $exists = EmployeeCall::where('nik', $employee->id)
                ->whereDate('date_call', $dateCall)
                ->exists();
            
            if ($exists) {
                $errors[] = "Employee already called on {$dateCall}";
            }
        }
        
        // Store result
        if (!empty($errors)) {
            $this->importErrors[] = [
                'row' => $rowNumber,
                'nik' => $row['nik'] ?? '-',
                'errors' => $errors
            ];
        } else {
            // Valid data - prepare for preview
            $validItem = [
                'row' => $rowNumber,
                'nik_employee' => $employee->id,
                'nik' => $row['nik'],
                'name' => $employee->name ?? '-',
                'department' => $employee->department ?? '-',
                'category' => $row['category'],
                'date_call' => date('Y-m-d', strtotime($row['date_call'])),
                'original_data' => $row
            ];
            
            $this->importValidData[] = $validItem;
            $this->importPreview[] = $validItem;
        }
    }

    public function confirmImport()
    {
        if (empty($this->importValidData)) {
            $this->dispatch('notify', message: 'No valid data to import!', type: 'error');
            return;
        }
        
        try {
            \DB::beginTransaction();
            
            $imported = 0;
            foreach ($this->importValidData as $data) {
                EmployeeCall::create([
                    'nik' => $data['nik_employee'],
                    'category' => $data['category'],
                    'date_call' => $data['date_call'],
                    'time_call' => now()->format('H:i:s'),
                ]);
                $imported++;
            }
            
            \DB::commit();
            
            $this->dispatch('notify', 
                message: "Successfully imported {$imported} records!", 
                type: 'success'
            );
            
            $this->showImportModal = false;
            $this->resetImport();
            $this->resetPage(); // Refresh the table
            
        } catch (\Exception $e) {
            \DB::rollBack();
            $this->dispatch('notify', 
                message: 'Import failed: ' . $e->getMessage(), 
                type: 'error'
            );
        }
    }

    public function cancelImport()
    {
        $this->showImportModal = false;
        $this->resetImport();
    }

    private function createSimpleXLSX()
    {
        // Create temporary file
        $tempFile = tmpfile();
        $tempPath = stream_get_meta_data($tempFile)['uri'];
        
        $zip = new \ZipArchive();
        $zip->open($tempPath, \ZipArchive::CREATE);
        
        // [Content_Types].xml
        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0" encoding="UTF-8"?>
    <Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
    <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
    <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
    </Types>');
        
        // _rels/.rels
        $zip->addFromString('_rels/.rels', '<?xml version="1.0" encoding="UTF-8"?>
    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
    </Relationships>');
        
        // xl/_rels/workbook.xml.rels
        $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0" encoding="UTF-8"?>
    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
    </Relationships>');
        
        // xl/workbook.xml
        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0" encoding="UTF-8"?>
    <workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
    <sheets>
        <sheet name="Sheet1" sheetId="1" r:id="rId1" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"/>
    </sheets>
    </workbook>');
        
        // Data template (header + 2 contoh)
        $data = [
            ['nik', 'category', 'date_call'],
            ['EMP001', 'Violation', date('Y-m-d')],
            ['EMP002', 'Comelate', date('Y-m-d')],
        ];
        
        // Collect all strings
        $strings = [];
        foreach ($data as $row) {
            foreach ($row as $cell) {
                if (!in_array($cell, $strings)) {
                    $strings[] = $cell;
                }
            }
        }
        
        // xl/sharedStrings.xml
        $stringsXml = '<?xml version="1.0" encoding="UTF-8"?>
    <sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="' . count($strings) . '" uniqueCount="' . count($strings) . '">';
        foreach ($strings as $string) {
            $stringsXml .= '<si><t>' . htmlspecialchars($string) . '</t></si>';
        }
        $stringsXml .= '</sst>';
        $zip->addFromString('xl/sharedStrings.xml', $stringsXml);
        
        // xl/worksheets/sheet1.xml
        $worksheetXml = '<?xml version="1.0" encoding="UTF-8"?>
    <worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
    <sheetData>';
        
        foreach ($data as $rowIndex => $row) {
            $worksheetXml .= '<row r="' . ($rowIndex + 1) . '">';
            foreach ($row as $colIndex => $cell) {
                $colLetter = chr(65 + $colIndex);
                $stringIndex = array_search($cell, $strings);
                $worksheetXml .= '<c r="' . $colLetter . ($rowIndex + 1) . '" t="s"><v>' . $stringIndex . '</v></c>';
            }
            $worksheetXml .= '</row>';
        }
        
        $worksheetXml .= '</sheetData>
    </worksheet>';
        
        $zip->addFromString('xl/worksheets/sheet1.xml', $worksheetXml);
        $zip->close();
        
        $content = file_get_contents($tempPath);
        fclose($tempFile);
        
        return $content;
    }

    // Method download CSV (lebih simple lagi)
    public function downloadTemplateCSV()
    {
        $fileName = 'employee_call_template.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
        ];
        
        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['nik', 'category', 'date_call']);
            
            // Contoh data
            fputcsv($file, ['EMP001', 'Violation', date('Y-m-d')]);
            fputcsv($file, ['EMP002', 'Comelate', date('Y-m-d')]);
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
    
    public function render()
    {
        if (!auth()->user()->can('view employee call')) {
            abort(403, 'Unauthorized access.');
        }
        
        $calls = EmployeeCall::query()
            ->with(['employee', 'creator', 'updater'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('employee', function ($subQuery) {
                        $subQuery->where('name', 'like', '%' . $this->search . '%')
                                 ->orWhere('nik', 'like', '%' . $this->search . '%');
                    })->orWhere('category', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categoryFilter, function ($query) {
                $query->where('category', $this->categoryFilter);
            })
            ->when($this->dateFrom, function ($query) {
                $query->whereDate('date_call', '>=', $this->dateFrom);
            })
            ->when($this->dateUntil, function ($query) {
                $query->whereDate('date_call', '<=', $this->dateUntil);
            })
            ->orderBy('date_call', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        
        return view('livewire.hr.employee-call-management', [
            'calls' => $calls,
        ]);
    }
}