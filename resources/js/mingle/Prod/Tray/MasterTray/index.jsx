import React, { useState } from 'react'
import TrayFormModal from './TrayFormModal'
import DeleteConfirmModal from './DeleteConfirmModal'
import HistoryModal from './HistoryModal' // ⬅️ TAMBAHKAN INI

export default function MasterTray({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [racks, setRacks]           = useState(mingleData?.racks ?? [])
    const [locators, setLocators]     = useState(mingleData?.locators ?? [])
    const [customers, setCustomers]   = useState(mingleData?.customers ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0,
    })
    const permissions = mingleData?.permissions ?? { canCreate: false, canEdit: false, canDelete: false }

    const [search, setSearch]               = useState('')
    const [searchLoading, setSearchLoading] = useState(false)
    const [loadingPage, setLoadingPage]   = useState(false)
    const [deletingId, setDeletingId]     = useState(null)
    const [toast, setToast]               = useState(null)

    const [showModal, setShowModal]       = useState(false)
    const [editRow, setEditRow]           = useState(null)
    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget] = useState(null)

    // History Modal
    const [showHistoryModal, setShowHistoryModal] = useState(false)
    const [historyTray, setHistoryTray] = useState(null)
    const [historyRows, setHistoryRows] = useState([])
    const [loadingHistory, setLoadingHistory] = useState(false)

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    const openHistory = async (row) => {
        setHistoryTray(row)
        setShowHistoryModal(true)
        setLoadingHistory(true)
        try {
            const result = await wire.getTrayHistory(row.id)
            if (result.success) {
                setHistoryRows(result.rows)
            } else {
                showToast('Failed to load history', 'error')
            }
        } catch (e) {
            showToast('Failed to load history: ' + e.message, 'error')
        } finally {
            setLoadingHistory(false)
        }
    }

    const handleSearchChange = async (e) => {
        const value = e.target.value
        setSearch(value)
        setSearchLoading(true)
        try {
            const result = await wire.setSearch(value)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (err) {
            showToast('Failed to search: ' + err.message, 'error')
        } finally {
            setSearchLoading(false)
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

    const openCreate = () => {
        if (!permissions.canCreate) return
        if (racks.length === 0) {
            showToast('Please add a Rack first before creating a Tray', 'error')
            return
        }
        setEditRow(null)
        setShowModal(true)
    }

    const openEdit = (row) => {
        if (!permissions.canEdit) return
        setEditRow(row)
        setShowModal(true)
    }

    const handleSaved = (result) => {
        setRows(result.data.rows)
        setPagination(result.data.pagination)
        if (result.data.racks) setRacks(result.data.racks)
        if (result.data.locators) setLocators(result.data.locators)
        if (result.data.customers) setCustomers(result.data.customers)
        showToast(result.message, 'success')
        setShowModal(false)
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
                <span className="shrink-0 font-semibold text-black dark:text-white">Master</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Master Tray</span>
            </nav>

            {/* HEADER */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">Master Tray</h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Tray master data</p>
                </div>
                {permissions.canCreate && (
                    <button onClick={openCreate}
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                            <path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                        </svg>
                        Add Tray
                    </button>
                )}
            </div>

            {/* TABLE CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6 text-white shrink-0">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fillRule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Tray List</span>
                    </div>
                    <div className="relative w-full sm:w-72">
                        <input type="text" value={search} onChange={handleSearchChange}
                            placeholder="Search tray..."
                            className="w-full pl-3 pr-3 py-2 text-sm rounded-lg border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm" />
                    </div>
                </div>

                <div className="overflow-x-auto">
                    {(loadingPage || searchLoading) ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Loading data...</div>
                    ) : rows.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">
                            {search ? 'No matching results' : 'No trays yet'}
                        </div>
                    ) : (
                        <table className="w-full text-sm min-w-max">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr className="whitespace-nowrap">
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500 w-12">#</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Rack</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Locator</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Customer</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Part Number</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Item Code SAP</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Desc</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Model</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Cav</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Stock</th>
                                    {/* Created By & Created At menggantikan Updated */}
                                    <th className="hidden lg:table-cell px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Created By</th>
                                    <th className="hidden lg:table-cell px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Created At</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500 w-40">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {rows.map((row, idx) => (
                                    <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors whitespace-nowrap">
                                        <td className="px-3 py-3 text-zinc-500 font-mono text-xs">{(pagination.current_page - 1) * pagination.per_page + idx + 1}</td>
                                        <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">
                                            <span className="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                                                {row.rack_number ?? '-'}
                                            </span>
                                        </td>
                                        <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">{row.locator_number ?? '-'}</td>
                                        <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">{row.customer_name ?? '-'}</td>
                                        <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">{row.part_number_tray}</td>
                                        <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">{row.item_code_sap ?? '-'}</td>
                                        <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">{row.desc ?? '-'}</td>
                                        <td className="px-3 py-3 text-zinc-600 dark:text-zinc-300 text-xs">{row.model ?? '-'}</td>
                                        <td className="px-3 py-3 text-zinc-700 dark:text-zinc-200 text-xs">{row.cav_tray ?? '-'}</td>
                                        <td className="px-3 py-3 text-center">
                                            <span className={`inline-flex items-center justify-center min-w-[32px] px-2 py-0.5 rounded-md text-xs font-bold ${
                                                row.current_stock > 0 
                                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300'
                                                    : row.current_stock < 0
                                                        ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300'
                                                        : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300'
                                            }`}>
                                                {row.current_stock ?? 0}
                                            </span>
                                        </td>
                                        {/* Data Created By & Created At */}
                                        <td className="hidden lg:table-cell px-3 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_by_name ?? '-'}</td>
                                        <td className="hidden lg:table-cell px-3 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{row.created_at ?? '-'}</td>
                                        <td className="px-3 py-3">
                                            <div className="flex items-center justify-center gap-1.5">
                                                <button onClick={() => openHistory(row)} className="px-2.5 py-1.5 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors shadow-sm">
                                                    History
                                                </button>
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
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40">Prev</button>
                            {getPageNumbers().map((p, idx) =>
                                p === '...' ? (
                                    <span key={`dots-${idx}`} className="px-2 text-zinc-400 text-sm">...</span>
                                ) : (
                                    <button key={p} onClick={() => gotoPage(p)} disabled={loadingPage}
                                        className={`min-w-[34px] px-2.5 py-1.5 text-sm rounded-lg border transition-all ${
                                            p === pagination.current_page
                                                ? 'bg-blue-600 border-blue-600 text-white font-bold'
                                                : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300'
                                        }`}>{p}</button>
                                )
                            )}
                            <button onClick={() => gotoPage(pagination.current_page + 1)} disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40">Next</button>
                        </div>
                    </div>
                )}
            </div>

            {/* MODALS */}
            {showModal && (
                <TrayFormModal
                    wire={wire}
                    initialRow={editRow}
                    racks={racks}
                    locators={locators}
                    customers={customers}
                    onClose={() => setShowModal(false)}
                    onSaved={handleSaved}
                    showToast={showToast}
                />
            )}

            {/* ⬇️ Panggil Modal History di sini */}
            {showHistoryModal && historyTray && (
                <HistoryModal
                    tray={historyTray}
                    historyRows={historyRows}
                    loading={loadingHistory}
                    onClose={() => {
                        setShowHistoryModal(false)
                        setHistoryTray(null)
                        setHistoryRows([])
                    }}
                />
            )}

            {showDeleteModal && deleteTarget && (
                <DeleteConfirmModal
                    target={deleteTarget}
                    deleting={!!deletingId}
                    onClose={() => { setShowDeleteModal(false); setDeleteTarget(null) }}
                    onConfirm={confirmDelete}
                />
            )}

            {toast && (
                <div className={`fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>
                    {toast.message}
                </div>
            )}
        </div>
    )
}