import React, { useState, useMemo, useRef, useEffect } from 'react'

export default function TrayFormModal({ wire, initialRow, racks, locators, customers, onClose, onSaved, showToast }) {
    const [saving, setSaving] = useState(false)
    const [form, setForm] = useState({
        id: initialRow?.id ?? null,
        master_rack_id: initialRow?.master_rack_id ?? '',
        master_locator_id: initialRow?.master_locator_id ?? '',
        customer_id: initialRow?.customer_id ?? '',
        part_number_tray: initialRow?.part_number_tray ?? '',
        item_code_sap: initialRow?.item_code_sap ?? '',
        desc: initialRow?.desc ?? '',
        model: initialRow?.model ?? '',
        cav_tray: initialRow?.cav_tray ?? '',
    })

    const [showRackDropdown, setShowRackDropdown]         = useState(false)
    const [showLocatorDropdown, setShowLocatorDropdown]   = useState(false)
    const [showCustomerDropdown, setShowCustomerDropdown] = useState(false)
    const rackDropdownRef     = useRef(null)
    const locatorDropdownRef  = useRef(null)
    const customerDropdownRef = useRef(null)

    useEffect(() => {
        const handler = (e) => {
            if (rackDropdownRef.current && !rackDropdownRef.current.contains(e.target)) setShowRackDropdown(false)
            if (locatorDropdownRef.current && !locatorDropdownRef.current.contains(e.target)) setShowLocatorDropdown(false)
            if (customerDropdownRef.current && !customerDropdownRef.current.contains(e.target)) setShowCustomerDropdown(false)
        }
        document.addEventListener('mousedown', handler)
        return () => document.removeEventListener('mousedown', handler)
    }, [])

    const filteredLocators = useMemo(() => {
        if (!form.master_rack_id) return []
        return locators.filter(l => String(l.master_rack_id) === String(form.master_rack_id))
    }, [locators, form.master_rack_id])

    const selectedRackNumber     = useMemo(() => racks.find(r => String(r.id) === String(form.master_rack_id))?.rack_number ?? '', [racks, form.master_rack_id])
    const selectedLocatorNumber  = useMemo(() => locators.find(l => String(l.id) === String(form.master_locator_id))?.locator_number ?? '', [locators, form.master_locator_id])
    const selectedCustomerName   = useMemo(() => customers.find(c => String(c.id) === String(form.customer_id))?.customer_name ?? '', [customers, form.customer_id])

    const pickRack     = (rack)     => { setForm({ ...form, master_rack_id: rack.id, master_locator_id: '' }); setShowRackDropdown(false) }
    const pickLocator  = (locator)  => { setForm({ ...form, master_locator_id: locator.id }); setShowLocatorDropdown(false) }
    const pickCustomer = (customer) => { setForm({ ...form, customer_id: customer.id }); setShowCustomerDropdown(false) }

    const handleSave = async (e) => {
        e.preventDefault()
        setSaving(true)
        try {
            const payload = {
                id: form.id,
                master_rack_id: form.master_rack_id || null,
                master_locator_id: form.master_locator_id || null,
                customer_id: form.customer_id || null,
                part_number_tray: (form.part_number_tray || '').trim(),
                item_code_sap: (form.item_code_sap || '').trim() || null,
                desc: (form.desc || '').trim() || null,
                model: (form.model || '').trim() || null,
                cav_tray: form.cav_tray !== '' ? form.cav_tray : null,
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
            <div className="w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 max-h-[90vh] flex flex-col">
                <div className="px-5 py-4 bg-gradient-to-r from-blue-600 to-blue-700 flex justify-between items-center rounded-t-2xl">
                    <h2 className="text-base font-bold text-white">{form.id ? 'Edit Tray' : 'Add Tray'}</h2>
                    <button onClick={onClose} className="text-white/80 hover:text-white p-1 rounded hover:bg-white/20">✕</button>
                </div>
                <form onSubmit={handleSave} className="p-5 space-y-4 overflow-y-auto">

                    {/* RACK + LOCATOR */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                Rack <span className="text-red-500">*</span>
                            </label>
                            <div className="relative" ref={rackDropdownRef}>
                                <button type="button" onClick={() => setShowRackDropdown(v => !v)}
                                    className="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-left text-zinc-800 dark:text-zinc-100 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                    <span className={selectedRackNumber ? '' : 'text-zinc-400 dark:text-zinc-500'}>
                                        {selectedRackNumber || '-- Select Rack --'}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        className={`w-4 h-4 text-zinc-400 shrink-0 transition-transform duration-200 ${showRackDropdown ? 'rotate-180' : ''}`}>
                                        <path fillRule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                    </svg>
                                </button>
                                {showRackDropdown && (
                                    <div className="absolute z-20 mt-1 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden">
                                        <div className="max-h-56 overflow-y-auto py-1">
                                            {racks.length === 0 && (
                                                <div className="px-3.5 py-2.5 text-sm text-zinc-400 italic">No racks available</div>
                                            )}
                                            {racks.map(rack => (
                                                <button key={rack.id} type="button" onClick={() => pickRack(rack)}
                                                    className={`w-full flex items-center justify-between gap-2 px-3.5 py-2 text-sm text-left transition-colors ${
                                                        String(form.master_rack_id) === String(rack.id)
                                                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold'
                                                            : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                                                    }`}>
                                                    <span>{rack.rack_number}</span>
                                                    {String(form.master_rack_id) === String(rack.id) && (
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                                            <path fillRule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clipRule="evenodd" />
                                                        </svg>
                                                    )}
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>

                        <div>
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Locator</label>
                            <div className="relative" ref={locatorDropdownRef}>
                                <button type="button" onClick={() => setShowLocatorDropdown(v => !v)} disabled={!form.master_rack_id}
                                    className="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-left text-zinc-800 dark:text-zinc-100 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span className={selectedLocatorNumber ? '' : 'text-zinc-400 dark:text-zinc-500'}>
                                        {selectedLocatorNumber || '-- Select Locator --'}
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        className={`w-4 h-4 text-zinc-400 shrink-0 transition-transform duration-200 ${showLocatorDropdown ? 'rotate-180' : ''}`}>
                                        <path fillRule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                    </svg>
                                </button>
                                {showLocatorDropdown && form.master_rack_id && (
                                    <div className="absolute z-20 mt-1 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden">
                                        <div className="max-h-56 overflow-y-auto py-1">
                                            {filteredLocators.length === 0 && (
                                                <div className="px-3.5 py-2.5 text-sm text-zinc-400 italic">No locators available for this rack</div>
                                            )}
                                            {filteredLocators.map(locator => (
                                                <button key={locator.id} type="button" onClick={() => pickLocator(locator)}
                                                    className={`w-full flex items-center justify-between gap-2 px-3.5 py-2 text-sm text-left transition-colors ${
                                                        String(form.master_locator_id) === String(locator.id)
                                                            ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold'
                                                            : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                                                    }`}>
                                                    <span>{locator.locator_number}</span>
                                                    {String(form.master_locator_id) === String(locator.id) && (
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                                            <path fillRule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clipRule="evenodd" />
                                                        </svg>
                                                    )}
                                                </button>
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </div>
                            <p className="text-xs text-zinc-500 dark:text-zinc-400 mt-1.5">Select rack first to load locators.</p>
                        </div>
                    </div>

                    {/* CUSTOMER */}
                    <div>
                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Customer</label>
                        <div className="relative" ref={customerDropdownRef}>
                            <button type="button" onClick={() => setShowCustomerDropdown(v => !v)}
                                className="w-full flex items-center justify-between gap-2 px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-left text-zinc-800 dark:text-zinc-100 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                                <span className={selectedCustomerName ? '' : 'text-zinc-400 dark:text-zinc-500'}>
                                    {selectedCustomerName || '-- Select Customer --'}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    className={`w-4 h-4 text-zinc-400 shrink-0 transition-transform duration-200 ${showCustomerDropdown ? 'rotate-180' : ''}`}>
                                    <path fillRule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clipRule="evenodd" />
                                </svg>
                            </button>
                            {showCustomerDropdown && (
                                <div className="absolute z-20 mt-1 w-full rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shadow-lg overflow-hidden">
                                    <div className="max-h-56 overflow-y-auto py-1">
                                        <button type="button" onClick={() => { setForm({ ...form, customer_id: '' }); setShowCustomerDropdown(false) }}
                                            className="w-full px-3.5 py-2 text-sm text-left text-zinc-400 italic hover:bg-zinc-100 dark:hover:bg-zinc-700">-- None --</button>
                                        {customers.map(customer => (
                                            <button key={customer.id} type="button" onClick={() => pickCustomer(customer)}
                                                className={`w-full flex items-center justify-between gap-2 px-3.5 py-2 text-sm text-left transition-colors ${
                                                    String(form.customer_id) === String(customer.id)
                                                        ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-semibold'
                                                        : 'text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-700'
                                                }`}>
                                                <span>{customer.customer_name}</span>
                                                {String(form.customer_id) === String(customer.id) && (
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" className="w-4 h-4">
                                                        <path fillRule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clipRule="evenodd" />
                                                    </svg>
                                                )}
                                            </button>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* PART NUMBER + ITEM CODE SAP */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                Part Number Tray <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                value={form.part_number_tray}
                                onChange={e => setForm({ ...form, part_number_tray: e.target.value })}
                                required
                                className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g. TRY-001"
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">
                                Item Code SAP
                            </label>
                            <input
                                type="text"
                                value={form.item_code_sap}
                                onChange={e => setForm({ ...form, item_code_sap: e.target.value })}
                                className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g. 12345678"
                            />
                        </div>
                    </div>

                    {/* DESC */}
                    <div>
                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Description</label>
                        <textarea
                            value={form.desc}
                            onChange={e => setForm({ ...form, desc: e.target.value })}
                            rows={3}
                            className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Tray description..."
                        />
                    </div>

                    {/* MODEL + CAV */}
                    <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Model</label>
                            <input
                                type="text"
                                value={form.model}
                                onChange={e => setForm({ ...form, model: e.target.value })}
                                className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g. ABC-123"
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-200 mb-1.5">Cavity Tray</label>
                            <input
                                type="number"
                                min="0"
                                value={form.cav_tray}
                                onChange={e => setForm({ ...form, cav_tray: e.target.value })}
                                className="w-full px-3.5 py-2.5 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="e.g. 12"
                            />
                        </div>
                    </div>

                    <div className="flex justify-end gap-2 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                        <button type="button" onClick={onClose} className="px-4 py-2 text-sm rounded-lg border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 font-semibold hover:bg-zinc-100 dark:hover:bg-zinc-700">
                            Cancel
                        </button>
                        <button type="submit" disabled={saving} className="px-4 py-2 text-sm rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 disabled:opacity-60">
                            {saving ? 'Saving...' : 'Save'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    )
}