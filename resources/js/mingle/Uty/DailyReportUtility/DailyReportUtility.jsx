import React, { useMemo, useRef, useState } from 'react'
import RichTextEditor from './RichTextEditor.jsx'
import { createPortal } from 'react-dom'

export default function DailyReportUtility({ wire, mingleData }) {
    const [rows, setRows]             = useState(mingleData?.rows ?? [])
    const [pagination, setPagination] = useState(mingleData?.pagination ?? {
        current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0,
    })

    const permissions = mingleData?.permissions ?? {
        canCreate: false, canEdit: false, canDelete: false,
    }
    const options = mingleData?.options ?? {
        shifts: [1, 2, 3],
        categories: ['Schedule PM', 'Abnormality'],
        statuses: ['Open', 'Under Maintenance', 'On Progress', 'Closed'],
    }

    const [loadingPage, setLoadingPage] = useState(false)
    const [saving, setSaving]           = useState(false)
    const [deletingId, setDeletingId]   = useState(null)
    const [toast, setToast]             = useState(null)
    const [hoverTooltip, setHoverTooltip] = useState(null)

    // Filters
    const [filterDateFrom, setFilterDateFrom] = useState('')
    const [filterDateTo, setFilterDateTo]     = useState('')
    const [filterShift, setFilterShift]       = useState('')
    const [filterCategory, setFilterCategory] = useState('')    
    const [filterStatus, setFilterStatus]     = useState('')
    const [exporting, setExporting] = useState(false)

    // View Photos modal state
    const [showPhotosModal, setShowPhotosModal] = useState(false)
    const [photosTarget, setPhotosTarget] = useState(null)
    const [photoScroll, setPhotoScroll] = useState({ before: false, after: false })

    // Cek apakah ada filter yang aktif
    const isFilterActive = filterDateFrom || filterDateTo || filterShift || filterCategory || filterStatus

    const fileBeforeRef = useRef(null)
    const fileAfterRef  = useRef(null)
    const [dragOverBefore, setDragOverBefore] = useState(false)
    const [dragOverAfter, setDragOverAfter]   = useState(false)

    const handleExport = async () => {
        setExporting(true)
        try {
            // Mengirimkan filter yang sedang aktif ke Livewire
            await wire.exportExcel({
                date_from: filterDateFrom,
                date_to: filterDateTo,
                shift: filterShift,
                category: filterCategory,
                status: filterStatus,
            })
        } catch (e) {
            showToast('Failed to export: ' + e.message, 'error')
        } finally {
            setExporting(false)
        }
    }

    // Ubah HTML jadi teks dengan mempertahankan list marker (1. 2. / •)
    const htmlToTextWithMarkers = (html) => {
        if (!html) return ''
        if (typeof window === 'undefined' || typeof document === 'undefined') return ''

        const container = document.createElement('div')
        container.innerHTML = html

        const walk = (node, depth = 0) => {
            let out = ''
            node.childNodes.forEach((child) => {
                if (child.nodeType === Node.TEXT_NODE) {
                    out += child.textContent
                } else if (child.nodeType === Node.ELEMENT_NODE) {
                    const tag = child.tagName.toLowerCase()
                    if (tag === 'ul' || tag === 'ol') {
                        const items = Array.from(child.children).filter(li => li.tagName.toLowerCase() === 'li')
                        items.forEach((li, i) => {
                            const marker = tag === 'ol' ? `${i + 1}. ` : '• '
                            out += '\n' + '  '.repeat(depth) + marker + walk(li, depth + 1).trim() + '\n'
                        })
                    } else if (tag === 'li') {
                        out += walk(child, depth)
                    } else if (tag === 'br') {
                        out += '\n'
                    } else if (tag === 'p' || tag === 'div') {
                        out += walk(child, depth) + '\n'
                    } else {
                        out += walk(child, depth)
                    }
                }
            })
            return out
        }

        return walk(container).replace(/\n{3,}/g, '\n\n').trim()
    }

    // Cek apakah konten perlu tooltip (kepanjangan secara kata ATAU baris)
    const hasLongContent = (html) => {
        const text = htmlToTextWithMarkers(html)
        if (!text) return false
        
        const wordCount = text.replace(/\s+/g, ' ').trim().split(' ').length
        const lineCount = text.split('\n').filter(l => l.trim() !== '').length

        // Munculkan tooltip jika lebih dari 30 kata ATAU lebih dari 3 baris (termasuk list)
        return wordCount > 30 || lineCount > 3
    }

    // Potong jadi max 30 kata atau max 3 baris, tambahkan "..." jika lebih
    const renderPreview = (html, maxWords = 30, maxLines = 3) => {
        const text = htmlToTextWithMarkers(html)
        if (!text) return '-'
        
        let lines = text.split('\n')
        if (lines.length > maxLines) {
            return lines.slice(0, maxLines).join('\n') + '\n...'
        }

        const words = text.replace(/\s+/g, ' ').trim().split(' ')
        if (words.length > maxWords) {
            return words.slice(0, maxWords).join(' ') + '...'
        }

        return text
    }

    const handleDrop = async (e, field) => {
        const files = Array.from(e.dataTransfer?.files || []).filter(f => f.type.startsWith('image/'))
        if (files.length === 0) return

        const uploaded = []
        for (const file of files) {
            const previewUrl = URL.createObjectURL(file)
            await new Promise((resolve, reject) => {
                wire.upload(
                    field,
                    file,
                    (uploadedFilename) => {
                        uploaded.push({ tmp: uploadedFilename, previewUrl })
                        resolve()
                    },
                    () => reject(new Error('Upload failed')),
                    () => {}
                )
            })
        }

        const targetKey = field === 'photoBeforeFiles' ? 'photo_before_files' : 'photo_after_files'
        setForm(prev => ({
            ...prev,
            [targetKey]: [...prev[targetKey], ...uploaded],
        }))
    }

    // Modal form
    const [showModal, setShowModal] = useState(false)
    const emptyForm = {
        id: null,
        shift: 1,
        report_category: 'Schedule PM',
        problem_desc: '',
        action_desc: '',
        photo_before_files: [],
        photo_after_files:  [],
        photo_before_existing: [],
        photo_after_existing:  [],
        photo_before_existing_urls: [],
        photo_after_existing_urls:  [],
    }
    const [form, setForm] = useState(emptyForm)

    // Photo preview modal
    const [previewUrl, setPreviewUrl] = useState(null)

    // Delete modal
    const [showDeleteModal, setShowDeleteModal] = useState(false)
    const [deleteTarget, setDeleteTarget]       = useState(null)

    // Update status modal
    const [showStatusModal, setShowStatusModal] = useState(false)
    const [statusTarget, setStatusTarget]       = useState(null)
    const [statusValue, setStatusValue]         = useState('On Progress')
    const [updatingStatus, setUpdatingStatus]   = useState(false)

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
            showToast('Failed to change page: ' + e.message, 'error')
        } finally {
            setLoadingPage(false)
        }
    }

    // ===== OPEN MODAL =====
    const openCreate = () => {
        if (!permissions.canCreate) return
        setForm({ ...emptyForm })
        setShowModal(true)
    }

    const openEdit = (row) => {
        if (!permissions.canEdit) return
        setForm({
            id: row.id,
            shift: row.shift,
            report_category: row.report_category,
            problem_desc: row.problem_desc ?? '',
            action_desc: row.action_desc ?? '',
            photo_before_files: [],
            photo_after_files: [],
            photo_before_existing: row.photo_before_paths ?? [],
            photo_after_existing:  row.photo_after_paths ?? [],
            photo_before_existing_urls: row.photo_before ?? [],
            photo_after_existing_urls:  row.photo_after ?? [],
        })
        setShowModal(true)
    }

    // ===== VIEW PHOTOS =====
    const openPhotosModal = (row) => {
        setPhotosTarget(row)
        setShowPhotosModal(true)
    }

    // ===== UPLOAD + LOCAL PREVIEW =====
    const handleFileChange = async (e, field) => {
        const files = Array.from(e.target.files || [])
        if (files.length === 0) return

        const uploaded = []
        for (const file of files) {
            const previewUrl = URL.createObjectURL(file)
            await new Promise((resolve, reject) => {
                wire.upload(
                    field,
                    file,
                    (uploadedFilename) => {
                        uploaded.push({ tmp: uploadedFilename, previewUrl })
                        resolve()
                    },
                    () => reject(new Error('Upload failed')),
                    () => {}
                )
            })
        }

        const targetKey = field === 'photoBeforeFiles' ? 'photo_before_files' : 'photo_after_files'
        setForm(prev => ({
            ...prev,
            [targetKey]: [...prev[targetKey], ...uploaded],
        }))

        e.target.value = ''
    }

    const removeNewFile = (idx, isBefore) => {
        setForm(prev => {
            const key = isBefore ? 'photo_before_files' : 'photo_after_files'
            const arr = [...prev[key]]
            if (arr[idx]?.previewUrl?.startsWith('blob:')) {
                URL.revokeObjectURL(arr[idx].previewUrl)
            }
            arr.splice(idx, 1)
            return { ...prev, [key]: arr }
        })
    }

    const removeExistingPhoto = (idx, isBefore) => {
        setForm(prev => {
            const keyPath = isBefore ? 'photo_before_existing' : 'photo_after_existing'
            const keyUrl  = isBefore ? 'photo_before_existing_urls' : 'photo_after_existing_urls'
            const paths = [...prev[keyPath]]
            const urls  = [...prev[keyUrl]]
            paths.splice(idx, 1)
            urls.splice(idx, 1)
            return { ...prev, [keyPath]: paths, [keyUrl]: urls }
        })
    }

    // ===== SAVE =====
    const handleSave = async (e) => {
        e.preventDefault()
        setSaving(true)
        try {
            const payload = {
                id: form.id,
                shift: form.shift,
                report_category: form.report_category,
                problem_desc: form.problem_desc,
                action_desc: form.action_desc,
                photo_before_existing: form.photo_before_existing,
                photo_after_existing:  form.photo_after_existing,
            }
            const result = await wire.save(payload)
            if (result.success) {
                form.photo_before_files.forEach(f => f.previewUrl?.startsWith('blob:') && URL.revokeObjectURL(f.previewUrl))
                form.photo_after_files.forEach(f => f.previewUrl?.startsWith('blob:') && URL.revokeObjectURL(f.previewUrl))

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

    // ===== DELETE =====
    const openDeleteConfirm = (row) => {
        if (!permissions.canDelete) return
        if (row.status !== 'Open') return
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

    // ===== UPDATE STATUS =====
    const openStatusModal = (row) => {
        setStatusTarget(row)
        setStatusValue('On Progress')
        setShowStatusModal(true)
    }

    const confirmUpdateStatus = async () => {
        if (!statusTarget) return
        setUpdatingStatus(true)
        try {
            const result = await wire.updateStatus(statusTarget.id, statusValue)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                showToast(result.message, 'success')
                setShowStatusModal(false)
                setStatusTarget(null)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Failed to update status: ' + e.message, 'error')
        } finally {
            setUpdatingStatus(false)
        }
    }

    // ===== FILTER =====
    const filtered = useMemo(() => {
        return rows.filter(r => {
            if (filterShift && String(r.shift) !== String(filterShift)) return false
            if (filterCategory && r.report_category !== filterCategory) return false
            if (filterStatus && r.status !== filterStatus) return false

            if (filterDateFrom || filterDateTo) {
                const parts = (r.created_at || '').split(' ')[0].split('/')
                if (parts.length === 3) {
                    const iso = `${parts[2]}-${parts[1]}-${parts[0]}`
                    if (filterDateFrom && iso < filterDateFrom) return false
                    if (filterDateTo && iso > filterDateTo) return false
                }
            }
            return true
        })
    }, [rows, filterShift, filterCategory, filterStatus, filterDateFrom, filterDateTo])

    const resetFilters = () => {
        setFilterDateFrom('')
        setFilterDateTo('')
        setFilterShift('')
        setFilterCategory('')
        setFilterStatus('')
    }

    const statusColor = (s) => {
        switch (s) {
            case 'Open': return 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'
            case 'Under Maintenance': return 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300'
            case 'On Progress': return 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'
            case 'Closed': return 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
            default: return 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300'
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

    const canEditRow   = (row) => permissions.canEdit && row.status !== 'Closed'
    const canDeleteRow = (row) => permissions.canDelete && row.status === 'Open'
    const canUpdateStatusRow = (row) => row.status !== 'Closed'
    const isFormValid = () => {
        // Shift & Category ada default, cek Problem Description
        const isProblemEmpty = !form.problem_desc || form.problem_desc === '<p></p>' || form.problem_desc.trim() === ''
        return form.shift && form.report_category && !isProblemEmpty
    }

    return (
        <div className="p-1 space-y-2">

            {/* ============ BREADCRUMBS ============ */}
            <nav className="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 overflow-x-auto whitespace-nowrap pb-1">
                <button type="button" onClick={() => window.Livewire.navigate('/main-dashboard')}
                    className="inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                    Dashboard
                </button>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Maintenance</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">UTY</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Daily Report Utility</span>
            </nav>

            {/* ============ HEADER ============ */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">
                        Daily Report Utility
                    </h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Utility patrol daily reports
                    </p>
                </div>
                <div className="flex items-center gap-2">
                    {/* Tombol Export Excel */}
                    <button onClick={handleExport} disabled={exporting || filtered.length === 0}
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        {exporting ? (
                            <svg className="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle>
                                <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        ) : (
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor" className="w-4 h-4">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        )}
                        {exporting ? 'Exporting...' : 'Export Excel'}
                    </button>

                    {/* Tombol Add Report */}
                    {permissions.canCreate && (
                        <button onClick={openCreate}
                            className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                <path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" />
                            </svg>
                            Add Report
                        </button>
                    )}
                </div>
            </div>

            {/* ============ CARD 1: FILTERS ============ */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-sm p-4 sm:p-5">
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    {/* Date From */}
                    <div className="space-y-1.5">
                        <label className="block text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Date From</label>
                        <div className="relative">
                            <input type="date" value={filterDateFrom} onChange={e => setFilterDateFrom(e.target.value)}
                                className="w-full pl-3 pr-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 hover:border-zinc-400 dark:hover:border-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-sm cursor-pointer" />
                        </div>
                    </div>

                    {/* Date To */}
                    <div className="space-y-1.5">
                        <label className="block text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Date To</label>
                        <div className="relative">
                            <input type="date" value={filterDateTo} onChange={e => setFilterDateTo(e.target.value)}
                                className="w-full pl-3 pr-3 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 hover:border-zinc-400 dark:hover:border-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-sm cursor-pointer" />
                        </div>
                    </div>
                    
                    {/* Shift */}
                    <div className="space-y-1.5">
                        <label className="block text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Shift</label>
                        <div className="relative group">
                            <select value={filterShift} onChange={e => setFilterShift(e.target.value)}
                                className="w-full appearance-none pl-3 pr-9 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 hover:border-zinc-400 dark:hover:border-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-sm cursor-pointer">
                                <option value="">All Shifts</option>
                                {options.shifts.map(s => <option key={s} value={s}>Shift {s}</option>)}
                            </select>
                            {/* Icon Chevron */}
                            <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {/* Category */}
                    <div className="space-y-1.5">
                        <label className="block text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Category</label>
                        <div className="relative group">
                            <select value={filterCategory} onChange={e => setFilterCategory(e.target.value)}
                                className="w-full appearance-none pl-3 pr-9 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 hover:border-zinc-400 dark:hover:border-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-sm cursor-pointer">
                                <option value="">All Categories</option>
                                {options.categories.map(c => <option key={c} value={c}>{c}</option>)}
                            </select>
                            {/* Icon Chevron */}
                            <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    {/* Status */}
                    <div className="space-y-1.5">
                        <label className="block text-[11px] font-semibold uppercase tracking-wider text-zinc-500 dark:text-zinc-400">Status</label>
                        <div className="relative group">
                            <select value={filterStatus} onChange={e => setFilterStatus(e.target.value)}
                                className="w-full appearance-none pl-3 pr-9 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 hover:border-zinc-400 dark:hover:border-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 shadow-sm cursor-pointer">
                                <option value="">All Statuses</option>
                                {options.statuses.map(s => <option key={s} value={s}>{s}</option>)}
                            </select>
                            {/* Icon Chevron */}
                            <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-300 transition-colors">
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                </div>

                {/* Tombol Reset hanya muncul jika ada filter aktif */}
                {isFilterActive && (
                    <div className="flex justify-end mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <button onClick={resetFilters}
                            className="inline-flex items-center gap-1.5 text-xs px-3.5 py-2 rounded-lg font-medium border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 hover:border-red-300 dark:border-red-900/50 dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-all duration-200 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                <path fillRule="evenodd" d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z" clipRule="evenodd" />
                            </svg>
                            Reset Filters
                        </button>
                    </div>
                )}
            </div>

            {/* ============ CARD 2: TABLE ============ */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="size-5 text-white">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Daily Report List</span>
                    </div>
                </div>

                <div className="overflow-x-auto">
                    {loadingPage ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Loading data...</div>
                    ) : filtered.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">No daily reports found</div>
                    ) : (
                        <table className="w-full text-sm min-w-[1100px]">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                <tr>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">#</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Date</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">PIC</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Shift</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Category</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Problem</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Action</th>
                                    <th className="px-3 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Status</th>
                                    <th className="px-3 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {filtered.map((row, idx) => (
                                    <tr key={row.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors">
                                        <td className="px-3 py-3 text-zinc-500 font-mono text-xs">
                                            {(pagination.current_page - 1) * pagination.per_page + idx + 1}
                                        </td>
                                        <td className="px-3 py-3 text-zinc-600 dark:text-zinc-400 text-xs whitespace-nowrap">{row.created_at}</td>
                                        <td className="px-3 py-3 text-zinc-600 dark:text-zinc-400 text-xs whitespace-nowrap">{row.pic_name}</td>
                                        <td className="px-3 py-3 text-zinc-600 dark:text-zinc-400 text-xs whitespace-nowrap">Shift {row.shift}</td>
                                        <td className="px-3 py-3 whitespace-nowrap">
                                            {(() => {
                                                if (row.report_category === 'Schedule PM') {
                                                    return (
                                                        <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 text-xs font-semibold border border-blue-200 dark:border-blue-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-3.5">
                                                                <path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" />
                                                                <path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clipRule="evenodd" />
                                                            </svg>
                                                            {row.report_category}
                                                        </span>
                                                    )
                                                } else if (row.report_category === 'Routine Check') {
                                                    return (
                                                        <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 text-xs font-semibold border border-emerald-200 dark:border-emerald-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-3.5">
                                                                <path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" />
                                                            </svg>
                                                            {row.report_category}
                                                        </span>
                                                    )
                                                } else {
                                                    return (
                                                        <span className="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 text-xs font-semibold border border-amber-200 dark:border-amber-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-3.5">
                                                                <path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" />
                                                            </svg>
                                                            {row.report_category}
                                                        </span>
                                                    )
                                                }
                                            })()}
                                        </td>

                                        {/* Problem */}
                                        <td
                                            className="px-3 py-3 text-zinc-600 dark:text-zinc-400 text-xs max-w-[260px] cursor-help"
                                            onMouseEnter={(e) => {
                                                if (hasLongContent(row.problem_desc)) {
                                                    const rect = e.currentTarget.getBoundingClientRect()
                                                    setHoverTooltip({ html: row.problem_desc, x: rect.left, y: rect.bottom + 6 })
                                                }
                                            }}
                                            onMouseLeave={() => setHoverTooltip(null)}
                                        >
                                            <div className="line-clamp-3 whitespace-pre-line break-words">
                                                {renderPreview(row.problem_desc)}
                                            </div>
                                        </td>

                                        {/* Action */}
                                        <td
                                            className="px-3 py-3 text-zinc-600 dark:text-zinc-400 text-xs max-w-[260px] cursor-help"
                                            onMouseEnter={(e) => {
                                                if (hasLongContent(row.action_desc)) {
                                                    const rect = e.currentTarget.getBoundingClientRect()
                                                    setHoverTooltip({ html: row.action_desc, x: rect.left, y: rect.bottom + 6 })
                                                }
                                            }}
                                            onMouseLeave={() => setHoverTooltip(null)}
                                        >
                                            <div className="line-clamp-3 whitespace-pre-line break-words">
                                                {renderPreview(row.action_desc)}
                                            </div>
                                        </td>

                                        <td className="px-3 py-3">
                                            <span className={`px-2 py-1 rounded text-xs font-semibold whitespace-nowrap ${statusColor(row.status)}`}>{row.status}</span>
                                        </td>
                                        
                                        {/* Actions - Icon Only with Tooltip */}
                                        <td className="px-3 py-3 whitespace-nowrap">
                                            <div className="flex items-center justify-center gap-1.5">
                                                {/* Tombol View Photos */}
                                                <div className="relative group flex items-center">
                                                    <button onClick={() => openPhotosModal(row)}
                                                        className="p-1.5 rounded-md bg-sky-100 hover:bg-sky-200 text-sky-700 dark:bg-sky-900/40 dark:hover:bg-sky-900/60 dark:text-sky-300 transition-colors">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="size-4">
                                                            <path fillRule="evenodd" d="M1 5.25A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25v9.5A2.25 2.25 0 0 1 16.75 17H3.25A2.25 2.25 0 0 1 1 14.75v-9.5Zm1.5 0c0-.414.336-.75.75-.75h13.5c.414 0 .75.336.75.75v3.197l-2.696-2.697a2.25 2.25 0 0 0-3.182 0l-7.872 7.872V5.25Zm2.25 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" clipRule="evenodd" />
                                                        </svg>
                                                    </button>
                                                    {/* Tooltip */}
                                                    <div className="absolute bottom-full mb-1.5 left-1/2 -translate-x-1/2 hidden group-hover:block z-50">
                                                        <div className="bg-zinc-800 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded whitespace-nowrap shadow-xl">
                                                            View Photos
                                                            <div className="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-zinc-800 dark:border-t-zinc-700"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {canEditRow(row) && (
                                                    <div className="relative group flex items-center">
                                                        <button onClick={() => openEdit(row)}
                                                            className="p-1.5 rounded-md bg-amber-100 hover:bg-amber-200 text-amber-700 dark:bg-amber-900/40 dark:hover:bg-amber-900/60 dark:text-amber-300 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="size-4">
                                                                <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                            </svg>
                                                        </button>
                                                        {/* Tooltip */}
                                                        <div className="absolute bottom-full mb-1.5 left-1/2 -translate-x-1/2 hidden group-hover:block z-50">
                                                            <div className="bg-zinc-800 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded whitespace-nowrap shadow-xl">
                                                                Edit Report
                                                                <div className="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-zinc-800 dark:border-t-zinc-700"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )}
                                                
                                                {canUpdateStatusRow(row) && (
                                                    <div className="relative group flex items-center">
                                                        <button onClick={() => openStatusModal(row)}
                                                            className="p-1.5 rounded-md bg-indigo-100 hover:bg-indigo-200 text-indigo-700 dark:bg-indigo-900/40 dark:hover:bg-indigo-900/60 dark:text-indigo-300 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="size-4">
                                                                <path fillRule="evenodd" d="M15.312 11.424a5.5 5.5 0 0 1-9.201 2.466l-.312-.311h2.433a.75.75 0 0 0 0-1.5H3.989a.75.75 0 0 0-.75.75v4.242a.75.75 0 0 0 1.5 0v-2.43l.31.31a7 7 0 0 0 11.712-3.138.75.75 0 0 0-1.449-.39Zm1.23-3.723a.75.75 0 0 0 .219-.53V2.929a.75.75 0 0 0-1.5 0V5.36l-.31-.31A7 7 0 0 0 3.239 8.188a.75.75 0 1 0 1.448.389A5.5 5.5 0 0 1 13.89 6.11l.311.31h-2.432a.75.75 0 0 0 0 1.5h4.243a.75.75 0 0 0 .53-.219Z" clipRule="evenodd" />
                                                            </svg>
                                                        </button>
                                                        {/* Tooltip */}
                                                        <div className="absolute bottom-full mb-1.5 left-1/2 -translate-x-1/2 hidden group-hover:block z-50">
                                                            <div className="bg-zinc-800 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded whitespace-nowrap shadow-xl">
                                                                Update Status
                                                                <div className="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-zinc-800 dark:border-t-zinc-700"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )}
                                                
                                                {canDeleteRow(row) && (
                                                    <div className="relative group flex items-center">
                                                        <button onClick={() => openDeleteConfirm(row)}
                                                            className="p-1.5 rounded-md bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:hover:bg-red-900/60 dark:text-red-300 transition-colors">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="size-4">
                                                                <path fillRule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clipRule="evenodd" />
                                                            </svg>
                                                        </button>
                                                        {/* Tooltip */}
                                                        <div className="absolute bottom-full mb-1.5 left-1/2 -translate-x-1/2 hidden group-hover:block z-50">
                                                            <div className="bg-zinc-800 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded whitespace-nowrap shadow-xl">
                                                                Delete
                                                                <div className="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-zinc-800 dark:border-t-zinc-700"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )}
                                                
                                                {row.status === 'Closed' && (
                                                    <span className="text-xs text-zinc-400 italic">Closed</span>
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
                            Showing <strong>{pagination.from ?? 0}</strong> - <strong>{pagination.to ?? 0}</strong> of <strong>{pagination.total}</strong> entries
                        </div>
                        <div className="flex items-center justify-center sm:justify-end gap-1 flex-wrap">
                            <button onClick={() => gotoPage(pagination.current_page - 1)}
                                disabled={pagination.current_page === 1 || loadingPage}
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
                            <button onClick={() => gotoPage(pagination.current_page + 1)}
                                disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="px-3 py-1.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 text-zinc-700 dark:text-zinc-300 disabled:opacity-40">Next</button>
                        </div>
                    </div>
                )}
            </div>

            {/* ============ MODAL FORM ============ */}
            {showModal && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div className="w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700 my-8">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center">
                            <h2 className="text-base font-bold text-white">
                                {form.id ? 'Edit Daily Report' : 'Add Daily Report'}
                            </h2>
                            <button onClick={() => setShowModal(false)}
                                className="text-white/80 hover:text-white transition-colors p-1 rounded hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form onSubmit={handleSave} className="p-5 space-y-4 max-h-[70vh] overflow-y-auto">
                            {/* Shift buttons */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-2">
                                    Shift <span className="text-red-500">*</span>
                                </label>
                                <div className="grid grid-cols-3 gap-2">
                                    {options.shifts.map(s => (
                                        <button key={s} type="button" onClick={() => setForm({ ...form, shift: s })}
                                            className={`px-4 py-2.5 rounded-lg text-sm font-semibold border-2 transition-all ${
                                                form.shift === s
                                                    ? 'bg-blue-600 border-blue-600 text-white shadow'
                                                    : 'bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 hover:border-blue-400'
                                            }`}>
                                            Shift {s}
                                        </button>
                                    ))}
                                </div>
                            </div>

                            {/* Category buttons */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-2">
                                    Category <span className="text-red-500">*</span>
                                </label>
                                {/* grid-cols-1 di HP, dan grid-cols-3 di layar lebih besar */}
                                <div className="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                    {[
                                        {
                                            value: 'Schedule PM',
                                            label: 'Schedule PM',
                                            icon: (
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 flex-shrink-0">
                                                    <path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" />
                                                    <path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clipRule="evenodd" />
                                                </svg>
                                            ),
                                        },
                                        {
                                            value: 'Abnormality',
                                            label: 'Abnormality',
                                            icon: (
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 flex-shrink-0">
                                                    <path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" />
                                                </svg>
                                            ),
                                        },
                                        {
                                            value: 'Routine Check',
                                            label: 'Routine Check',
                                            icon: (
                                                // Icon berbeda untuk Routine Check
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 flex-shrink-0">
                                                    <path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" />
                                                    <path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clipRule="evenodd" />
                                                </svg>
                                            ),
                                        }
                                    ].map(opt => {
                                        const isActive = form.report_category === opt.value
                                        return (
                                            <button key={opt.value} type="button" onClick={() => setForm({ ...form, report_category: opt.value })}
                                                className={`flex items-center justify-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold border-2 transition-all ${
                                                    isActive
                                                        ? 'bg-blue-600 border-blue-600 text-white shadow'
                                                        : 'bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 hover:border-blue-400'
                                                }`}>
                                                <span className={isActive ? 'text-white' : 'text-blue-600 dark:text-blue-400'}>
                                                    {opt.icon}
                                                </span>
                                                <span className="truncate">{opt.label}</span>
                                            </button>
                                        )
                                    })}
                                </div>
                            </div>

                            {/* Problem Description - Rich Text */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                    Problem Description <span className="text-red-500">*</span>
                                </label>
                                <RichTextEditor
                                    value={form.problem_desc}
                                    onChange={(html) => setForm(prev => ({ ...prev, problem_desc: html }))}
                                    placeholder="Describe the problem..."
                                />
                            </div>

                            {/* Photo Before - Drag & Drop */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Photo Before</label>
                                <div
                                    onDragOver={(e) => { e.preventDefault(); setDragOverBefore(true) }}
                                    onDragLeave={(e) => { e.preventDefault(); setDragOverBefore(false) }}
                                    onDrop={(e) => { e.preventDefault(); setDragOverBefore(false); handleDrop(e, 'photoBeforeFiles') }}
                                    onClick={() => fileBeforeRef.current?.click()}
                                    className={`relative border-2 border-dashed rounded-lg p-4 text-center cursor-pointer transition-all ${
                                        dragOverBefore
                                            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20'
                                            : 'border-zinc-300 dark:border-zinc-600 hover:border-blue-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50'
                                    }`}
                                >
                                    <input
                                        ref={fileBeforeRef}
                                        type="file"
                                        multiple
                                        accept="image/*"
                                        onChange={e => handleFileChange(e, 'photoBeforeFiles')}
                                        className="hidden"
                                    />
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        className="w-8 h-8 mx-auto mb-1 text-zinc-400">
                                        <path fillRule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clipRule="evenodd" />
                                    </svg>
                                    <p className="text-xs text-zinc-500 dark:text-zinc-400">
                                        <span className="font-semibold text-blue-600 dark:text-blue-400">Click to upload</span> or drag & drop
                                    </p>
                                    <p className="text-[10px] text-zinc-400 mt-0.5">PNG, JPG, JPEG (multiple)</p>
                                </div>
                                <div className="flex flex-wrap gap-2 mt-2">
                                    {form.photo_before_existing_urls.map((url, i) => (
                                        <div key={`eb-${i}`} className="relative">
                                            <img src={url} alt="before"
                                                onClick={() => setPreviewUrl(url)}
                                                className="h-16 w-16 object-cover rounded border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:opacity-80" />
                                            <button type="button" onClick={() => removeExistingPhoto(i, true)}
                                                className="absolute -top-1.5 -right-1.5 bg-red-600 text-white rounded-full w-5 h-5 text-xs font-bold leading-none flex items-center justify-center">×</button>
                                        </div>
                                    ))}
                                    {form.photo_before_files.map((f, i) => (
                                        <div key={`nb-${i}`} className="relative">
                                            <img src={f.previewUrl} alt="new before"
                                                onClick={() => setPreviewUrl(f.previewUrl)}
                                                className="h-16 w-16 object-cover rounded border-2 border-blue-400 dark:border-blue-600 cursor-pointer hover:opacity-80" />
                                            <span className="absolute -bottom-1 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-[9px] px-1 rounded">NEW</span>
                                            <button type="button" onClick={() => removeNewFile(i, true)}
                                                className="absolute -top-1.5 -right-1.5 bg-red-600 text-white rounded-full w-5 h-5 text-xs font-bold leading-none flex items-center justify-center">×</button>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {/* Action Description - Rich Text */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Action Description</label>
                                <RichTextEditor
                                    value={form.action_desc}
                                    onChange={(html) => setForm(prev => ({ ...prev, action_desc: html }))}
                                    placeholder="Describe the action taken..."
                                />
                            </div>

                            {/* Photo After - Drag & Drop */}
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Photo After</label>
                                <div
                                    onDragOver={(e) => { e.preventDefault(); setDragOverAfter(true) }}
                                    onDragLeave={(e) => { e.preventDefault(); setDragOverAfter(false) }}
                                    onDrop={(e) => { e.preventDefault(); setDragOverAfter(false); handleDrop(e, 'photoAfterFiles') }}
                                    onClick={() => fileAfterRef.current?.click()}
                                    className={`relative border-2 border-dashed rounded-lg p-4 text-center cursor-pointer transition-all ${
                                        dragOverAfter
                                            ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20'
                                            : 'border-zinc-300 dark:border-zinc-600 hover:border-blue-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50'
                                    }`}
                                >
                                    <input
                                        ref={fileAfterRef}
                                        type="file"
                                        multiple
                                        accept="image/*"
                                        onChange={e => handleFileChange(e, 'photoAfterFiles')}
                                        className="hidden"
                                    />
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        className="w-8 h-8 mx-auto mb-1 text-zinc-400">
                                        <path fillRule="evenodd" d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z" clipRule="evenodd" />
                                    </svg>
                                    <p className="text-xs text-zinc-500 dark:text-zinc-400">
                                        <span className="font-semibold text-blue-600 dark:text-blue-400">Click to upload</span> or drag & drop
                                    </p>
                                    <p className="text-[10px] text-zinc-400 mt-0.5">PNG, JPG, JPEG (multiple)</p>
                                </div>
                                <div className="flex flex-wrap gap-2 mt-2">
                                    {form.photo_after_existing_urls.map((url, i) => (
                                        <div key={`ea-${i}`} className="relative">
                                            <img src={url} alt="after"
                                                onClick={() => setPreviewUrl(url)}
                                                className="h-16 w-16 object-cover rounded border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:opacity-80" />
                                            <button type="button" onClick={() => removeExistingPhoto(i, false)}
                                                className="absolute -top-1.5 -right-1.5 bg-red-600 text-white rounded-full w-5 h-5 text-xs font-bold leading-none flex items-center justify-center">×</button>
                                        </div>
                                    ))}
                                    {form.photo_after_files.map((f, i) => (
                                        <div key={`na-${i}`} className="relative">
                                            <img src={f.previewUrl} alt="new after"
                                                onClick={() => setPreviewUrl(f.previewUrl)}
                                                className="h-16 w-16 object-cover rounded border-2 border-blue-400 dark:border-blue-600 cursor-pointer hover:opacity-80" />
                                            <span className="absolute -bottom-1 left-1/2 -translate-x-1/2 bg-blue-600 text-white text-[9px] px-1 rounded">NEW</span>
                                            <button type="button" onClick={() => removeNewFile(i, false)}
                                                className="absolute -top-1.5 -right-1.5 bg-red-600 text-white rounded-full w-5 h-5 text-xs font-bold leading-none flex items-center justify-center">×</button>
                                        </div>
                                    ))}
                                </div>
                            </div>

                            {form.id && (
                                <div className="text-xs text-zinc-500 dark:text-zinc-400 italic">
                                    Status is changed via the "Update Status" action in the table.
                                </div>
                            )}

                            <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <button type="button" onClick={() => setShowModal(false)}
                                    className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">Cancel</button>
                                <button type="submit" disabled={saving || !isFormValid()}
                                    className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 dark:hover:bg-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm">
                                    {saving ? 'Saving...' : 'Save'}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* ============ MODAL UPDATE STATUS ============ */}
            {showStatusModal && statusTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden">
                        <div className="px-5 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 flex justify-between items-center">
                            <h2 className="text-base font-bold text-white">Update Status</h2>
                            <button onClick={() => setShowStatusModal(false)}
                                className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div className="p-5 space-y-4">
                            <p className="text-sm text-zinc-600 dark:text-zinc-400">
                                Report: <strong>Shift {statusTarget.shift} - {statusTarget.report_category}</strong>
                            </p>
                            <p className="text-sm text-zinc-600 dark:text-zinc-400">
                                Current status: <span className={`px-2 py-0.5 rounded text-xs font-semibold ${statusColor(statusTarget.status)}`}>{statusTarget.status}</span>
                            </p>
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-2">New Status</label>
                                <div className="grid grid-cols-1 gap-2">
                                    {[
                                        {
                                            value: 'On Progress',
                                            label: 'On Progress',
                                            desc: 'Work is ongoing',
                                            active: 'bg-amber-500 border-amber-500 text-white shadow',
                                            hover: 'hover:border-amber-400',
                                            iconColorActive: 'text-white',
                                            iconColorIdle: 'text-amber-600 dark:text-amber-400',
                                            icon: (
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-5">
                                                    <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                                </svg>
                                            ),
                                        },
                                        {
                                            value: 'Under Maintenance',
                                            label: 'Under Maintenance',
                                            desc: 'Being repaired / serviced',
                                            active: 'bg-red-600 border-red-600 text-white shadow',
                                            hover: 'hover:border-red-400',
                                            iconColorActive: 'text-white',
                                            iconColorIdle: 'text-red-600 dark:text-red-400',
                                            icon: (
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-5">
                                                    <path fillRule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clipRule="evenodd" />
                                                </svg>
                                            ),
                                        },
                                        {
                                            value: 'Closed',
                                            label: 'Closed',
                                            desc: 'Work completed',
                                            active: 'bg-emerald-600 border-emerald-600 text-white shadow',
                                            hover: 'hover:border-emerald-400',
                                            iconColorActive: 'text-white',
                                            iconColorIdle: 'text-emerald-600 dark:text-emerald-400',
                                            icon: (
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-5">
                                                    <path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" />
                                                </svg>
                                            ),
                                        },
                                    ].map(opt => {
                                        const isActive = statusValue === opt.value
                                        return (
                                            <button key={opt.value} type="button" onClick={() => setStatusValue(opt.value)}
                                                className={`flex items-center gap-3 px-4 py-3 rounded-lg text-sm border-2 text-left transition-all ${
                                                    isActive
                                                        ? opt.active
                                                        : `bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 ${opt.hover}`
                                                }`}>
                                                <span className={`flex-shrink-0 ${isActive ? opt.iconColorActive : opt.iconColorIdle}`}>
                                                    {opt.icon}
                                                </span>
                                                <span className="flex-1">
                                                    <span className="block font-semibold">{opt.label}</span>
                                                    <span className={`block text-xs ${isActive ? 'text-white/80' : 'text-zinc-500 dark:text-zinc-400'}`}>
                                                        {opt.desc}
                                                    </span>
                                                </span>
                                            </button>
                                        )
                                    })}
                                </div>
                            </div>
                            <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                <button type="button" onClick={() => setShowStatusModal(false)}
                                    className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
                                <button onClick={confirmUpdateStatus} disabled={updatingStatus}
                                    className="px-4 py-2 text-sm rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 disabled:opacity-60">
                                    {updatingStatus ? 'Updating...' : 'Update'}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {/* ============ MODAL DELETE ============ */}
            {showDeleteModal && deleteTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden">
                        <div className="p-5 text-center">
                            <h3 className="text-lg font-bold text-zinc-800 dark:text-white">Delete Daily Report?</h3>
                            <p className="text-sm text-zinc-500 mt-2">
                                Are you sure you want to delete <strong>Shift {deleteTarget.shift} - {deleteTarget.report_category}</strong>?
                            </p>
                        </div>
                        <div className="flex justify-end gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700">
                            <button onClick={() => setShowDeleteModal(false)}
                                className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
                            <button onClick={confirmDelete} disabled={!!deletingId}
                                className="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold disabled:opacity-60">
                                {deletingId ? 'Deleting...' : 'Yes, Delete'}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* ============ PHOTO PREVIEW MODAL ============ */}
            {previewUrl && (
                <div className="fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
                    onClick={() => setPreviewUrl(null)}>
                    <div className="relative max-w-3xl max-h-[85vh]">
                        <img src={previewUrl} alt="preview" className="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl" />
                        <button
                            onClick={(e) => { e.stopPropagation(); setPreviewUrl(null); }}
                            className="absolute -top-4 -right-4 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg transition-colors p-0.5"
                            aria-label="Close preview"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="size-6">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            )}

            {/* ============ MODAL VIEW PHOTOS ============ */}
            {showPhotosModal && photosTarget && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 backdrop-blur-sm p-4 overflow-y-auto">
                    <div className="w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700 my-8">
                        {/* Header */}
                        <div className="px-5 py-4 bg-gradient-to-r from-sky-600 to-sky-700 flex justify-between items-center">
                            <h2 className="text-base font-bold text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="size-5">
                                    <path fillRule="evenodd" d="M1 5.25A2.25 2.25 0 0 1 3.25 3h13.5A2.25 2.25 0 0 1 19 5.25v9.5A2.25 2.25 0 0 1 16.75 17H3.25A2.25 2.25 0 0 1 1 14.75v-9.5Zm1.5 0c0-.414.336-.75.75-.75h13.5c.414 0 .75.336.75.75v3.197l-2.696-2.697a2.25 2.25 0 0 0-3.182 0l-7.872 7.872V5.25Zm2.25 7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" clipRule="evenodd" />
                                </svg>
                                Photos: Shift {photosTarget.shift} - {photosTarget.report_category}
                            </h2>
                            <button onClick={() => setShowPhotosModal(false)}
                                className="text-white/80 hover:text-white transition-colors p-1 rounded hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {/* Body: Grid 2 Kolom (Before & After) */}
                        <div className="p-5 grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {/* Kolom Before */}
                            <div className="flex flex-col">
                                <h3 className="text-sm font-bold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2 shrink-0">
                                    <span className="w-2 h-2 rounded-full bg-red-500"></span>
                                    Photo Before
                                </h3>
                                
                                {photosTarget.photo_before?.length > 0 ? (
                                    <div className="relative">
                                        <div 
                                            onScroll={(e) => {
                                                const el = e.target
                                                // Cek apakah ada foto di bawah (belum scroll mentok)
                                                const isScrollable = el.scrollHeight > el.clientHeight && Math.ceil(el.scrollTop + el.clientHeight) < el.scrollHeight
                                                setPhotoScroll(prev => ({ ...prev, before: isScrollable }))
                                            }}
                                            // max-h disesuaikan dengan 2 baris (foto h-28 + gap-2) = 2 * 112px + 8px = 232px
                                            className="grid grid-cols-2 gap-2 max-h-[232px] overflow-y-auto pr-1 custom-scrollbar content-start"
                                        >
                                            {photosTarget.photo_before.map((url, i) => (
                                                <img key={i} src={url} alt={`Before ${i+1}`} 
                                                    onClick={() => setPreviewUrl(url)}
                                                    className="w-full h-28 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:opacity-80 transition-opacity" />
                                            ))}
                                        </div>
                                        
                                        {/* Indikator Scroll */}
                                        {photoScroll.before && (
                                            <div className="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-white dark:from-zinc-900 to-transparent pointer-events-none flex items-end justify-center pb-1">
                                                <span className="text-[10px] font-semibold text-zinc-500 bg-white/90 dark:bg-zinc-800/90 px-2 py-0.5 rounded-full shadow-sm border border-zinc-200 dark:border-zinc-700">
                                                    Scroll for more
                                                </span>
                                            </div>
                                        )}
                                    </div>
                                ) : (
                                    <div className="py-8 text-center text-sm text-zinc-400 bg-zinc-50 dark:bg-zinc-800/40 rounded-lg border border-dashed border-zinc-300 dark:border-zinc-600">
                                        No photos
                                    </div>
                                )}
                            </div>

                            {/* Kolom After */}
                            <div className="flex flex-col">
                                <h3 className="text-sm font-bold text-zinc-800 dark:text-zinc-100 mb-3 flex items-center gap-2 shrink-0">
                                    <span className="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Photo After
                                </h3>
                                
                                {photosTarget.photo_after?.length > 0 ? (
                                    <div className="relative">
                                        <div 
                                            onScroll={(e) => {
                                                const el = e.target
                                                const isScrollable = el.scrollHeight > el.clientHeight && Math.ceil(el.scrollTop + el.clientHeight) < el.scrollHeight
                                                setPhotoScroll(prev => ({ ...prev, after: isScrollable }))
                                            }}
                                            className="grid grid-cols-2 gap-2 max-h-[232px] overflow-y-auto pr-1 custom-scrollbar content-start"
                                        >
                                            {photosTarget.photo_after.map((url, i) => (
                                                <img key={i} src={url} alt={`After ${i+1}`} 
                                                    onClick={() => setPreviewUrl(url)}
                                                    className="w-full h-28 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:opacity-80 transition-opacity" />
                                            ))}
                                        </div>

                                        {/* Indikator Scroll */}
                                        {photoScroll.after && (
                                            <div className="absolute bottom-0 left-0 right-0 h-10 bg-gradient-to-t from-white dark:from-zinc-900 to-transparent pointer-events-none flex items-end justify-center pb-1">
                                                <span className="text-[10px] font-semibold text-zinc-500 bg-white/90 dark:bg-zinc-800/90 px-2 py-0.5 rounded-full shadow-sm border border-zinc-200 dark:border-zinc-700">
                                                    Scroll for more
                                                </span>
                                            </div>
                                        )}
                                    </div>
                                ) : (
                                    <div className="py-8 text-center text-sm text-zinc-400 bg-zinc-50 dark:bg-zinc-800/40 rounded-lg border border-dashed border-zinc-300 dark:border-zinc-600">
                                        No photos
                                    </div>
                                )}
                            </div>

                        </div>
                    </div>
                </div>
            )}

            {/* ============ TOOLTIP (PORTAL) ============ */}
            {hoverTooltip && typeof document !== 'undefined' && createPortal(
                <div
                    className="fixed w-[420px] max-h-64 overflow-y-auto rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 shadow-2xl p-3 text-xs text-zinc-700 dark:text-zinc-200 pointer-events-none"
                    style={{
                        zIndex: 9999,
                        left: Math.max(8, Math.min(hoverTooltip.x, window.innerWidth - 440)),
                        top: Math.max(8, Math.min(hoverTooltip.y, window.innerHeight - 280)),
                    }}
                >
                    <div
                        className="prose prose-sm dark:prose-invert max-w-none break-words [&_ul]:list-disc [&_ul]:pl-4 [&_ol]:list-decimal [&_ol]:pl-4 [&_p]:my-1"
                        dangerouslySetInnerHTML={{ __html: hoverTooltip.html || '' }}
                    />
                </div>,
                document.body
            )}

            {/* ============ TOAST ============ */}
            {toast && (
                <div className={`fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>
                    {toast.message}
                </div>
            )}
        </div>
    )
}