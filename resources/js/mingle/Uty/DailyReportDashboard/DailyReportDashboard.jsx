import React, { useState, useEffect } from 'react'
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    ArcElement, // <-- TAMBAHKAN INI UNTUK DOUGHNUT
    Title,
    Tooltip,
    Legend,
} from 'chart.js'
import { Bar, Doughnut } from 'react-chartjs-2' // <-- IMPORT DOUGHNUT

ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    ArcElement, // <-- DAFTARKAN
    Title,
    Tooltip,
    Legend
)

export default function DailyReportDashboard({ wire, mingleData }) {
    const [stats, setStats] = useState(mingleData?.stats ?? {})
    const [categories, setCategories] = useState(mingleData?.categories ?? [])
    const [chartData, setChartData] = useState(mingleData?.chartData ?? [])
    
    // Filter State
    const [month, setMonth] = useState(mingleData?.currentMonth ?? new Date().getMonth() + 1)
    const [year, setYear]   = useState(mingleData?.currentYear ?? new Date().getFullYear())
    const [loading, setLoading] = useState(false)

    const availableYears = mingleData?.availableYears ?? []

    const months = [
        { value: 1, label: 'January' }, { value: 2, label: 'February' },
        { value: 3, label: 'March' }, { value: 4, label: 'April' },
        { value: 5, label: 'May' }, { value: 6, label: 'June' },
        { value: 7, label: 'July' }, { value: 8, label: 'August' },
        { value: 9, label: 'September' }, { value: 10, label: 'October' },
        { value: 11, label: 'November' }, { value: 12, label: 'December' },
    ]

    const handleFilterChange = async (newMonth, newYear) => {
        setLoading(true)
        try {
            const result = await wire.changeFilter(newMonth, newYear)
            setStats(result.stats)
            setCategories(result.categories)
            setChartData(result.chartData)
        } catch (error) {
            console.error("Failed to load data", error)
        } finally {
            setLoading(false)
        }
    }

    useEffect(() => {
        handleFilterChange(month, year)
    }, [month, year])

    // 1. Konfigurasi Bar Chart
    const barData = {
        labels: chartData.map(d => d.label),
        datasets: [
            {
                label: 'Total Reports',
                data: chartData.map(d => d.count),
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                hoverBackgroundColor: '#2563eb',
            },
        ],
    }

    const barOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#18181b', padding: 12, cornerRadius: 8,
                titleFont: { size: 13, family: 'inherit' },
                bodyFont: { size: 14, family: 'inherit', weight: 'bold' },
            }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(0,0,0,0.05)' } },
            x: { grid: { display: false } }
        }
    }

    // 2. Konfigurasi Doughnut Chart (Spedometer)
    // Sisa (Open + On Progress + Under Maintenance) dianggap "Unfinished"
    const unfinished = stats.total - stats.closed
    const doughnutData = {
        labels: ['Closed', 'Unfinished'],
        datasets: [
            {
                data: [stats.closed, unfinished],
                backgroundColor: ['#10b981', '#e4e4e7'], // Emerald-500 & Zinc-200
                hoverBackgroundColor: ['#059669', '#d4d4d8'],
                borderWidth: 0,
                cutout: '75%', // Membuat lubang di tengah seperti spedometer
            },
        ],
    }

    const doughnutOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#18181b', padding: 10, cornerRadius: 8,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        if (label) { label += ': '; }
                        if (context.parsed !== null) { label += context.parsed; }
                        return label;
                    }
                }
            }
        }
    }

    // Persentase Penyelesaian
    const completionRate = stats.total > 0 ? Math.round((stats.closed / stats.total) * 100) : 0

    return (
        <div className="p-1 space-y-2">

            {/* HEADER & FILTER */}
            <div className="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h1 className="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white leading-tight">
                        Utility Daily Report Dashboard
                    </h1>
                    <p className="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Summary of utility patrol daily reports
                    </p>
                </div>

                {/* FILTER MONTH & YEAR CARD */}
                <div className="flex items-center gap-2 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-2 rounded-xl shadow-sm">
                    <select value={month} onChange={(e) => setMonth(Number(e.target.value))}
                        className="px-3 py-2 text-sm rounded-lg border-none bg-zinc-50 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 cursor-pointer font-medium">
                        {months.map(m => <option key={m.value} value={m.value}>{m.label}</option>)}
                    </select>
                    <select value={year} onChange={(e) => setYear(Number(e.target.value))}
                        className="px-3 py-2 text-sm rounded-lg border-none bg-zinc-50 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 cursor-pointer font-medium">
                        {availableYears.map(y => <option key={y} value={y}>{y}</option>)}
                    </select>
                </div>
            </div>

            {/* 1. STAT CARDS */}
            <div className={`grid grid-cols-2 lg:grid-cols-4 gap-4 transition-opacity duration-300 ${loading ? 'opacity-50 pointer-events-none' : 'opacity-100'}`}>
                
                {/* OPEN */}
                <div className="bg-gradient-to-br from-red-500 to-red-700 text-white rounded-xl p-5 shadow-md flex flex-col justify-between relative overflow-hidden">
                    <div className="absolute -bottom-4 -right-4 opacity-20 transform scale-150 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-24 h-24">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v2.25m0 5.25h.008v.008H12v-.008ZM21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9Z" />
                        </svg>
                    </div>
                    <span className="text-sm font-bold tracking-wider uppercase text-red-100 z-10">Open</span>
                    <span className="text-4xl font-extrabold mt-2 z-10">{stats.open}</span>
                </div>

                {/* ON PROGRESS */}
                <div className="bg-gradient-to-br from-amber-400 to-amber-600 text-white rounded-xl p-5 shadow-md flex flex-col justify-between relative overflow-hidden">
                    <div className="absolute -bottom-4 -right-4 opacity-20 transform scale-150 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-24 h-24">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <span className="text-sm font-bold tracking-wider uppercase text-amber-100 z-10">On Progress</span>
                    <span className="text-4xl font-extrabold mt-2 z-10">{stats.on_progress}</span>
                </div>

                {/* UNDER MAINTENANCE */}
                <div className="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-xl p-5 shadow-md flex flex-col justify-between relative overflow-hidden">
                    <div className="absolute -bottom-4 -right-4 opacity-20 transform scale-150 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-24 h-24">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437L11.5 10.5" />
                        </svg>
                    </div>
                    <span className="text-sm font-bold tracking-wider uppercase text-blue-100 z-10">Under Maint.</span>
                    <span className="text-4xl font-extrabold mt-2 z-10">{stats.under_maintenance}</span>
                </div>

                {/* CLOSED */}
                <div className="bg-gradient-to-br from-emerald-500 to-emerald-700 text-white rounded-xl p-5 shadow-md flex flex-col justify-between relative overflow-hidden">
                    <div className="absolute -bottom-4 -right-4 opacity-20 transform scale-150 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor" className="w-24 h-24">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <span className="text-sm font-bold tracking-wider uppercase text-emerald-100 z-10">Closed</span>
                    <span className="text-4xl font-extrabold mt-2 z-10">{stats.closed}</span>
                </div>

            </div>

            {/* 2. CHART & SPEDOMETER */}
            <div className={`grid grid-cols-1 lg:grid-cols-3 gap-4 transition-opacity duration-300 ${loading ? 'opacity-50 pointer-events-none' : 'opacity-100'}`}>
                
                {/* CHART BAR (By Week) */}
                <div className="lg:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm p-5">
                    <div className="flex items-center justify-between mb-6">
                        <h2 className="text-sm font-bold text-zinc-800 dark:text-white">Reports by Week (Friday - Thursday)</h2>
                        <span className="text-xs font-semibold bg-blue-50 text-blue-600 dark:bg-blue-900/40 dark:text-blue-400 px-2.5 py-1 rounded-md">
                            Total: {stats.total}
                        </span>
                    </div>
                    <div className="h-72 w-full">
                        <Bar data={barData} options={barOptions} />
                    </div>
                </div>

                {/* CHART DOUGHNUT (Perbandingan Total vs Closed) */}
                <div className="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm p-5 flex flex-col items-center justify-center relative">
                    <h2 className="text-sm font-bold text-zinc-800 dark:text-white absolute top-5 left-5">Completion Rate</h2>
                    
                    <div className="h-56 w-56 relative mt-4">
                        <Doughnut data={doughnutData} options={doughnutOptions} />
                        {/* Text di tengah Doughnut */}
                        <div className="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <span className="text-4xl font-extrabold text-zinc-800 dark:text-white">{completionRate}%</span>
                            <span className="text-xs font-semibold text-zinc-500 dark:text-zinc-400 mt-1">Closed</span>
                        </div>
                    </div>
                    
                    {/* Legend manual di bawah */}
                    <div className="flex items-center justify-center gap-6 mt-6 w-full">
                        <div className="flex items-center gap-2">
                            <span className="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span className="text-xs font-medium text-zinc-600 dark:text-zinc-400">Closed ({stats.closed})</span>
                        </div>
                        <div className="flex items-center gap-2">
                            <span className="w-3 h-3 rounded-full bg-zinc-200 dark:bg-zinc-700"></span>
                            <span className="text-xs font-medium text-zinc-600 dark:text-zinc-400">Unfinished ({unfinished})</span>
                        </div>
                    </div>
                </div>

            </div>

            {/* 3. TABLE (Full Width) */}
            <div className={`bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden flex flex-col transition-opacity duration-300 ${loading ? 'opacity-50 pointer-events-none' : 'opacity-100'}`}>
                <div className="px-5 py-4 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/40 flex justify-between items-center">
                    <h2 className="text-sm font-bold text-zinc-800 dark:text-white">Reports Breakdown by Category</h2>
                    <span className="text-xs font-semibold text-zinc-500">Bulan ke-{month} Tahun {year}</span>
                </div>
                <div className="overflow-x-auto">
                    <table className="w-full text-sm min-w-[700px]">
                        <thead className="bg-zinc-50 dark:bg-zinc-800/40 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th className="px-5 py-3 text-left text-xs uppercase tracking-wider font-semibold text-zinc-500">Category</th>
                                <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-red-500">Open</th>
                                <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-amber-500">On Progress</th>
                                <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-blue-500">Under Maintenance</th>
                                <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-emerald-500">Closed</th>
                                <th className="px-4 py-3 text-center text-xs uppercase tracking-wider font-semibold text-zinc-500">Total</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-zinc-100 dark:divide-zinc-800">
                            {categories.map((cat, idx) => (
                                <tr key={idx} className="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td className="px-5 py-4 font-semibold text-zinc-800 dark:text-zinc-200">{cat.name}</td>
                                    <td className="px-4 py-4 text-center font-medium text-red-600 dark:text-red-400">{cat.open}</td>
                                    <td className="px-4 py-4 text-center font-medium text-amber-600 dark:text-amber-400">{cat.on_progress}</td>
                                    <td className="px-4 py-4 text-center font-medium text-blue-600 dark:text-blue-400">{cat.under_maintenance}</td>
                                    <td className="px-4 py-4 text-center font-medium text-emerald-600 dark:text-emerald-400">{cat.closed}</td>
                                    <td className="px-4 py-4 text-center font-bold text-zinc-800 dark:text-white">{cat.total}</td>
                                </tr>
                            ))}
                            {categories.length === 0 && (
                                <tr>
                                    <td colSpan="7" className="px-5 py-12 text-center text-sm text-zinc-400">
                                        No data available for this month
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    )
}