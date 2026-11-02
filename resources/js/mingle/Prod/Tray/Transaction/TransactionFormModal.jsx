import React, { useState } from 'react'

export default function TransactionFormModal({ wire, tray, initialRow, onClose, onBack, onSaved, showToast }) {
    const [saving, setSaving] = useState(false)
    const [form, setForm] = useState({
        id: initialRow?.id ?? null,
        master_tray_id: tray?.id ?? initialRow?.master_tray_id ?? null,
        transaction_type: initialRow?.transaction_type ?? 'in',
        qty_in: initialRow?.qty_in ?? '',
        qty_out: initialRow?.qty_out ?? '',
        reason: initialRow?.reason ?? '',
    })

    const isIn = form.transaction_type === 'in'

    const setType = (type) => {
        setForm({
            ...form,
            transaction_type: type,
            qty_in: type === 'in' ? form.qty_in : '',
            qty_out: type === 'out' ? form.qty_out : '',
        })
    }

    const handleSave = async (e) => {
        e.preventDefault()
        setSaving(true)
        try {
            const payload = {
                id: form.id,
                master_tray_id: form.master_tray_id,
                transaction_type: form.transaction_type,
                qty_in: isIn ? form.qty_in : null,
                qty_out: isIn ? null : form.qty_out,
                reason: (form.reason || '').trim() || null,
            }
            const result = await wire.save(payload)
            if (result.success) {
                onSaved(result)
            } else {
                showToast(result.message, 'error')
            }
        } catch (e) {
            showToast('Failed to save: ' + e.message, 'error')
        } finally {
            setSaving(false)
        }
    }

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div className="w-full max-w-xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 max-h-[90vh] flex flex-col">
                <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center rounded-t-2xl">
                    <h2 className="text-base font-bold text-white">{form.id ? 'Edit Transaction' : 'Transaction'}</h2>
                </div>

                <form onSubmit={handleSave} className="p-5 space-y-4 overflow-y-auto">

                    {/* TRAY INFO (READ-ONLY) */}
                    <div className="rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/30 overflow-hidden">
                        <div className="px-4 py-2 bg-blue-600 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4 text-white shrink-0">
                                <path fillRule="evenodd" d="M16.403 12.652a3 3 0 0 0 0-5.304 3 3 0 0 0-3.75-3.751 3 3 0 0 0-5.305 0 3 3 0 0 0-3.751 3.75 3 3 0 0 0 0 5.305 3 3 0 0 0 3.75 3.751 3 3 0 0 0 5.305 0 3 3 0 0 0 3.751-3.75Zm-2.546-4.46a.75.75 0 0 0-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clipRule="evenodd" />
                            </svg>
                            <span className="text-xs font-bold text-white uppercase tracking-wider">Selected Tray</span>
                        </div>
                        
                        <table className="w-full text-sm">
                            <tbody className="divide-y divide-blue-200/60 dark:divide-blue-800/60">
                                <tr>
                                    <td className="px-4 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-400 w-1/3">Part Number</td>
                                    <td className="px-4 py-2 font-bold text-zinc-800 dark:text-white">{tray?.part_number_tray ?? '-'}</td>
                                </tr>
                                <tr>
                                    <td className="px-4 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-400">Item Code SAP</td>
                                    <td className="px-4 py-2 font-mono text-zinc-800 dark:text-zinc-100">{tray?.item_code_sap ?? '-'}</td>
                                </tr>
                                <tr>
                                    <td className="px-4 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-400">Description</td>
                                    <td className="px-4 py-2 text-zinc-800 dark:text-zinc-100">{tray?.desc ?? '-'}</td>
                                </tr>
                                <tr>
                                    <td className="px-4 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-400">Model</td>
                                    <td className="px-4 py-2 text-zinc-800 dark:text-zinc-100">{tray?.model ?? '-'}</td>
                                </tr>
                                <tr>
                                    <td className="px-4 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-400">Cavity</td>
                                    <td className="px-4 py-2 text-zinc-800 dark:text-zinc-100">{tray?.cav_tray ?? '-'}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {/* TIPE TRANSAKSI */}
                    <div>
                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                            Transaction Type <span className="text-red-500">*</span>
                        </label>
                        <div className="grid grid-cols-2 gap-2">
                            <button type="button" onClick={() => setType('in')}
                                className={`flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold border-2 transition-all ${
                                    isIn
                                        ? 'bg-emerald-600 border-emerald-600 text-white shadow-sm'
                                        : 'bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 text-zinc-600 dark:text-zinc-300 hover:border-emerald-400'
                                }`}>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                    <path fillRule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z" clipRule="evenodd" />
                                </svg>
                                IN
                            </button>
                            <button type="button" onClick={() => setType('out')}
                                className={`flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg text-sm font-bold border-2 transition-all ${
                                    !isIn
                                        ? 'bg-red-600 border-red-600 text-white shadow-sm'
                                        : 'bg-white dark:bg-zinc-800 border-zinc-300 dark:border-zinc-600 text-zinc-600 dark:text-zinc-300 hover:border-red-400'
                                }`}>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                    <path fillRule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM6.75 9.25a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clipRule="evenodd" />
                                </svg>
                                OUT
                            </button>
                        </div>
                    </div>

                    {/* QTY */}
                    <div>
                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                            {isIn ? 'Qty IN' : 'Qty OUT'} <span className="text-red-500">*</span>
                        </label>
                        <input type="number" min="1"
                            value={isIn ? form.qty_in : form.qty_out}
                            onChange={e => setForm({ ...form, [isIn ? 'qty_in' : 'qty_out']: e.target.value })}
                            required
                            className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="e.g. 10"
                        />
                    </div>

                    {/* REASON */}
                    <div>
                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Reason</label>
                        <textarea value={form.reason} onChange={e => setForm({ ...form, reason: e.target.value })} rows={3}
                            className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Optional reason..." />
                    </div>

                    <div className="flex justify-between gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        {/* Tombol Back (jika alur create, bukan edit) */}
                        {onBack ? (
                            <button type="button" onClick={onBack} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                ← Back
                            </button>
                        ) : <div></div>}
                        
                        <div className="flex gap-2">
                            <button type="button" onClick={onClose} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">
                                Cancel
                            </button>
                            <button type="submit" disabled={saving}
                                className={`px-4 py-2 text-sm rounded-lg text-white font-semibold disabled:opacity-60 ${isIn ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-red-600 hover:bg-red-700'}`}>
                                {saving ? 'Saving...' : (isIn ? 'Save IN' : 'Save OUT')}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    )
}