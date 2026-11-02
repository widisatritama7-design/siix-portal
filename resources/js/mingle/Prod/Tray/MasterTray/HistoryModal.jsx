import React from 'react'

export default function HistoryModal({ tray, historyRows, loading, onClose }) {
    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            {/* ⬇️ Pastikan container utama punya rounded-2xl dan overflow-hidden */}
            <div className="w-full max-w-3xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 max-h-[90vh] flex flex-col overflow-hidden">
                
                {/* ⬇️ Hapus rounded-t-2xl di sini */}
                <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center shrink-0">
                    <div>
                        <h2 className="text-base font-bold text-white">Transaction History</h2>
                        <p className="text-xs text-white/80 mt-0.5">
                            Tray <strong>{tray?.part_number_tray}</strong>
                            {tray?.rack_number ? ` · Rack ${tray.rack_number}` : ''}
                            {tray?.locator_number ? ` / ${tray.locator_number}` : ''}
                        </p>
                    </div>
                </div>

                <div className="p-0 overflow-y-auto">
                    {loading ? (
                        <div className="py-16 text-center text-sm text-zinc-400">Loading history...</div>
                    ) : historyRows.length === 0 ? (
                        <div className="py-16 text-center text-sm text-zinc-400">No transactions found for this tray.</div>
                    ) : (
                        <table className="w-full text-sm min-w-max">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700 sticky top-0 z-10">
                                <tr className="whitespace-nowrap text-xs uppercase tracking-wider font-semibold text-zinc-500">
                                    <th className="px-4 py-3 w-12 text-center">#</th>
                                    <th className="px-4 py-3 text-center">Date</th>
                                    <th className="px-4 py-3 text-center">Type</th>
                                    <th className="px-4 py-3 text-center">Qty In</th>
                                    <th className="px-4 py-3 text-center">Qty Out</th>
                                    <th className="px-4 py-3 text-left">Reason</th>
                                    <th className="px-4 py-3 text-left">Created By</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {historyRows.map((trx, idx) => {
                                    const isIn = (trx.transaction_type ?? '').toLowerCase() === 'in'
                                    return (
                                        <tr key={trx.id} className="hover:bg-blue-50/30 dark:hover:bg-blue-950/10 transition-colors whitespace-nowrap">
                                            <td className="px-4 py-3 text-center text-zinc-500 font-mono text-xs">{idx + 1}</td>
                                            <td className="px-4 py-3 text-center text-zinc-600 dark:text-zinc-300 text-xs">{trx.created_at}</td>
                                            <td className="px-4 py-3 text-center">
                                                {isIn ? (
                                                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                                        IN
                                                    </span>
                                                ) : (
                                                    <span className="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                                        OUT
                                                    </span>
                                                )}
                                            </td>
                                            <td className="px-4 py-3 text-center font-semibold text-emerald-700 dark:text-emerald-300">{trx.qty_in ?? '-'}</td>
                                            <td className="px-4 py-3 text-center font-semibold text-red-700 dark:text-red-300">{trx.qty_out ?? '-'}</td>
                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 text-xs">{trx.reason ?? '-'}</td>
                                            <td className="px-4 py-3 text-zinc-500 dark:text-zinc-400 text-xs">{trx.created_by_name}</td>
                                        </tr>
                                    )
                                })}
                            </tbody>
                        </table>
                    )}
                </div>

                <div className="px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 flex justify-end shrink-0">
                    <button onClick={onClose} className="px-4 py-2 text-sm rounded-lg bg-zinc-200 dark:bg-zinc-700 text-zinc-800 dark:text-zinc-200 font-semibold hover:bg-zinc-300 dark:hover:bg-zinc-600 transition-colors">
                        Close
                    </button>
                </div>
            </div>
        </div>
    )
}