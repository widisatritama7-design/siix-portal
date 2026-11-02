import React, { useState, useMemo } from 'react'
import ScanLocatorModal from './ScanLocatorModal'
import PickTrayModal from './PickTrayModal'
import TransactionFormModal from './TransactionFormModal'

export default function Transaction({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [trays, setTrays]           = useState(mingleData?.trays ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0,
    })
    const permissions = mingleData?.permissions ?? { canCreate: false, canEdit: false, canDelete: false }

    // State Filter
    const [filters, setFilters] = useState(mingleData?.filters ?? {
        type: '', date_from: '', date_until: ''
    })
    const [loadingFilter, setLoadingFilter] = useState(false)
    const [showExtraCols, setShowExtraCols] = useState(false)

    const [search, setSearch]           = useState('')
    const [loadingPage, setLoadingPage] = useState(false)
    const [deletingId, setDeletingId]   = useState(null)
    const [toast, setToast]             = useState(null)

    // Alur step: null | 'scan' | 'pick' | 'form'
    const [step, setStep]                     = useState(null)
    const [scannedLocator, setScannedLocator] = useState(null)
    const [scannedTrays, setScannedTrays]     = useState([])
    const [selectedTray, setSelectedTray]     = useState(null)
    const [editRow, setEditRow]               = useState(null)

    // Delete
    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget]       = useState(null)
    const [deleteReason, setDeleteReason]       = useState('') // State untuk alasan hapus

    const hasActiveFilter = useMemo(() => {
        return filters.type !== '' || filters.date_from !== '' || filters.date_until !== ''
    }, [filters])

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    // Handler Filter
    const handleApplyFilter = async () => {
        setLoadingFilter(true)
        try {
            const result = await wire.applyFilter(filters)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (e) {
            showToast('Failed to apply filter: ' + e.message, 'error')
        } finally {
            setLoadingFilter(false)
        }
    }

    const handleResetFilter = async () => {
        setLoadingFilter(true)
        try {
            const result = await wire.resetFilter()
            setRows(result.rows)
            setPagination(result.pagination)
            setFilters({ type: '', date_from: '', date_until: '' })
        } catch (e) {
            showToast('Failed to reset filter: ' + e.message, 'error')
        } finally {
            setLoadingFilter(false)
        }
    }

    const gotoPage = async (page) => {
        if (page < 1 || page > pagination.last_page || page === pagination.current_page) return
        setLoadingPage(true)
        try {
            const result = await wire.gotoPage(page)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (e) {
            showToast('Failed to change page: ' + e.message, 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    // ===== ALUR STEP =====
    const closeAllSteps = () => {
        setStep(null)
        setScannedLocator(null)
        setScannedTrays([])
        setSelectedTray(null)
        setEditRow(null)
    }

    const openCreate = () => {
        if (!permissions.canCreate) return
        setScannedLocator(null)
        setScannedTrays([])
        setSelectedTray(null)
        setEditRow(null)
        setStep('scan')
    }

    const handleScanFound = (locator, traysFound) => {
        setScannedLocator(locator)
        setScannedTrays(traysFound)
        setStep('pick') 
    }

    const handlePickTray = (tray) => {
        setSelectedTray(tray)
        setStep('form')
    }

    const handleBackToScan = () => {
        setStep('scan')
        setScannedLocator(null)
        setScannedTrays([])
        setSelectedTray(null)
    }

    const handleBackToPick = () => {
        setStep('pick')
        setSelectedTray(null)
    }

    const handleSaved = (result) => {
        setRows(result.data.rows)
        setPagination(result.data.pagination)
        if (result.data.trays) setTrays(result.data.trays)
        showToast(result.message, 'success')
        closeAllSteps()
    }

    // ===== DELETE =====
    const openDeleteConfirm = (row) => {
        if (!permissions.canDelete) return
        if (!row.can_delete) {
            showToast('Cannot delete transaction older than 24 hours', 'error')
            return
        }
        setDeleteTarget(row)
        setDeleteReason('') // Reset alasan saat buka modal
        setShowDeleteModal(true)
    }

    const confirmDelete = async () => {
        if (!deleteTarget) return
        if (!deleteReason.trim()) {
            showToast('Please provide a reason for deletion', 'error')
            return
        }

        setDeletingId(deleteTarget.id)
        try {
            const result = await wire.deleteRow(deleteTarget.id, deleteReason)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                showToast(result.message, 'success')
                setShowDeleteModal(false)
                setDeleteTarget(null)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Failed to delete: ' + e.message, 'error')
        } finally {
            setDeletingId(null)
        }
    }

    // ===== FILTER & PAGINATION =====
    const filtered = useMemo(() => {
        if (!search.trim()) return rows
        const q = search.toLowerCase()
        return rows.filter(r =>
            (r.part_number_tray ?? '').toLowerCase().includes(q) ||
            (r.item_code_sap ?? '').toLowerCase().includes(q) ||
            (r.desc ?? '').toLowerCase().includes(q) ||
            (r.model ?? '').toLowerCase().includes(q) ||
            (r.rack_number ?? '').toLowerCase().includes(q) ||
            (r.locator_number ?? '').toLowerCase().includes(q) ||
            (r.transaction_type ?? '').toLowerCase().includes(q) ||
            (r.reason ?? '').toLowerCase().includes(q) ||
            (r.created_by_name ?? '').toLowerCase().includes(q))
    }, [rows, search])

    const getPageNumbers = () => {
        const { current_page, last_page } = pagination
        const pages = []
        if (last_page <= 5) {
            for (let i = 1; i <= last_page; i++) pages.push(i)
        } else {
            pages.push(1)
            if (current_page > 3) pages.push('...')
            const start = Math.max(2, current_page - 1)
            const end   = Math.min(last_page - 1, current_page + 1)
            for (let i = start; i <= end; i++) pages.push(i)
            if (current_page < last_page - 2) pages.push('...')
            pages.push(last_page)
        }
        return pages
    }

    return (
        <div className="p-1 space-y-2">

            {/* BREADCRUMBS */}
            <nav className="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 overflow-x-auto whitespace-nowrap pb-1">
                <button type="button" onClick={() => window.Livewire.navigate('/main-dashboard')}
                    className="inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                    Dashboard
                </button>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">PROD</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Tray Monitoring</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Transaction</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Tray Transaction</span>
            </nav>

            {/* HEADER (Judul saja) */}
            <div>
                <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">Tray Transaction</h1>
                <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Stock in / out records</p>
            </div>

            {/* FILTER CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4 shadow-sm flex flex-col gap-4">
                <div className="flex flex-col lg:flex-row lg:items-end gap-3 w-full">
                    <div className="flex flex-col sm:flex-row flex-1 gap-3 w-full">
                        <div className="flex-1 min-w-[140px]">
                            <label className="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Type</label>
                            <select value={filters.type} onChange={(e) => setFilters({ ...filters, type: e.target.value })}
                                className="w-full px-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Types</option>
                                <option value="in">IN</option>
                                <option value="out">OUT</option>
                            </select>
                        </div>
                        <div className="flex-1 min-w-[140px]">
                            <label className="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Date From</label>
                            <input type="date" value={filters.date_from} onChange={(e) => setFilters({ ...filters, date_from: e.target.value })}
                                className="w-full px-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div className="flex-1 min-w-[140px]">
                            <label className="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 mb-1">Date Until</label>
                            <input type="date" value={filters.date_until} onChange={(e) => setFilters({ ...filters, date_until: e.target.value })}
                                className="w-full px-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>
                    {hasActiveFilter && (
                        <div className="flex gap-2 shrink-0 sm:mt-0 mt-2">
                            <button type="button" onClick={handleApplyFilter} disabled={loadingFilter}
                                className="px-4 py-2 h-[38px] rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm disabled:opacity-60 w-full sm:w-auto">
                                {loadingFilter ? 'Loading...' : 'Apply'}
                            </button>
                            <button type="button" onClick={handleResetFilter} disabled={loadingFilter}
                                className="px-4 py-2 h-[38px] rounded-lg border border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 text-sm font-semibold hover:bg-red-50 dark:hover:bg-red-900/20 transition-all disabled:opacity-60 w-full sm:w-auto">
                                Reset
                            </button>
                        </div>
                    )}
                </div>
                {permissions.canCreate && (
                    <button onClick={openCreate}
                        className="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6">
                            <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clipRule="evenodd" />
                        </svg>
                        Add Transaction
                    </button>
                )}
            </div>

            {/* TABLE CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6 text-white shrink-0">
                            <path fillRule="evenodd" d="M4.5 3.75a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V6.75a3 3 0 0 0-3-3h-15Zm4.125 3a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Zm-3.873 8.703a4.126 4.126 0 0 1 7.746 0 .75.75 0 0 1-.351.92 7.47 7.47 0 0 1-3.522.877 7.47 7.47 0 0 1-3.522-.877.75.75 0 0 1-.351-.92ZM15 8.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15ZM14.25 12a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H15a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3.75a.75.75 0 0 0 0-1.5H15Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Transaction List</span>
                    </div>
                    
                    <div className="flex items-center gap-2 w-full sm:w-auto">
                        <button 
                            onClick={() => setShowExtraCols(v => !v)}
                            className="flex items-center gap-1.5 px-3 py-2 rounded-lg bg-white/10 hover:bg-white/20 text-white text-xs font-semibold transition-colors border border-white/20"
                        >
                            {showExtraCols ? (
                                <>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                        <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clipRule="evenodd" />
                                    </svg>
                                    <span className="hidden sm:inline">Hide Info</span>
                                </>
                            ) : (
                                <>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                        <path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577a11.217 11.217 0 0 1 4.242-.827c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113Z" />
                                        <path d="M15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.53 15.713l-4.243-4.244a3.75 3.75 0 0 0 4.244 4.243Z" />
                                        <path d="M6.75 12c0-.619.107-1.213.304-1.764l-3.1-3.1a11.25 11.25 0 0 0-2.63 4.31c-.12.362-.12.752 0 1.113 1.489 4.467 5.704 7.69 10.675 7.69 1.5 0 2.933-.294 4.242-.827l-2.477-2.477A5.25 5.25 0 0 1 6.75 12Z" />
                                    </svg>
                                    <span className="hidden sm:inline">Show Info</span>
                                </>
                            )}
                        </button>
                        <div className="relative w-full sm:w-64">
                            <input type="text" value={search} onChange={e => setSearch(e.target.value)}
                                placeholder="Search tray / reason..."
                                className="w-full pl-3 pr-3 py-2 text-sm rounded-lg border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm" />
                        </div>
                    </div>
                </div>

                <div className="overflow-x-auto">
                    {loadingPage ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Loading data...</div>
                    ) : filtered.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">
                            {search ? 'No matching results' : 'No transactions yet'}
                        </div>
                    ) : (
                        <table className="w-full text-sm min-w-max">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr className="whitespace-nowrap">
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 w-12">#</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Part Number</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Item Code SAP</th>
                                    
                                    {/* KOLOM EXTRA (HIDE/UNHIDE) */}
                                    {showExtraCols && (
                                        <>
                                            <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Desc</th>
                                            <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Model</th>
                                        </>
                                    )}
                                    
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Rack</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Locator</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Type</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Qty In</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Qty Out</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Reason</th>
                                    <th className="hidden lg:table-cell px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Created By</th>
                                    <th className="hidden lg:table-cell px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Created At</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500 w-40">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {filtered.map((row, idx) => {
                                    const isIn = (row.transaction_type ?? '').toLowerCase() === 'in'
                                    return (
                                        <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors whitespace-nowrap">
                                            <td className="px-3 py-3 text-zinc-500 font-mono text-xs">
                                                {(pagination.current_page - 1) * pagination.per_page + idx + 1}
                                            </td>
                                            <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {row.part_number_tray?.trim() ? row.part_number_tray : '-'}
                                            </td>
                                            <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {row.item_code_sap?.trim() ? row.item_code_sap : '-'}
                                            </td>
                                            
                                            {/* DATA EXTRA (HIDE/UNHIDE) */}
                                            {showExtraCols && (
                                                <>
                                                    <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                        {row.desc?.trim() ? row.desc : '-'}
                                                    </td>
                                                    <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                        {row.model?.trim() ? row.model : '-'}
                                                    </td>
                                                </>
                                            )}
                                            
                                            <td className="px-3 py-3 text-center text-zinc-700 dark:text-zinc-200 text-xs">
                                                <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                    {row.rack_number ?? '-'}
                                                </span>
                                            </td>
                                            <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">{row.locator_number ?? '-'}</td>
                                            <td className="px-3 py-3 text-center text-zinc-700 dark:text-zinc-200 text-xs">
                                                {isIn ? (
                                                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-3.5 h-3.5">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z" clipRule="evenodd" />
                                                        </svg>
                                                        IN
                                                    </span>
                                                ) : (
                                                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-3.5 h-3.5">
                                                            <path fillRule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM6.75 9.25a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clipRule="evenodd" />
                                                        </svg>
                                                        OUT
                                                    </span>
                                                )}
                                            </td>
                                            <td className="px-3 py-3 text-center font-semibold text-emerald-700 dark:text-emerald-300">{row.qty_in ?? '-'}</td>
                                            <td className="px-3 py-3 text-center font-semibold text-red-700 dark:text-red-300">{row.qty_out ?? '-'}</td>
                                            <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">{row.reason ?? '-'}</td>
                                            <td className="hidden lg:table-cell px-3 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_by_name ?? '-'}</td>
                                            <td className="hidden lg:table-cell px-3 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_at ?? '-'}</td>
                                            <td className="px-3 py-3">
                                                <div className="flex items-center justify-center gap-1.5">
                                                    {permissions.canDelete && (
                                                        <button 
                                                            onClick={() => openDeleteConfirm(row)} 
                                                            disabled={!row.can_delete}
                                                            className={`px-2.5 py-1.5 rounded-md text-white text-xs font-semibold transition-colors shadow-sm ${
                                                                row.can_delete 
                                                                    ? 'bg-red-600 hover:bg-red-700' 
                                                                    : 'bg-zinc-400 dark:bg-zinc-700 cursor-not-allowed'
                                                            }`}
                                                            title={!row.can_delete ? 'Lebih dari 24 jam, tidak dapat dihapus' : 'Hapus'}
                                                        >
                                                            Delete
                                                        </button>
                                                    )}
                                                    {(!permissions.canEdit && !permissions.canDelete) && (
                                                        <span className="text-xs text-zinc-400 italic">No Action</span>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                    )
                                })}
                            </tbody>
                        </table>
                    )}
                </div>

                {pagination.last_page > 1 && (
                    <div className="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div className="text-sm text-zinc-500 dark:text-zinc-400 text-center sm:text-left">
                            Showing <strong>{pagination.from ?? 0}</strong> - <strong>{pagination.to ?? 0}</strong> of <strong>{pagination.total}</strong> records
                        </div>
                        <div className="flex items-center justify-center sm:justify-end gap-1 flex-wrap">
                            <button onClick={() => gotoPage(pagination.current_page - 1)} disabled={pagination.current_page === 1 || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40">
                                Prev
                            </button>
                            {getPageNumbers().map((p, idx) =>
                                p === '...' ? (
                                    <span key={`dots-${idx}`} className="px-2 text-zinc-400 text-sm">...</span>
                                ) : (
                                    <button key={p} onClick={() => gotoPage(p)} disabled={loadingPage}
                                        className={`min-w-[34px] px-2.5 py-1.5 text-sm rounded-lg border transition-all ${
                                            p === pagination.current_page
                                                ? 'bg-blue-600 border-blue-600 text-white font-bold'
                                                : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300'
                                        }`}>
                                        {p}
                                    </button>
                                )
                            )}
                            <button onClick={() => gotoPage(pagination.current_page + 1)} disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40">
                                Next
                            </button>
                        </div>
                    </div>
                )}
            </div>

            {/* MODALS — alur step */}
            {step === 'scan' && (
                <ScanLocatorModal
                    wire={wire}
                    onClose={closeAllSteps}
                    onFound={handleScanFound}
                    showToast={showToast}
                />
            )}

            {step === 'pick' && (
                <PickTrayModal
                    locator={scannedLocator}
                    trays={scannedTrays}
                    onBack={handleBackToScan}
                    onPick={handlePickTray}
                />
            )}

            {step === 'form' && selectedTray && (
                <TransactionFormModal
                    wire={wire}
                    tray={selectedTray}
                    initialRow={editRow}
                    onClose={closeAllSteps}
                    onBack={!editRow ? handleBackToPick : null}
                    onSaved={handleSaved}
                    showToast={showToast}
                />
            )}

            {/* DELETE MODAL */}
            {showDeleteModal && deleteTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden">
                        <div className="p-5 text-center">
                            <div className="mx-auto mb-3 flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-6 h-6 text-red-600 dark:text-red-400">
                                    <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <h3 className="text-lg font-bold text-zinc-800 dark:text-white">Delete Transaction?</h3>
                            <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-2">
                                Are you sure you want to delete this <strong className="text-zinc-800 dark:text-zinc-100">{deleteTarget.transaction_type?.toUpperCase()}</strong> transaction
                                {deleteTarget.part_number_tray ? <> for <strong className="text-zinc-800 dark:text-zinc-100">{deleteTarget.part_number_tray}</strong></> : null}?
                            </p>
                        </div>
                        <div className="px-5 pb-4">
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                Reason <span className="text-red-500">*</span>
                            </label>
                            <textarea
                                value={deleteReason}
                                onChange={(e) => setDeleteReason(e.target.value)}
                                rows={3}
                                className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                                placeholder="Why do you want to delete this transaction?"
                            />
                        </div>
                        <div className="flex justify-end gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700">
                            <button onClick={() => { setShowDeleteModal(false); setDeleteTarget(null); setDeleteReason('') }} disabled={!!deletingId}
                                className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50">
                                Cancel
                            </button>
                            <button onClick={confirmDelete} disabled={!!deletingId || !deleteReason.trim()}
                                className="px-4 py-2 text-sm rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 disabled:opacity-60">
                                {deletingId ? 'Deleting...' : 'Yes, Delete'}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {toast && (
                <div className={`fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>
                    {toast.message}
                </div>
            )}
        </div>
    )
}