import React, { useState, useMemo, useRef, useEffect } from 'react'
import { QRCodeSVG } from 'qrcode.react'

export default function MasterLocator({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [racks, setRacks]           = useState(mingleData?.racks ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0,
    })
    const permissions = mingleData?.permissions ?? { canCreate: false, canEdit: false, canDelete: false }

    // State Filter
    const [search, setSearch]               = useState('')
    const [selectedRackId, setSelectedRackId] = useState('')
    const [searchLoading, setSearchLoading] = useState(false)
    const [loadingPage, setLoadingPage]   = useState(false)
    const [saving, setSaving]             = useState(false)
    const [deletingId, setDeletingId]     = useState(null)
    const [toast, setToast]               = useState(null)

    // Modal Form
    const [showModal, setShowModal] = useState(false)
    const [form, setForm]           = useState({
        id: null,
        master_rack_id: '',
        locator_number: '',
        has_tray: false,
    })

    // Custom rack dropdown
    const [showRackDropdown, setShowRackDropdown] = useState(false)
    const rackDropdownRef = useRef(null)
    
    // Filter Rack Dropdown
    const [showRackFilterDropdown, setShowRackFilterDropdown] = useState(false)
    const rackFilterRef = useRef(null)

    // Detail Modal
    const [showDetailModal, setShowDetailModal] = useState(false)
    const [detailLocator, setDetailLocator]     = useState(null)
    const [detailTrays, setDetailTrays]         = useState([])
    const [loadingDetail, setLoadingDetail]     = useState(false)

    // Delete Modal
    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget]       = useState(null)

    // QR Modal
    const [showQrModal, setShowQrModal] = useState(false)
    const [qrTargets, setQrTargets]     = useState([])

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    // Close dropdown on outside click
    useEffect(() => {
        const handler = (e) => {
            if (rackDropdownRef.current && !rackDropdownRef.current.contains(e.target)) setShowRackDropdown(false)
            if (rackFilterRef.current && !rackFilterRef.current.contains(e.target)) setShowRackFilterDropdown(false)
        }
        document.addEventListener('mousedown', handler)
        return () => document.removeEventListener('mousedown', handler)
    }, [])

    const selectedRackNumber = useMemo(() => {
        const found = racks.find(r => String(r.id) === String(form.master_rack_id))
        return found?.rack_number ?? ''
    }, [racks, form.master_rack_id])

    const selectedRackFilterName = useMemo(() => {
        if (!selectedRackId) return 'All Racks'
        const found = racks.find(r => String(r.id) === String(selectedRackId))
        return found?.rack_number ?? 'All Racks'
    }, [racks, selectedRackId])

    // ===== FILTER & PAGINATION =====
    const applyFilter = async (newSearch = search, newRackId = selectedRackId) => {
        setSearchLoading(true)
        try {
            const result = await wire.applyFilter(newSearch, newRackId)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (err) {
            showToast('Failed to filter: ' + err.message, 'error')
        } finally {
            setSearchLoading(false)
        }
    }

    const handleSearchChange = (e) => {
        const val = e.target.value
        setSearch(val)
        applyFilter(val, selectedRackId)
    }

    const handleRackFilterChange = (rackId) => {
        setSelectedRackId(rackId)
        setShowRackFilterDropdown(false)
        applyFilter(search, rackId)
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

    // ===== PRINT QR =====
    const handlePrintQr = () => {
        const printContent = document.getElementById('qr-print-area')
        if (!printContent) return
        
        const originalContent = document.body.innerHTML
        document.body.innerHTML = printContent.innerHTML
        window.print()
        document.body.innerHTML = originalContent
        window.location.reload()
    }

    const openQr = (locators) => {
        if (locators.length === 0) {
            showToast('No locators to print', 'error')
            return
        }
        setQrTargets(locators)
        setShowQrModal(true)
    }

    const handlePrintAll = async () => {
        if (!selectedRackId) return
        setSearchLoading(true)
        try {
            const result = await wire.getQrDataByRack(selectedRackId)
            if (result.success) {
                openQr(result.qr_data)
            }
        } catch (err) {
            showToast('Failed to load QR data', 'error')
        } finally {
            setSearchLoading(false)
        }
    }

    // ===== FORM ACTIONS =====
    const openCreate = () => {
        if (!permissions.canCreate) return
        if (racks.length === 0) {
            showToast('Please add a Rack first before creating a Locator', 'error')
            return
        }
        setForm({ id: null, master_rack_id: selectedRackId || '', locator_number: '', has_tray: false })
        setShowRackDropdown(false)
        setShowModal(true)
    }

    const openEdit = (row) => {
        if (!permissions.canEdit) return
        setForm({
            id: row.id,
            master_rack_id: row.master_rack_id,
            locator_number: row.locator_number,
            has_tray: row.has_tray,
        })
        setShowRackDropdown(false)
        setShowModal(true)
    }

    const openDetail = async (row) => {
        setDetailLocator(row)
        setShowDetailModal(true)
        setLoadingDetail(true)
        try {
            const result = await wire.getTraysByLocator(row.id)
            if (result.success) setDetailTrays(result.trays)
            else showToast('Failed to load trays', 'error')
        } catch (e) {
            showToast('Failed to load trays: ' + e.message, 'error')
        } finally {
            setLoadingDetail(false)
        }
    }

    const pickRack = (rack) => {
        setForm({ ...form, master_rack_id: rack.id })
        setShowRackDropdown(false)
    }

    const handleSave = async (e) => {
        e.preventDefault()
        setSaving(true)
        try {
            const payload = {
                id: form.id,
                master_rack_id: form.master_rack_id || null,
                locator_number: (form.locator_number || '').trim(),
            }
            const result = await wire.save(payload)
            if (result.success) {
                setRows(result.data.rows)
                if (result.data.racks) setRacks(result.data.racks)
                showToast(result.message, 'success')
                setShowModal(false)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Failed to save: ' + e.message, 'error')
        } finally {
            setSaving(false)
        }
    }

    const openDeleteConfirm = (locator) => {
        if (!permissions.canDelete) return
        setDeleteTarget(locator)
        setShowDeleteModal(true)
    }

    const confirmDelete = async () => {
        if (!deleteTarget) return
        setDeletingId(deleteTarget.id)
        try {
            const result = await wire.deleteRow(deleteTarget.id)
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

    return (
        <div className="p-1 space-y-4">
            {/* BREADCRUMBS */}
            <nav className="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 overflow-x-auto whitespace-nowrap pb-1">
                <button type="button" onClick={() => window.Livewire.navigate('/main-dashboard')} className="hover:text-blue-600 transition-colors shrink-0">Dashboard</button>
                <span className="text-zinc-300 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">PROD</span>
                <span className="text-zinc-300 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Tray Monitoring</span>
                <span className="text-zinc-300 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Master</span>
                <span className="text-zinc-300 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Master Locator</span>
            </nav>

            {/* HEADER */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">Master Locator</h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Rack locator master data</p>
                </div>
                {permissions.canCreate && (
                    <button onClick={openCreate} className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4"><path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" /></svg>
                        Add Locator
                    </button>
                )}
            </div>

            {/* MAIN CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
                {/* Header Filter & Search */}
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 flex flex-col lg:flex-row lg:items-center justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6 text-white shrink-0">
                            <path fillRule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Locator List</span>
                    </div>
                    
                    <div className="flex flex-col sm:flex-row items-center gap-2 w-full lg:w-auto">
                        {/* FILTER RACK */}
                        <div className="relative w-full sm:w-56" ref={rackFilterRef}>
                            <button 
                                onClick={() => setShowRackFilterDropdown(v => !v)}
                                className="w-full flex items-center justify-between gap-2 pl-3 pr-2 py-2 text-sm rounded-lg border-none bg-white/10 hover:bg-white/20 text-white focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors"
                            >
                                <span className="truncate">{selectedRackFilterName}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className={`w-4 h-4 shrink-0 transition-transform ${showRackFilterDropdown ? 'rotate-180' : ''}`}>
                                    <path fillRule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                </svg>
                            </button>
                            {showRackFilterDropdown && (
                                <div className="absolute z-30 mt-1 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden text-left">
                                    <div className="max-h-56 overflow-y-auto py-1">
                                        <button onClick={() => handleRackFilterChange('')} className="w-full px-3.5 py-2 text-sm text-zinc-800 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700 italic">All Racks</button>
                                        {racks.map(rack => (
                                            <button key={rack.id} onClick={() => handleRackFilterChange(rack.id)}
                                                className={`w-full px-3.5 py-2 text-sm text-left transition-colors ${
                                                    String(selectedRackId) === String(rack.id) ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold' : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                                                }`}
                                            >
                                                {rack.rack_number}
                                            </button>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>

                        {/* SEARCH */}
                        <div className="relative w-full sm:w-64">
                            <input type="text" value={search} onChange={handleSearchChange} placeholder="Search locator..."
                                className="w-full pl-3 pr-3 py-2 text-sm rounded-lg border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm" />
                        </div>

                        {/* PRINT ALL BUTTON */}
                        {selectedRackId && (
                            <button 
                                onClick={handlePrintAll} 
                                disabled={searchLoading}
                                className="w-full sm:w-auto flex items-center justify-center gap-1.5 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors whitespace-nowrap disabled:opacity-60"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                </svg>
                                Print All QR
                            </button>
                        )}
                    </div>
                </div>

                {/* TABLE */}
                <div className="overflow-x-auto">
                    {(loadingPage || searchLoading) ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Loading data...</div>
                    ) : rows.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">
                            {search || selectedRackId ? 'No matching results' : 'No locators yet'}
                        </div>
                    ) : (
                        <table className="w-full text-sm min-w-max">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr className="whitespace-nowrap text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">
                                    <th className="px-4 py-3 w-16 text-center">#</th>
                                    <th className="px-4 py-3">Rack Number</th>
                                    <th className="px-4 py-3">Locator Number</th>
                                    <th className="px-4 py-3">Created By</th>
                                    <th className="px-4 py-3">Created Date</th>
                                    <th className="px-4 py-3 text-center w-40">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {rows.map((row, idx) => (
                                    <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors whitespace-nowrap">
                                        <td className="px-4 py-3 text-center text-zinc-500 font-mono text-xs">
                                            {(pagination.current_page - 1) * pagination.per_page + idx + 1}
                                        </td>
                                        <td className="px-4 py-3 text-zinc-800 dark:text-zinc-100">
                                            <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                {row.rack_number ?? '-'}
                                            </span>
                                        </td>
                                        <td className="px-4 py-3 font-semibold text-zinc-800 dark:text-zinc-100">{row.locator_number}</td>
                                        <td className="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_by_name ?? '-'}</td>
                                        <td className="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_at ?? '-'}</td>
                                        <td className="px-4 py-3">
                                            <div className="flex items-center justify-center gap-1.5">
                                                
                                                {/* Print QR */}
                                                <div className="relative group flex items-center justify-center">
                                                    <button 
                                                        onClick={() => openQr([row])} 
                                                        className="inline-flex items-center gap-1 px-2 py-1 bg-zinc-100 hover:bg-zinc-200 text-zinc-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-300 text-[11px] font-semibold rounded transition-colors" 
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                                                        </svg>
                                                        QR
                                                    </button>
                                                    {/* Tooltip */}
                                                    <div className="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-50">
                                                        <span className="relative z-10 p-1.5 text-[10px] leading-none text-white bg-zinc-800 dark:bg-zinc-700 rounded shadow-md whitespace-nowrap">Print QR Code</span>
                                                        <div className="w-2 h-2 -mt-1 bg-zinc-800 dark:bg-zinc-700 rotate-45"></div>
                                                    </div>
                                                </div>
                                                
                                                {/* View Trays */}
                                                <div className="relative group flex items-center justify-center">
                                                    <button 
                                                        onClick={() => openDetail(row)} 
                                                        className="inline-flex items-center gap-1 px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/40 dark:hover:bg-blue-900/60 dark:text-blue-300 text-[11px] font-semibold rounded transition-colors" 
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                            <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z" clipRule="evenodd" />
                                                        </svg>
                                                        View
                                                    </button>
                                                    <div className="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-50">
                                                        <span className="relative z-10 p-1.5 text-[10px] leading-none text-white bg-zinc-800 dark:bg-zinc-700 rounded shadow-md whitespace-nowrap">View Tray List</span>
                                                        <div className="w-2 h-2 -mt-1 bg-zinc-800 dark:bg-zinc-700 rotate-45"></div>
                                                    </div>
                                                </div>

                                                {/* Edit */}
                                                {permissions.canEdit && (
                                                    <div className="relative group flex items-center justify-center">
                                                        <button 
                                                            onClick={() => openEdit(row)} 
                                                            disabled={row.has_tray}
                                                            className={`inline-flex items-center gap-1 px-2 py-1 text-[11px] font-semibold rounded transition-colors ${
                                                                row.has_tray 
                                                                    ? 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600 cursor-not-allowed' 
                                                                    : 'bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/40 dark:hover:bg-amber-900/60 dark:text-amber-300'
                                                            }`}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                        <div className="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-50">
                                                            <span className="relative z-10 p-1.5 text-[10px] leading-none text-white bg-zinc-800 dark:bg-zinc-700 rounded shadow-md whitespace-nowrap">
                                                                {row.has_tray ? 'Tidak dapat diedit' : 'Edit Locator'}
                                                            </span>
                                                            <div className="w-2 h-2 -mt-1 bg-zinc-800 dark:bg-zinc-700 rotate-45"></div>
                                                        </div>
                                                    </div>
                                                )}

                                                {/* Delete */}
                                                {permissions.canDelete && (
                                                    <div className="relative group flex items-center justify-center">
                                                        <button 
                                                            onClick={() => openDeleteConfirm(row)} 
                                                            disabled={row.has_tray}
                                                            className={`inline-flex items-center gap-1 px-2 py-1 text-[11px] font-semibold rounded transition-colors ${
                                                                row.has_tray 
                                                                    ? 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600 cursor-not-allowed' 
                                                                    : 'bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:hover:bg-red-900/60 dark:text-red-300'
                                                            }`}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                                <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clipRule="evenodd" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                        <div className="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-50">
                                                            <span className="relative z-10 p-1.5 text-[10px] leading-none text-white bg-zinc-800 dark:bg-zinc-700 rounded shadow-md whitespace-nowrap">
                                                                {row.has_tray ? 'Tidak dapat dihapus' : 'Delete Locator'}
                                                            </span>
                                                            <div className="w-2 h-2 -mt-1 bg-zinc-800 dark:bg-zinc-700 rotate-45"></div>
                                                        </div>
                                                    </div>
                                                )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    )}
                </div>

                {/* PAGINATION */}
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

            {/* MODAL FORM (Add/Edit Locator) */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-visible border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center rounded-t-2xl">
                            <h2 className="text-base font-bold text-white">{form.id ? 'Edit Locator' : 'Add Locator'}</h2>
                            <button onClick={() => setShowModal(false)} className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">✕</button>
                        </div>
                        <form onSubmit={handleSave} className="p-5 space-y-4">
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Rack <span className="text-red-500">*</span></label>
                                <div className="relative" ref={rackDropdownRef}>
                                    <button type="button" onClick={() => setShowRackDropdown(v => !v)} disabled={form.has_tray}
                                        className="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-left text-zinc-800 dark:text-zinc-100 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                                        <span className={selectedRackNumber ? '' : 'text-zinc-400 dark:text-zinc-500'}>{selectedRackNumber || '-- Select Rack --'}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className={`w-4 h-4 text-zinc-400 shrink-0 transition-transform duration-200 ${showRackDropdown ? 'rotate-180' : ''}`}><path fillRule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                                    </button>
                                    {showRackDropdown && !form.has_tray && (
                                        <div className="absolute z-20 mt-1 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden">
                                            <div className="max-h-56 overflow-y-auto py-1">
                                                {racks.map(rack => (
                                                    <button key={rack.id} type="button" onClick={() => pickRack(rack)}
                                                        className={`w-full flex items-center justify-between gap-2 px-3.5 py-2 text-sm text-left transition-colors ${String(form.master_rack_id) === String(rack.id) ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold' : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'}`}
                                                    >
                                                        <span>{rack.rack_number}</span>
                                                    </button>
                                                ))}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Locator Number <span className="text-red-500">*</span></label>
                                <input type="text" value={form.locator_number} onChange={e => setForm({ ...form, locator_number: e.target.value })} required disabled={form.has_tray}
                                    className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-60 disabled:cursor-not-allowed" placeholder="e.g. LC-001" />
                                {form.has_tray && <p className="text-xs text-red-500 mt-1.5">Cannot edit because this locator is already assigned to a tray.</p>}
                            </div>
                            <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <button type="button" onClick={() => setShowModal(false)} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
                                <button type="submit" disabled={saving} className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-60">{saving ? 'Saving...' : 'Save'}</button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* MODAL DELETE */}
            {showDeleteModal && deleteTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden">
                        <div className="p-5 text-center">
                            <h3 className="text-lg font-bold text-zinc-800 dark:text-white">Delete Locator?</h3>
                            <p className="text-sm text-zinc-500 mt-2">Are you sure you want to delete <strong>{deleteTarget.locator_number}</strong>?</p>
                        </div>
                        <div className="flex justify-end gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700">
                            <button onClick={() => { setShowDeleteModal(false); setDeleteTarget(null) }} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
                            <button onClick={confirmDelete} disabled={!!deletingId} className="px-4 py-2 text-sm rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 disabled:opacity-60">{deletingId ? 'Deleting...' : 'Yes, Delete'}</button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL DETAIL TRAY */}
            {showDetailModal && detailLocator && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 max-h-[90vh] flex flex-col">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center rounded-t-2xl shrink-0">
                            <div>
                                <h2 className="text-base font-bold text-white">Tray List Detail</h2>
                                <p className="text-xs text-white/80 mt-0.5">Locator <strong>{detailLocator.locator_number}</strong> · Rack {detailLocator.rack_number ?? '-'}</p>
                            </div>
                            <button onClick={() => setShowDetailModal(false)} className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">✕</button>
                        </div>
                        <div className="p-0 overflow-y-auto">
                            {loadingDetail ? (
                                <div className="py-16 text-center text-sm text-zinc-400">Loading trays...</div>
                            ) : detailTrays.length === 0 ? (
                                <div className="py-16 text-center text-sm text-zinc-400">No trays assigned to this locator.</div>
                            ) : (
                                <table className="w-full text-sm min-w-max">
                                    <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700 sticky top-0 z-10">
                                        <tr className="whitespace-nowrap text-xs uppercase tracking-wider font-semibold text-zinc-500">
                                            <th className="px-4 py-3 w-12 text-center">#</th>
                                            <th className="px-4 py-3 text-center">Part Number</th>
                                            <th className="px-4 py-3 text-center">Item Code SAP</th>
                                            <th className="px-4 py-3 text-center">Desc</th>
                                            <th className="px-4 py-3 text-center">Model</th>
                                            <th className="px-4 py-3 text-center">Cav</th>
                                            <th className="px-4 py-3 text-center">Customer</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                        {detailTrays.map((tray, idx) => (
                                            <tr key={tray.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors whitespace-nowrap">
                                                <td className="px-4 py-3 text-center text-zinc-500 font-mono text-xs">{idx + 1}</td>
                                                <td className="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300 text-xs">{tray.part_number_tray}</td>
                                                <td className="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300 text-xs">{tray.item_code_sap}</td>
                                                <td className="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300 text-xs">{tray.desc}</td>
                                                <td className="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300 text-xs">{tray.model}</td>
                                                <td className="px-4 py-3 text-center text-zinc-700 dark:text-zinc-200 text-xs">{tray.cav_tray ?? '-'}</td>
                                                <td className="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300 text-xs">{tray.customer_name}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            )}
                        </div>
                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex justify-end shrink-0">
                            <button onClick={() => setShowDetailModal(false)} className="px-4 py-2 text-sm rounded-lg bg-zinc-200 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200 font-semibold hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL QR CODE (Print 1 atau Sekaligus) */}
            {showQrModal && qrTargets.length > 0 && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-5xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center shrink-0 print:hidden">
                            <h2 className="text-base font-bold text-white">Print QR Code</h2>
                            <button onClick={() => setShowQrModal(false)} className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">✕</button>
                        </div>

                        {/* Area yang akan diprint */}
                        <div className="p-6 overflow-y-auto bg-white flex-1">
                            {/* ⬇️ Tambahkan bg-white dan warna teks hitam di sini */}
                            <div id="qr-print-area" className="w-full bg-white text-black">
                                <table className="w-full border-collapse border border-zinc-300 bg-white">
                                    <tbody>
                                        {Array.from({ length: Math.ceil(qrTargets.length / 4) }).map((_, rowIndex) => (
                                            <tr key={rowIndex}>
                                                {qrTargets.slice(rowIndex * 4, rowIndex * 4 + 4).map((target) => (
                                                    // ⬇️ Pastikan td juga bg-white
                                                    <td key={target.id} className="border border-zinc-300 p-4 w-1/4 align-top bg-white">
                                                        <div className="flex flex-col items-center justify-center bg-white text-black h-full">
                                                            <QRCodeSVG 
                                                                value={target.locator_number} 
                                                                size={140}
                                                                level="H"
                                                                includeMargin={false}
                                                                bgColor="#ffffff" // ⬅️ Paksa QR Code background putih
                                                                fgColor="#000000" // ⬅️ Paksa QR Code warna hitam
                                                            />
                                                            <h4 className="mt-4 print:mt-3 text-sm font-bold text-center break-all leading-tight text-black print:text-[10px]">
                                                                {target.locator_number}
                                                            </h4>
                                                        </div>
                                                    </td>
                                                ))}
                                                {Array.from({ length: 4 - qrTargets.slice(rowIndex * 4, rowIndex * 4 + 4).length }).map((_, emptyIdx) => (
                                                    <td key={`empty-${emptyIdx}`} className="border border-zinc-300 p-4 w-1/4 bg-white"></td>
                                                ))}
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2 shrink-0 print:hidden">
                            <button onClick={() => setShowQrModal(false)} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                Close
                            </button>
                            <button onClick={handlePrintQr} className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                    <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5ZM15 9.75a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V10.5a.75.75 0 0 0-.75-.75H15Z" clip-rule="evenodd" />
                                </svg>
                                Print
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