import React, { useState } from 'react'

export default function ResultPatrol({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? { current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0 })
    const [loadingPage, setLoadingPage] = useState(false)
    const [toast, setToast]             = useState(null)
    const [selectedRow, setSelectedRow] = useState(null)
    const [photoPreview, setPhotoPreview] = useState(null)
    const [showStatusModal, setShowStatusModal] = useState(false)
    const [selectedStatus, setSelectedStatus] = useState('Open')

    // Ambil Permission
    const permissions = mingleData?.permissions ?? {
        canCreate: false,
        canEdit: false,
        canDelete: false
    }

    // Modals
    const [showViewModal, setShowViewModal] = useState(false)
    const [showDeleteModal, setShowDeleteModal] = useState(false)

    // Filter State
    const [filter, setFilter] = useState({
        search: '',
        date_from: '',
        date_until: '',
        shift: '',
        group: '',
        line: '',
        category: '',
        status: ''
    })

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    const applyFilter = async () => {
        setLoadingPage(true)
        try {
            const result = await wire.setFilter(filter)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (e) {
            showToast('Failed to apply filter', 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    const resetFilter = async () => {
        const emptyFilter = {
            search: '',
            date_from: '',
            date_until: '',
            shift: '',
            group: '',
            line: '',
            category: '',
            status: ''
        }
        setFilter(emptyFilter)
        setLoadingPage(true)
        try {
            const result = await wire.setFilter(emptyFilter)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (e) {
            showToast('Failed to reset filter', 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    const gotoPage = async (page) => {
        setLoadingPage(true)
        try {
            const result = await wire.gotoPage(page)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (e) {
            showToast('Failed to change page', 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    const openDeleteConfirm = (row) => {
        if (!permissions.canDelete) return
        setSelectedRow(row)
        setShowDeleteModal(true)
    }

    const confirmDelete = async () => {
        if (!selectedRow) return
        try {
            const result = await wire.deleteRow(selectedRow.id)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                showToast(result.message, 'success')
                setShowDeleteModal(false)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Failed to delete data', 'error')
        }
    }

    const handleStatusChange = async (id, newStatus) => {
        if (!permissions.canEdit) {
            showToast('You do not have permission to change status!', 'error')
            return
        }
        setLoadingPage(true)
        try {
            const result = await wire.updateStatus(id, newStatus)
            if (result.success) {
                setRows(result.data.rows)
                showToast(result.message, 'success')
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Failed to update status', 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    return (
        <div className="p-1 space-y-2">

            {/* ============ BREADCRUMBS ============ */}
            <nav className="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 overflow-x-auto whitespace-nowrap pb-1">
                <button
                    type="button"
                    onClick={() => window.Livewire.navigate('/main-dashboard')}
                    className="inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0"
                >
                    Dashboard
                </button>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">PROD</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Patrol Monitoring</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Result Patrol</span>
            </nav>

            {/* ============ HEADER ============ */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">
                        Result Patrol
                    </h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Patrol inspection history list
                    </p>
                </div>
                <div className="flex items-center gap-2">
                    {/* Tombol Export PDF */}
                    <button 
                        onClick={async () => {
                            setLoadingPage(true)
                            try {
                                await wire.exportPdf()
                            } catch (e) {
                                showToast('Failed to export PDF', 'error')
                            } finally {
                                setLoadingPage(false)
                            }
                        }}
                        disabled={loadingPage}
                        className="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition-all shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                            <path fillRule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clipRule="evenodd" />
                            <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                        </svg>
                        Export PDF
                    </button>

                    {/* Tombol Export Excel */}
                    <button 
                        onClick={async () => {
                            setLoadingPage(true)
                            try {
                                const result = await wire.exportExcel()
                                
                                if (result.success) {
                                    const byteCharacters = atob(result.file);
                                    const byteNumbers = new Array(byteCharacters.length);
                                    for (let i = 0; i < byteCharacters.length; i++) {
                                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                                    }
                                    const byteArray = new Uint8Array(byteNumbers);
                                    const blob = new Blob([byteArray], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
                                    
                                    const url = window.URL.createObjectURL(blob);
                                    const a = document.createElement('a');
                                    a.href = url;
                                    a.download = result.filename;
                                    document.body.appendChild(a);
                                    a.click();
                                    a.remove();
                                    window.URL.revokeObjectURL(url);
                                    
                                    showToast('Excel berhasil diexport!', 'success')
                                } else {
                                    showToast(result.message, 'error')
                                }
                            } catch (e) {
                                console.error(e);
                                showToast('Failed to export Excel', 'error')
                            } finally {
                                setLoadingPage(false)
                            }
                        }}
                        disabled={loadingPage}
                        className="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition-all shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4">
                            <path fillRule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z" clipRule="evenodd" />
                        </svg>
                        Export Excel
                    </button>

                    {/* Tombol Input Result (Hanya jika punya akses create) */}
                    {permissions.canCreate && (
                        <button 
                            onClick={() => window.Livewire.navigate('/prod/patrol/result-patrol/create')}
                            className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold transition-all shadow-sm hover:shadow-md"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4"><path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" /></svg>
                            Input Result
                        </button>
                    )}
                </div>
            </div>

            {/* ============ FILTER CARD ============ */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm mb-3">

                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col xl:flex-row xl:items-center justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 text-white">
                            <path fillRule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Filter</span>
                    </div>

                    <div className="flex flex-wrap items-center gap-2 w-full xl:w-auto">
                        <div className="relative w-full sm:w-64">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input 
                                type="text" 
                                placeholder="Search line / location..." 
                                value={filter.search}
                                onChange={(e) => setFilter({...filter, search: e.target.value})}
                                onKeyDown={(e) => e.key === 'Enter' && applyFilter()}
                                className="w-full pl-9 pr-3 py-1.5 text-sm rounded-md border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm"
                            />
                        </div>

                        {(() => {
                            const isFilterActive = 
                                filter.search !== '' || 
                                filter.shift !== '' || 
                                filter.group !== '' || 
                                filter.category !== '' || 
                                filter.status !== '' ||
                                filter.date_from !== '' || 
                                filter.date_until !== '';

                            if (!isFilterActive) return null;

                            return (
                                <div className="flex gap-1.5 w-full sm:w-auto">
                                    <button 
                                        onClick={applyFilter}
                                        className="flex-1 sm:flex-none px-4 py-1.5 text-sm font-semibold rounded-md bg-emerald-500 hover:bg-emerald-600 text-white transition-colors shadow-sm"
                                    >
                                        Apply
                                    </button>
                                    <button 
                                        onClick={resetFilter}
                                        className="flex-1 sm:flex-none px-4 py-1.5 text-sm font-semibold rounded-md bg-red-500 hover:bg-red-600 text-white transition-colors shadow-sm"
                                    >
                                        Reset
                                    </button>
                                </div>
                            );
                        })()}
                    </div>
                </div>

                <div className="p-4 space-y-3">
                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        {/* Select Shift */}
                        <div className="relative">
                            <select 
                                value={filter.shift} 
                                onChange={(e) => setFilter({...filter, shift: e.target.value})} 
                                className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                            >
                                <option value="">All Shifts</option>
                                <option value="NS">NS</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        {/* Select Group */}
                        <div className="relative">
                            <select 
                                value={filter.group} 
                                onChange={(e) => setFilter({...filter, group: e.target.value})} 
                                className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                            >
                                <option value="">All Groups</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                            <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        {/* Select Category */}
                        <div className="relative">
                            <select 
                                value={filter.category} 
                                onChange={(e) => setFilter({...filter, category: e.target.value})} 
                                className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                            >
                                <option value="">All Categories</option>
                                {mingleData?.categories?.map(cat => (
                                    <option key={cat.id} value={cat.id}>{cat.category_name}</option>
                                ))}
                            </select>
                            <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div className="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Status</label>
                            <div className="relative">
                                <select 
                                    value={filter.status} 
                                    onChange={(e) => setFilter({...filter, status: e.target.value})} 
                                    className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                >
                                    <option value="">All Status</option>
                                    <option value="Open">Open</option>
                                    <option value="On Progress">On Progress</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Closed">Closed</option>
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Date From</label>
                            <input 
                                type="date"
                                value={filter.date_from}
                                onChange={(e) => setFilter({...filter, date_from: e.target.value})}
                                className="w-full px-3 py-2 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>

                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Date Until</label>
                            <input 
                                type="date"
                                value={filter.date_until}
                                onChange={(e) => setFilter({...filter, date_until: e.target.value})}
                                className="w-full px-3 py-2 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                    </div>
                </div>
            </div>

            {/* ============ TABLE CARD ============ */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">

                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex items-center justify-between">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 text-white">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fillRule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white">Result History Table</span>
                    </div>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-sm text-left min-w-[800px] whitespace-nowrap">
                        <thead className="bg-zinc-50 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Shift / Group</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Line</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Category</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Standard</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Finding</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Status</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Created By</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Date</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center w-48">Action</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                            {loadingPage ? (
                                <tr>
                                    <td colSpan={8} className="px-4 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                        <div className="flex flex-col items-center justify-center gap-2">
                                            <svg className="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                            </svg>
                                            Loading data...
                                        </div>
                                    </td>
                                </tr>
                            ) : rows.length === 0 ? (
                            <tr>
                                <td colSpan={9} className="px-4 py-16 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    <div className="flex flex-col items-center justify-center w-full h-full space-y-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" className="w-14 h-14 text-zinc-300 dark:text-zinc-600">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                        </svg>
                                        <p className="font-medium">No result patrol data yet.</p>
                                    </div>
                                </td>
                            </tr>
                            ) : rows.map(r => (
                                <tr key={r.id} className="hover:bg-blue-50/50 dark:hover:bg-blue-950/20 transition-colors">
                                    <td className="px-4 py-3 text-center">
                                        <span className="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold">
                                            {r.shift} / {r.group}
                                        </span>
                                    </td>
                                    <td className="px-4 py-3 text-center">
                                        <div className="flex items-center gap-2">
                                            <span className="font-semibold text-zinc-800 dark:text-zinc-100">{r.master_line?.line_number}</span>
                                            <span className="text-xs text-zinc-500 dark:text-zinc-400">({r.master_line?.location})</span>
                                        </div>
                                    </td>
                                    
                                    <td className="px-4 py-3 text-center">
                                        {r.finding_patrol_items?.length > 0 && r.finding_patrol_items[0].category_id ? (
                                            mingleData?.categories?.find(c => String(c.id) === String(r.finding_patrol_items[0].category_id))?.category_name || '-'
                                        ) : (
                                            <span className="text-zinc-400">-</span>
                                        )}
                                    </td>

                                    <td className="px-4 py-3 text-center">
                                        <span className="text-zinc-700 dark:text-zinc-300 font-medium">{r.standard_patrol_items?.length || 0} items</span>
                                    </td>
                                    <td className="px-4 py-3 text-center">
                                        {r.finding_patrol_items?.length > 0 ? (
                                            <span className="inline-flex items-center gap-1 bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 px-2.5 py-1 rounded-md text-xs font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" /></svg>
                                                {r.finding_patrol_items.length} Findings
                                            </span>
                                        ) : (
                                            <span className="inline-flex items-center gap-1 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 px-2.5 py-1 rounded-md text-xs font-bold">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" /></svg>
                                                Safe
                                            </span>
                                        )}
                                    </td>
                                    
                                    {/* Kolom Status */}
                                    <td className="px-4 py-3 text-center">
                                        {r.status === 'Closed' ? (
                                            <span className="inline-flex items-center gap-1.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 px-3 py-1.5 rounded-md text-xs font-bold border border-emerald-200 dark:border-emerald-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                    <path fillRule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" />
                                                </svg>
                                                Closed
                                            </span>
                                        ) : (
                                            <button 
                                                onClick={() => { 
                                                    if (!permissions.canEdit) return;
                                                    setSelectedRow(r); 
                                                    setSelectedStatus(r.status); 
                                                    setShowStatusModal(true); 
                                                }}
                                                disabled={!permissions.canEdit}
                                                className={`inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-bold border transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed ${
                                                    r.status === 'Open' ? 'bg-blue-100 text-blue-700 border-blue-200 hover:bg-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800 dark:hover:bg-blue-900/60' :
                                                    r.status === 'On Progress' ? 'bg-amber-100 text-amber-700 border-amber-200 hover:bg-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:border-amber-800 dark:hover:bg-amber-900/60' :
                                                    'bg-purple-100 text-purple-700 border-purple-200 hover:bg-purple-200 dark:bg-purple-900/40 dark:text-purple-300 dark:border-purple-800 dark:hover:bg-purple-900/60'
                                                }`}
                                            >
                                                {/* Icon Open (Clock) */}
                                                {r.status === 'Open' && (
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                        <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                                    </svg>
                                                )}

                                                {/* Icon On Progress (Pencil) */}
                                                {r.status === 'On Progress' && (
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                    </svg>
                                                )}

                                                {/* Icon Pending (Pause) */}
                                                {r.status === 'Pending' && (
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                        <path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM9 8.25a.75.75 0 0 0-.75.75v6c0 .414.336.75.75.75h.75a.75.75 0 0 0 .75-.75V9a.75.75 0 0 0-.75-.75H9Zm5.25 0a.75.75 0 0 0-.75.75v6c0 .414.336.75.75.75H15a.75.75 0 0 0 .75-.75V9a.75.75 0 0 0-.75-.75h-.75Z" clipRule="evenodd" />
                                                    </svg>
                                                )}

                                                {r.status}
                                                
                                                {/* Icon Edit (Pencil) di ujung kanan */}
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-3.5 h-3.5 ml-0.5 opacity-70">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>
                                        )}
                                    </td>
                                    
                                    <td className="px-4 py-3 text-xs text-zinc-600 dark:text-zinc-300 font-medium text-center">
                                        {r.created_by || '-'}
                                    </td>
                                    <td className="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap text-center">{r.created_at}</td>
                                    <td className="px-4 py-3">
                                        <div className="flex justify-center gap-1.5">
                                            {/* Tombol View (Selalu Ada) */}
                                            <button 
                                                onClick={() => { setSelectedRow(r); setShowViewModal(true); }} 
                                                className="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors shadow-sm"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" /></svg>
                                                View
                                            </button>

                                            {/* Tombol Edit & Delete (Hanya jika BUKAN Closed DAN punya izin) */}
                                            {r.status !== 'Closed' && (
                                                <>
                                                    {permissions.canEdit && (
                                                        <button 
                                                            onClick={() => window.Livewire.navigate(`/prod/patrol/result-patrol/${r.id}/edit`)} 
                                                            className="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold transition-colors shadow-sm"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                    )}
                                                    {/* Tombol Delete hanya muncul jika status = Open DAN punya izin */}
                                                    {permissions.canDelete && r.status === 'Open' && (
                                                        <button 
                                                            onClick={() => openDeleteConfirm(r)} 
                                                            className="inline-flex items-center gap-1 px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition-colors shadow-sm"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                                <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Z" clipRule="evenodd" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    )}
                                                </>
                                            )}
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {/* PAGINATION */}
                {pagination.last_page > 1 && (
                    <div className="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div className="text-sm text-zinc-500 dark:text-zinc-400 text-center sm:text-left whitespace-nowrap">
                            Showing{' '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.from ?? 0}</strong>
                            {' - '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.to ?? 0}</strong>
                            {' of '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.total}</strong>
                            {' data'}
                        </div>

                        <div className="flex items-center justify-center sm:justify-end gap-1 flex-wrap">
                            <button
                                onClick={() => gotoPage(pagination.current_page - 1)}
                                disabled={pagination.current_page === 1 || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap"
                            >
                                Prev
                            </button>
                            
                            <button className="min-w-[34px] px-2.5 py-1.5 text-sm rounded-lg border bg-blue-600 border-blue-600 text-white font-bold shadow-sm">
                                {pagination.current_page}
                            </button>

                            <button
                                onClick={() => gotoPage(pagination.current_page + 1)}
                                disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                )}
            </div>

            {/* MODAL STATUS */}
            {showStatusModal && selectedRow && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        {/* Header */}
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white">
                                    <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 className="text-base font-bold text-white">Update Status</h3>
                                <p className="text-xs text-blue-100">Ubah status untuk <strong>{selectedRow.master_line?.line_number}</strong></p>
                            </div>
                        </div>
                        
                        {/* Body */}
                        <div className="p-5 space-y-3">
                            {['Open', 'On Progress', 'Pending', 'Closed'].map((status) => (
                                <label 
                                    key={status} 
                                    className={`flex items-center justify-between p-3 border rounded-lg cursor-pointer transition-colors ${
                                        selectedStatus === status 
                                            ? 'bg-blue-50 border-blue-300 dark:bg-blue-900/30 dark:border-blue-600' 
                                            : 'bg-white border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700/50'
                                    }`}
                                >
                                    <div className="flex items-center gap-3">
                                        <input 
                                            type="radio" 
                                            name="status" 
                                            value={status}
                                            checked={selectedStatus === status}
                                            onChange={() => setSelectedStatus(status)}
                                            className="w-4 h-4 text-blue-600 dark:text-blue-500 bg-white dark:bg-zinc-700 border-zinc-300 dark:border-zinc-600 focus:ring-blue-500 cursor-pointer"
                                        />
                                        <span className="font-semibold text-sm text-zinc-800 dark:text-zinc-200">{status}</span>
                                    </div>
                                    
                                    <span className={`w-3 h-3 rounded-full ${
                                        status === 'Open' ? 'bg-blue-500' :
                                        status === 'On Progress' ? 'bg-amber-500' :
                                        status === 'Pending' ? 'bg-purple-500' : 'bg-zinc-500 dark:bg-zinc-400'
                                    }`}></span>
                                </label>
                            ))}
                        </div>

                        {/* Footer */}
                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                            <button 
                                onClick={() => setShowStatusModal(false)} 
                                className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                onClick={async () => {
                                    setShowStatusModal(false);
                                    await handleStatusChange(selectedRow.id, selectedStatus);
                                }} 
                                className="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 dark:hover:bg-blue-500 transition-colors"
                            >
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL VIEW */}
            {showViewModal && selectedRow && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] border border-zinc-200 dark:border-zinc-700">
                        
                        {/* HEADER */}
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center text-white">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100">
                                    <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                    <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" />
                                </svg>
                                <h2 className="font-bold text-lg">Result Detail: {selectedRow.master_line?.line_number}</h2>
                            </div>
                            <button onClick={() => setShowViewModal(false)} className="p-1.5 rounded-lg hover:bg-white/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {/* BODY */}
                        <div className="p-6 overflow-y-auto space-y-6 text-sm">
                            
                            {/* SHIFT & GROUP CARDS */}
                            <div className="grid grid-cols-2 gap-4">
                                <div className="bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 p-3 rounded-xl flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center text-blue-700 dark:text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                                            <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span className="text-xs text-blue-600 dark:text-blue-400 font-semibold uppercase block">Shift</span>
                                        <strong className="text-xl text-blue-900 dark:text-blue-200">{selectedRow.shift}</strong>
                                    </div>
                                </div>
                                <div className="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800 p-3 rounded-xl flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-emerald-200 dark:bg-emerald-800 flex items-center justify-center text-emerald-700 dark:text-emerald-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                                            <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span className="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase block">Group</span>
                                        <strong className="text-xl text-emerald-900 dark:text-emerald-200">{selectedRow.group}</strong>
                                    </div>
                                </div>
                            </div>

                            {/* STANDARD CHECK */}
                            <div>
                                <h3 className="font-bold text-base mb-2 border-b border-zinc-200 dark:border-zinc-700 pb-2 flex items-center gap-2 text-zinc-800 dark:text-zinc-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4">
                                        <path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" />
                                        <path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clipRule="evenodd" />
                                    </svg>
                                    Standard Check
                                </h3>
                                
                                {(!selectedRow.standard_patrol_items || selectedRow.standard_patrol_items.length === 0) ? (
                                    <p className="text-sm text-zinc-500 dark:text-zinc-400 italic">No standard check available.</p>
                                ) : (
                                    (() => {
                                        const groupedItems = selectedRow.standard_patrol_items.reduce((acc, item) => {
                                            const lineName = item.line_name || 'No Line';
                                            if (!acc[lineName]) acc[lineName] = [];
                                            acc[lineName].push(item);
                                            return acc;
                                        }, {});

                                        return Object.entries(groupedItems).map(([lineName, items]) => (
                                            <div key={lineName} className="mb-4 last:mb-0 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden shadow-sm">
                                                <div className="bg-zinc-100 dark:bg-zinc-800 px-4 py-2 border-b border-zinc-200 dark:border-zinc-700">
                                                    <span className="font-bold text-xs text-zinc-700 dark:text-zinc-300 flex items-center gap-2 uppercase tracking-wide">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4">
                                                            <path fillRule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clipRule="evenodd" />
                                                        </svg>
                                                        {lineName}
                                                    </span>
                                                </div>

                                                <table className="w-full text-sm">
                                                    <thead className="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                                                        <tr>
                                                            <th className="p-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-400 w-1/3">Item Check</th>
                                                            <th className="p-2.5 text-center font-semibold text-zinc-600 dark:text-zinc-400 w-24">Result</th>
                                                            <th className="p-2.5 text-left font-semibold text-zinc-600 dark:text-zinc-400">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                        {items.map((it, i) => (
                                                            <tr key={i} className="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                                                                <td className="p-2.5 text-zinc-800 dark:text-zinc-200 font-medium">{it.item_check}</td>
                                                                <td className="p-2.5 text-center">
                                                                    <span className={`inline-block px-2 py-1 rounded text-xs font-bold ${
                                                                        it.result === 'NG' 
                                                                            ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300' 
                                                                            : 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300'
                                                                    }`}>
                                                                        {it.result}
                                                                    </span>
                                                                </td>
                                                                <td className="p-2.5 text-zinc-600 dark:text-zinc-400">{it.remarks || '-'}</td>
                                                            </tr>
                                                        ))}
                                                    </tbody>
                                                </table>
                                            </div>
                                        ));
                                    })()
                                )}
                            </div>

                            {/* FINDING */}
                            <div>
                                <h3 className="font-bold text-base mb-3 border-b border-zinc-200 dark:border-zinc-700 pb-2 flex items-center gap-2 text-zinc-800 dark:text-zinc-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-red-500">
                                        <path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" />
                                    </svg>
                                    Finding
                                </h3>
                                
                                {(!selectedRow.finding_patrol_items || selectedRow.finding_patrol_items.length === 0) ? (
                                    <div className="p-5 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-300 flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-8 h-8 text-emerald-500 dark:text-emerald-400">
                                            <path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" />
                                        </svg>
                                        <span className="font-bold text-sm">No findings (Safe)</span>
                                        <span className="text-xs text-emerald-600 dark:text-emerald-400">All inspection standards are met.</span>
                                    </div>
                                ) : (
                                    <div className="space-y-5">
                                        {selectedRow.finding_patrol_items.map((f, i) => {
                                            return (
                                                <div key={i} className="border border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-900 shadow-sm overflow-hidden">
                                                    <div className="bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 flex items-center gap-3 text-white">
                                                        <span className="bg-white/20 w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">
                                                            {i + 1}
                                                        </span>
                                                        <h4 className="font-bold text-sm">Finding Detail</h4>
                                                    </div>

                                                    <div className="p-4 space-y-5">
                                                        {/* INFO GRID */}
                                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                            <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                                <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Category</span>
                                                                <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                                    {f.category_name || mingleData?.categories?.find(c => String(c.id) === String(f.category_id))?.category_name || f.category_id || '-'}
                                                                </span>
                                                            </div>
                                                            <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                                <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Finding Result</span>
                                                                <div 
                                                                    className="rte-content text-sm font-semibold text-zinc-800 dark:text-zinc-100"
                                                                    dangerouslySetInnerHTML={{ __html: f.finding_result || '-' }}
                                                                />
                                                            </div>
                                                            <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                                <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Feedback To (Employee)</span>
                                                                <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100">
                                                                    {mingleData?.employees?.find(e => String(e.nik) === String(f.feedback_to))?.name || f.feedback_to || '-'}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        {/* EVIDENCE + REASON | EVIDENCE ACTION + ACTION TAKEN */}
                                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            
                                                            {/* KIRI: Evidence + Reason */}
                                                            <div className="space-y-3">
                                                                <div>
                                                                    <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">
                                                                        Evidence (Live Photo) — {Array.isArray(f.evidence) ? f.evidence.length : (f.evidence ? 1 : 0)} foto
                                                                    </span>
                                                                    {(() => {
                                                                        const photos = Array.isArray(f.evidence) ? f.evidence : (f.evidence ? [f.evidence] : [])
                                                                        if (photos.length === 0) {
                                                                            return <div className="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-center text-xs text-zinc-400 dark:text-zinc-500 italic border border-zinc-200 dark:border-zinc-700">No photo</div>
                                                                        }
                                                                        return (
                                                                            <div className="grid grid-cols-2 gap-2">
                                                                                {photos.map((photo, pIdx) => (
                                                                                    <div 
                                                                                        key={pIdx}
                                                                                        className="relative group cursor-pointer rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800"
                                                                                        onClick={() => setPhotoPreview({ url: photo, title: `Initial Evidence ${pIdx + 1}` })}
                                                                                    >
                                                                                        <img src={photo} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt={`Evidence ${pIdx + 1}`} />
                                                                                        <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-6 h-6 text-white">
                                                                                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                                                                <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" />
                                                                                            </svg>
                                                                                        </div>
                                                                                    </div>
                                                                                ))}
                                                                            </div>
                                                                        )
                                                                    })()}
                                                                </div>
                                                                <div>
                                                                    <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Reason</span>
                                                                    <div 
                                                                        className="rte-content bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 text-sm text-zinc-800 dark:text-zinc-100 h-[80px] overflow-y-auto"
                                                                        dangerouslySetInnerHTML={{ __html: f.reason || '-' }}
                                                                    />
                                                                </div>
                                                            </div>

                                                            {/* KANAN: Evidence Action + Action Taken */}
                                                            <div className="space-y-3">
                                                                <div>
                                                                    <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">
                                                                        Evidence Action (Live Photo) — {Array.isArray(f.evidence_action) ? f.evidence_action.length : (f.evidence_action ? 1 : 0)} foto
                                                                    </span>
                                                                    {(() => {
                                                                        const photos = Array.isArray(f.evidence_action) ? f.evidence_action : (f.evidence_action ? [f.evidence_action] : [])
                                                                        if (photos.length === 0) {
                                                                            return <div className="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-center text-xs text-zinc-400 dark:text-zinc-500 italic border border-zinc-200 dark:border-zinc-700">No photo</div>
                                                                        }
                                                                        return (
                                                                            <div className="grid grid-cols-2 gap-2">
                                                                                {photos.map((photo, pIdx) => (
                                                                                    <div 
                                                                                        key={pIdx}
                                                                                        className="relative group cursor-pointer rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800"
                                                                                        onClick={() => setPhotoPreview({ url: photo, title: `Action Evidence ${pIdx + 1}` })}
                                                                                    >
                                                                                        <img src={photo} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt={`Action Evidence ${pIdx + 1}`} />
                                                                                        <div className="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-6 h-6 text-white">
                                                                                                <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                                                                <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" />
                                                                                            </svg>
                                                                                        </div>
                                                                                    </div>
                                                                                ))}
                                                                            </div>
                                                                        )
                                                                    })()}
                                                                </div>
                                                                <div>
                                                                    <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Action Taken</span>
                                                                    <div 
                                                                        className="rte-content bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 text-sm text-zinc-800 dark:text-zinc-100 h-[80px] overflow-y-auto"
                                                                        dangerouslySetInnerHTML={{ __html: f.action || '-' }}
                                                                    />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            )
                                        })}
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL DELETE */}
            {showDeleteModal && selectedRow && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        {/* Header */}
                        <div className="px-5 py-4 bg-gradient-to-r from-red-600 to-red-700 flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white">
                                    <path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <h3 className="text-base font-bold text-white">Delete Data?</h3>
                                <p className="text-xs text-red-100">This action cannot be undone</p>
                            </div>
                        </div>

                        {/* Body */}
                        <div className="p-5">
                            <p className="text-sm text-zinc-700 dark:text-zinc-300">
                                Are you sure you want to delete result line <strong className="text-zinc-900 dark:text-zinc-100">{selectedRow.master_line?.line_number}</strong> shift <strong className="text-zinc-900 dark:text-zinc-100">{selectedRow.shift}</strong>?
                            </p>
                        </div>

                        {/* Footer */}
                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                            <button 
                                onClick={() => setShowDeleteModal(false)} 
                                className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                onClick={confirmDelete} 
                                className="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-red-700 dark:hover:bg-red-500 transition-colors"
                            >
                                Yes, Delete
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL PREVIEW FOTO */}
            {photoPreview && (
                <div className="fixed inset-0 z-[110] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" onClick={() => setPhotoPreview(null)}>
                    <div className="relative max-w-4xl w-full flex flex-col items-center" onClick={e => e.stopPropagation()}>
                        <div className="w-full flex justify-between items-center bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 rounded-t-xl text-white shadow-md">
                            <h3 className="font-bold text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" /></svg>
                                Preview {photoPreview.title}
                            </h3>
                            <button onClick={() => setPhotoPreview(null)} className="text-blue-100 hover:text-white bg-white/20 hover:bg-white/30 rounded-full p-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                            </button>
                        </div>
                        <div className="bg-zinc-900 p-2 w-full flex justify-center rounded-b-xl border border-t-0 border-zinc-700">
                            <img 
                                src={photoPreview.url} 
                                alt="Preview" 
                                className="max-h-[80vh] w-auto object-contain rounded"
                            />
                        </div>
                    </div>
                </div>
            )}

            {/* TOAST */}
            {toast && <div className={`fixed bottom-6 right-6 z-[120] px-4 py-3 rounded-xl shadow-xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>{toast.message}</div>}
        </div>
    )
}