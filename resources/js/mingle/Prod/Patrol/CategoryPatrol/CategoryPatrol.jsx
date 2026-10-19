import React, { useState } from 'react'

export default function CategoryPatrol({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0,
    })
    
    // Ambil permission dari backend
    const permissions = mingleData?.permissions ?? { 
        canCreate: false, 
        canEdit: false, 
        canDelete: false 
    }

    const [search, setSearch]           = useState('')
    const [loadingPage, setLoadingPage] = useState(false)
    const [saving, setSaving]           = useState(false)
    const [deletingId, setDeletingId]   = useState(null)
    const [toast, setToast]             = useState(null)

    // Modal State
    const [showModal, setShowModal] = useState(false)
    const [form, setForm]           = useState({ id: null, category_name: '' })

    // Delete State
    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget]       = useState(null)

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    // ===== PAGINATION =====
    const gotoPage = async (page) => {
        if (page < 1 || page > pagination.last_page || page === pagination.current_page) return
        setLoadingPage(true)
        try {
            const result = await wire.gotoPage(page)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch (e) {
            showToast('Gagal pindah halaman: ' + e.message, 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    // ===== OPEN MODAL =====
    const openCreate = () => {
        if (!permissions.canCreate) return
        setForm({ id: null, category_name: '' })
        setShowModal(true)
    }

    const openEdit = (row) => {
        if (!permissions.canEdit) return
        setForm({ id: row.id, category_name: row.category_name })
        setShowModal(true)
    }

    // ===== SAVE =====
    const handleSave = async (e) => {
        e.preventDefault()
        setSaving(true)
        try {
            const result = await wire.save(form)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
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

    // ===== DELETE =====
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
            showToast('Gagal menghapus: ' + e.message, 'error')
        } finally {
            setDeletingId(null)
        }
    }

    // ===== FILTER =====
    const filtered = search.trim()
        ? rows.filter(r => (r.category_name ?? '').toLowerCase().includes(search.toLowerCase()))
        : rows

    // ===== PAGINATION HELPER =====
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
                <span className="font-semibold text-black dark:text-white shrink-0">Category Patrol</span>
            </nav>

            {/* HEADER */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">
                        Category Patrol
                    </h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Master kategori pemeriksaan patrol
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
                        Tambah Kategori
                    </button>
                )}
            </div>

            {/* TABLE CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">

                {/* Card Header + Search (BIRU) */}
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100">
                            <path fillRule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 1 1-1.06 1.06l-.621-.62A3.75 3.75 0 0 1 12 22.5a3.75 3.75 0 0 1-3.348-2.09l-.62.62a.75.75 0 0 1-1.061-1.06l.621-.621c.422-.422.659-.995.659-1.591V18h-3a3 3 0 0 1-3-3V5.25Z" clipRule="evenodd" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">
                            Daftar Kategori
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
                            placeholder="Cari kategori..."
                            className="w-full pl-10 pr-3 py-2 text-sm rounded-lg border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm"
                        />
                    </div>
                </div>

                {/* TABLE */}
                <div className="overflow-x-auto">
                    {loadingPage ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Memuat data...</div>
                    ) : filtered.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">
                            {search ? 'Tidak ada hasil pencarian' : 'Belum ada kategori'}
                        </div>
                    ) : (
                        <table className="w-full text-sm min-w-[600px] table-fixed">
                            <colgroup>
                                <col className="w-16" />
                                <col className="w-full" />
                                <col className="w-40" />
                                <col className="w-32" />
                            </colgroup>
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">#</th>
                                    <th className="px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Nama Kategori</th>
                                    <th className="hidden md:table-cell px-4 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Diperbarui</th>
                                    <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {filtered.map((row, idx) => (
                                    <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors">
                                        <td className="px-4 py-3 text-zinc-500 font-mono text-xs">
                                            {(pagination.current_page - 1) * pagination.per_page + idx + 1}
                                        </td>
                                        <td className="px-4 py-3 font-semibold text-zinc-800 dark:text-zinc-100 truncate" title={row.category_name}>
                                            {row.category_name}
                                        </td>
                                        <td className="hidden md:table-cell px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">
                                            {row.updated_at}
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="flex items-center justify-center gap-1.5">
                                                {permissions.canEdit && (
                                                    <button
                                                        onClick={() => openEdit(row)}
                                                        className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold transition-colors shadow-sm"
                                                    >
                                                        Edit
                                                    </button>
                                                )}
                                                {permissions.canDelete && (
                                                    <button
                                                        onClick={() => openDeleteConfirm(row)}
                                                        className="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition-colors shadow-sm"
                                                    >
                                                        Hapus
                                                    </button>
                                                )}
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

                {/* PAGINATION */}
                {pagination.last_page > 1 && (
                    <div className="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div className="text-sm text-zinc-500 dark:text-zinc-400 text-center sm:text-left whitespace-nowrap">
                            Menampilkan <strong>{pagination.from ?? 0}</strong> - <strong>{pagination.to ?? 0}</strong> dari <strong>{pagination.total}</strong> data
                        </div>

                        <div className="flex items-center justify-center sm:justify-end gap-1 flex-wrap">
                            <button
                                onClick={() => gotoPage(pagination.current_page - 1)}
                                disabled={pagination.current_page === 1 || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40"
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
                                        className={`min-w-[34px] px-2.5 py-1.5 text-sm rounded-lg border transition-all ${
                                            p === pagination.current_page
                                                ? 'bg-blue-600 border-blue-600 text-white font-bold'
                                                : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300'
                                        }`}
                                    >
                                        {p}
                                    </button>
                                )
                            )}

                            <button
                                onClick={() => gotoPage(pagination.current_page + 1)}
                                disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                )}
            </div>

            {/* MODAL FORM */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 backdrop-blur-sm p-4">
                    <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        
                        {/* Header */}
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center">
                            <h2 className="text-base font-bold text-white">
                                {form.id ? 'Edit Kategori' : 'Tambah Kategori'}
                            </h2>
                            <button 
                                onClick={() => setShowModal(false)} 
                                className="text-white/80 hover:text-white transition-colors p-1 rounded hover:bg-white/20"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {/* Form Body */}
                        <form onSubmit={handleSave} className="p-5 space-y-4">
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                    Nama Kategori <span className="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    value={form.category_name}
                                    onChange={e => setForm({ ...form, category_name: e.target.value })}
                                    required
                                    className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
                                    placeholder="Contoh: Kebersihan"
                                />
                            </div>

                            {/* Footer */}
                            <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <button 
                                    type="button" 
                                    onClick={() => setShowModal(false)} 
                                    className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                                >
                                    Batal
                                </button>
                                <button 
                                    type="submit" 
                                    disabled={saving} 
                                    className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 dark:hover:bg-blue-500 disabled:opacity-60 transition-colors shadow-sm"
                                >
                                    {saving ? 'Menyimpan...' : 'Simpan'}
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
                            <h3 className="text-lg font-bold text-zinc-800 dark:text-white">Hapus Kategori?</h3>
                            <p className="text-sm text-zinc-500 mt-2">Yakin ingin menghapus <strong>{deleteTarget.category_name}</strong>?</p>
                        </div>
                        <div className="flex justify-end gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t">
                            <button onClick={() => setShowDeleteModal(false)} className="px-4 py-2 text-sm rounded-lg border">Batal</button>
                            <button onClick={confirmDelete} disabled={!!deletingId} className="px-4 py-2 text-sm rounded-lg bg-red-600 text-white font-semibold">
                                {deletingId ? 'Menghapus...' : 'Ya, Hapus'}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* TOAST */}
            {toast && (
                <div className={`fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>
                    {toast.message}
                </div>
            )}

        </div>
    )
}