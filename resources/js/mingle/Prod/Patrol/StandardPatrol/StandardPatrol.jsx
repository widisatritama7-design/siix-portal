import React, { useState, useMemo } from 'react'

export default function StandardPatrol({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1,
        last_page:    1,
        per_page:     10,
        total:        0,
        from:         0,
        to:           0,
    })
    const [linesList, setLinesList]   = useState(mingleData?.lines ?? [])
    
    // STATE BARU: MASTER LINES
    const [masterLinesList, setMasterLinesList] = useState(mingleData?.masterLines ?? [])
    const [selectedMasterLines, setSelectedMasterLines] = useState([])
    const [masterLineSearch, setMasterLineSearch] = useState('')

    // STATE PERMISSIONS
    const permissions = mingleData?.permissions ?? {
        canCreate: false,
        canEdit: false,
        canDelete: false
    }

    const [search, setSearch]           = useState('')
    const [loadingPage, setLoadingPage] = useState(false)
    const [saving, setSaving]           = useState(false)
    const [deletingLine, setDeletingLine] = useState(null)
    const [toast, setToast]             = useState(null)
    
    // Delete confirm modal state
    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget] = useState(null)  // { line, count }

    // State untuk Modal View
    const [showViewModal, setShowViewModal] = useState(false)
    const [viewTarget, setViewTarget] = useState(null)

    const [expandedLines, setExpandedLines] = useState([])

    // Modal state
    const [showModal, setShowModal] = useState(false)
    const [formLine, setFormLine]   = useState('')
    const [items, setItems]         = useState([
        { id: null, item_check: '', standard: '' }
    ])
    const [editingLine, setEditingLine] = useState(null)  // untuk mode edit line

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    const gotoPage = async (page) => {
        if (page < 1 || page > pagination.last_page || page === pagination.current_page) return
        setLoadingPage(true)
        try {
            const result = await wire.gotoPage(page)
            setRows(result.rows)
            setPagination(result.pagination)
            setLinesList(result.lines ?? [])
            setMasterLinesList(result.masterLines ?? [])
        } catch (e) {
            showToast('Gagal pindah halaman: ' + e.message, 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    // ===== Modal: Open =====
    const openCreate = () => {
        if (!permissions.canCreate) return
        setEditingLine(null)
        setFormLine('')
        setItems([{ id: null, item_check: '', standard: '' }])
        setSelectedMasterLines([])
        setMasterLineSearch('')
        setShowModal(true)
    }

    const openEditLine = async (line) => {
        if (!permissions.canEdit) return
        try {
            const data = await wire.getLineItems(line)
            setEditingLine(line)
            setFormLine(line)
            setItems(
                data.items?.length > 0
                    ? data.items.map(i => ({ id: i.id, item_check: i.item_check, standard: i.standard }))
                    : [{ id: null, item_check: '', standard: '' }]
            )
            setSelectedMasterLines(data.master_line_ids ?? [])
            setMasterLineSearch('')
            setShowModal(true)
        } catch (e) {
            showToast('Gagal load data line: ' + e.message, 'error')
        }
    }

    // ===== Item handlers =====
    const addItem = () => {
        setItems([...items, { id: null, item_check: '', standard: '' }])
    }

    const removeItem = (idx) => {
        if (items.length === 1) {
            showToast('Minimal 1 item', 'error')
            return
        }
        setItems(items.filter((_, i) => i !== idx))
    }

    const updateItem = (idx, field, value) => {
        const next = [...items]
        next[idx][field] = value
        setItems(next)
    }

    // ===== Save =====
    const handleSave = async (e) => {
        e.preventDefault()
        
        if (selectedMasterLines.length === 0) {
            showToast('Pilih minimal 1 Master Line', 'error')
            return
        }

        setSaving(true)
        try {
            const result = await wire.saveBatch({
                line: formLine,
                items: items,
                master_line_ids: selectedMasterLines,
            })

            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                setLinesList(result.data.lines ?? [])
                setMasterLinesList(result.data.masterLines ?? [])
                showToast(result.message, 'success')
                setShowModal(false)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Gagal menyimpan: ' + e.message, 'error')
        } finally {
            setSaving(false)
        }
    }

    // ===== DELETE LINE - Open Confirm Modal =====
    const openDeleteConfirm = (line, count) => {
        if (!permissions.canDelete) return
        setDeleteTarget({ line, count })
        setShowDeleteModal(true)
    }

    // ===== VIEW LINE - Open Modal =====
    const openViewModal = (group) => {
        setViewTarget(group)
        setShowViewModal(true)
    }

    // ===== DELETE LINE - Confirm Handler =====
    const confirmDelete = async () => {
        if (!deleteTarget) return
        const { line } = deleteTarget

        setDeletingLine(line)
        try {
            const result = await wire.deleteLine(line)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                setLinesList(result.data.lines ?? [])
                showToast(result.message, 'success')
                setShowDeleteModal(false)
                setDeleteTarget(null)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Gagal hapus line: ' + e.message, 'error')
        } finally {
            setDeletingLine(null)
        }
    }

    // ===== Group by Line =====
    const groupedRows = useMemo(() => {
        const groups = {}
        rows.forEach(row => {
            const line = row.line || '(tanpa line)'
            if (!groups[line]) {
                groups[line] = { line, items: [], latestUpdate: row.updated_at, masterLines: row.master_lines || [] }
            }
            groups[line].items.push(row)
            if (row.updated_at > groups[line].latestUpdate) {
                groups[line].latestUpdate = row.updated_at
            }
        })
        return Object.values(groups)
    }, [rows])

    // ===== Search filter (group-level) =====
    const filteredGroups = search.trim()
        ? groupedRows
            .map(g => ({
                ...g,
                items: g.items.filter(it =>
                    (it.line ?? '').toLowerCase().includes(search.toLowerCase()) ||
                    (it.item_check ?? '').toLowerCase().includes(search.toLowerCase()) ||
                    (it.standard ?? '').toLowerCase().includes(search.toLowerCase())
                )
            }))
            .filter(g => g.items.length > 0)
        : groupedRows

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

    const totalItems = filteredGroups.reduce((sum, g) => sum + g.items.length, 0)

    const filteredMasterLines = (masterLinesList ?? []).filter(ml => {
        const searchLower = masterLineSearch.toLowerCase();
        const lineStr = String(ml?.line_number ?? '').toLowerCase();
        const locStr = String(ml?.location ?? '').toLowerCase();
        return lineStr.includes(searchLower) || locStr.includes(searchLower);
    })

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
                <span className="font-semibold text-black dark:text-white shrink-0">Standard Patrol</span>
            </nav>

            {/* ============ HEADER ============ */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">
                        Standard Patrol
                    </h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Master standar pemeriksaan patrol per line
                    </p>
                </div>

                {permissions.canCreate && (
                    <div className="flex items-center gap-2 flex-wrap">
                        <button
                            onClick={openCreate}
                            className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold transition-all shadow-sm hover:shadow-md"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                <path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                            </svg>
                            New Standard
                        </button>
                    </div>
                )}
            </div>

            {/* ============ TABLE CARD ============ */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">

                {/* Card Header + Search */}
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100">
                            <path fillRule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 1 1-1.06 1.06l-.621-.62A3.75 3.75 0 0 1 12 22.5a3.75 3.75 0 0 1-3.348-2.09l-.62.62a.75.75 0 0 1-1.061-1.06l.621-.621c.422-.422.659-.995.659-1.591V18h-3a3 3 0 0 1-3-3V5.25Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">
                            Daftar Line & Standard
                        </span>
                    </div>

                    <div className="relative w-full sm:w-72">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input
                            type="text"
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            placeholder="Cari line, item, atau standard..."
                            className="w-full pl-10 pr-3 py-2 text-sm rounded-lg border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm"
                        />
                    </div>
                </div>

                {/* Grouped Table */}
                <div className="overflow-x-auto">
                    {loadingPage ? (
                        <div className="px-4 py-16 text-center text-sm text-zinc-400">
                            <div className="flex flex-col items-center justify-center gap-2">
                                <svg className="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                <span>Memuat data...</span>
                            </div>
                        </div>
                    ) : filteredGroups.length === 0 ? (
                        <div className="px-4 py-16 text-center">
                            <div className="flex flex-col items-center gap-2 text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" className="w-12 h-12">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                </svg>
                                <p className="text-sm font-medium">
                                    {search ? 'Tidak ada hasil untuk pencarian ini' : 'Belum ada data Standard Patrol'}
                                </p>
                                {!search && permissions.canCreate && (
                                    <button onClick={openCreate} className="mt-2 text-sm text-blue-600 hover:text-blue-700 font-medium">
                                        + Tambah line sekarang
                                    </button>
                                )}
                            </div>
                        </div>
                    ) : (
                        <table className="w-full text-sm min-w-[900px] table-fixed">
                            <colgroup>
                                <col className="w-44" />
                                <col className="w-14" />
                                <col className="w-1/3" />
                                <col className="w-1/3" />
                                <col className="w-48" />
                            </colgroup>
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 whitespace-nowrap">Line</th>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 whitespace-nowrap">#</th>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 whitespace-nowrap">Item Check</th>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 whitespace-nowrap">Standard</th>
                                    <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {filteredGroups.map((group) => (
                                    <React.Fragment key={group.line}>
                                        {/* Group header row */}
                                        <tr className="bg-blue-50/50 dark:bg-blue-950/20 border-t-2 border-blue-200 dark:border-blue-800">
                                            <td className="px-4 py-3 whitespace-nowrap">
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-600 text-white text-xs font-bold whitespace-nowrap">
                                                    <span className="truncate max-w-[140px]" title={group.line}>{group.line}</span>
                                                </span>
                                            </td>
                                            <td colSpan={3} className="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                                                <div className="flex items-center justify-end gap-2 flex-wrap">
                                                    
                                                    {group.masterLines && group.masterLines.length > 0 && (
                                                        <>
                                                            {group.masterLines.slice(0, 3).map(ml => (
                                                                <span 
                                                                    key={ml.id} 
                                                                    className="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[10px] font-bold"
                                                                    title={ml.location ? `Area: ${ml.location}` : ml.line_number}
                                                                >
                                                                    {ml.line_number}
                                                                    {ml.location && (
                                                                        <span className="text-emerald-500 dark:text-emerald-500 font-normal">
                                                                            • {ml.location}
                                                                        </span>
                                                                    )}
                                                                </span>
                                                            ))}

                                                            {group.masterLines.length > 3 && (
                                                                <button
                                                                    onClick={() => openViewModal(group)}
                                                                    className="inline-flex items-center px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 text-[10px] font-bold hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition-colors cursor-pointer"
                                                                    title="Lihat semua Master Line"
                                                                >
                                                                    +{group.masterLines.length - 3} Line
                                                                </button>
                                                            )}

                                                            <span className="text-zinc-300 dark:text-zinc-600">|</span>
                                                        </>
                                                    )}

                                                    <span>
                                                        <span className="font-semibold text-zinc-700 dark:text-zinc-200">{group.items.length}</span> item check
                                                    </span>
                                                    <span className="text-zinc-400 dark:text-zinc-500">•</span>
                                                    <span>
                                                        Update terakhir: <span className="font-medium text-zinc-700 dark:text-zinc-200">{group.latestUpdate || '-'}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td className="px-4 py-3">
                                                <div className="flex items-center justify-center gap-1.5">
                                                    
                                                    {/* TOMBOL EDIT */}
                                                    {permissions.canEdit && (
                                                        <button
                                                            onClick={() => openEditLine(group.line)}
                                                            className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold transition-colors shadow-sm whitespace-nowrap"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5 flex-shrink-0">
                                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                            </svg>
                                                            Edit
                                                        </button>
                                                    )}

                                                    {/* TOMBOL HAPUS */}
                                                    {permissions.canDelete && (
                                                        <button
                                                            onClick={() => openDeleteConfirm(group.line, group.items.length)}
                                                            disabled={deletingLine === group.line}
                                                            className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition-colors shadow-sm disabled:opacity-50 whitespace-nowrap"
                                                        >
                                                            {deletingLine === group.line ? (
                                                                <svg className="animate-spin h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                                </svg>
                                                            ) : (
                                                                <>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5 flex-shrink-0">
                                                                        <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Z" clipRule="evenodd" />
                                                                    </svg>
                                                                    Hapus
                                                                </>
                                                            )}
                                                        </button>
                                                    )}

                                                    {(!permissions.canEdit && !permissions.canDelete) && (
                                                        <span className="text-xs text-zinc-400 italic">No Action</span>
                                                    )}
                                                </div>
                                            </td>
                                        </tr>
                                        {/* Item rows */}
                                        {(() => {
                                            const isExpanded = expandedLines.includes(group.line)
                                            const displayItems = isExpanded ? group.items : group.items.slice(0, 5)
                                            const hasMore = group.items.length > 5

                                            return (
                                                <>
                                                    {displayItems.map((row, idx) => (
                                                        <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors">
                                                            <td className="px-4 py-3 whitespace-nowrap text-zinc-400 dark:text-zinc-500 text-xs"></td>
                                                            <td className="px-4 py-3 text-zinc-500 dark:text-zinc-400 font-mono text-xs whitespace-nowrap">
                                                                {idx + 1}
                                                            </td>
                                                            <td className="px-4 py-3 font-semibold text-zinc-800 dark:text-zinc-100 truncate whitespace-nowrap" title={row.item_check || '-'}>
                                                                {row.item_check || '-'}
                                                            </td>
                                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 truncate whitespace-nowrap" title={row.standard || '-'}>
                                                                {row.standard || '-'}
                                                            </td>
                                                            <td className="px-4 py-3"></td>
                                                        </tr>
                                                    ))}

                                                    {hasMore && !isExpanded && (
                                                        <tr>
                                                            <td colSpan={5} className="px-4 py-2 text-center bg-zinc-50/50 dark:bg-zinc-800/20 border-t border-zinc-100 dark:border-zinc-800">
                                                                <button
                                                                    onClick={() => setExpandedLines([...expandedLines, group.line])}
                                                                    className="inline-flex items-center gap-1 text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors"
                                                                >
                                                                    ... dan {group.items.length - 5} item lainnya
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-3 h-3">
                                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    )}

                                                    {hasMore && isExpanded && (
                                                        <tr>
                                                            <td colSpan={5} className="px-4 py-2 text-center bg-zinc-50/50 dark:bg-zinc-800/20 border-t border-zinc-100 dark:border-zinc-800">
                                                                <button
                                                                    onClick={() => setExpandedLines(expandedLines.filter(l => l !== group.line))}
                                                                    className="inline-flex items-center gap-1 text-xs font-bold text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-200 transition-colors"
                                                                >
                                                                    Sembunyikan item lainnya
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-3 h-3">
                                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M5 15l7-7 7 7" />
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    )}
                                                </>
                                            )
                                        })()}
                                    </React.Fragment>
                                ))}
                            </tbody>
                        </table>
                    )}
                </div>

                {/* ============ PAGINATION ============ */}
                {pagination.last_page > 1 && (
                    <div className="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div className="text-sm text-zinc-500 dark:text-zinc-400 text-center sm:text-left whitespace-nowrap">
                            Menampilkan{' '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.from ?? 0}</strong>
                            {' - '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.to ?? 0}</strong>
                            {' dari '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.total}</strong>
                            {' item'}
                        </div>

                        <div className="flex items-center justify-center sm:justify-end gap-1 flex-wrap">
                            <button
                                onClick={() => gotoPage(pagination.current_page - 1)}
                                disabled={pagination.current_page === 1 || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap"
                            >
                                Prev
                            </button>

                            {getPageNumbers().map((p, idx) =>
                                p === '...' ? (
                                    <span key={`dots-${idx}`} className="px-2 text-zinc-400 text-sm">...</span>
                                ) : (
                                    <button
                                        key={p}
                                        onClick={() => gotoPage(p)}
                                        disabled={loadingPage}
                                        className={`min-w-[34px] px-2.5 py-1.5 text-sm rounded-lg border transition-all whitespace-nowrap ${
                                            p === pagination.current_page
                                                ? 'bg-blue-600 border-blue-600 text-white font-bold shadow-sm'
                                                : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300'
                                        } disabled:opacity-40 disabled:cursor-not-allowed`}
                                    >
                                        {p}
                                    </button>
                                )
                            )}

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

            {/* ============ MODAL FORM ============ */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden max-h-[90vh] flex flex-col">

                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-between flex-shrink-0">
                            <div className="flex items-center gap-2.5">
                                <div className="w-9 h-9 rounded-lg bg-white/20 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white">
                                        <path fillRule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5Z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 className="text-base font-bold text-white">
                                        {editingLine ? `Edit Line: ${editingLine}` : 'Tambah Line Baru'}
                                    </h2>
                                    <p className="text-xs text-blue-100">
                                        {editingLine ? 'Perbarui item check & standard' : 'Tambah 1 line dengan banyak item check'}
                                    </p>
                                </div>
                            </div>
                            <button onClick={() => setShowModal(false)} className="p-1.5 rounded-lg hover:bg-white/20 text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form onSubmit={handleSave} className="flex-1 overflow-y-auto">
                            <div className="p-5 space-y-4">

                                {/* Line Input */}
                                <div>
                                    <label className="flex items-center gap-1.5 text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-blue-500">
                                            <path fillRule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5Z" clipRule="evenodd" />
                                        </svg>
                                        Line <span className="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        value={formLine}
                                        onChange={e => setFormLine(e.target.value)}
                                        required
                                        disabled={!!editingLine}
                                        list="lines-list"
                                        className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all disabled:bg-zinc-100 dark:disabled:bg-zinc-800 disabled:opacity-70"
                                        placeholder="Contoh: LINE-A"
                                    />
                                    <datalist id="lines-list">
                                        {linesList.map(l => <option key={l} value={l} />)}
                                    </datalist>
                                    {editingLine && (
                                        <p className="text-xs text-zinc-500 mt-1">
                                            Line tidak bisa diubah saat edit. Kalau perlu, hapus dan buat baru.
                                        </p>
                                    )}
                                </div>

                                {/* ===== MASTER LINE MULTI-SELECT ===== */}
                                <div>
                                    <label className="flex items-center gap-1.5 text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-blue-500">
                                            <path fillRule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5Z" clipRule="evenodd" />
                                        </svg>
                                        Master Line <span className="text-red-500">*</span>
                                        <span className="ml-1 text-xs font-normal text-zinc-500">
                                            ({selectedMasterLines.length} dipilih)
                                        </span>
                                    </label>

                                    <div className="relative mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <input
                                            type="text"
                                            placeholder="Cari master line..."
                                            value={masterLineSearch}
                                            onChange={e => setMasterLineSearch(e.target.value)}
                                            className="w-full pl-10 pr-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        />
                                    </div>

                                    <div className="max-h-56 overflow-y-auto rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/40 p-2 space-y-1">
                                        {filteredMasterLines.length === 0 ? (
                                            <div className="text-center text-xs text-zinc-400 py-3">Tidak ada master line cocok</div>
                                        ) : (
                                            filteredMasterLines.map(ml => (
                                                <label 
                                                    key={ml.id} 
                                                    className={`flex items-center justify-between gap-2 px-3 py-2 rounded-md cursor-pointer transition-colors border ${
                                                        selectedMasterLines.includes(ml.id) 
                                                            ? 'bg-blue-50 border-blue-200 dark:bg-blue-900/30 dark:border-blue-800' 
                                                            : 'bg-white border-transparent hover:bg-zinc-100 dark:bg-zinc-800 dark:hover:bg-zinc-700'
                                                    }`}
                                                >
                                                    <div className="flex items-center gap-3">
                                                        <input
                                                            type="checkbox"
                                                            checked={selectedMasterLines.includes(ml.id)}
                                                            onChange={e => {
                                                                if (e.target.checked) {
                                                                    setSelectedMasterLines([...selectedMasterLines, ml.id])
                                                                } else {
                                                                    setSelectedMasterLines(selectedMasterLines.filter(id => id !== ml.id))
                                                                }
                                                            }}
                                                            className="w-4 h-4 rounded border-zinc-300 text-blue-600 focus:ring-blue-500"
                                                        />
                                                        <span className="text-sm font-bold text-zinc-800 dark:text-zinc-200 font-mono">
                                                            {ml.line_number}
                                                        </span>
                                                    </div>
                                                    
                                                    {ml.location && (
                                                        <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-semibold bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3 h-3 text-zinc-400">
                                                                <path fillRule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clipRule="evenodd" />
                                                            </svg>
                                                            {ml.location}
                                                        </span>
                                                    )}
                                                </label>
                                            ))
                                        )}
                                    </div>

                                    <div className="flex gap-2 mt-2">
                                        <button type="button" onClick={() => setSelectedMasterLines(filteredMasterLines.map(ml => ml.id))} className="text-xs text-blue-600 hover:text-blue-700 font-medium">
                                            Pilih semua
                                        </button>
                                        <span className="text-zinc-300">•</span>
                                        <button type="button" onClick={() => setSelectedMasterLines([])} className="text-xs text-red-600 hover:text-red-700 font-medium">
                                            Hapus semua
                                        </button>
                                    </div>
                                </div>

                                {/* Items List */}
                                <div>
                                    <div className="flex items-center justify-between mb-2">
                                        <label className="flex items-center gap-1.5 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-blue-500">
                                                <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 0 1 3.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0 1 21 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 0 1 7.5 16.125V3.375Z" />
                                            </svg>
                                            Item Check & Standard <span className="text-red-500">*</span>
                                        </label>
                                        <span className="text-xs text-zinc-500">{items.length} item</span>
                                    </div>

                                    <div className="space-y-2 max-h-[400px] overflow-y-auto pr-1">
                                        {items.map((it, idx) => (
                                            <div key={idx} className="grid grid-cols-12 gap-2 items-start p-2.5 rounded-lg bg-zinc-50 dark:bg-zinc-800/40 border border-zinc-200 dark:border-zinc-700">
                                                <div className="col-span-1 flex items-center justify-center pt-2.5">
                                                    <span className="w-6 h-6 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center">
                                                        {idx + 1}
                                                    </span>
                                                </div>
                                                <div className="col-span-5">
                                                    <input
                                                        type="text"
                                                        value={it.item_check}
                                                        onChange={e => updateItem(idx, 'item_check', e.target.value)}
                                                        required
                                                        className="w-full px-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        placeholder="Item check, mis: Suhu Soldering"
                                                    />
                                                </div>
                                                <div className="col-span-5">
                                                    <input
                                                        type="text"
                                                        value={it.standard}
                                                        onChange={e => updateItem(idx, 'standard', e.target.value)}
                                                        required
                                                        className="w-full px-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                        placeholder="Standard, mis: 350°C ± 10°C"
                                                    />
                                                </div>
                                                <div className="col-span-1 flex justify-center pt-1.5">
                                                    <button
                                                        type="button"
                                                        onClick={() => removeItem(idx)}
                                                        disabled={items.length === 1}
                                                        className="p-1.5 rounded-md text-red-500 hover:bg-red-50 dark:hover:bg-red-950/30 transition-colors disabled:opacity-30 disabled:cursor-not-allowed"
                                                        title="Hapus item"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                            <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Z" clipRule="evenodd" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        ))}
                                    </div>

                                    <button
                                        type="button"
                                        onClick={addItem}
                                        className="mt-2 inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg border-2 border-dashed border-blue-300 dark:border-blue-700 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-colors w-full justify-center"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                            <path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                                        </svg>
                                        Tambah Item Check
                                    </button>
                                </div>

                            </div>

                            <div className="flex items-center justify-between gap-2 px-5 py-4 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                                <div className="text-xs text-zinc-500 dark:text-zinc-400">
                                    Total: <strong className="text-zinc-700 dark:text-zinc-200">{items.length} item</strong>
                                </div>
                                <div className="flex items-center gap-2">
                                    <button
                                        type="button"
                                        onClick={() => setShowModal(false)}
                                        className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-medium transition-colors"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={saving}
                                        className="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors shadow-sm disabled:opacity-60 disabled:cursor-not-allowed"
                                    >
                                        {saving ? (
                                            <>
                                                <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                                    <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                Menyimpan...
                                            </>
                                        ) : (
                                            <>
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                    <path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" />
                                                </svg>
                                                {editingLine ? 'Update Semua Item' : 'Simpan Semua Item'}
                                            </>
                                        )}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* ============ MODAL VIEW ============ */}
            {showViewModal && viewTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden max-h-[90vh] flex flex-col">
                        
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center justify-between flex-shrink-0">
                            <div className="flex items-center gap-3">
                                <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white">
                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                        <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 className="text-lg font-bold text-white">Detail Line: {viewTarget.line}</h2>
                                    <p className="text-xs text-blue-100">Informasi Master Line & Item Check</p>
                                </div>
                            </div>
                            <button
                                onClick={() => setShowViewModal(false)}
                                className="p-1.5 rounded-lg hover:bg-white/20 text-white transition-colors"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div className="p-5 overflow-y-auto space-y-6">
                            
                            <div>
                                <h3 className="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-2 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-blue-500">
                                        <path fillRule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5Z" clipRule="evenodd" />
                                    </svg>
                                    Master Line Terkait
                                    <span className="ml-auto text-[10px] bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 px-2 py-0.5 rounded-full font-bold">
                                        {viewTarget.masterLines?.length || 0} Line
                                    </span>
                                </h3>
                                
                                {(!viewTarget.masterLines || viewTarget.masterLines.length === 0) ? (
                                    <div className="p-4 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-200 dark:border-zinc-700 text-center text-sm text-zinc-500 italic">
                                        Belum ada master line yang terhubung.
                                    </div>
                                ) : (
                                    <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden shadow-sm">
                                        <table className="w-full text-sm">
                                            <thead className="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-100 dark:border-blue-800/50">
                                                <tr>
                                                    <th className="px-4 py-2.5 text-left text-xs uppercase tracking-wider font-bold text-blue-600 dark:text-blue-400 w-12 text-center">#</th>
                                                    <th className="px-4 py-2.5 text-left text-xs uppercase tracking-wider font-bold text-blue-600 dark:text-blue-400">Line Number</th>
                                                    <th className="px-4 py-2.5 text-left text-xs uppercase tracking-wider font-bold text-blue-600 dark:text-blue-400">Location</th>
                                                </tr>
                                            </thead>
                                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                {viewTarget.masterLines.map((ml, idx) => (
                                                    <tr key={ml.id} className="hover:bg-blue-50/50 dark:hover:bg-blue-950/20 transition-colors">
                                                        <td className="px-4 py-2.5 text-zinc-400 font-mono text-xs text-center">{idx + 1}</td>
                                                        <td className="px-4 py-2.5">
                                                            <span className="inline-flex items-center px-2.5 py-1 rounded-md bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 font-bold text-xs font-mono">
                                                                {ml.line_number}
                                                            </span>
                                                        </td>
                                                        <td className="px-4 py-2.5 text-zinc-700 dark:text-zinc-300">
                                                            <div className="flex items-center gap-1.5">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5 text-zinc-400 flex-shrink-0">
                                                                    <path fillRule="evenodd" d="M11.54 22.351l.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clipRule="evenodd" />
                                                                </svg>
                                                                {ml.location || '-'}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                )}
                            </div>

                            <div>
                                <h3 className="text-sm font-bold text-zinc-800 dark:text-zinc-200 mb-2 flex items-center gap-1.5">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-amber-500">
                                        <path d="M7.5 3.375c0-1.036.84-1.875 1.875-1.875h.375a3.75 3.75 0 0 1 3.75 3.75v1.875C13.5 8.161 14.34 9 15.375 9h1.875A3.75 3.75 0 0 1 21 12.75v3.375C21 17.16 20.16 18 19.125 18h-9.75A1.875 1.875 0 0 1 7.5 16.125V3.375Z" />
                                    </svg>
                                    Daftar Item Check
                                    <span className="ml-auto text-[10px] bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300 px-2 py-0.5 rounded-full">
                                        {viewTarget.items?.length || 0} Item
                                    </span>
                                </h3>
                                
                                <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden shadow-sm">
                                    <table className="w-full text-sm">
                                        <thead className="bg-zinc-100 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                                            <tr>
                                                <th className="px-4 py-2.5 text-left text-xs uppercase tracking-wider font-bold text-zinc-500 w-12 text-center">#</th>
                                                <th className="px-4 py-2.5 text-left text-xs uppercase tracking-wider font-bold text-zinc-500">Item Check</th>
                                                <th className="px-4 py-2.5 text-left text-xs uppercase tracking-wider font-bold text-zinc-500">Standard</th>
                                            </tr>
                                        </thead>
                                        <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                            {viewTarget.items?.map((item, idx) => (
                                                <tr key={item.id} className="hover:bg-zinc-50 dark:hover:bg-zinc-800/30 transition-colors">
                                                    <td className="px-4 py-2.5 text-zinc-400 font-mono text-xs text-center">{idx + 1}</td>
                                                    <td className="px-4 py-2.5 font-semibold text-zinc-800 dark:text-zinc-100">{item.item_check}</td>
                                                    <td className="px-4 py-2.5 text-zinc-600 dark:text-zinc-400">{item.standard}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex justify-end flex-shrink-0">
                            <button
                                onClick={() => setShowViewModal(false)}
                                className="px-6 py-2 text-sm rounded-lg bg-zinc-200 hover:bg-zinc-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-zinc-800 dark:text-zinc-200 font-semibold transition-colors shadow-sm"
                            >
                                Tutup
                            </button>
                        </div>

                    </div>
                </div>
            )}

            {/* ============ DELETE CONFIRM MODAL ============ */}
            {showDeleteModal && deleteTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                        <div className="px-5 py-4 bg-gradient-to-r from-red-600 to-red-700 flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white">
                                    <path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" />
                                </svg>
                            </div>
                            <div className="flex-1">
                                <h2 className="text-base font-bold text-white">
                                    Konfirmasi Hapus
                                </h2>
                                <p className="text-xs text-red-100">
                                    Tindakan ini tidak bisa dibatalkan
                                </p>
                            </div>
                        </div>

                        <div className="p-5">
                            <p className="text-sm text-zinc-700 dark:text-zinc-300 leading-relaxed">
                                Apakah Anda yakin ingin menghapus semua item pada line berikut?
                            </p>

                            <div className="mt-4 p-3 rounded-lg bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800">
                                <div className="flex items-center gap-2 mb-1">
                                    <span className="text-xs font-medium text-red-600 dark:text-red-400 uppercase tracking-wide">
                                        Line
                                    </span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0">
                                        <path fillRule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5Z" clipRule="evenodd" />
                                    </svg>
                                    <span className="font-bold text-red-700 dark:text-red-300 text-base">
                                        {deleteTarget.line}
                                    </span>
                                </div>
                                <p className="text-xs text-red-600 dark:text-red-400 mt-2">
                                    Total <strong>{deleteTarget.count}</strong> item check akan dihapus permanen.
                                </p>
                            </div>
                        </div>

                        <div className="px-5 py-4 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-end gap-2">
                            <button
                                type="button"
                                onClick={() => {
                                    setShowDeleteModal(false)
                                    setDeleteTarget(null)
                                }}
                                disabled={!!deletingLine}
                                className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-medium transition-colors disabled:opacity-50"
                            >
                                Batal
                            </button>
                            <button
                                type="button"
                                onClick={confirmDelete}
                                disabled={!!deletingLine}
                                className="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors shadow-sm disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {deletingLine ? (
                                    <>
                                        <svg className="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                        Menghapus...
                                    </>
                                ) : (
                                    <>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                            <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Z" clipRule="evenodd" />
                                        </svg>
                                        Ya, Hapus Semua
                                    </>
                                )}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* ============ TOAST ============ */}
            {toast && (
                <div
                    className={`fixed bottom-6 right-6 z-50 flex items-center gap-2.5 px-4 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold min-w-[280px] ${
                        toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'
                    }`}
                >
                    <div className="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                        {toast.type === 'error' ? (
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clipRule="evenodd" />
                            </svg>
                        ) : (
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                <path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" />
                            </svg>
                        )}
                    </div>
                    <span>{toast.message}</span>
                </div>
            )}
        </div>
    )
}