import React, { useState, useRef, useEffect } from 'react'

export default function ScanLocatorModal({ wire, onClose, onFound, showToast }) {
    const [locator, setLocator] = useState('')
    const [scanning, setScanning] = useState(false)
    const inputRef = useRef(null)

    useEffect(() => {
        setTimeout(() => inputRef.current?.focus(), 100)
    }, [])

    const handleScan = async (e) => {
        e.preventDefault()
        const value = locator.trim()
        if (!value) {
            showToast('Please scan or type a locator number', 'error')
            return
        }
        setScanning(true)
        try {
            // Panggil fungsi Livewire
            const result = await wire.findTraysByLocator(value)
            if (result.success) {
                onFound(result.locator, result.trays)
            } else {
                showToast(result.message, 'error')
                setLocator('')
                inputRef.current?.focus()
            }
        } catch (e) {
            showToast('Failed to scan: ' + e.message, 'error')
        } finally {
            setScanning(false)
        }
    }

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div className="w-full max-w-md bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center">
                    <h2 className="text-base font-bold text-white">Scan Locator</h2>
                    <button onClick={onClose} className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">✕</button>
                </div>

                <form onSubmit={handleScan} className="p-5 space-y-4">
                    <div className="text-center">
                        <div className="mx-auto mb-3 flex items-center justify-center w-14 h-14 rounded-full bg-blue-100 dark:bg-blue-900/30">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                <path fill-rule="evenodd" d="M3 4.875C3 3.839 3.84 3 4.875 3h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 9.375v-4.5ZM4.875 4.5a.375.375 0 0 0-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 0 0 .375-.375v-4.5a.375.375 0 0 0-.375-.375h-4.5Zm7.875.375c0-1.036.84-1.875 1.875-1.875h4.5C20.16 3 21 3.84 21 4.875v4.5c0 1.036-.84 1.875-1.875 1.875h-4.5a1.875 1.875 0 0 1-1.875-1.875v-4.5Zm1.875-.375a.375.375 0 0 0-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 0 0 .375-.375v-4.5a.375.375 0 0 0-.375-.375h-4.5ZM6 6.75A.75.75 0 0 1 6.75 6h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75A.75.75 0 0 1 6 7.5v-.75Zm9.75 0A.75.75 0 0 1 16.5 6h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75ZM3 14.625c0-1.036.84-1.875 1.875-1.875h4.5c1.036 0 1.875.84 1.875 1.875v4.5c0 1.035-.84 1.875-1.875 1.875h-4.5A1.875 1.875 0 0 1 3 19.125v-4.5Zm1.875-.375a.375.375 0 0 0-.375.375v4.5c0 .207.168.375.375.375h4.5a.375.375 0 0 0 .375-.375v-4.5a.375.375 0 0 0-.375-.375h-4.5Zm7.875-.75a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm6 0a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75ZM6 16.5a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm9.75 0a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm-3 3a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Zm6 0a.75.75 0 0 1 .75-.75h.75a.75.75 0 0 1 .75.75v.75a.75.75 0 0 1-.75.75h-.75a.75.75 0 0 1-.75-.75v-.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p className="text-sm text-zinc-600 dark:text-zinc-400">
                            Scan the locator barcode or type the locator number below.
                        </p>
                    </div>

                    <div>
                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                            Locator Number <span className="text-red-500">*</span>
                        </label>
                        <input
                            ref={inputRef}
                            type="text"
                            value={locator}
                            onChange={e => setLocator(e.target.value)}
                            disabled={scanning}
                            className="w-full px-3.5 py-3 text-center text-lg font-mono tracking-widest rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-60"
                            placeholder="e.g. LC-001"
                            autoComplete="off"
                        />
                    </div>

                    <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" onClick={onClose} disabled={scanning}
                            className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700 disabled:opacity-50">
                            Cancel
                        </button>
                        <button type="submit" disabled={scanning}
                            className="inline-flex items-center gap-2 px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-60">
                            {scanning ? 'Scanning...' : 'Next →'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    )
}