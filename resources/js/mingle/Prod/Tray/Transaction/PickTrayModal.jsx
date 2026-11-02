import React, { useState } from 'react'

export default function PickTrayModal({ locator, trays = [], onBack, onPick }) {
    const [selectedId, setSelectedId] = useState(null)

    const selected = trays.find(t => String(t.id) === String(selectedId))

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div className="w-full max-w-4xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 max-h-[90vh] flex flex-col">
                
                {/* HEADER */}
                <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center rounded-t-2xl shrink-0">
                    <div>
                        <h2 className="text-base font-bold text-white">Pick Tray</h2>
                        <p className="text-xs text-white/80 mt-0.5">
                            Locator <strong>{locator?.locator_number}</strong>
                            {locator?.rack_number ? ` · Rack ${locator.rack_number}` : ''}
                        </p>
                    </div>
                </div>

                {/* CONTENT */}
                <div className="p-0 overflow-y-auto">
                    <div className="p-5 pb-0">
                        <p className="text-sm text-zinc-600 dark:text-zinc-400 mb-3">
                            {trays.length} tray{trays.length > 1 ? 's' : ''} found in this locator. Pick one to continue.
                        </p>
                    </div>

                    <div className="overflow-x-auto px-5 pb-5">
                        <table className="w-full text-sm min-w-max border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">
                                <tr>
                                    <th className="px-4 py-3 w-12 text-center"></th>
                                    <th className="px-4 py-3">Part Number</th>
                                    <th className="px-4 py-3 text-center">Item Code SAP</th>
                                    <th className="px-4 py-3 text-center">Model</th>
                                    <th className="px-4 py-3 text-center">Cav</th>
                                    <th className="px-4 py-3">Customer</th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                                {trays.map(tray => {
                                    const active = String(selectedId) === String(tray.id)
                                    return (
                                        <tr 
                                            key={tray.id} 
                                            onClick={() => setSelectedId(tray.id)}
                                            className={`cursor-pointer transition-colors whitespace-nowrap ${
                                                active 
                                                    ? 'bg-blue-50 dark:bg-blue-900/20' 
                                                    : 'hover:bg-zinc-50 dark:hover:bg-zinc-800/50'
                                            }`}
                                        >
                                            <td className="px-4 py-3 text-center">
                                                <div className={`inline-flex items-center justify-center w-5 h-5 rounded-full border-2 ${
                                                    active ? 'border-blue-500 bg-blue-500' : 'border-zinc-300 dark:border-zinc-600'
                                                }`}>
                                                    {active && (
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-3 h-3 text-white">
                                                            <path fillRule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clipRule="evenodd" />
                                                        </svg>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {tray.part_number_tray}
                                            </td>
                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {tray.item_code_sap || '-'}
                                            </td>
                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {tray.model || '-'}
                                            </td>
                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {tray.cav_tray ?? '-'}
                                            </td>
                                            <td className="px-4 py-3 text-zinc-600 dark:text-zinc-300 text-xs">
                                                {tray.customer_name || '-'}
                                            </td>
                                        </tr>
                                    )
                                })}
                            </tbody>
                        </table>
                    </div>
                </div>

                {/* FOOTER */}
                <div className="flex justify-between gap-2 px-5 py-3 bg-zinc-50 dark:bg-zinc-800/40 border-t border-zinc-200 dark:border-zinc-700 shrink-0">
                    <button type="button" onClick={onBack}
                        className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">
                        ← Back
                    </button>
                    <button type="button" disabled={!selected} onClick={() => onPick(selected)}
                        className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next →
                    </button>
                </div>
            </div>
        </div>
    )
}