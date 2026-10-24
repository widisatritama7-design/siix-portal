import React, { useState, useRef, useEffect } from 'react'
import { createPortal } from 'react-dom'

export default function ResultPatrol({ wire, mingleData }) {
    // ============================================================
    // STATE
    // ============================================================
    const [rows, setRows]                         = useState(mingleData?.rows ?? [])
    const [pagination, setPagination]             = useState(mingleData?.pagination ?? { current_page: 1, last_page: 1, per_page: 10, total: 0, from: 0, to: 0 })
    const [loadingPage, setLoadingPage]           = useState(false)
    const [toast, setToast]                       = useState(null)
    const [selectedRow, setSelectedRow]           = useState(null)
    const [photoPreview, setPhotoPreview]         = useState(null)

    // Modals
    const [showStatusModal, setShowStatusModal]       = useState(false)
    const [showViewModal, setShowViewModal]           = useState(false)
    const [showDeleteModal, setShowDeleteModal]       = useState(false)
    const [showEvidenceModal, setShowEvidenceModal]   = useState(false)
    const [showVerifyModal, setShowVerifyModal]       = useState(false)
    const [showHistoryModal, setShowHistoryModal]     = useState(false)
    const [showFindingListModal, setShowFindingListModal] = useState(false)

    // Status
    const [selectedStatus, setSelectedStatus]     = useState('Open')

    const [feedbackTooltip, setFeedbackTooltip] = useState(null)

    // Form Action/Evidence (shared)
    const [findingForm, setFindingForm] = useState({
        index: 0,
        action: '',
        evidence_action: [],
        meta: { category_name: '', feedback_to_name: '', finding_result: '', reason: '' },
    })

    // Saving flags
    const [savingEvidence, setSavingEvidence] = useState(false)
    const [savingVerify, setSavingVerify]     = useState(false)

    // Verify form
    const [verifyForm, setVerifyForm] = useState({ index: 0, action: 'approve', reason: '' })

    // Kamera live
    const [cameraStream, setCameraStream] = useState(null)
    const [cameraError, setCameraError]   = useState('')
    const videoRef  = useRef(null)
    const canvasRef = useRef(null)

    // Filter
    const [filter, setFilter] = useState({
        search: '', date_from: '', date_until: '', shift: '', group: '', line: '', category: '', status: '',
        finding_type: '', progress_action: '',
    })

    // ============================================================
    // AUTO APPLY FILTER (debounce 400ms)
    // ============================================================
    const filterDebounceRef = useRef(null)
    const isFirstRenderRef  = useRef(true)

    useEffect(() => {
        if (isFirstRenderRef.current) {
            isFirstRenderRef.current = false
            return
        }

        if (filterDebounceRef.current) clearTimeout(filterDebounceRef.current)
        filterDebounceRef.current = setTimeout(() => {
            applyFilter()
        }, 400)

        return () => {
            if (filterDebounceRef.current) clearTimeout(filterDebounceRef.current)
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [filter])

    // ============================================================
    // PERMISSION
    // ============================================================
    const permissions = mingleData?.permissions ?? {
        canCreate: false, canEdit: false, canDelete: false, canVerify: false, canFeedback: false,
    }

    // ============================================================
    // HELPER
    // ============================================================
    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    const isFindingApproved = (finding) => finding?.verification_status === 'approve'

    const isFeedbackMine = (finding) => {
        const fb = finding?.feedback_to
        const myId = String(mingleData?.auth_user_id ?? '') // pastikan PHP kirim auth_user_id
        if (!myId) return true // fallback: jika tidak ada info, anggap boleh

        if (Array.isArray(fb)) {
            return fb.map(String).includes(myId)
        }
        return String(fb) === myId
    }

    const getVerifBadge = (finding) => {
        const s = finding?.verification_status || 'pending'
        if (s === 'approve') return { label: '✓ Approved', cls: 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800' }
        if (s === 'reject')  return { label: '✗ Rejected', cls: 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 border-red-200 dark:border-red-800' }
        return { label: 'Pending', cls: 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700' }
    }

    const buildFindingForm = (finding, index) => {
        const catName = finding.category_name ||
            mingleData?.categories?.find(c => String(c.id) === String(finding.category_id))?.category_name || '-'
        const empName = mingleData?.employees?.find(e => String(e.nik) === String(finding.feedback_to))?.name ||
            finding.feedback_to || '-'
        return {
            index,
            action: finding.action ?? '',
            evidence_action: Array.isArray(finding.evidence_action)
                ? finding.evidence_action
                : (finding.evidence_action ? [finding.evidence_action] : []),
            meta: {
                category_name: catName,
                feedback_to_name: empName,
                finding_result: finding.finding_result ?? '',
                reason: finding.reason ?? '',
            },
        }
    }

    // ============================================================
    // KAMERA LIVE
    // ============================================================
    const openCamera = async () => {
        setCameraError('')
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' }, audio: false })
            setCameraStream(stream)
            setTimeout(() => { if (videoRef.current) videoRef.current.srcObject = stream }, 100)
        } catch (err) {
            setCameraError('Gagal mengakses kamera. Pastikan izin kamera telah diberikan di browser Anda.')
            console.error(err)
        }
    }

    const closeCamera = () => {
        if (cameraStream) cameraStream.getTracks().forEach(t => t.stop())
        setCameraStream(null)
        setCameraError('')
    }

    const capturePhoto = () => {
        if (!videoRef.current || !canvasRef.current) return
        const video  = videoRef.current
        const canvas = canvasRef.current
        const ctx    = canvas.getContext('2d')
        canvas.width  = video.videoWidth
        canvas.height = video.videoHeight
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height)
        const imageData = canvas.toDataURL('image/jpeg', 0.8)
        if (findingForm.evidence_action.length >= 4) {
            showToast('Maksimal 4 foto evidence action', 'error')
            closeCamera()
            return
        }
        setFindingForm(prev => ({ ...prev, evidence_action: [...prev.evidence_action, imageData] }))
        closeCamera()
    }

    const removeEvidenceAction = (idx) => {
        setFindingForm(prev => ({ ...prev, evidence_action: prev.evidence_action.filter((_, i) => i !== idx) }))
    }

    // ============================================================
    // FILTER & PAGINATION
    // ============================================================
    const applyFilter = async () => {
        setLoadingPage(true)
        try {
            const result = await wire.setFilter(filter)   // ✅ kirim seluruh object
            setRows(result.rows)
            setPagination(result.pagination)
        } catch { showToast('Failed to apply filter', 'error') }
        finally { setLoadingPage(false) }
    }

    const resetFilter = async () => {
        const empty = {
            search: '', date_from: '', date_until: '', shift: '', group: '', line: '', category: '', status: '',
            finding_type: '', progress_action: '',
        }
        setFilter(empty)
        setLoadingPage(true)
        try {
            const result = await wire.setFilter(empty)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch { showToast('Failed to reset filter', 'error') }
        finally { setLoadingPage(false) }
    }

    const gotoPage = async (page) => {
        setLoadingPage(true)
        try {
            const result = await wire.gotoPage(page)
            setRows(result.rows)
            setPagination(result.pagination)
        } catch { showToast('Failed to change page', 'error') }
        finally { setLoadingPage(false) }
    }

    // ============================================================
    // CRUD
    // ============================================================
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
            } else showToast(result.message, 'error')
        } catch { showToast('Failed to delete data', 'error') }
    }

    // ============================================================
    // STATUS
    // ============================================================
    const handleStatusChange = async (id, newStatus) => {
        if (!permissions.canEdit) return showToast('You do not have permission to change status!', 'error')
        setLoadingPage(true)
        try {
            const result = await wire.updateStatus(id, newStatus)
            if (result.success) {
                setRows(result.data.rows)
                showToast(result.message, 'success')
            } else showToast(result.message, 'error')
        } catch { showToast('Failed to update status', 'error') }
        finally { setLoadingPage(false) }
    }

    const openActionEvidenceModal = (row, finding, index) => {
        if (!permissions.canFeedback) return
        if (isFindingApproved(finding)) {
            showToast('Finding ini sudah di-approve dan tidak bisa diubah', 'error')
            return
        }
        setFindingForm(buildFindingForm(finding, index))
        setSelectedRow(row)
        setShowEvidenceModal(true)
    }

    const closeEvidenceModal = () => {
        if (cameraStream) closeCamera()
        setShowEvidenceModal(false)
        // Kembali ke Finding List jika ada selectedRow
        if (selectedRow) setShowFindingListModal(true)
    }

    const submitActionEvidence = async () => {
        if (!selectedRow) return

        // Validasi wajib
        const plainAction = (findingForm.action || '').replace(/<[^>]*>/g, '').trim()
        if (!plainAction) {
            showToast('Action Taken wajib diisi', 'error')
            return
        }
        if (!Array.isArray(findingForm.evidence_action) || findingForm.evidence_action.length === 0) {
            showToast('Minimal 1 foto Evidence Action', 'error')
            return
        }

        if (cameraStream) closeCamera()
        setSavingEvidence(true)
        try {
            const result = await wire.updateActionAndEvidence(selectedRow.id, findingForm.index, {
                action: findingForm.action,
                evidence_action: findingForm.evidence_action,
            })
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                const updated = result.data.rows.find(r => r.id === selectedRow.id)
                if (updated) setSelectedRow(updated)
                showToast(result.message, 'success')
                closeEvidenceModal()   // sudah menutup modal gabungan + membuka Finding List
            } else showToast(result.message, 'error')
        } catch (e) { console.error(e); showToast('Failed to save Action & Evidence', 'error') }
        finally { setSavingEvidence(false) }
    }

    // ============================================================
    // VERIFIKASI
    // ============================================================
    const openVerifyModal = (row, finding, index, action = 'approve') => {
        if (!permissions.canVerify) return
        const hasAction = finding.action && finding.action.replace(/<[^>]*>/g, '').trim() !== ''
        const hasEvidence = Array.isArray(finding.evidence_action) && finding.evidence_action.length > 0
        if (!hasAction || !hasEvidence) {
            showToast('Action Taken dan Evidence Action harus diisi sebelum verifikasi', 'error')
            return
        }
        setSelectedRow(row)
        setVerifyForm({ index, action, reason: '' })
        setShowVerifyModal(true)
    }

    const submitVerify = async () => {
        if (!selectedRow) return
        if (verifyForm.action === 'reject' && !verifyForm.reason.trim()) {
            showToast('Alasan reject wajib diisi', 'error')
            return
        }
        setSavingVerify(true)
        try {
            const result = await wire.verifyFinding(selectedRow.id, verifyForm.index, verifyForm.action, verifyForm.reason)
            if (result.success) {
                setRows(result.data.rows)
                setPagination(result.data.pagination)
                const updated = result.data.rows.find(r => r.id === selectedRow.id)
                if (updated) setSelectedRow(updated)
                showToast(result.message, 'success')
                setShowVerifyModal(false)
                setShowFindingListModal(true)
            } else showToast(result.message, 'error')
        } catch (e) { console.error(e); showToast('Failed to verify', 'error') }
        finally { setSavingVerify(false) }
    }

    const showFeedbackTooltip = (e, users) => {
    const rect = e.currentTarget.getBoundingClientRect()
        setFeedbackTooltip({
            users,
            x: rect.left + rect.width / 2,
            y: rect.top - 8, // muncul di atas elemen
        })
    }

    const hideFeedbackTooltip = () => setFeedbackTooltip(null)

    // ============================================================
    // RENDER
    // ============================================================
    return (
        <div className="p-1 space-y-2">

            {/* BREADCRUMBS */}
            <nav className="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 overflow-x-auto whitespace-nowrap pb-1">
                <button type="button" onClick={() => window.Livewire.navigate('/main-dashboard')} className="inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">Dashboard</button>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">PROD</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="shrink-0 font-semibold text-black dark:text-white">Patrol Monitoring</span>
                <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
                <span className="font-semibold text-black dark:text-white shrink-0">Result Patrol</span>
            </nav>

            {/* HEADER */}
            <div className="flex flex-col sm:flex-row sm:justify-between sm:items-end gap-3">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">Result Patrol</h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Patrol inspection history list</p>
                </div>
                <div className="flex items-center gap-2">
                    <button
                        onClick={async () => { setLoadingPage(true); try { await wire.exportPdf() } catch { showToast('Failed to export PDF', 'error') } finally { setLoadingPage(false) } }}
                        disabled={loadingPage}
                        className="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition-all shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4"><path fillRule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5H5.625Z" clipRule="evenodd" /><path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" /></svg>
                        Export PDF
                    </button>

                    <button
                        onClick={async () => {
                            setLoadingPage(true)
                            try {
                                const result = await wire.exportExcel()
                                if (result.success) {
                                    const bc = atob(result.file)
                                    const bytes = new Uint8Array(bc.length)
                                    for (let i = 0; i < bc.length; i++) bytes[i] = bc.charCodeAt(i)
                                    const blob = new Blob([bytes], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
                                    const url = window.URL.createObjectURL(blob)
                                    const a = document.createElement('a'); a.href = url; a.download = result.filename
                                    document.body.appendChild(a); a.click(); a.remove()
                                    window.URL.revokeObjectURL(url)
                                    showToast('Excel berhasil diexport!', 'success')
                                } else showToast(result.message, 'error')
                            } catch (e) { console.error(e); showToast('Failed to export Excel', 'error') }
                            finally { setLoadingPage(false) }
                        }}
                        disabled={loadingPage}
                        className="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-semibold transition-all shadow-sm"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4"><path fillRule="evenodd" d="M1.5 5.625c0-1.036.84-1.875 1.875-1.875h17.25c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 18.375V5.625ZM21 9.375A.375.375 0 0 0 20.625 9h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5Zm0 3.75a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5a.375.375 0 0 0 .375-.375v-1.5ZM10.875 18.75a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375h7.5ZM3.375 15h7.5a.375.375 0 0 0 .375-.375v-1.5a.375.375 0 0 0-.375-.375h-7.5a.375.375 0 0 0-.375.375v1.5c0 .207.168.375.375.375Zm0-3.75h7.5a.375.375 0 0 0 .375-.375v-1.5A.375.375 0 0 0 10.875 9h-7.5A.375.375 0 0 0 3 9.375v1.5c0 .207.168.375.375.375Z" clipRule="evenodd" /></svg>
                        Export Excel
                    </button>

                    {permissions.canCreate && (
                        <button onClick={() => window.Livewire.navigate('/prod/patrol/result-patrol/create')} className="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold transition-all shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4"><path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" /></svg>
                            Input Result
                        </button>
                    )}
                </div>
            </div>

            {/* FILTER CARD */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm mb-3">
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex flex-col xl:flex-row xl:items-center justify-between gap-3">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 text-white"><path fillRule="evenodd" d="M3.792 2.938A49.069 49.069 0 0 1 12 2.25c2.797 0 5.54.236 8.209.688a1.857 1.857 0 0 1 1.541 1.836v1.044a3 3 0 0 1-.879 2.121l-6.182 6.182a1.5 1.5 0 0 0-.439 1.061v2.927a3 3 0 0 1-1.658 2.684l-1.757.878A.75.75 0 0 1 9.75 21v-5.818a1.5 1.5 0 0 0-.44-1.06L3.13 7.938a3 3 0 0 1-.879-2.121V4.774c0-.897.64-1.683 1.542-1.836Z" clipRule="evenodd" /></svg>
                        <span className="text-sm font-bold text-white whitespace-nowrap">Filter</span>
                    </div>
                    <div className="flex flex-wrap items-center gap-2 w-full xl:w-auto">
                        <div className="relative w-full sm:w-64">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none"><path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            <input type="text" placeholder="Search line / location..." value={filter.search} onChange={(e) => setFilter({ ...filter, search: e.target.value })} className="w-full pl-9 pr-3 py-1.5 text-sm rounded-md border-none bg-white text-zinc-800 placeholder:text-zinc-400 focus:outline-none focus:ring-2 focus:ring-white/50 shadow-sm" />
                        </div>
                        {(() => {
                            const active =
                                filter.search !== '' || filter.shift !== '' || filter.group !== '' ||
                                filter.category !== '' || filter.status !== '' || filter.date_from !== '' ||
                                filter.date_until !== '' || filter.finding_type !== '' || filter.progress_action !== ''
                            if (!active) return null
                            return (
                                <div className="flex gap-1.5 w-full sm:w-auto">
                                    <button
                                        onClick={resetFilter}
                                        className="flex-1 sm:flex-none px-4 py-1.5 text-sm font-semibold rounded-md bg-red-500 hover:bg-red-600 text-white transition-colors shadow-sm"
                                    >
                                        Reset Filter
                                    </button>
                                </div>
                            )
                        })()}
                    </div>
                </div>

                <div className="p-4 space-y-3">
                    {/* Row 1: Shift, Group, Category, Status */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Shift</label>
                            <div className="relative">
                                <select value={filter.shift} onChange={(e) => setFilter({ ...filter, shift: e.target.value })} className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <option value="">All Shifts</option>
                                    <option value="NS">NS</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400"><path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </div>
                        </div>
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Group</label>
                            <div className="relative">
                                <select value={filter.group} onChange={(e) => setFilter({ ...filter, group: e.target.value })} className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <option value="">All Groups</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400"><path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </div>
                        </div>
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Category</label>
                            <div className="relative">
                                <select value={filter.category} onChange={(e) => setFilter({ ...filter, category: e.target.value })} className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <option value="">All Categories</option>
                                    {mingleData?.categories?.map(cat => <option key={cat.id} value={cat.id}>{cat.category_name}</option>)}
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400"><path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </div>
                        </div>
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Status</label>
                            <div className="relative">
                                <select value={filter.status} onChange={(e) => setFilter({ ...filter, status: e.target.value })} className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <option value="">All Status</option>
                                    <option value="Open">Open</option>
                                    <option value="On Progress">On Progress</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Closed">Closed</option>
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400"><path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </div>
                        </div>
                    </div>

                    {/* Row 2: Date From, Date Until, Finding Type, Progress Action */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Date From</label>
                            <input type="date" value={filter.date_from} onChange={(e) => setFilter({ ...filter, date_from: e.target.value })} className="w-full px-3 py-2 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Date Until</label>
                            <input type="date" value={filter.date_until} onChange={(e) => setFilter({ ...filter, date_until: e.target.value })} className="w-full px-3 py-2 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Finding Type</label>
                            <div className="relative">
                                <select value={filter.finding_type} onChange={(e) => setFilter({ ...filter, finding_type: e.target.value })} className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <option value="">All Types</option>
                                    <option value="safe">Safe</option>
                                    <option value="finding">Finding</option>
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400"><path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" /></svg></div>
                            </div>
                        </div>
                        {/* ✅ Progress Action */}
                        <div className="flex flex-col gap-1">
                            <label className="text-xs font-medium text-zinc-500">Progress Action</label>
                            <div className="relative">
                                <select
                                    value={filter.progress_action}
                                    onChange={(e) => setFilter({ ...filter, progress_action: e.target.value })}
                                    className="w-full appearance-none px-3 py-2 pr-10 text-sm rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-900 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer"
                                >
                                    <option value="">All Progress</option>
                                    <option value="lengkap">Lengkap</option>
                                    <option value="belum_diisi">Belum Diisi</option>
                                    <option value="sebagian">Sebagian</option>       {/* ✅ BARU */}
                                    <option value="waiting_approval">Waiting Approval</option>  {/* ✅ BARU */}
                                </select>
                                <div className="pointer-events-none absolute inset-y-0 right-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* TABLE */}
            <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
                <div className="px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-blue-800 flex items-center justify-between">
                    <div className="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4 text-white"><path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" /><path fillRule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clipRule="evenodd" /></svg>
                        <span className="text-sm font-bold text-white">Result History Table</span>
                    </div>
                </div>

                <div className="overflow-x-auto overflow-y-visible">
                    <table className="w-full text-sm text-left min-w-[1050px] whitespace-nowrap">
                        <thead className="bg-zinc-50 dark:bg-zinc-800/80 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th className="sticky left-0 z-[1] px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center bg-zinc-50 dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700">Shift / Group</th>
                                <th className="sticky left-[110px] z-[1] px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center bg-zinc-50 dark:bg-zinc-800 border-r border-zinc-200 dark:border-zinc-700">Line</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Category</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Finding</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Feedback To</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Progress Action</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Status</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Created By</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center">Date</th>
                                <th className="px-4 py-3 text-xs uppercase tracking-wider font-semibold text-zinc-500 dark:text-zinc-400 text-center w-48">Action</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                            {loadingPage ? (
                                <tr><td colSpan={10} className="px-4 py-12 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    <div className="flex flex-col items-center justify-center gap-2">
                                        <svg className="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4"></circle><path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                        Loading data...
                                    </div>
                                </td></tr>
                            ) : rows.length === 0 ? (
                                <tr><td colSpan={10} className="px-4 py-16 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                    <div className="flex flex-col items-center justify-center w-full h-full space-y-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" className="w-14 h-14 text-zinc-300 dark:text-zinc-600"><path strokeLinecap="round" strokeLinejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>
                                        <p className="font-medium">No result patrol data yet.</p>
                                    </div>
                                </td></tr>
                            ) : rows.map(r => (
                                <tr key={r.id} className="group hover:bg-blue-50/50 dark:hover:bg-blue-950/20 transition-colors">
                                    <td className="sticky left-0 z-[1] px-4 py-3 text-center bg-white dark:bg-zinc-900 group-hover:bg-blue-50 dark:group-hover:bg-blue-950/40 border-r border-zinc-200 dark:border-zinc-700 transition-colors">
                                        <span className="inline-flex items-center px-2.5 py-1 rounded-md bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-bold">{r.shift} / {r.group}</span>
                                    </td>
                                    <td className="sticky left-[110px] z-[1] px-4 py-3 text-center bg-white dark:bg-zinc-900 group-hover:bg-blue-50 dark:group-hover:bg-blue-950/40 border-r border-zinc-200 dark:border-zinc-700 transition-colors">
                                        <div className="flex items-center gap-2">
                                            <span className="font-semibold text-zinc-800 dark:text-zinc-100">{r.master_line?.line_number}</span>
                                            <span className="text-xs text-zinc-500 dark:text-zinc-400">({r.master_line?.location})</span>
                                        </div>
                                    </td>
                                    <td className="px-4 py-3 text-center">
                                        {r.finding_patrol_items?.length > 0 && r.finding_patrol_items[0].category_id
                                            ? mingleData?.categories?.find(c => String(c.id) === String(r.finding_patrol_items[0].category_id))?.category_name || '-'
                                            : <span className="text-zinc-400">-</span>}
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

                                    <td className="px-4 py-3 text-center">
                                        {Array.isArray(r.feedback_users) && r.feedback_users.length > 0 ? (
                                            (() => {
                                                const users = r.feedback_users
                                                const visible = users.slice(0, 2)
                                                const remaining = users.length - visible.length

                                                return (
                                                    <div
                                                        className="relative inline-flex items-center justify-center gap-1 cursor-help"
                                                        onMouseEnter={(e) => showFeedbackTooltip(e, users)}
                                                        onMouseLeave={hideFeedbackTooltip}
                                                        onClick={(e) => {
                                                            e.stopPropagation()
                                                            showFeedbackTooltip(e, users)
                                                        }}
                                                    >
                                                        {visible.map((u) => (
                                                            <span
                                                                key={u.id}
                                                                className="inline-flex items-center gap-1 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 px-2 py-0.5 rounded-md text-[11px] font-semibold border border-indigo-200 dark:border-indigo-800 whitespace-nowrap"
                                                            >
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3 h-3">
                                                                    <path fillRule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clipRule="evenodd" />
                                                                </svg>
                                                                {u.name}
                                                            </span>
                                                        ))}

                                                        {remaining > 0 && (
                                                            <span className="inline-flex items-center justify-center min-w-[28px] h-5 px-1.5 rounded-md bg-indigo-600 text-white text-[10px] font-bold shadow-sm">
                                                                +{remaining}
                                                            </span>
                                                        )}
                                                    </div>
                                                )
                                            })()
                                        ) : (
                                            <span className="text-zinc-400 text-xs">-</span>
                                        )}
                                    </td>

                                    <td className="px-4 py-3 text-center">
                                        {(() => {
                                            const p = r.progress
                                            if (!p || p.status === 'N/A') return <span className="text-zinc-400 text-xs">-</span>

                                            const config = {
                                                'Belum Diisi': { bg: 'bg-red-100 dark:bg-red-900/40', text: 'text-red-700 dark:text-red-300', border: 'border-red-200 dark:border-red-800' },
                                                'Sebagian':    { bg: 'bg-amber-100 dark:bg-amber-900/40', text: 'text-amber-700 dark:text-amber-300', border: 'border-amber-200 dark:border-amber-800' },
                                                'Lengkap':     { bg: 'bg-emerald-100 dark:bg-emerald-900/40', text: 'text-emerald-700 dark:text-emerald-300', border: 'border-emerald-200 dark:border-emerald-800' },
                                            }
                                            const c = config[p.status] || config['Belum Diisi']

                                            const findings = r.finding_patrol_items || []
                                            const total = p.total_findings || findings.length
                                            const approved = findings.filter(f => f.verification_status === 'approve').length
                                            const rejected = findings.filter(f => f.verification_status === 'reject').length

                                            // ✅ Cek "Waiting Approval": semua sudah diisi (Lengkap) TAPI belum semua approved
                                            const isLengkap = p.status === 'Lengkap'
                                            const isFullyApproved = total > 0 && approved === total
                                            const isWaitingApproval = isLengkap && !isFullyApproved

                                            return (
                                                <div className="inline-flex flex-col items-center gap-1">
                                                    <span className={`inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold border ${c.bg} ${c.text} ${c.border}`}>
                                                        {p.status}
                                                    </span>
                                                    <span className="text-[10px] text-zinc-500 dark:text-zinc-400 font-medium">
                                                        {p.completed_findings}/{p.total_findings} finding
                                                    </span>
                                                    {approved > 0 && (
                                                        <span className="text-[10px] text-emerald-600 dark:text-emerald-400 font-bold">
                                                            ✓ {approved} approved
                                                        </span>
                                                    )}
                                                    {rejected > 0 && (
                                                        <span className="text-[10px] text-red-600 dark:text-red-400 font-bold">
                                                            ✗ {rejected} rejected
                                                        </span>
                                                    )}

                                                    {/* ✅ BARU: Waiting Approval badge */}
                                                    {isWaitingApproval && (
                                                        <span className="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 border border-amber-300 dark:border-amber-700 text-[10px] font-bold mt-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3 h-3">
                                                                <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                                            </svg>
                                                            Waiting Approval
                                                        </span>
                                                    )}
                                                </div>
                                            )
                                        })()}
                                    </td>

                                    <td className="px-4 py-3 text-center">
                                        {r.status === 'Closed' ? (
                                            <span className="inline-flex items-center gap-1.5 bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 px-3 py-1.5 rounded-md text-xs font-bold border border-emerald-200 dark:border-emerald-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4"><path fillRule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" /></svg>
                                                Closed
                                            </span>
                                        ) : (
                                            <span
                                                className={`inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-xs font-bold border shadow-sm ${
                                                    r.status === 'Open'
                                                        ? 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/40 dark:text-blue-300 dark:border-blue-800'
                                                        : r.status === 'On Progress'
                                                        ? 'bg-amber-100 text-amber-700 border-amber-200 dark:bg-amber-900/40 dark:text-amber-300 dark:border-amber-800'
                                                        : 'bg-purple-100 text-purple-700 border-purple-200 dark:bg-purple-900/40 dark:text-purple-300 dark:border-purple-800'
                                                }`}
                                            >
                                                {r.status === 'Open' && (
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                        <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                                    </svg>
                                                )}
                                                {r.status}
                                            </span>
                                        )}
                                    </td>

                                    <td className="px-4 py-3 text-xs text-zinc-600 dark:text-zinc-300 font-medium text-center">{r.created_by || '-'}</td>
                                    <td className="px-4 py-3 text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap text-center">{r.created_at}</td>
                                    <td className="px-4 py-3">
                                        <div className="flex justify-center gap-1.5">
                                            {r.finding_patrol_items?.length > 0 && r.status !== 'Closed' && (
                                                <div className="relative group/btn">
                                                    <button
                                                        onClick={() => { setSelectedRow(r); setShowFindingListModal(true) }}
                                                        className="inline-flex items-center justify-center w-8 h-8 rounded-md bg-purple-600 hover:bg-purple-700 text-white transition-colors shadow-sm"
                                                    >
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                            <path fillRule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clipRule="evenodd" />
                                                        </svg>
                                                    </button>
                                                    <span className="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 whitespace-nowrap opacity-0 group-hover/btn:opacity-100 transition-opacity duration-150 bg-zinc-900 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded shadow-lg z-10">
                                                        Finding ({r.finding_patrol_items.length})
                                                    </span>
                                                </div>
                                            )}

                                            <div className="relative group/btn">
                                                <button
                                                    onClick={() => { setSelectedRow(r); setShowViewModal(true) }}
                                                    className="inline-flex items-center justify-center w-8 h-8 rounded-md bg-blue-600 hover:bg-blue-700 text-white transition-colors shadow-sm"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                        <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                        <path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" />
                                                    </svg>
                                                </button>
                                                <span className="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 whitespace-nowrap opacity-0 group-hover/btn:opacity-100 transition-opacity duration-150 bg-zinc-900 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded shadow-lg z-10">
                                                    View
                                                </span>
                                            </div>

                                            {r.status !== 'Closed' && (
                                                <>
                                                    {permissions.canEdit && (
                                                        <div className="relative group/btn">
                                                            <button
                                                                onClick={() => window.Livewire.navigate(`/prod/patrol/result-patrol/${r.id}/edit`)}
                                                                className="inline-flex items-center justify-center w-8 h-8 rounded-md bg-amber-500 hover:bg-amber-600 text-white transition-colors shadow-sm"
                                                            >
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                                </svg>
                                                            </button>
                                                            <span className="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 whitespace-nowrap opacity-0 group-hover/btn:opacity-100 transition-opacity duration-150 bg-zinc-900 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded shadow-lg z-10">
                                                                Edit
                                                            </span>
                                                        </div>
                                                    )}
                                                    {permissions.canDelete && r.status === 'Open' && (
                                                        <div className="relative group/btn">
                                                            <button
                                                                onClick={() => openDeleteConfirm(r)}
                                                                className="inline-flex items-center justify-center w-8 h-8 rounded-md bg-red-600 hover:bg-red-700 text-white transition-colors shadow-sm"
                                                            >
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                                                    <path fillRule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Z" clipRule="evenodd" />
                                                                </svg>
                                                            </button>
                                                            <span className="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-1.5 whitespace-nowrap opacity-0 group-hover/btn:opacity-100 transition-opacity duration-150 bg-zinc-900 dark:bg-zinc-700 text-white text-[10px] font-semibold px-2 py-1 rounded shadow-lg z-10">
                                                                Delete
                                                            </span>
                                                        </div>
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

                {pagination.last_page > 1 && (
                    <div className="px-4 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3">

                        {/* Info range */}
                        <div className="text-sm text-zinc-500 dark:text-zinc-400 text-center lg:text-left whitespace-nowrap">
                            Showing <strong className="text-zinc-700 dark:text-zinc-200">{pagination.from ?? 0}</strong>
                            {' - '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.to ?? 0}</strong>
                            {' of '}
                            <strong className="text-zinc-700 dark:text-zinc-200">{pagination.total}</strong>
                            {' data'}
                        </div>

                        {/* Page numbers */}
                        <div className="flex items-center justify-center lg:justify-end gap-1 flex-wrap">
                            {/* First */}
                            <button
                                onClick={() => gotoPage(1)}
                                disabled={pagination.current_page === 1 || loadingPage}
                                className="inline-flex items-center justify-center w-8 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                title="First page"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                    <path fillRule="evenodd" d="M18.72 4.72a.75.75 0 0 1 0 1.06L12.56 12l6.16 6.22a.75.75 0 1 1-1.06 1.06l-6.25-6.25a1.5 1.5 0 0 1 0-2.06l6.25-6.25a.75.75 0 0 1 1.06 0Zm-6.44 0a.75.75 0 0 1 0 1.06L6.12 12l6.16 6.22a.75.75 0 1 1-1.06 1.06l-6.25-6.25a1.5 1.5 0 0 1 0-2.06l6.25-6.25a.75.75 0 0 1 1.06 0Z" clipRule="evenodd" />
                                </svg>
                            </button>

                            {/* Prev */}
                            <button
                                onClick={() => gotoPage(pagination.current_page - 1)}
                                disabled={pagination.current_page === 1 || loadingPage}
                                className="inline-flex items-center justify-center gap-1 px-3 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                    <path fillRule="evenodd" d="M15.53 4.72a.75.75 0 0 1 0 1.06L9.31 12l6.22 6.22a.75.75 0 1 1-1.06 1.06l-6.25-6.25a1.5 1.5 0 0 1 0-2.06l6.25-6.25a.75.75 0 0 1 1.06 0Z" clipRule="evenodd" />
                                </svg>
                                <span className="hidden sm:inline">Prev</span>
                            </button>

                            {/* Page numbers */}
                            {(() => {
                                const current = pagination.current_page
                                const last = pagination.last_page
                                const pages = []

                                // Tampilkan maksimal 7 angka (dengan ellipsis)
                                const showMax = 7
                                let start = Math.max(2, current - 2)
                                let end = Math.min(last - 1, current + 2)

                                if (current <= 4) {
                                    start = 2
                                    end = Math.min(last - 1, showMax - 1)
                                } else if (current >= last - 3) {
                                    start = Math.max(2, last - (showMax - 2))
                                    end = last - 1
                                }

                                // Halaman pertama
                                pages.push(
                                    <button
                                        key={1}
                                        onClick={() => gotoPage(1)}
                                        disabled={loadingPage}
                                        className={`min-w-[34px] h-8 px-2 text-sm rounded-lg border font-bold transition-colors disabled:cursor-not-allowed ${
                                            current === 1
                                                ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                                                : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300'
                                        }`}
                                    >
                                        1
                                    </button>
                                )

                                // Ellipsis kiri
                                if (start > 2) {
                                    pages.push(
                                        <span key="ellipsis-left" className="px-1 text-zinc-400 dark:text-zinc-500 select-none">…</span>
                                    )
                                }

                                // Halaman tengah
                                for (let i = start; i <= end; i++) {
                                    pages.push(
                                        <button
                                            key={i}
                                            onClick={() => gotoPage(i)}
                                            disabled={loadingPage}
                                            className={`min-w-[34px] h-8 px-2 text-sm rounded-lg border font-bold transition-colors disabled:cursor-not-allowed ${
                                                current === i
                                                    ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                                                    : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300'
                                            }`}
                                        >
                                            {i}
                                        </button>
                                    )
                                }

                                // Ellipsis kanan
                                if (end < last - 1) {
                                    pages.push(
                                        <span key="ellipsis-right" className="px-1 text-zinc-400 dark:text-zinc-500 select-none">…</span>
                                    )
                                }

                                // Halaman terakhir
                                if (last > 1) {
                                    pages.push(
                                        <button
                                            key={last}
                                            onClick={() => gotoPage(last)}
                                            disabled={loadingPage}
                                            className={`min-w-[34px] h-8 px-2 text-sm rounded-lg border font-bold transition-colors disabled:cursor-not-allowed ${
                                                current === last
                                                    ? 'bg-blue-600 border-blue-600 text-white shadow-sm'
                                                    : 'border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300'
                                            }`}
                                        >
                                            {last}
                                        </button>
                                    )
                                }

                                return pages
                            })()}

                            {/* Next */}
                            <button
                                onClick={() => gotoPage(pagination.current_page + 1)}
                                disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="inline-flex items-center justify-center gap-1 px-3 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors whitespace-nowrap"
                            >
                                <span className="hidden sm:inline">Next</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                    <path fillRule="evenodd" d="M8.47 4.72a.75.75 0 0 1 1.06 0l6.25 6.25a1.5 1.5 0 0 1 0 2.06l-6.25 6.25a.75.75 0 1 1-1.06-1.06L14.69 12 8.47 5.78a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                </svg>
                            </button>

                            {/* Last */}
                            <button
                                onClick={() => gotoPage(pagination.last_page)}
                                disabled={pagination.current_page === pagination.last_page || loadingPage}
                                className="inline-flex items-center justify-center w-8 h-8 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-40 disabled:cursor-not-allowed transition-colors"
                                title="Last page"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                                    <path fillRule="evenodd" d="M5.28 4.72a.75.75 0 0 0 0 1.06L11.44 12l-6.16 6.22a.75.75 0 1 0 1.06 1.06l6.25-6.25a1.5 1.5 0 0 0 0-2.06L6.34 4.72a.75.75 0 0 0-1.06 0Zm6.44 0a.75.75 0 0 0 0 1.06L17.88 12l-6.16 6.22a.75.75 0 1 0 1.06 1.06l6.25-6.25a1.5 1.5 0 0 0 0-2.06L12.78 4.72a.75.75 0 0 0-1.06 0Z" clipRule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                )}
            </div>

            {/* MODAL STATUS */}
            {showStatusModal && selectedRow && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white"><path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" /></svg>
                            </div>
                            <div>
                                <h3 className="text-base font-bold text-white">Update Status</h3>
                                <p className="text-xs text-blue-100">Ubah status untuk <strong>{selectedRow.master_line?.line_number}</strong></p>
                            </div>
                        </div>
                        <div className="p-5 space-y-3">
                            {['Open', 'On Progress', 'Pending', 'Closed'].map((status) => (
                                <label key={status} className={`flex items-center justify-between p-3 border rounded-lg cursor-pointer transition-colors ${selectedStatus === status ? 'bg-blue-50 border-blue-300 dark:bg-blue-900/30 dark:border-blue-600' : 'bg-white border-zinc-200 dark:bg-zinc-800 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700/50'}`}>
                                    <div className="flex items-center gap-3">
                                        <input type="radio" name="status" value={status} checked={selectedStatus === status} onChange={() => setSelectedStatus(status)} className="w-4 h-4 text-blue-600 dark:text-blue-500 bg-white dark:bg-zinc-700 border-zinc-300 dark:border-zinc-600 focus:ring-blue-500 cursor-pointer" />
                                        <span className="font-semibold text-sm text-zinc-800 dark:text-zinc-200">{status}</span>
                                    </div>
                                    <span className={`w-3 h-3 rounded-full ${status === 'Open' ? 'bg-blue-500' : status === 'On Progress' ? 'bg-amber-500' : status === 'Pending' ? 'bg-purple-500' : 'bg-zinc-500 dark:bg-zinc-400'}`}></span>
                                </label>
                            ))}
                        </div>
                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                            <button onClick={() => setShowStatusModal(false)} className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">Cancel</button>
                            <button onClick={async () => { setShowStatusModal(false); await handleStatusChange(selectedRow.id, selectedStatus) }} className="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-blue-700 dark:hover:bg-blue-500 transition-colors">Save Changes</button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL VIEW */}
            {showViewModal && selectedRow && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center text-white">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" /></svg>
                                <h2 className="font-bold text-lg">Result Detail: {selectedRow.master_line?.line_number}</h2>
                            </div>
                            <button onClick={() => setShowViewModal(false)} className="p-1.5 rounded-lg hover:bg-white/20 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div className="p-6 overflow-y-auto space-y-6 text-sm">
                            <div className="grid grid-cols-2 gap-4">
                                <div className="bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 p-3 rounded-xl flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-blue-200 dark:bg-blue-800 flex items-center justify-center text-blue-700 dark:text-blue-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" /></svg>
                                    </div>
                                    <div>
                                        <span className="text-xs text-blue-600 dark:text-blue-400 font-semibold uppercase block">Shift</span>
                                        <strong className="text-xl text-blue-900 dark:text-blue-200">{selectedRow.shift}</strong>
                                    </div>
                                </div>
                                <div className="bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-100 dark:border-emerald-800 p-3 rounded-xl flex items-center gap-3">
                                    <div className="w-10 h-10 rounded-full bg-emerald-200 dark:bg-emerald-800 flex items-center justify-center text-emerald-700 dark:text-emerald-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" /></svg>
                                    </div>
                                    <div>
                                        <span className="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase block">Group</span>
                                        <strong className="text-xl text-emerald-900 dark:text-emerald-200">{selectedRow.group}</strong>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3 className="font-bold text-base mb-2 border-b border-zinc-200 dark:border-zinc-700 pb-2 flex items-center gap-2 text-zinc-800 dark:text-zinc-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4"><path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" /><path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clipRule="evenodd" /></svg>
                                    Standard Check
                                </h3>
                                {(!selectedRow.standard_patrol_items || selectedRow.standard_patrol_items.length === 0) ? (
                                    <p className="text-sm text-zinc-500 dark:text-zinc-400 italic">No standard check available.</p>
                                ) : (() => {
                                    const grouped = selectedRow.standard_patrol_items.reduce((acc, item) => {
                                        const ln = item.line_name || 'No Line'
                                        if (!acc[ln]) acc[ln] = []
                                        acc[ln].push(item)
                                        return acc
                                    }, {})
                                    return Object.entries(grouped).map(([lineName, items]) => (
                                        <div key={lineName} className="mb-4 last:mb-0 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden shadow-sm">
                                            <div className="bg-zinc-100 dark:bg-zinc-800 px-4 py-2 border-b border-zinc-200 dark:border-zinc-700">
                                                <span className="font-bold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-wide">{lineName}</span>
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
                                                    {items.map((it, idx) => (
                                                        <tr key={idx} className="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/40">
                                                            <td className="p-2.5 text-zinc-800 dark:text-zinc-200 font-medium">{it.item_check}</td>
                                                            <td className="p-2.5 text-center">
                                                                <span className={`inline-block px-2 py-1 rounded text-xs font-bold ${it.result === 'NG' ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300' : 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300'}`}>{it.result}</span>
                                                            </td>
                                                            <td className="p-2.5 text-zinc-600 dark:text-zinc-400">{it.remarks || '-'}</td>
                                                        </tr>
                                                    ))}
                                                </tbody>
                                            </table>
                                        </div>
                                    ))
                                })()}
                            </div>

                            <div>
                                <h3 className="font-bold text-base mb-3 border-b border-zinc-200 dark:border-zinc-700 pb-2 flex items-center gap-2 text-zinc-800 dark:text-zinc-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-red-500"><path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" /></svg>
                                    Finding
                                </h3>

                                {(!selectedRow.finding_patrol_items || selectedRow.finding_patrol_items.length === 0) ? (
                                    <div className="p-5 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-300 flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-8 h-8 text-emerald-500 dark:text-emerald-400"><path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" /></svg>
                                        <span className="font-bold text-sm">No findings (Safe)</span>
                                        <span className="text-xs text-emerald-600 dark:text-emerald-400">All inspection standards are met.</span>
                                    </div>
                                ) : (
                                    <div className="space-y-5">
                                        {selectedRow.finding_patrol_items.map((f, i) => {
                                            const verifBadge = getVerifBadge(f)
                                            const approved = isFindingApproved(f)
                                            const catName = f.category_name || mingleData?.categories?.find(c => String(c.id) === String(f.category_id))?.category_name || '-'
                                            const empName = mingleData?.employees?.find(e => String(e.id) === String(f.feedback_to))?.name
                                                || mingleData?.employees?.find(e => String(e.nik) === String(f.feedback_to))?.name
                                                || f.feedback_to
                                                || '-'
                                            const evidenceList = Array.isArray(f.evidence) ? f.evidence : (f.evidence ? [f.evidence] : [])
                                            const evidenceActionList = Array.isArray(f.evidence_action) ? f.evidence_action : (f.evidence_action ? [f.evidence_action] : [])
                                            const hasAction      = f.action && f.action.replace(/<[^>]*>/g, '').trim() !== ''
                                            const hasEvidenceAct = evidenceActionList.length > 0
                                            const canVerifyHere  = permissions.canVerify && !approved && hasAction && hasEvidenceAct

                                            return (
                                                <div key={i} className="border border-zinc-200 dark:border-zinc-700 rounded-xl bg-white dark:bg-zinc-900 shadow-sm overflow-hidden">
                                                    <div className="bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 text-white">
                                                        <div className="flex items-center justify-between gap-2 flex-wrap">
                                                            <div className="flex items-center gap-3 flex-wrap">
                                                                <span className="bg-white/20 w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0">{i + 1}</span>
                                                                <h4 className="font-bold text-sm">Finding Detail</h4>
                                                                <span className={`px-2 py-0.5 rounded text-[10px] font-bold border ${verifBadge.cls}`}>{verifBadge.label}</span>
                                                            </div>
                                                            {f.history?.length > 0 && (
                                                                <button
                                                                    onClick={() => setShowHistoryModal(true)}
                                                                    className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white/20 hover:bg-white/30 text-white text-[11px] font-bold transition-colors"
                                                                    title="Lihat history revisi"
                                                                >
                                                                    📜 {f.history.length} revisi
                                                                </button>
                                                            )}
                                                        </div>
                                                        {f.verification_status === 'reject' && f.rejection_reason && (
                                                            <div className="mt-2 p-2 bg-white/15 rounded text-xs">
                                                                <strong>Alasan reject:</strong> {f.rejection_reason}
                                                                {f.rejected_by_name && <span className="ml-1 text-[10px] opacity-80">— oleh {f.rejected_by_name}</span>}
                                                            </div>
                                                        )}
                                                    </div>

                                                    <div className="p-4 space-y-3">
                                                        {/* Category */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Category</span>
                                                            <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100">{catName}</span>
                                                        </div>

                                                        {/* Finding Result */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Finding Result</span>
                                                            <div className="rte-content text-sm font-semibold text-zinc-800 dark:text-zinc-100" dangerouslySetInnerHTML={{ __html: f.finding_result || '-' }} />
                                                        </div>

                                                        {/* Feedback To (User) */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Feedback To (User)</span>
                                                            <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100">{empName}</span>
                                                        </div>

                                                        {/* Evidence */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Evidence (Live Photo) — {evidenceList.length} foto</span>
                                                            {evidenceList.length === 0 ? (
                                                                <div className="p-3 bg-zinc-100 dark:bg-zinc-800 rounded text-center text-xs text-zinc-400 dark:text-zinc-500 italic">No photo</div>
                                                            ) : (
                                                                <div className="grid grid-cols-4 gap-2">
                                                                    {evidenceList.map((photo, pIdx) => (
                                                                        <div key={pIdx} className="relative group cursor-pointer rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800" onClick={() => setPhotoPreview({ url: photo, title: `Initial Evidence ${pIdx + 1}` })}>
                                                                            <img src={photo} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt={`Evidence ${pIdx + 1}`} />
                                                                        </div>
                                                                    ))}
                                                                </div>
                                                            )}
                                                        </div>

                                                        {/* Reason */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Reason</span>
                                                            <div className="rte-content text-sm text-zinc-800 dark:text-zinc-100 max-h-[120px] overflow-y-auto" dangerouslySetInnerHTML={{ __html: f.reason || '-' }} />
                                                        </div>

                                                        {/* Evidence Action */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Evidence Action (Live Photo) — {evidenceActionList.length} foto</span>
                                                            {evidenceActionList.length === 0 ? (
                                                                <div className="p-3 bg-zinc-100 dark:bg-zinc-800 rounded text-center text-xs text-zinc-400 dark:text-zinc-500 italic">No photo</div>
                                                            ) : (
                                                                <div className="grid grid-cols-4 gap-2">
                                                                    {evidenceActionList.map((photo, pIdx) => (
                                                                        <div key={pIdx} className="relative group cursor-pointer rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800" onClick={() => setPhotoPreview({ url: photo, title: `Action Evidence ${pIdx + 1}` })}>
                                                                            <img src={photo} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt={`Action Evidence ${pIdx + 1}`} />
                                                                        </div>
                                                                    ))}
                                                                </div>
                                                            )}
                                                        </div>

                                                        {/* Action Taken */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Action Taken</span>
                                                            <div className="rte-content text-sm text-zinc-800 dark:text-zinc-100 max-h-[120px] overflow-y-auto" dangerouslySetInnerHTML={{ __html: f.action || '-' }} />
                                                        </div>

                                                        {/* ✅ APPROVE / REJECT DI MODAL VIEW */}
                                                        {permissions.canVerify && (
                                                            <div className="flex items-center justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                                                {!approved && canVerifyHere && (
                                                                    <>
                                                                        <button
                                                                            onClick={() => { setShowViewModal(false); openVerifyModal(selectedRow, f, i, 'approve') }}
                                                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition-colors"
                                                                        >
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" /></svg>
                                                                            Approve
                                                                        </button>
                                                                        <button
                                                                            onClick={() => { setShowViewModal(false); openVerifyModal(selectedRow, f, i, 'reject') }}
                                                                            className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-sm transition-colors"
                                                                        >
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clipRule="evenodd" /></svg>
                                                                            Reject
                                                                        </button>
                                                                    </>
                                                                )}
                                                                {approved && (
                                                                    <span className="inline-flex items-center gap-1 px-2 py-1 rounded bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">
                                                                        ✓ Sudah di-approve, tidak bisa diubah
                                                                    </span>
                                                                )}
                                                                {!approved && !canVerifyHere && (
                                                                    <span className="inline-flex items-center gap-1 px-2 py-1 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-[11px] font-semibold">
                                                                        Isi Action Taken & Evidence Action dulu sebelum verifikasi
                                                                    </span>
                                                                )}
                                                            </div>
                                                        )}
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

            {/* MODAL FINDING LIST */}
            {showFindingListModal && selectedRow && (
                <div className="fixed inset-0 z-[104] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[88vh] border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-purple-600 to-purple-700 flex justify-between items-center text-white">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-purple-100">
                                    <path fillRule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clipRule="evenodd" />
                                </svg>
                                <div>
                                    <h2 className="font-bold text-lg leading-tight">Finding Actions</h2>
                                    <p className="text-xs text-purple-100">
                                        {selectedRow.master_line?.line_number} — Shift {selectedRow.shift} / Group {selectedRow.group}
                                    </p>
                                </div>
                            </div>
                            <button onClick={() => setShowFindingListModal(false)} className="p-1.5 rounded-lg hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div className="p-4 overflow-y-auto space-y-4">
                            {(selectedRow.finding_patrol_items || []).map((f, i) => {
                                const verifBadge = getVerifBadge(f)
                                const approved = isFindingApproved(f)
                                const catName = f.category_name || mingleData?.categories?.find(c => String(c.id) === String(f.category_id))?.category_name || '-'
                                const evidenceActionList = Array.isArray(f.evidence_action) ? f.evidence_action : (f.evidence_action ? [f.evidence_action] : [])
                                const hasAction = f.action && f.action.replace(/<[^>]*>/g, '').trim() !== ''
                                const hasEvidenceAction = evidenceActionList.length > 0

                                return (
                                    <div key={i} className="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-900 shadow-sm">
                                        <div className="px-4 py-2.5 bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between gap-2 flex-wrap">
                                            <div className="flex items-center gap-2 flex-wrap">
                                                <span className="bg-purple-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                                    {i + 1}
                                                </span>
                                                <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100">{catName}</span>
                                                <span className={`px-2 py-0.5 rounded text-[10px] font-bold border ${verifBadge.cls}`}>{verifBadge.label}</span>
                                            </div>
                                            {f.history?.length > 0 && (
                                                <button onClick={() => setShowHistoryModal(true)} className="inline-flex items-center gap-1 px-2 py-1 rounded bg-zinc-500 hover:bg-zinc-600 text-white text-[10px] font-bold">
                                                    📜 {f.history.length} revisi
                                                </button>
                                            )}
                                        </div>

                                        <div className="px-4 py-3 space-y-2">
                                            <div className="text-xs text-zinc-600 dark:text-zinc-400">
                                                <span className="font-bold text-zinc-500 dark:text-zinc-500">Finding:</span>{' '}
                                                <span className="rte-content" dangerouslySetInnerHTML={{ __html: (f.finding_result || '-').substring(0, 150) + ((f.finding_result || '').length > 150 ? '...' : '') }} />
                                            </div>

                                            <div className="flex items-center gap-3 text-[11px] flex-wrap">
                                                <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded font-bold ${hasAction ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'}`}>
                                                    {hasAction ? '✓' : '○'} Action Taken
                                                </span>
                                                <span className={`inline-flex items-center gap-1 px-2 py-0.5 rounded font-bold ${hasEvidenceAction ? 'bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400'}`}>
                                                    {hasEvidenceAction ? '✓' : '○'} Evidence ({evidenceActionList.length})
                                                </span>
                                            </div>

                                            {f.verification_status === 'reject' && f.rejection_reason && (
                                                <div className="p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded text-xs text-red-700 dark:text-red-300">
                                                    <strong>Alasan reject:</strong> {f.rejection_reason}
                                                </div>
                                            )}

                                            <div className="flex items-center gap-1.5 flex-wrap pt-2 border-t border-zinc-100 dark:border-zinc-800">
                                                {permissions.canFeedback && !approved && (() => {
                                                    // Hanya batasi jika user feedback TANPA verification
                                                    const restricted = !permissions.canVerify
                                                    const mine = isFeedbackMine(f)
                                                    const allowed = !restricted || mine

                                                    return (
                                                        <button
                                                            type="button"
                                                            disabled={!allowed}
                                                            onClick={() => allowed && openActionEvidenceModal(selectedRow, f, i)}
                                                            title={
                                                                !allowed
                                                                    ? 'Finding ini bukan untuk Anda (Feedback To bukan user Anda)'
                                                                    : 'Isi Action & Evidence'
                                                            }
                                                            className={`inline-flex items-center gap-1 px-3 py-1.5 rounded-md text-white text-xs font-semibold transition-colors shadow-sm ${
                                                                allowed
                                                                    ? 'bg-blue-600 hover:bg-blue-700 cursor-pointer'
                                                                    : 'bg-zinc-400 dark:bg-zinc-600 cursor-not-allowed opacity-60'
                                                            }`}
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                            </svg>
                                                            {allowed ? 'Isi Action & Evidence' : 'Bukan Feedback Anda'}
                                                        </button>
                                                    )
                                                })()}
                                                {approved && (
                                                    <span className="inline-flex items-center gap-1 px-2 py-1 rounded bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">
                                                        ✓ Sudah di-approve, tidak bisa diubah
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    </div>
                                )
                            })}
                        </div>

                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                            <button onClick={() => setShowFindingListModal(false)} className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL DELETE */}
            {showDeleteModal && selectedRow && (
                <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 dark:bg-black/80 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-sm bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-red-600 to-red-700 flex items-center gap-3">
                            <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white"><path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" /></svg>
                            </div>
                            <div>
                                <h3 className="text-base font-bold text-white">Delete Data?</h3>
                                <p className="text-xs text-red-100">This action cannot be undone</p>
                            </div>
                        </div>
                        <div className="p-5">
                            <p className="text-sm text-zinc-700 dark:text-zinc-300">
                                Are you sure you want to delete result line <strong className="text-zinc-900 dark:text-zinc-100">{selectedRow.master_line?.line_number}</strong> shift <strong className="text-zinc-900 dark:text-zinc-100">{selectedRow.shift}</strong>?
                            </p>
                        </div>
                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                            <button onClick={() => setShowDeleteModal(false)} className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">Cancel</button>
                            <button onClick={confirmDelete} className="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold shadow-md hover:bg-red-700 dark:hover:bg-red-500 transition-colors">Yes, Delete</button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL PREVIEW FOTO */}
            {photoPreview && (
                <div className="fixed inset-0 z-[110] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" onClick={() => setPhotoPreview(null)}>
                    <div className="relative max-w-4xl w-full flex flex-col items-center" onClick={e => e.stopPropagation()}>
                        <div className="w-full flex justify-between items-center bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 rounded-t-xl text-white shadow-md">
                            <h3 className="font-bold text-sm flex items-center gap-2">Preview {photoPreview.title}</h3>
                            <button onClick={() => setPhotoPreview(null)} className="text-blue-100 hover:text-white bg-white/20 hover:bg-white/30 rounded-full p-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                            </button>
                        </div>
                        <div className="bg-zinc-900 p-2 w-full flex justify-center rounded-b-xl border border-t-0 border-zinc-700">
                            <img src={photoPreview.url} alt="Preview" className="max-h-[80vh] w-auto object-contain rounded" />
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL ACTION + EVIDENCE ACTION (GABUNGAN) */}
            {showEvidenceModal && selectedRow && (
                <div className="fixed inset-0 z-[105] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[92vh] border border-zinc-200 dark:border-zinc-700">
                        <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-emerald-600 flex justify-between items-center text-white">
                            <div className="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-white/90">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                </svg>
                                <div>
                                    <h2 className="font-bold text-lg leading-tight">Isi Action & Evidence</h2>
                                    <p className="text-xs text-white/80">Finding #{findingForm.index + 1} — {selectedRow.master_line?.line_number}</p>
                                </div>
                            </div>
                            <button onClick={closeEvidenceModal} className="p-1.5 rounded-lg hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5"><path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <div className="p-5 overflow-y-auto space-y-5 text-sm">
                            <FindingDetailReadOnly form={findingForm} />

                            {/* Action Taken */}
                            <div>
                                <label className="text-xs font-semibold text-zinc-700 dark:text-zinc-300 block mb-1">
                                    Action Taken <span className="text-red-500">*</span>
                                </label>
                                <textarea
                                    rows={4}
                                    value={findingForm.action}
                                    onChange={(e) => setFindingForm({ ...findingForm, action: e.target.value })}
                                    placeholder="Tulis tindakan perbaikan yang dilakukan..."
                                    className="w-full px-3 py-2 rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                />
                            </div>

                            {/* Evidence Action */}
                            <div>
                                <div className="flex items-center justify-between mb-1">
                                    <label className="text-xs font-semibold text-zinc-700 dark:text-zinc-300">
                                        Evidence Action (Live Photo) <span className="text-red-500">*</span>
                                    </label>
                                    <span className={`text-[10px] font-bold ${findingForm.evidence_action.length >= 4 ? 'text-red-600 dark:text-red-400' : 'text-zinc-500 dark:text-zinc-400'}`}>
                                        {findingForm.evidence_action.length}/4
                                    </span>
                                </div>
                                {findingForm.evidence_action.length > 0 && (
                                    <div className="grid grid-cols-3 sm:grid-cols-4 gap-2 mb-2">
                                        {findingForm.evidence_action.map((photo, pIdx) => (
                                            <div key={pIdx} className="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800">
                                                <img src={photo} alt={`Evidence action ${pIdx + 1}`} className="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity" onClick={() => setPhotoPreview({ url: photo, title: `Evidence Action ${pIdx + 1}` })} />
                                                <span className="absolute top-1 left-1 bg-black/60 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">{pIdx + 1}</span>
                                                <button type="button" onClick={(e) => { e.stopPropagation(); removeEvidenceAction(pIdx) }} className="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-md" title="Hapus foto">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                                                </button>
                                            </div>
                                        ))}
                                    </div>
                                )}
                                <button type="button" onClick={openCamera} disabled={findingForm.evidence_action.length >= 4} className="w-full flex items-center justify-center gap-2 border-2 border-dashed rounded-lg py-2 text-sm font-semibold transition-colors border-emerald-300 dark:border-emerald-700 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h2.596c.864 0 1.671-.448 2.13-1.188l.94-1.505a1.875 1.875 0 0 1 1.602-.915h3.614c.659 0 1.271.35 1.602.915l.94 1.505c.459.74 1.266 1.188 2.13 1.188h2.596c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 19.125V6.375ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clipRule="evenodd" /></svg>
                                    {findingForm.evidence_action.length >= 4 ? 'Maksimal 4 Foto' : (findingForm.evidence_action.length > 0 ? `Tambah Foto (${findingForm.evidence_action.length}/4)` : 'Buka Kamera')}
                                </button>
                                <p className="text-[11px] text-zinc-500 dark:text-zinc-400 mt-1.5 italic">Minimal 1 foto sebelum verifikasi.</p>
                            </div>
                        </div>

                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                            <button onClick={closeEvidenceModal} disabled={savingEvidence} className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50">
                                Cancel
                            </button>
                            <button onClick={submitActionEvidence} disabled={savingEvidence} className="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 disabled:cursor-not-allowed text-white rounded-lg text-sm font-bold shadow-md">
                                {savingEvidence ? 'Saving...' : 'Simpan Action & Evidence'}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL VERIFIKASI */}
            {showVerifyModal && selectedRow && (
                <div className="fixed inset-0 z-[106] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div className={`px-5 py-4 flex items-center gap-3 text-white ${verifyForm.action === 'approve' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700' : 'bg-gradient-to-r from-red-600 to-red-700'}`}>
                            <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                {verifyForm.action === 'approve' ? (
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" /></svg>
                                ) : (
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clipRule="evenodd" /></svg>
                                )}
                            </div>
                            <div>
                                <h3 className="text-base font-bold">{verifyForm.action === 'approve' ? 'Approve Finding' : 'Reject Finding'}</h3>
                                <p className="text-xs opacity-90">Finding #{verifyForm.index + 1} — {selectedRow.master_line?.line_number}</p>
                            </div>
                        </div>
                        <div className="p-5 space-y-4">
                            <p className="text-sm text-zinc-700 dark:text-zinc-300">
                                {verifyForm.action === 'approve' ? 'Approve akan menandai finding ini selesai. Jika semua finding sudah di-approve, status Result Patrol otomatis menjadi Closed.' : 'Reject akan mengembalikan finding ini ke user untuk membuat ulang Action Taken & Evidence Action. Data lama tetap tersimpan sebagai history.'}
                            </p>
                            {verifyForm.action === 'reject' && (
                                <div>
                                    <label className="text-xs font-semibold text-zinc-700 dark:text-zinc-300 block mb-1">Alasan Reject <span className="text-red-500">*</span></label>
                                    <textarea rows={3} value={verifyForm.reason} onChange={(e) => setVerifyForm({ ...verifyForm, reason: e.target.value })} placeholder="Contoh: Foto kurang jelas, action tidak sesuai..." className="w-full px-3 py-2 rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm" />
                                </div>
                            )}
                        </div>
                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-2">
                            <button onClick={() => setShowVerifyModal(false)} disabled={savingVerify} className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50">Cancel</button>
                            <button onClick={submitVerify} disabled={savingVerify || (verifyForm.action === 'reject' && !verifyForm.reason.trim())} className={`px-4 py-2 rounded-lg text-sm font-bold text-white shadow-md disabled:opacity-60 disabled:cursor-not-allowed ${verifyForm.action === 'approve' ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-red-600 hover:bg-red-700'}`}>
                                {savingVerify ? 'Processing...' : (verifyForm.action === 'approve' ? 'Ya, Approve' : 'Ya, Reject')}
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL HISTORY */}
            {showHistoryModal && selectedRow && (
                <div className="fixed inset-0 z-[107] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
                    <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl max-h-[88vh] flex flex-col border border-zinc-200 dark:border-zinc-700 overflow-hidden">

                        {/* HEADER */}
                        <div className="px-5 py-4 bg-gradient-to-r from-zinc-700 to-zinc-800 text-white flex-shrink-0">
                            <div className="flex items-start justify-between gap-3">
                                <div className="flex items-center gap-3 min-w-0">
                                    <div className="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                                            <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clipRule="evenodd" />
                                        </svg>
                                    </div>
                                    <div className="min-w-0">
                                        <h3 className="font-bold text-base leading-tight">History Revisi</h3>
                                        <p className="text-xs text-zinc-300 mt-0.5 truncate">
                                            {selectedRow.master_line?.line_number} — Shift {selectedRow.shift} / Group {selectedRow.group}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    onClick={() => setShowHistoryModal(false)}
                                    className="p-1.5 rounded-lg hover:bg-white/20 transition-colors flex-shrink-0"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" className="w-5 h-5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            {(() => {
                                const totalRevisions = (selectedRow.finding_patrol_items || []).reduce((sum, f) => sum + (f.history?.length || 0), 0)
                                const findingsWithHistory = (selectedRow.finding_patrol_items || []).filter(f => f.history?.length > 0).length
                                const totalFindings = (selectedRow.finding_patrol_items || []).length

                                if (totalRevisions === 0) return null

                                return (
                                    <div className="mt-3 flex items-center gap-2 flex-wrap">
                                        <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white/15 text-xs font-semibold">
                                            📊 {totalRevisions} total revisi
                                        </span>
                                        <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-white/15 text-xs font-semibold">
                                            🔄 {findingsWithHistory} dari {totalFindings} finding
                                        </span>
                                    </div>
                                )
                            })()}
                        </div>

                        {/* BODY */}
                        <div className="p-5 overflow-y-auto space-y-5 flex-1">
                            {(() => {
                                const findingsWithHistory = (selectedRow.finding_patrol_items || [])
                                    .map((f, i) => ({ ...f, _originalIndex: i }))
                                    .filter(f => f.history && f.history.length > 0)

                                if (findingsWithHistory.length === 0) {
                                    return (
                                        <div className="flex flex-col items-center justify-center py-12 text-center">
                                            <div className="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" className="w-8 h-8 text-zinc-400">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <p className="text-sm font-semibold text-zinc-700 dark:text-zinc-300">Belum ada history revisi</p>
                                            <p className="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                                Revisi akan muncul di sini jika ada finding yang di-reject oleh verifikator.
                                            </p>
                                        </div>
                                    )
                                }

                                return findingsWithHistory.map((finding) => {
                                    const i = finding._originalIndex
                                    const catName = finding.category_name ||
                                        mingleData?.categories?.find(c => String(c.id) === String(finding.category_id))?.category_name || '-'

                                    return (
                                        <div key={i} className="border border-zinc-200 dark:border-zinc-700 rounded-xl overflow-hidden bg-white dark:bg-zinc-900 shadow-sm">

                                            <div className="px-4 py-3 bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-b border-red-200 dark:border-red-800 flex items-center justify-between gap-2 flex-wrap">
                                                <div className="flex items-center gap-2 flex-wrap">
                                                    <span className="bg-red-600 text-white w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                                        {i + 1}
                                                    </span>
                                                    <div>
                                                        <div className="text-sm font-bold text-zinc-800 dark:text-zinc-100">{catName}</div>
                                                        <div className="text-[11px] text-zinc-500 dark:text-zinc-400">
                                                            {finding.history.length} kali di-reject
                                                        </div>
                                                    </div>
                                                </div>
                                                <span className="px-2 py-0.5 rounded bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 text-[10px] font-bold border border-red-200 dark:border-red-800">
                                                    {finding.history.length} Revisi
                                                </span>
                                            </div>

                                            <div className="px-4 py-2.5 bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                                                <div className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide mb-1">Finding Result</div>
                                                <div
                                                    className="rte-content text-xs text-zinc-700 dark:text-zinc-300 line-clamp-2"
                                                    dangerouslySetInnerHTML={{ __html: finding.finding_result || '-' }}
                                                />
                                            </div>

                                            <div className="p-4 space-y-4">
                                                {/* Baris 1: Category | Finding Result | Feedback To */}
                                                <div className="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                    <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                        <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Category</span>
                                                        <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100 break-words">{catName}</span>
                                                    </div>
                                                    <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                        <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Finding Result</span>
                                                        <div className="rte-content text-sm font-semibold text-zinc-800 dark:text-zinc-100 break-words" dangerouslySetInnerHTML={{ __html: f.finding_result || '-' }} />
                                                    </div>
                                                    <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                        <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Feedback To (User)</span>
                                                        <span className="text-sm font-semibold text-zinc-800 dark:text-zinc-100 break-words">{empName}</span>
                                                    </div>
                                                </div>

                                                {/* Baris 2: Evidence | Reason | Evidence Action | Action Taken — semua sejajar */}
                                                <div className="overflow-x-auto">
                                                    <div className="grid grid-cols-4 gap-3 min-w-[900px]">
                                                        {/* Evidence */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">
                                                                Evidence — {evidenceList.length} foto
                                                            </span>
                                                            {evidenceList.length === 0 ? (
                                                                <div className="p-2 bg-zinc-100 dark:bg-zinc-800 rounded text-center text-[11px] text-zinc-400 dark:text-zinc-500 italic">No photo</div>
                                                            ) : (
                                                                <div className="grid grid-cols-3 gap-1.5">
                                                                    {evidenceList.map((photo, pIdx) => (
                                                                        <div
                                                                            key={pIdx}
                                                                            className="relative group cursor-pointer rounded overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800"
                                                                            onClick={() => setPhotoPreview({ url: photo, title: `Initial Evidence ${pIdx + 1}` })}
                                                                        >
                                                                            <img src={photo} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt={`Evidence ${pIdx + 1}`} />
                                                                        </div>
                                                                    ))}
                                                                </div>
                                                            )}
                                                        </div>

                                                        {/* Reason */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Reason</span>
                                                            <div className="rte-content text-sm text-zinc-800 dark:text-zinc-100 h-[120px] overflow-y-auto break-words" dangerouslySetInnerHTML={{ __html: f.reason || '-' }} />
                                                        </div>

                                                        {/* Evidence Action */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">
                                                                Evidence Action — {evidenceActionList.length} foto
                                                            </span>
                                                            {evidenceActionList.length === 0 ? (
                                                                <div className="p-2 bg-zinc-100 dark:bg-zinc-800 rounded text-center text-[11px] text-zinc-400 dark:text-zinc-500 italic">No photo</div>
                                                            ) : (
                                                                <div className="grid grid-cols-3 gap-1.5">
                                                                    {evidenceActionList.map((photo, pIdx) => (
                                                                        <div
                                                                            key={pIdx}
                                                                            className="relative group cursor-pointer rounded overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800"
                                                                            onClick={() => setPhotoPreview({ url: photo, title: `Action Evidence ${pIdx + 1}` })}
                                                                        >
                                                                            <img src={photo} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt={`Action Evidence ${pIdx + 1}`} />
                                                                        </div>
                                                                    ))}
                                                                </div>
                                                            )}
                                                        </div>

                                                        {/* Action Taken */}
                                                        <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700 min-w-0">
                                                            <span className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Action Taken</span>
                                                            <div className="rte-content text-sm text-zinc-800 dark:text-zinc-100 h-[120px] overflow-y-auto break-words" dangerouslySetInnerHTML={{ __html: f.action || '-' }} />
                                                        </div>
                                                    </div>
                                                </div>

                                                {/* ✅ APPROVE / REJECT DI MODAL VIEW */}
                                                {permissions.canVerify && (
                                                    <div className="flex items-center justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                                        {!approved && canVerifyHere && (
                                                            <>
                                                                <button
                                                                    onClick={() => { setShowViewModal(false); openVerifyModal(selectedRow, f, i, 'approve') }}
                                                                    className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-sm transition-colors"
                                                                >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clipRule="evenodd" /></svg>
                                                                    Approve
                                                                </button>
                                                                <button
                                                                    onClick={() => { setShowViewModal(false); openVerifyModal(selectedRow, f, i, 'reject') }}
                                                                    className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold shadow-sm transition-colors"
                                                                >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clipRule="evenodd" /></svg>
                                                                    Reject
                                                                </button>
                                                            </>
                                                        )}
                                                        {approved && (
                                                            <span className="inline-flex items-center gap-1 px-2 py-1 rounded bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[11px] font-bold">
                                                                ✓ Sudah di-approve, tidak bisa diubah
                                                            </span>
                                                        )}
                                                        {!approved && !canVerifyHere && (
                                                            <span className="inline-flex items-center gap-1 px-2 py-1 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 text-[11px] font-semibold">
                                                                Isi Action Taken & Evidence Action dulu sebelum verifikasi
                                                            </span>
                                                        )}
                                                    </div>
                                                )}
                                            </div>
                                        </div>
                                    )
                                })
                            })()}
                        </div>

                        <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-end flex-shrink-0">
                            <button
                                onClick={() => setShowHistoryModal(false)}
                                className="px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL KAMERA */}
            {cameraStream && (
                <div className="fixed inset-0 z-[110] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
                    <div className="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden w-full max-w-lg flex flex-col">
                        <div className="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 flex justify-between items-center text-white">
                            <h3 className="font-bold text-sm flex items-center gap-2">Ambil Foto</h3>
                            <button onClick={closeCamera} className="text-blue-100 hover:text-white bg-white/20 hover:bg-white/30 rounded-full p-1 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                            </button>
                        </div>
                        <div className="relative bg-black flex items-center justify-center min-h-[300px]">
                            {cameraError ? (
                                <p className="text-red-400 p-4 text-center text-sm">{cameraError}</p>
                            ) : (
                                <>
                                    <video ref={videoRef} autoPlay playsInline muted className="w-full max-h-[60vh] object-contain"></video>
                                    <canvas ref={canvasRef} className="hidden"></canvas>
                                </>
                            )}
                        </div>
                        <div className="p-4 bg-zinc-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 flex justify-center gap-4">
                            <button onClick={closeCamera} className="px-6 py-2 rounded-full bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 shadow-sm font-semibold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors">Cancel</button>
                            {!cameraError && (
                                <button onClick={capturePhoto} className="px-8 py-2 rounded-full bg-blue-600 text-white font-bold shadow-md hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h2.596c.864 0 1.671-.448 2.13-1.188l.94-1.505a1.875 1.875 0 0 1 1.602-.915h3.614c.659 0 1.271.35 1.602.915l.94 1.505c.459.74 1.266 1.188 2.13 1.188h2.596c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 19.125V6.375ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clipRule="evenodd" /></svg>
                                    Take Photo
                                </button>
                            )}
                        </div>
                    </div>
                </div>
            )}

            {/* FLOATING TOOLTIP FEEDBACK TO (Portal) */}
            {feedbackTooltip && createPortal(
                <div
                    className="fixed z-[200] pointer-events-none"
                    style={{
                        left: `${feedbackTooltip.x}px`,
                        top: `${feedbackTooltip.y}px`,
                        transform: 'translate(-50%, -100%)',
                    }}
                >
                    <div className="relative bg-zinc-900 text-white text-[11px] font-medium rounded-lg shadow-2xl px-3 py-2 max-w-[280px] border border-zinc-700">
                        <div className="text-[9px] uppercase tracking-wide text-zinc-400 font-bold mb-1">
                            Feedback To ({feedbackTooltip.users.length})
                        </div>
                        <ul className="space-y-0.5">
                            {feedbackTooltip.users.map((u) => (
                                <li key={u.id} className="flex items-center gap-1.5 whitespace-nowrap">
                                    <span className="w-1 h-1 rounded-full bg-indigo-400"></span>
                                    {u.name}
                                </li>
                            ))}
                        </ul>
                        {/* Arrow */}
                        <div className="absolute left-1/2 -translate-x-1/2 -bottom-1 w-2 h-2 bg-zinc-900 border-r border-b border-zinc-700 rotate-45"></div>
                    </div>
                </div>,
                document.body
            )}

            {/* TOAST */}
            {toast && <div className={`fixed bottom-6 right-6 z-[120] px-4 py-3 rounded-xl shadow-xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>{toast.message}</div>}
        </div>
    )
}

// ============================================================
// KOMPONEN KECIL
// ============================================================
function FindingDetailReadOnly({ form }) {
    return (
        <div className="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
            <div className="px-3 py-2 bg-zinc-100 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-zinc-500"><path fillRule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" /></svg>
                <span className="text-xs font-bold text-zinc-600 dark:text-zinc-300 uppercase tracking-wide">Finding Detail (read-only)</span>
            </div>
            <div className="p-3 space-y-3">
                <div className="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Category</label>
                        <input type="text" value={form.meta?.category_name || '-'} readOnly className="w-full px-3 py-2 rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 cursor-not-allowed text-sm" />
                    </div>
                    <div>
                        <label className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Feedback To (User)</label>
                        <input type="text" value={form.meta?.feedback_to_name || '-'} readOnly className="w-full px-3 py-2 rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 cursor-not-allowed text-sm" />
                    </div>
                </div>
                <div>
                    <label className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Finding Result</label>
                    <div className="rte-content w-full px-3 py-2 rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 min-h-[50px] max-h-[120px] overflow-y-auto text-sm" dangerouslySetInnerHTML={{ __html: form.meta?.finding_result || '-' }} />
                </div>
                <div>
                    <label className="text-[10px] font-bold text-zinc-500 dark:text-zinc-400 uppercase tracking-wide block mb-1">Reason</label>
                    <div className="rte-content w-full px-3 py-2 rounded-md border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 min-h-[50px] max-h-[120px] overflow-y-auto text-sm" dangerouslySetInnerHTML={{ __html: form.meta?.reason || '-' }} />
                </div>
            </div>
        </div>
    )
}