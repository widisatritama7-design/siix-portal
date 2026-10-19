import React, { useState, useRef, useEffect } from 'react'
import RichTextEditor from './RichTextEditor'

export default function ResultPatrolForm({ wire, mingleData }) {
    const [cameraTarget, setCameraTarget] = useState(null)
    const [cameraStream, setCameraStream] = useState(null)
    const [cameraError, setCameraError] = useState('')
    const [photoPreview, setPhotoPreview] = useState(null)
    const videoRef = useRef(null)
    const canvasRef = useRef(null)

    const existingData = mingleData?.result

    const normalizeFindings = (items = []) => items.map(f => ({
        ...f,
        evidence: Array.isArray(f.evidence) ? f.evidence : (f.evidence ? [f.evidence] : []),
        evidence_action: Array.isArray(f.evidence_action) ? f.evidence_action : (f.evidence_action ? [f.evidence_action] : []),
    }))

    const [saving, setSaving] = useState(false)
    const [toast, setToast]     = useState(null)

    const [form, setForm] = useState({
        id: existingData?.id || null,
        shift: existingData?.shift || '1',
        group: existingData?.group || 'A',
        master_line_id: existingData?.master_line_id || '',
        standard_patrol_items: existingData?.standard_patrol_items || [],
        finding_patrol_items: normalizeFindings(existingData?.finding_patrol_items || [])
    })

    const [isDropdownOpen, setIsDropdownOpen] = useState(false)
    const [searchQuery, setSearchQuery] = useState('')
    const dropdownRef = useRef(null)

    const [searchModal, setSearchModal] = useState({
        isOpen: false,
        target: null,
        findingIdx: null,
        query: '',
        page: 1,
        perPage: 5
    })

    useEffect(() => {
        function handleClickOutside(event) {
            if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
                setIsDropdownOpen(false)
            }
        }
        document.addEventListener("mousedown", handleClickOutside)
        return () => document.removeEventListener("mousedown", handleClickOutside)
    }, [])

    const showToast = (message, type = 'success') => {
        setToast({ message, type })
        setTimeout(() => setToast(null), 3500)
    }

    const handleLineSelect = (lineId) => {
        setIsDropdownOpen(false)
        setSearchQuery('')
        
        setForm(prev => ({ ...prev, master_line_id: lineId, standard_patrol_items: [] }))
        if (!lineId) return

        const lineStandards = mingleData.standardsByLine?.[lineId] || []
        if (lineStandards.length > 0) {
            const items = lineStandards.flatMap(group => 
                group.items.map(s => ({
                    line_name: group.line_name,
                    item_check: s.item_check,
                    standard: s.standard,
                    result: '',
                    remarks: ''
                }))
            )
            setForm(prev => ({ ...prev, standard_patrol_items: items }))
        } else {
            showToast('Tidak ada Standard Patrol untuk line ini.', 'error')
        }
    }

    const filteredMasterLines = mingleData.masterLines
        .filter(ml => {
            const searchLower = searchQuery.toLowerCase()
            const lineStr = String(ml.line_number || '').toLowerCase()
            const locStr = String(ml.location || '').toLowerCase()
            return lineStr.includes(searchLower) || locStr.includes(searchLower)
        })
        .sort((a, b) => {
            const locA = String(a.location || '').toLowerCase()
            const locB = String(b.location || '').toLowerCase()
            const lineA = String(a.line_number || '').toLowerCase()
            const lineB = String(b.line_number || '').toLowerCase()
            if (locA < locB) return -1
            if (locA > locB) return 1
            if (lineA < lineB) return -1
            if (lineA > lineB) return 1
            return 0
        })

    const selectedLineData = mingleData.masterLines.find(ml => String(ml.id) === String(form.master_line_id))

    const updateStandard = (idx, field, value) => {
        const next = [...form.standard_patrol_items]
        next[idx][field] = value
        setForm({ ...form, standard_patrol_items: next })
    }

    const addFinding = () => {
        setForm({
            ...form,
            finding_patrol_items: [
                ...form.finding_patrol_items,
                { 
                    category_id: '', 
                    finding_result: '', 
                    evidence: [],
                    feedback_to: '', 
                    reason: '', 
                    action: '', 
                    evidence_action: []
                }
            ]
        })
    }

    const removeFinding = (idx) => {
        setForm({ ...form, finding_patrol_items: form.finding_patrol_items.filter((_, i) => i !== idx) })
    }

    const updateFinding = (idx, field, value) => {
        const next = [...form.finding_patrol_items]
        next[idx][field] = value
        setForm({ ...form, finding_patrol_items: next })
    }

    const openCamera = async (idx, field) => {
        setCameraTarget({ idx, field })
        setCameraError('')
        
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { facingMode: 'environment' },
                audio: false 
            })
            setCameraStream(stream)
            setTimeout(() => {
                if (videoRef.current) videoRef.current.srcObject = stream
            }, 100)
        } catch (err) {
            setCameraError('Gagal mengakses kamera. Pastikan izin kamera telah diberikan di browser Anda.')
            console.error(err)
        }
    }

    const closeCamera = () => {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop())
        }
        setCameraStream(null)
        setCameraTarget(null)
        setCameraError('')
    }

    const capturePhoto = () => {
        if (videoRef.current && canvasRef.current && cameraTarget) {
            const video = videoRef.current
            const canvas = canvasRef.current
            const context = canvas.getContext('2d')

            canvas.width = video.videoWidth
            canvas.height = video.videoHeight
            context.drawImage(video, 0, 0, canvas.width, canvas.height)

            const imageData = canvas.toDataURL('image/jpeg', 0.8)

            const next = [...form.finding_patrol_items]
            const current = Array.isArray(next[cameraTarget.idx][cameraTarget.field])
                ? [...next[cameraTarget.idx][cameraTarget.field]]
                : []

            if (current.length >= 4) {
                showToast('Maksimal 4 foto per evidence', 'error')
                closeCamera()
                return
            }

            current.push(imageData)
            next[cameraTarget.idx][cameraTarget.field] = current
            setForm({ ...form, finding_patrol_items: next })
            closeCamera()
        }
    }

    const removePhoto = (findingIdx, field, photoIdx) => {
        const next = [...form.finding_patrol_items]
        next[findingIdx][field] = next[findingIdx][field].filter((_, i) => i !== photoIdx)
        setForm({ ...form, finding_patrol_items: next })
    }

    const renderEvidencePhotos = (finding, idx, field, label, color = 'red') => {
        const photos = Array.isArray(finding[field]) ? finding[field] : []
        const isFull = photos.length >= 4
        const colorClasses = color === 'red' 
            ? 'border-red-300 dark:border-red-700 text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30' 
            : 'border-emerald-300 dark:border-emerald-700 text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30'

        return (
            <div>
                <div className="flex items-center justify-between mb-1">
                    <label className="block text-xs font-semibold text-zinc-700 dark:text-zinc-300">{label}</label>
                    <span className={`text-[10px] font-bold ${isFull ? 'text-red-600 dark:text-red-400' : 'text-zinc-500 dark:text-zinc-400'}`}>
                        {photos.length}/4
                    </span>
                </div>

                {photos.length > 0 && (
                    <div className="grid grid-cols-2 gap-2 mb-2">
                        {photos.map((photo, pIdx) => (
                            <div key={pIdx} className="relative group rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square bg-zinc-100 dark:bg-zinc-800">
                                <img 
                                    src={photo} 
                                    alt={`${label} ${pIdx + 1}`}
                                    className="w-full h-full object-cover cursor-pointer hover:opacity-90 transition-opacity"
                                    onClick={() => setPhotoPreview({ 
                                        url: photo, 
                                        title: `${label} ${pIdx + 1}`,
                                        onDelete: () => removePhoto(idx, field, pIdx)
                                    })}
                                />
                                <span className="absolute top-1 left-1 bg-black/60 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">
                                    {pIdx + 1}
                                </span>
                                <button
                                    type="button"
                                    onClick={(e) => { e.stopPropagation(); removePhoto(idx, field, pIdx) }}
                                    className="absolute top-1 right-1 w-6 h-6 rounded-full bg-red-600 hover:bg-red-700 text-white flex items-center justify-center shadow-md opacity-90 hover:opacity-100 transition-opacity"
                                    title="Hapus foto"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5">
                                        <path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        ))}
                    </div>
                )}

                <button 
                    type="button" 
                    onClick={() => !isFull && openCamera(idx, field)}
                    disabled={isFull}
                    className={`w-full flex items-center justify-center gap-2 border-2 border-dashed rounded-lg py-2 text-sm font-semibold transition-colors ${colorClasses} disabled:opacity-50 disabled:cursor-not-allowed`}
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5">
                        <path fillRule="evenodd" d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h2.596c.864 0 1.671-.448 2.13-1.188l.94-1.505a1.875 1.875 0 0 1 1.602-.915h3.614c.659 0 1.271.35 1.602.915l.94 1.505c.459.74 1.266 1.188 2.13 1.188h2.596c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 19.125V6.375ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clipRule="evenodd" />
                    </svg>
                    {isFull ? 'Maksimal 4 Foto' : (photos.length > 0 ? `Tambah Foto (${photos.length}/4)` : 'Buka Kamera')}
                </button>
            </div>
        )
    }

    const openSearchModal = (target, idx) => {
        setSearchModal({ isOpen: true, target, findingIdx: idx, query: '', page: 1, perPage: 5 })
    }
    
    const closeSearchModal = () => {
        setSearchModal({ ...searchModal, isOpen: false })
    }

    const getFilteredModalData = () => {
        const { target, query } = searchModal
        const q = query.toLowerCase()

        if (target === 'category') {
            return mingleData.categories.filter(c => c.category_name.toLowerCase().includes(q))
        }
        if (target === 'employee') {
            return mingleData.employees.filter(e => 
                e.name.toLowerCase().includes(q) || e.nik.toLowerCase().includes(q)
            )
        }
        return []
    }

    const handleSelectModalData = (item) => {
        if (searchModal.target === 'category') {
            updateFinding(searchModal.findingIdx, 'category_id', item.id)
        } else if (searchModal.target === 'employee') {
            updateFinding(searchModal.findingIdx, 'feedback_to', item.nik)
        }
        closeSearchModal()
    }

    const handleSave = async (e) => {
        e.preventDefault()
        if (!form.master_line_id) return showToast('Pilih Master Line terlebih dahulu', 'error')

        const unselected = form.standard_patrol_items.some(item => !item.result)
        if (unselected) {
            return showToast('Harap isi semua Result (OK / NG) pada Standard Check', 'error')
        }

        for (let i = 0; i < form.finding_patrol_items.length; i++) {
            const f = form.finding_patrol_items[i]
            const plainText = (f.finding_result || '').replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim()
            if (!plainText) {
                return showToast(`Finding #${i + 1}: Finding Result wajib diisi`, 'error')
            }
            if (!Array.isArray(f.evidence) || f.evidence.length === 0) {
                return showToast(`Finding #${i + 1}: Minimal 1 foto Evidence`, 'error')
            }
        }
        
        setSaving(true)
        try {
            const result = await wire.save(form)
            if (result.success) {
                showToast(result.message, 'success')
                setTimeout(() => window.Livewire.navigate(result.redirect), 1000)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Gagal menyimpan: ' + e.message, 'error')
        } finally {
            setSaving(false)
        }
    }

    return (
        <div className="p-1 space-y-2">

        {/* BREADCRUMBS */}
        <nav className="flex items-center gap-1.5 text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 overflow-x-auto whitespace-nowrap pb-1">
            <a href="/dashboard" className="hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                Dashboard
            </a>
            <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
            <span className="shrink-0 font-semibold text-black dark:text-white">PROD</span>
            <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
            <span className="shrink-0 font-semibold text-black dark:text-white">Patrol Monitoring</span>
            <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
            <a href="/prod/patrol/result-patrol" className="hover:text-blue-600 dark:hover:text-blue-400 transition-colors shrink-0">
                Result Patrol
            </a>
            <span className="text-zinc-300 dark:text-zinc-600 shrink-0">/</span>
            <span className="font-semibold text-black dark:text-white shrink-0">
                {form.id ? 'Edit' : 'Create'}
            </span>
        </nav>

            {/* HEADER PAGE */}
            <div className="flex flex-col sm:flex-row justify-between sm:items-end gap-3 mb-4">
                <div>
                    <h1 className="text-2xl font-bold text-zinc-800 dark:text-white">
                        {form.id ? 'Edit Result Patrol' : 'Input Result Patrol'}
                    </h1>
                </div>
            </div>

            <form onSubmit={handleSave} className="space-y-6">
                
                {/* SEKSI 1: HEADER INFO (BIRU) */}
                <div className="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden mb-6">
                    <div className="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 border-b border-blue-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6 text-white">
                            <path d="M4.913 2.658c2.075-.27 4.19-.408 6.337-.408 2.147 0 4.262.139 6.337.408 1.922.25 3.291 1.861 3.405 3.727a4.403 4.403 0 0 0-1.032-.211 50.89 50.89 0 0 0-8.42 0c-2.358.196-4.04 2.19-4.04 4.434v4.286a4.47 4.47 0 0 0 2.433 3.984L7.28 21.53A.75.75 0 0 1 6 21v-4.03a48.527 48.527 0 0 1-1.087-.128C2.905 16.58 1.5 14.833 1.5 12.862V6.638c0-1.97 1.405-3.718 3.413-3.979Z" />
                            <path d="M15.75 7.5c-1.376 0-2.739.057-4.086.169C10.124 7.797 9 9.103 9 10.609v4.285c0 1.507 1.128 2.814 2.67 2.94 1.243.102 2.5.157 3.768.165l2.782 2.781a.75.75 0 0 0 1.28-.53v-2.39l.33-.026c1.542-.125 2.67-1.433 2.67-2.94v-4.286c0-1.505-1.125-2.811-2.664-2.94A49.392 49.392 0 0 0 15.75 7.5Z" />
                        </svg>
                        <h3 className="font-bold text-white text-sm">Informasi Utama</h3>
                    </div>
                    
                    <div className="p-5 space-y-5">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                            
                            {/* Select Shift */}
                            <div>
                                <label className="block text-sm font-semibold mb-1 text-zinc-700 dark:text-zinc-300">Shift</label>
                                <div className="relative">
                                    <select 
                                        value={form.shift} 
                                        onChange={e => setForm({...form, shift: e.target.value})} 
                                        className="w-full appearance-none border border-zinc-300 dark:border-zinc-600 rounded-lg pl-3 pr-10 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-zinc-800 cursor-pointer"
                                    >
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
                            </div>

                            {/* Select Group */}
                            <div>
                                <label className="block text-sm font-semibold mb-1 text-zinc-700 dark:text-zinc-300">Group</label>
                                <div className="relative">
                                    <select 
                                        value={form.group} 
                                        onChange={e => setForm({...form, group: e.target.value})} 
                                        className="w-full appearance-none border border-zinc-300 dark:border-zinc-600 rounded-lg pl-3 pr-10 py-2 text-sm text-zinc-800 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 outline-none bg-white dark:bg-zinc-800 cursor-pointer"
                                    >
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
                            </div>

                            {/* Display Master Line Terpilih */}
                            <div>
                                <label className="block text-sm font-semibold mb-1 text-zinc-700 dark:text-zinc-300">
                                    Master Line <span className="text-red-500">*</span>
                                </label>
                                <div className={`w-full flex items-center border rounded-lg px-3 py-2 text-sm font-semibold transition-colors ${
                                    selectedLineData 
                                        ? 'bg-blue-50 dark:bg-blue-900/30 border-blue-300 dark:border-blue-700 text-blue-800 dark:text-blue-300' 
                                        : 'bg-zinc-100 dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 text-zinc-500 dark:text-zinc-400'
                                }`}>
                                    {selectedLineData ? (
                                        <div className="flex items-center gap-1.5 w-full overflow-hidden">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                            <div className="flex items-baseline gap-1.5 min-w-0">
                                                <span className="truncate">{selectedLineData.line_number}</span>
                                                <span className="text-blue-500 dark:text-blue-400 text-xs font-normal whitespace-nowrap">({selectedLineData.location})</span>
                                            </div>
                                        </div>
                                    ) : (
                                        <div className="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4 text-zinc-400 flex-shrink-0">
                                                <path fillRule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clipRule="evenodd" />
                                            </svg>
                                            <span>-- Belum memilih line --</span>
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        {/* Tabel Master Line */}
                        <div className="border border-zinc-300 dark:border-zinc-600 rounded-lg overflow-hidden flex flex-col">
                            <div className="bg-zinc-50 dark:bg-zinc-800/50 p-3 border-b border-zinc-200 dark:border-zinc-700">
                                <div className="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input 
                                        type="text" 
                                        placeholder="Cari line atau lokasi..." 
                                        value={searchQuery}
                                        onChange={(e) => setSearchQuery(e.target.value)}
                                        className="w-full pl-10 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-md text-zinc-800 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-zinc-800"
                                    />
                                </div>
                            </div>

                            <div className="max-h-60 overflow-y-auto">
                                <table className="w-full text-sm text-left">
                                    <thead className="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10 shadow-sm border-b border-zinc-200 dark:border-zinc-700">
                                        <tr>
                                            <th className="px-4 py-2 text-xs font-bold text-zinc-600 dark:text-zinc-400 w-16 text-center">Pilih</th>
                                            <th className="px-4 py-2 text-xs font-bold text-zinc-600 dark:text-zinc-400">Line Number</th>
                                            <th className="px-4 py-2 text-xs font-bold text-zinc-600 dark:text-zinc-400">Location Name</th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                                        {filteredMasterLines.length === 0 ? (
                                            <tr>
                                                <td colSpan={3} className="px-4 py-6 text-center text-zinc-500 dark:text-zinc-400 italic">
                                                    Tidak ada line yang cocok dengan pencarian.
                                                </td>
                                            </tr>
                                        ) : (
                                            filteredMasterLines.map(ml => {
                                                const isSelected = String(form.master_line_id) === String(ml.id)
                                                return (
                                                    <tr 
                                                        key={ml.id} 
                                                        onClick={() => handleLineSelect(String(ml.id))}
                                                        className={`cursor-pointer transition-colors ${isSelected ? 'bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50' : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50'}`}
                                                    >
                                                        <td className="px-4 py-2 text-center">
                                                            <input 
                                                                type="radio" 
                                                                name="master_line"
                                                                checked={isSelected}
                                                                readOnly
                                                                className="w-4 h-4 text-blue-600 focus:ring-blue-500 cursor-pointer"
                                                            />
                                                        </td>
                                                        <td className={`px-4 py-2 font-semibold ${isSelected ? 'text-blue-700 dark:text-blue-300' : 'text-zinc-800 dark:text-zinc-200'}`}>
                                                            {ml.line_number}
                                                        </td>
                                                        <td className="px-4 py-2 text-zinc-500 dark:text-zinc-400">{ml.location || '-'}</td>
                                                    </tr>
                                                )
                                            })
                                        )}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {/* SEKSI 2: STANDARD PATROL ITEMS (KUNING) */}
                <div className="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div className="bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 border-b border-amber-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-6 text-white">
                            <path fillRule="evenodd" d="M7.502 6h7.128A3.375 3.375 0 0 1 18 9.375v9.375a3 3 0 0 0 3-3V6.108c0-1.505-1.125-2.811-2.664-2.94a48.972 48.972 0 0 0-.673-.05A3 3 0 0 0 15 1.5h-1.5a3 3 0 0 0-2.663 1.618c-.225.015-.45.032-.673.05C8.662 3.295 7.554 4.542 7.502 6ZM13.5 3A1.5 1.5 0 0 0 12 4.5h4.5A1.5 1.5 0 0 0 15 3h-1.5Z" clipRule="evenodd" />
                            <path fillRule="evenodd" d="M3 9.375C3 8.339 3.84 7.5 4.875 7.5h9.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-9.75A1.875 1.875 0 0 1 3 20.625V9.375Zm9.586 4.594a.75.75 0 0 0-1.172-.938l-2.476 3.096-.908-.907a.75.75 0 0 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.116-.062l3-3.75Z" clipRule="evenodd" />
                        </svg>
                        <h3 className="font-bold text-white text-sm">Standard Check</h3>
                    </div>
                    <div className="p-5">
                        {form.standard_patrol_items.length === 0 ? (
                            <p className="text-sm text-zinc-500 dark:text-zinc-400 italic p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700 text-center">
                                Pilih Master Line terlebih dahulu.
                            </p>
                        ) : (
                            (() => {
                                const groupedItems = form.standard_patrol_items.reduce((acc, item, globalIdx) => {
                                    const lineName = item.line_name || 'Tanpa Line';
                                    if (!acc[lineName]) acc[lineName] = [];
                                    acc[lineName].push({ ...item, globalIdx });
                                    return acc;
                                }, {});

                                return Object.entries(groupedItems).map(([lineName, items]) => (
                                    <div key={lineName} className="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden shadow-sm mb-4 last:mb-0">
                                        <div className="bg-zinc-100 dark:bg-zinc-800 px-4 py-2 border-b border-zinc-200 dark:border-zinc-700">
                                            <span className="font-bold text-xs text-zinc-700 dark:text-zinc-300 flex items-center gap-2 uppercase tracking-wide">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                    <path fill-rule="evenodd" d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z" clip-rule="evenodd" />
                                                </svg>
                                                {lineName}
                                            </span>
                                        </div>
                                        <table className="w-full text-sm border-collapse">
                                            <thead className="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                                                <tr>
                                                    <th className="p-2 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400 w-1/3">Item Check</th>
                                                    <th className="p-2 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400 w-1/4">Standard</th>
                                                    <th className="p-2 text-center text-xs font-semibold text-zinc-500 dark:text-zinc-400 w-32">Result</th>
                                                    <th className="p-2 text-left text-xs font-semibold text-zinc-500 dark:text-zinc-400">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                                {items.map((item) => (
                                                    <tr key={item.globalIdx} className="hover:bg-zinc-50/80 dark:hover:bg-zinc-800/40 transition-colors">
                                                        <td className="p-2 font-medium text-zinc-800 dark:text-zinc-200">{item.item_check}</td>
                                                        <td className="p-2 text-zinc-500 dark:text-zinc-400">{item.standard}</td>
                                                        
                                                        <td className="p-2">
                                                            <div className="flex items-center justify-center gap-2">
                                                                <button
                                                                    type="button"
                                                                    onClick={() => updateStandard(item.globalIdx, 'result', 'OK')}
                                                                    title="OK"
                                                                    className={`w-8 h-8 rounded-full flex items-center justify-center transition-all border-2 ${
                                                                        item.result === 'OK' 
                                                                            ? 'bg-emerald-500 border-emerald-600 text-white shadow-md' 
                                                                            : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-600 text-zinc-400 dark:text-zinc-500 hover:border-emerald-400 hover:text-emerald-500'
                                                                    }`}
                                                                >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" className="w-4 h-4">
                                                                        <path d="M20 6L9 17l-5-5" />
                                                                    </svg>
                                                                </button>

                                                                <button
                                                                    type="button"
                                                                    onClick={() => updateStandard(item.globalIdx, 'result', 'NG')}
                                                                    title="NG"
                                                                    className={`w-8 h-8 rounded-full flex items-center justify-center transition-all border-2 ${
                                                                        item.result === 'NG' 
                                                                            ? 'bg-red-500 border-red-600 text-white shadow-md' 
                                                                            : 'bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-600 text-zinc-400 dark:text-zinc-500 hover:border-red-400 hover:text-red-500'
                                                                    }`}
                                                                >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" className="w-4 h-4">
                                                                        <path d="M18 6L6 18M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                        
                                                        <td className="p-2">
                                                            <input 
                                                                type="text" 
                                                                value={item.remarks} 
                                                                onChange={(e) => updateStandard(item.globalIdx, 'remarks', e.target.value)} 
                                                                placeholder="Catatan..." 
                                                                className="w-full border border-zinc-300 dark:border-zinc-600 rounded px-2 py-1 text-sm text-zinc-800 dark:text-zinc-100 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 bg-white dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500 outline-none" 
                                                            />
                                                        </td>
                                                    </tr>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                ));
                            })()
                        )}
                    </div>
                </div>

                {/* SEKSI 3: FINDING PATROL ITEMS (MERAH) */}
                <div className="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div className="bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 border-b border-red-800 flex justify-between items-center">
                        <div className="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-red-100"><path fillRule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clipRule="evenodd" /></svg>
                            <h3 className="font-bold text-white text-sm">Temuan / Finding</h3>
                        </div>
                        <button type="button" onClick={addFinding} className="text-xs bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-md font-semibold transition-colors flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-3.5 h-3.5"><path fillRule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clipRule="evenodd" /></svg>
                            Tambah
                        </button>
                    </div>
                    
                    <div className="p-5 space-y-6">
                        {form.finding_patrol_items.length === 0 ? (
                            <p className="text-sm text-zinc-500 dark:text-zinc-400 italic text-center py-4">Tidak ada temuan (Aman).</p>
                        ) : (
                            form.finding_patrol_items.map((finding, idx) => {
                                const selectedCategoryName = mingleData.categories.find(c => String(c.id) === String(finding.category_id))?.category_name
                                const selectedEmployeeName = mingleData.employees.find(e => String(e.nik) === String(finding.feedback_to))?.name

                                return (
                                    <div key={idx} className="p-5 border border-red-200 dark:border-red-800 rounded-xl bg-red-50/20 dark:bg-red-900/10 relative shadow-sm space-y-5">
                                        
                                        <button type="button" onClick={() => removeFinding(idx)} className="absolute top-4 right-4 text-red-400 hover:text-red-600 dark:text-red-500 dark:hover:text-red-400 bg-white dark:bg-zinc-800 rounded-full p-1.5 shadow-sm transition-colors z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4"><path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                                        </button>

                                        <div className="flex items-center gap-2 pb-2 border-b border-red-200 dark:border-red-800">
                                            <span className="bg-red-600 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold">{idx + 1}</span>
                                            <h4 className="font-bold text-sm text-red-800 dark:text-red-300">Detail Temuan</h4>
                                        </div>
                                        
                                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            {/* Category Search */}
                                            <div>
                                                <label className="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Category</label>
                                                <div 
                                                    onClick={() => openSearchModal('category', idx)}
                                                    className="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg pl-3 pr-3 py-2 text-sm bg-white dark:bg-zinc-800 cursor-pointer flex items-center justify-between hover:border-red-400 transition-colors"
                                                >
                                                    <span className={`truncate flex-1 pr-2 ${selectedCategoryName ? "text-zinc-800 dark:text-zinc-200" : "text-zinc-400 dark:text-zinc-500"}`}>
                                                        {selectedCategoryName || '-- Pilih Kategori --'}
                                                    </span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400 flex-shrink-0">
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </div>
                                            </div>

                                            {/* Finding Result */}
                                            <div>
                                                <label className="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Finding Result</label>
                                                <RichTextEditor
                                                    value={finding.finding_result}
                                                    onChange={(val) => updateFinding(idx, 'finding_result', val)}
                                                    placeholder="Deskripsi temuan..."
                                                    rows={2}
                                                />
                                            </div>

                                            {/* Feedback To */}
                                            <div>
                                                <label className="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Feedback To (Employee)</label>
                                                <div 
                                                    onClick={() => openSearchModal('employee', idx)}
                                                    className="w-full border border-zinc-300 dark:border-zinc-600 rounded-lg pl-3 pr-3 py-2 text-sm bg-white dark:bg-zinc-800 cursor-pointer flex items-center justify-between hover:border-red-400 transition-colors"
                                                >
                                                    <span className={`truncate flex-1 pr-2 ${selectedEmployeeName ? "text-zinc-800 dark:text-zinc-200" : "text-zinc-400 dark:text-zinc-500"}`}>
                                                        {selectedEmployeeName || '-- Pilih Karyawan --'}
                                                    </span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4 text-zinc-400 flex-shrink-0">
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        {/* BARIS 2: EVIDENCE, REASON */}
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            {renderEvidencePhotos(finding, idx, 'evidence', 'Evidence (Live Photo)', 'red')}
                                            <div>
                                                <label className="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Reason</label>
                                                <RichTextEditor
                                                    value={finding.reason}
                                                    onChange={(val) => updateFinding(idx, 'reason', val)}
                                                    placeholder="Kenapa temuan ini terjadi?"
                                                    rows={4}
                                                />
                                            </div>
                                        </div>

                                        {/* HEADER: TINDAKAN PERBAIKAN */}
                                        <div className="flex items-center gap-2 pb-2 border-b border-red-200 dark:border-red-800 mt-6">
                                            <span className="bg-emerald-600 text-white w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="size-4">
                                                    <path fillRule="evenodd" d="M12 6.75a5.25 5.25 0 0 1 6.775-5.025.75.75 0 0 1 .313 1.248l-3.32 3.319c.063.475.276.934.641 1.299.365.365.824.578 1.3.64l3.318-3.319a.75.75 0 0 1 1.248.313 5.25 5.25 0 0 1-5.472 6.756c-1.018-.086-1.87.1-2.309.634L7.344 21.3A3.298 3.298 0 1 1 2.7 16.657l8.684-7.151c.533-.44.72-1.291.634-2.309A5.342 5.342 0 0 1 12 6.75ZM4.117 19.125a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75h-.008a.75.75 0 0 1-.75-.75v-.008Z" clipRule="evenodd" />
                                                    <path d="m10.076 8.64-2.201-2.2V4.874a.75.75 0 0 0-.364-.643l-3.75-2.25a.75.75 0 0 0-.916.113l-.75.75a.75.75 0 0 0-.113.916l2.25 3.75a.75.75 0 0 0 .643.364h1.564l2.062 2.062 1.575-1.297Z" />
                                                    <path fillRule="evenodd" d="m12.556 17.329 4.183 4.182a3.375 3.375 0 0 0 4.773-4.773l-3.306-3.305a6.803 6.803 0 0 1-1.53.043c-.394-.034-.682-.006-.867.042a.589.589 0 0 0-.167.063l-3.086 3.748Zm3.414-1.36a.75.75 0 0 1 1.06 0l1.875 1.876a.75.75 0 1 1-1.06 1.06L15.97 17.03a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                                </svg>
                                            </span>
                                            <h4 className="font-bold text-sm text-emerald-800 dark:text-emerald-300">Tindakan Perbaikan</h4>
                                        </div>

                                        {/* BARIS 3: ACTION TAKEN, EVIDENCE ACTION */}
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label className="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Action Taken</label>
                                                <RichTextEditor
                                                    value={finding.action}
                                                    onChange={(val) => updateFinding(idx, 'action', val)}
                                                    placeholder="Tindakan perbaikan yang dilakukan..."
                                                    rows={4}
                                                />
                                            </div>
                                            {renderEvidencePhotos(finding, idx, 'evidence_action', 'Evidence Action (Live Photo)', 'emerald')}
                                        </div>
                                    </div>
                                )
                            })
                        )}
                    </div>
                </div>

                {/* FOOTER */}
                <div className="pt-2 pb-8 flex justify-end gap-3">
                    <button 
                        type="button" 
                        onClick={() => window.Livewire.navigate('/prod/patrol/result-patrol')} 
                        className="px-6 py-2.5 border border-zinc-300 dark:border-zinc-600 rounded-lg text-sm font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors"
                    >
                        Batal
                    </button>
                    <button type="submit" disabled={saving} className="px-6 py-2.5 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 shadow-md disabled:opacity-60 transition-all">
                        {saving ? 'Menyimpan...' : 'Simpan Result Patrol'}
                    </button>
                </div>
            </form>

            {/* MODAL PREVIEW FOTO */}
            {photoPreview && (
                <div className="fixed inset-0 z-[110] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm" onClick={() => setPhotoPreview(null)}>
                    <div className="relative max-w-4xl w-full flex flex-col items-center" onClick={e => e.stopPropagation()}>
                        <div className="w-full flex justify-between items-center bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 rounded-t-xl text-white shadow-md">
                            <h3 className="font-bold text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100"><path d="M12 15a3 3 0 100-6 3 3 0 000 6z" /><path fillRule="evenodd" d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.49 4.467-5.705 7.69-10.675 7.69-4.973 0-9.19-3.223-10.678-7.69a2.25 2.25 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" clipRule="evenodd" /></svg>
                                Preview {photoPreview.title}
                            </h3>
                            <div className="flex items-center gap-2">
                                {photoPreview.onDelete && (
                                    <button 
                                        onClick={() => { photoPreview.onDelete(); setPhotoPreview(null) }} 
                                        className="text-white bg-red-600 hover:bg-red-700 rounded-full px-3 py-1 text-xs font-bold transition-colors"
                                    >
                                        Hapus
                                    </button>
                                )}
                                <button onClick={() => setPhotoPreview(null)} className="text-blue-100 hover:text-white bg-white/20 hover:bg-white/30 rounded-full p-1 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" /></svg>
                                </button>
                            </div>
                        </div>
                        <div className="bg-zinc-900 p-2 w-full flex justify-center rounded-b-xl border border-t-0 border-zinc-700">
                            <img src={photoPreview.url} alt="Preview" className="max-h-[80vh] w-auto object-contain rounded" />
                        </div>
                    </div>
                </div>
            )}

            {/* MODAL SEARCH */}
            {searchModal.isOpen && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 p-4 backdrop-blur-sm">
                    <div className="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden w-full max-w-lg flex flex-col max-h-[80vh] border dark:border-zinc-700">
                        <div className="bg-zinc-800 dark:bg-zinc-950 px-4 py-3 flex justify-between items-center text-white">
                            <h3 className="font-bold text-sm">
                                Pilih {searchModal.target === 'category' ? 'Kategori' : 'Karyawan'}
                            </h3>
                            <button onClick={closeSearchModal} className="text-zinc-400 hover:text-white">✕</button>
                        </div>
                        
                        <div className="p-3 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                            <div className="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400 pointer-events-none">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input 
                                    type="text" 
                                    placeholder="Cari..." 
                                    value={searchModal.query}
                                    onChange={(e) => setSearchModal({...searchModal, query: e.target.value, page: 1})}
                                    className="w-full pl-12 pr-3 py-2 text-sm border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-800 dark:text-zinc-100 bg-white dark:bg-zinc-800 placeholder:text-zinc-400 dark:placeholder:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    autoFocus
                                />
                            </div>
                        </div>

                        <div className="flex-1 overflow-auto">
                            {(() => {
                                const data = getFilteredModalData()
                                const startIndex = (searchModal.page - 1) * searchModal.perPage
                                const paginatedData = data.slice(startIndex, startIndex + searchModal.perPage)

                                if (data.length === 0) {
                                    return <p className="p-6 text-center text-sm text-zinc-500 dark:text-zinc-400 italic">Data tidak ditemukan.</p>
                                }

                                return (
                                    <table className="w-full text-sm text-left">
                                        <thead className="bg-zinc-100 dark:bg-zinc-800 sticky top-0 z-10 border-b border-zinc-200 dark:border-zinc-700">
                                            <tr>
                                                {searchModal.target === 'category' ? (
                                                    <th className="px-4 py-2 text-xs font-bold text-zinc-600 dark:text-zinc-400">Nama Kategori</th>
                                                ) : (
                                                    <>
                                                        <th className="px-4 py-2 text-xs font-bold text-zinc-600 dark:text-zinc-400">Nama</th>
                                                        <th className="px-4 py-2 text-xs font-bold text-zinc-600 dark:text-zinc-400">NIK</th>
                                                    </>
                                                )}
                                            </tr>
                                        </thead>
                                        <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                            {paginatedData.map((item) => (
                                                <tr 
                                                    key={item.id || item.nik} 
                                                    onClick={() => handleSelectModalData(item)}
                                                    className="cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
                                                >
                                                    {searchModal.target === 'category' ? (
                                                        <td className="px-4 py-2 font-medium text-zinc-800 dark:text-zinc-200">{item.category_name}</td>
                                                    ) : (
                                                        <>
                                                            <td className="px-4 py-2 font-medium text-zinc-800 dark:text-zinc-200">{item.name}</td>
                                                            <td className="px-4 py-2 text-zinc-500 dark:text-zinc-400">{item.nik}</td>
                                                        </>
                                                    )}
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                )
                            })()}
                        </div>

                        {(() => {
                            const data = getFilteredModalData()
                            const totalPages = Math.ceil(data.length / searchModal.perPage)
                            if (totalPages <= 1) return null
                            
                            return (
                                <div className="p-3 border-t border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50 flex justify-between items-center text-sm">
                                    <span className="text-zinc-500 dark:text-zinc-400 text-xs">Total: {data.length}</span>
                                    <div className="flex gap-2">
                                        <button 
                                            disabled={searchModal.page === 1}
                                            onClick={() => setSearchModal({...searchModal, page: searchModal.page - 1})}
                                            className="px-3 py-1 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-50"
                                        >
                                            Prev
                                        </button>
                                        <span className="px-3 py-1 font-semibold text-zinc-700 dark:text-zinc-300">{searchModal.page} / {totalPages}</span>
                                        <button 
                                            disabled={searchModal.page === totalPages}
                                            onClick={() => setSearchModal({...searchModal, page: searchModal.page + 1})}
                                            className="px-3 py-1 border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 disabled:opacity-50"
                                        >
                                            Next
                                        </button>
                                    </div>
                                </div>
                            )
                        })()}
                    </div>
                </div>
            )}

            {/* MODAL KAMERA */}
            {cameraTarget && (
                <div className="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm">
                    <div className="bg-white dark:bg-zinc-900 rounded-xl shadow-2xl overflow-hidden w-full max-w-lg flex flex-col">
                        <div className="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 flex justify-between items-center text-white">
                            <h3 className="font-bold text-sm flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5 text-blue-100"><path fillRule="evenodd" d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h2.596c.864 0 1.671-.448 2.13-1.188l.94-1.505a1.875 1.875 0 0 1 1.602-.915h3.614c.659 0 1.271.35 1.602.915l.94 1.505c.459.74 1.266 1.188 2.13 1.188h2.596c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 19.125V6.375ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clipRule="evenodd" /></svg>
                                Ambil Foto
                            </h3>
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
                            <button 
                                onClick={closeCamera} 
                                className="px-6 py-2 rounded-full bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 shadow-sm font-semibold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"
                            >
                                Cancel
                            </button>
                            {!cameraError && (
                                <button 
                                    onClick={capturePhoto} 
                                    className="px-8 py-2 rounded-full bg-blue-600 text-white font-bold shadow-md hover:bg-blue-700 transition-colors flex items-center gap-2"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-5 h-5"><path fillRule="evenodd" d="M1.5 6.375c0-1.036.84-1.875 1.875-1.875h2.596c.864 0 1.671-.448 2.13-1.188l.94-1.505a1.875 1.875 0 0 1 1.602-.915h3.614c.659 0 1.271.35 1.602.915l.94 1.505c.459.74 1.266 1.188 2.13 1.188h2.596c1.035 0 1.875.84 1.875 1.875v12.75c0 1.035-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 19.125V6.375ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clipRule="evenodd" /></svg>
                                    Take Photo
                                </button>
                            )}
                        </div>
                    </div>
                </div>
            )}

            {/* TOAST */}
            {toast && <div className={`fixed bottom-6 right-6 z-[120] px-4 py-3 rounded-xl shadow-xl text-white text-sm font-semibold ${toast.type === 'error' ? 'bg-red-600' : 'bg-emerald-600'}`}>{toast.message}</div>}
        </div>
    )
}