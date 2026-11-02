import React, { useState, useMemo, useRef, useEffect } from 'react'

export default function MasterRack({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0,
    })
    const permissions = mingleData?.permissions ?? { canCreate: false, canEdit: false, canDelete: false }
    const areaOptions = mingleData?.areaOptions ?? ['Router', 'PKG']

    const [search, setSearch]           = useState('')
    const [loadingPage, setLoadingPage] = useState(false)
    const [saving, setSaving]           = useState(false)
    const [deletingId, setDeletingId]   = useState(null)
    const [toast, setToast]             = useState(null)

    const [showModal, setShowModal] = useState(false)
    const [form, setForm]           = useState({
        id: null,
        rack_number: '',
        area: '',
        areaMode: 'select', // 'select' | 'manual'
    })

    // Custom dropdown state
    const [showAreaDropdown, setShowAreaDropdown] = useState(false)
    const areaDropdownRef = useRef(null)

    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget]       = useState(null)

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    // Combined areas: defaults + custom areas from existing data
    const allAreaOptions = useMemo(() => {
        const set = new Set(areaOptions)
        rows.forEach(r => { if (r.area) set.add(r.area) })
        return Array.from(set)
    }, [areaOptions, rows])

    // Close dropdown on outside click
    useEffect(() => {
        const handler = (e) => {
            if (areaDropdownRef.current && !areaDropdownRef.current.contains(e.target)) {
                setShowAreaDropdown(false)
            }
        }
        document.addEventListener('mousedown', handler)
        return () => document.removeEventListener('mousedown', handler)
    }, [])

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

    const openCreate = () => {
        if (!permissions.canCreate) return
        setForm({ id: null, rack_number: '', area: '', areaMode: 'select' })
        setShowAreaDropdown(false)
        setShowModal(true)
    }

    const openEdit = (row) => {
        if (!permissions.canEdit) return
        const isCustom = row.area && !areaOptions.includes(row.area)
        setForm({
            id: row.id,
            rack_number: row.rack_number,
            area: row.area ?? '',
            areaMode: isCustom ? 'manual' : 'select',
        })
        setShowAreaDropdown(false)
        setShowModal(true)
    }

    const pickArea = (val) => {
        setForm({ ...form, area: val })
        setShowAreaDropdown(false)
    }

    const activateManual = () => {
        setForm({ ...form, areaMode: 'manual', area: '' })
        setShowAreaDropdown(false)
    }

    const backToSelect = () => {
        setForm({ ...form, areaMode: 'select', area: '' })
    }

    const handleSave = async (e) => {
        e.preventDefault()
        setSaving(true)
        try {
            const payload = {
                id: form.id,
                rack_number: form.rack_number,
                area: (form.area || '').trim() || null,
            }
            const result = await wire.save(payload)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
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

    const openDeleteConfirm = (row) => {
        if (!permissions.canDelete) return
        setDeleteTarget(row)
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

    const filtered = search.trim()
        ? rows.filter(r =>
            (r.rack_number ?? '').toLowerCase().includes(search.toLowerCase()) ||
            (r.area ?? '').toLowerCase().includes(search.toLowerCase()))
        : rows

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
                <span className="shrink-0 font-semibold text-black dark:text-white">Tray Monitoring</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Master</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Master Rack</span>
            </nav>

            {/* HEADER */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">
                        Master Rack
                    </h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Storage rack master data
                    </p>
                </div>
                {permissions.canCreate && (
                    <button
                        onClick={openCreate}
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                            <path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                        </svg>
                        Add Rack
                    </button>
                )}
            </div>

            {/* TABLE CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">

                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6 text-white shrink-0">
                            <path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" />
                            <path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375ZM6 12a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V12Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 15a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V15Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM6 18a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H6.75a.75.75 0 0 1-.75-.75V18Zm2.25 0a.75.75 0 0 1 .75-.75h3.75a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Rack List</span>
                    </div>
                    <div className="relative w-full sm:w-72">
                        <input
                            type="text"
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            placeholder="Search rack / area..."
                            className="w-full pl-3 pr-3 py-2 text-sm rounded-lg border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm"
                        />
                    </div>
                </div>

                <div className="overflow-x-auto">
                    {loadingPage ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Loading data...</div>
                    ) : filtered.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">
                            {search ? 'No matching results' : 'No racks yet'}
                        </div>
                    ) : (
                        <table className="w-full text-sm min-w-max">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr className="whitespace-nowrap">
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 w-16">#</th>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Rack Number</th>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Area</th>
                                    <th className="hidden md:table-cell px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Created By</th>
                                    <th className="hidden md:table-cell px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Created Date</th>
                                    <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500 w-40">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {filtered.map((row, idx) => (
                                    <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors whitespace-nowrap">
                                        <td className="px-4 py-3 text-zinc-500 font-mono text-xs">
                                            {(pagination.current_page - 1) * pagination.per_page + idx + 1}
                                        </td>
                                        <td className="px-4 py-3 font-semibold text-zinc-800 dark:text-zinc-100">{row.rack_number}</td>
                                        <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300">
                                            {row.area ? (
                                                <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                                    {row.area}
                                                </span>
                                            ) : '-'}
                                        </td>
                                        <td className="hidden md:table-cell px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_by_name ?? '-'}</td>
                                        <td className="hidden md:table-cell px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_at ?? '-'}</td>
                                        <td className="px-4 py-3">
                                            <div className="flex items-center justify-center gap-1.5">
                                                
                                                {/* Tombol Edit */}
                                                {permissions.canEdit && (
                                                    <div className="relative group flex items-center justify-center">
                                                        <button 
                                                            onClick={() => openEdit(row)} 
                                                            disabled={row.has_relation}
                                                            className={`inline-flex items-center gap-1 px-2 py-1 text-[11px] font-semibold rounded transition-colors ${
                                                                row.has_relation 
                                                                    ? 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600 cursor-not-allowed' 
                                                                    : 'bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/40 dark:hover:bg-amber-900/60 dark:text-amber-300'
                                                            }`}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                        
                                                        {/* Tooltip */}
                                                        <div className="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-50">
                                                            <span className="relative z-10 p-1.5 text-[10px] leading-none text-white bg-zinc-800 dark:bg-zinc-700 rounded shadow-md whitespace-nowrap">
                                                                {row.has_relation ? 'Tidak dapat diedit karena sudah dipakai' : 'Edit Rack'}
                                                            </span>
                                                            <div className="w-2 h-2 -mt-1 bg-zinc-800 dark:bg-zinc-700 rotate-45"></div>
                                                        </div>
                                                    </div>
                                                )}

                                                {/* Tombol Delete */}
                                                {permissions.canDelete && (
                                                    <div className="relative group flex items-center justify-center">
                                                        <button 
                                                            onClick={() => openDeleteConfirm(row)} 
                                                            disabled={row.has_relation}
                                                            className={`inline-flex items-center gap-1 px-2 py-1 text-[11px] font-semibold rounded transition-colors ${
                                                                row.has_relation 
                                                                    ? 'bg-zinc-100 text-zinc-400 dark:bg-zinc-800 dark:text-zinc-600 cursor-not-allowed' 
                                                                    : 'bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:hover:bg-red-900/60 dark:text-red-300'
                                                            }`}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                                <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clipRule="evenodd" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                        
                                                        {/* Tooltip */}
                                                        <div className="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-50">
                                                            <span className="relative z-10 p-1.5 text-[10px] leading-none text-white bg-zinc-800 dark:bg-zinc-700 rounded shadow-md whitespace-nowrap">
                                                                {row.has_relation ? 'Tidak dapat dihapus karena sudah dipakai' : 'Hapus Rack'}
                                                            </span>
                                                            <div className="w-2 h-2 -mt-1 bg-zinc-800 dark:bg-zinc-700 rotate-45"></div>
                                                        </div>
                                                    </div>
                                                )}

                                                {/* Jika user tidak punya permission edit & delete sama sekali */}
                                                {(!permissions.canEdit && !permissions.canDelete) && (
                                                    <span className="text-xs text-zinc-400 italic">No Action</span>
                                                )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
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

            {/* MODAL FORM */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-visible border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center rounded-t-2xl">
                            <h2 className="text-base font-bold text-white">{form.id ? 'Edit Rack' : 'Add Rack'}</h2>
                            <button onClick={() => setShowModal(false)} className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">✕</button>
                        </div>
                        <form onSubmit={handleSave} className="p-5 space-y-4">
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                    Rack Number <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    value={form.rack_number}
                                    onChange={e => setForm({ ...form, rack_number: e.target.value })}
                                    required
                                    className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="e.g. RK-001"
                                />
                            </div>

                            {/* AREA */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                    Area
                                </label>

                                {form.areaMode === 'select' ? (
                                    <div className="relative" ref={areaDropdownRef}>
                                        {/* Trigger */}
                                        <button
                                            type="button"
                                            onClick={() => setShowAreaDropdown(v => !v)}
                                            className="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-left text-zinc-800 dark:text-zinc-100 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                        >
                                            <span className={form.area ? '' : 'text-zinc-400 dark:text-zinc-500'}>
                                                {form.area || '-- Select Area --'}
                                            </span>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                className={`w-4 h-4 text-zinc-400 shrink-0 transition-transform duration-200 ${showAreaDropdown ? 'rotate-180' : ''}`}
                                            >
                                                <path fillRule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                            </svg>
                                        </button>

                                        {/* Menu */}
                                        {showAreaDropdown && (
                                            <div className="absolute z-20 mt-1 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden">
                                                <div className="max-h-56 overflow-y-auto py-1">
                                                    {allAreaOptions.map(opt => (
                                                        <button
                                                            key={opt}
                                                            type="button"
                                                            onClick={() => pickArea(opt)}
                                                            className={`w-full flex items-center justify-between gap-2 px-3.5 py-2 text-sm text-left transition-colors ${
                                                                form.area === opt
                                                                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold'
                                                                    : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                                                            }`}
                                                        >
                                                            <span>{opt}</span>
                                                            {form.area === opt && (
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                                                    <path fillRule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clipRule="evenodd" />
                                                                </svg>
                                                            )}
                                                        </button>
                                                    ))}
                                                </div>

                                                {/* Divider + Add Manual */}
                                                <div className="border-t border-zinc-200 dark:border-zinc-700">
                                                    <button
                                                        type="button"
                                                        onClick={activateManual}
                                                        className="w-full flex items-center gap-2 px-3.5 py-2.5 text-sm text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 font-semibold transition-colors"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                            <path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                                                        </svg>
                                                        Add Manual
                                                    </button>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                ) : (
                                    <div className="space-y-1.5">
                                        <input
                                            type="text"
                                            value={form.area}
                                            onChange={e => setForm({ ...form, area: e.target.value })}
                                            autoFocus
                                            className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-blue-400 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Type custom area..."
                                        />
                                        <button
                                            type="button"
                                            onClick={backToSelect}
                                            className="inline-flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400 hover:underline"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-3 h-3">
                                                <path fillRule="evenodd" d="M12.79 5.23a.75.75 0 0 1-.02 1.06L8.832 10l3.938 3.71a.75.75 0 1 1-1.04 1.08l-4.5-4.25a.75.75 0 0 1 0-1.08l4.5-4.25a.75.75 0 0 1 1.06.02Z" clipRule="evenodd" />
                                            </svg>
                                            Back to options
                                        </button>
                                    </div>
                                )}
                            </div>

                            <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <button type="button" onClick={() => setShowModal(false)} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                    Cancel
                                </button>
                                <button type="submit" disabled={saving} className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-60">
                                    {saving ? 'Saving...' : 'Save'}
                                </button>
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
                            <h3 className="text-lg font-bold text-zinc-800 dark:text-white">Delete Rack?</h3>
                            <p className="text-sm text-zinc-500 mt-2">Are you sure you want to delete <strong>{deleteTarget.rack_number}</strong>?</p>
                        </div>
                        <div className="flex justify-end gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t">
                            <button onClick={() => setShowDeleteModal(false)} className="px-4 py-2 text-sm rounded-lg border">Cancel</button>
                            <button onClick={confirmDelete} disabled={!!deletingId} className="px-4 py-2 text-sm rounded-lg bg-red-600 text-white font-semibold">
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