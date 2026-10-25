import React, { useState, useEffect } from 'react'
import { Rnd } from 'react-rnd'

const COLORS = [
    { name: 'Blue', hex: '#3b82f6' }, { name: 'Red', hex: '#ef4444' },
    { name: 'Yellow', hex: '#eab308' }, { name: 'Green', hex: '#22c55e' },
    { name: 'Purple', hex: '#a855f7' }, { name: 'Gray', hex: '#64748b' },
    { name: 'Dark', hex: '#0f172a' },
]

export default function FloorPlanBuilder({ wire, mingleData }) {
    const [items, setItems] = useState(mingleData?.items || [])
    const [parentData, setParentData] = useState(mingleData?.parentData || null)
    const [currentParentId, setCurrentParentId] = useState(mingleData?.currentParentId || null)
    const [selectedItem, setSelectedItem] = useState(null)
    const [isLoading, setIsLoading] = useState(false)
    const [selectedColor, setSelectedColor] = useState(COLORS[0].hex)

    // State Zoom Manual
    const [zoomLevel, setZoomLevel] = useState(100); 

    // State untuk Menggambar Polygon
    const [isDrawMode, setIsDrawMode] = useState(false)
    const [drawnPoints, setDrawnPoints] = useState([])
    const [mousePos, setMousePos] = useState({ x: 0, y: 0 })

    useEffect(() => {
        if (mingleData) {
            setItems(mingleData.items || [])
            setParentData(mingleData.parentData || null)
            setCurrentParentId(mingleData.currentParentId || null)
        }
    }, [mingleData])

    const snapToGrid = (value) => Math.round(value / 20) * 20;

    // Fungsi Zoom
    const handleZoomIn = () => setZoomLevel(prev => Math.min(prev + 10, 200));
    const handleZoomOut = () => setZoomLevel(prev => Math.max(prev - 10, 50));
    const resetZoom = () => setZoomLevel(100);

    // ==========================================
    // FUNGSI MEMBUAT PATH MELENGKUNG
    // ==========================================
    const getSmoothPath = (points, radius = 8) => {
        if (!points || points.length < 3) return "";
        let d = "";
        const len = points.length;

        for (let i = 0; i < len; i++) {
            const p0 = points[(i - 1 + len) % len]; 
            const p1 = points[i];                 
            const p2 = points[(i + 1) % len];     

            const v1 = { x: p0.x - p1.x, y: p0.y - p1.y };
            const v2 = { x: p2.x - p1.x, y: p2.y - p1.y };

            const len1 = Math.hypot(v1.x, v1.y);
            const len2 = Math.hypot(v2.x, v2.y);

            const r1 = Math.min(radius, len1 / 2);
            const r2 = Math.min(radius, len2 / 2);

            const p1_start = { x: p1.x + (v1.x / len1) * r1, y: p1.y + (v1.y / len1) * r1 };
            const p1_end = { x: p1.x + (v2.x / len2) * r2, y: p1.y + (v2.y / len2) * r2 };

            if (i === 0) {
                d += `M ${p1_start.x} ${p1_start.y} `;
            } else {
                d += `L ${p1_start.x} ${p1_start.y} `;
            }

            d += `Q ${p1.x} ${p1.y} ${p1_end.x} ${p1_end.y} `;
        }
        d += "Z";
        return d;
    };

    // ==========================================
    // LOGIKA MENGGAMBAR SHAPE
    // ==========================================
    const handleCanvasClick = (e) => {
        if (!isDrawMode) return;
        const rect = e.currentTarget.getBoundingClientRect();
        const scale = zoomLevel / 100;
        const x = snapToGrid((e.clientX - rect.left) / scale);
        const y = snapToGrid((e.clientY - rect.top) / scale);

        if (drawnPoints.length > 2) {
            const firstPoint = drawnPoints[0];
            const distance = Math.hypot(x - firstPoint.x, y - firstPoint.y);
            if (distance < 20) {
                savePolygon(drawnPoints);
                return;
            }
        }
        setDrawnPoints([...drawnPoints, { x, y }]);
    };

    const handleCanvasMouseMove = (e) => {
        if (!isDrawMode) return;
        const rect = e.currentTarget.getBoundingClientRect();
        const scale = zoomLevel / 100;
        setMousePos({
            x: snapToGrid((e.clientX - rect.left) / scale),
            y: snapToGrid((e.clientY - rect.top) / scale)
        });
    };

    const savePolygon = async (points) => {
        const currentLevel = parentData ? parentData.level + 1 : (currentParentId === null ? 0 : 1);
        setIsLoading(true);
        try {
            const freshData = await wire.addItem(selectedColor, currentParentId, currentLevel, 'Custom Shape', 'polygon', points);
            if (freshData) setItems(freshData.items || []);
        } catch (error) {
            console.error("Gagal menyimpan shape:", error);
        } finally {
            setIsLoading(false);
            setIsDrawMode(false);
            setDrawnPoints([]);
        }
    };

    // ==========================================
    // NAVIGASI & TAMBAH
    // ==========================================
    const handleNavigate = async (item) => {
        if (item.level > 0 && item.level >= 4) return; 
        setIsLoading(true);
        try {
            const freshData = await wire.loadChildren(item.id, item.level);
            if (freshData) {
                setItems(freshData.items || []);
                setParentData(freshData.parentData || null);
                setCurrentParentId(freshData.currentParentId || null);
                setSelectedItem(null);
                setIsDrawMode(false);
                setZoomLevel(100); 
            }
        } catch (error) { console.error(error); } finally { setIsLoading(false); }
    }

    const handleGoBack = async () => {
        setIsLoading(true);
        try {
            const freshData = await wire.goBack();
            if (freshData) {
                setItems(freshData.items || []);
                setParentData(freshData.parentData || null);
                setCurrentParentId(freshData.currentParentId || null);
                setSelectedItem(null);
                setIsDrawMode(false);
                setZoomLevel(100); 
            }
        } catch (error) { console.error(error); } finally { setIsLoading(false); }
    }

    const handleAddItem = async () => {
        let currentLevel = 1; 
        let parentIdToSend = currentParentId;
        let nameToSend = null;

        if (currentParentId === null) {
            currentLevel = 0; parentIdToSend = null; nameToSend = `Floor Plan ${items.length + 1}`;
        } else if (String(currentParentId).startsWith('plan_')) {
            currentLevel = 1; parentIdToSend = null; 
        } else if (parentData) {
            currentLevel = parentData.level + 1;
        }

        setIsLoading(true);
        try {
            const freshData = await wire.addItem(selectedColor, parentIdToSend, currentLevel, nameToSend);
            if (freshData) setItems(freshData.items || []);
        } catch (error) { console.error(error); } finally { setIsLoading(false); }
    }

    // ==========================================
    // DRAG & RESIZE
    // ==========================================
    const handleDragStop = async (id, e, d) => {
        const newX = snapToGrid(d.x); const newY = snapToGrid(d.y);
        setItems(items.map(item => item.id === id ? { ...item, x: newX, y: newY } : item))
        await wire.updateItemPosition(id, newX, newY)
    }

    const handleResizeStop = async (id, e, direction, ref, delta, position) => {
        const newWidth = snapToGrid(parseInt(ref.style.width, 10));
        const newHeight = snapToGrid(parseInt(ref.style.height, 10));
        const newX = snapToGrid(position.x); const newY = snapToGrid(position.y);
        setItems(items.map(item => item.id === id ? { ...item, width: newWidth, height: newHeight, x: newX, y: newY } : item))
        await wire.updateItemSize(id, newWidth, newHeight, newX, newY)
    }

    // ==========================================
    // RENDER
    // ==========================================
    return (
        // PERBAIKAN: Menggunakan h-[calc(100vh-64px)] agar pas di bawah topbar (asumsi 64px)
        // Dan w-full agar tidak menabrak sidebar
        <div className="flex flex-col w-full h-[calc(100vh-64px)] bg-zinc-50 dark:bg-zinc-900 overflow-hidden relative">
            
            {isLoading && (
                <div className="absolute inset-0 bg-white/60 backdrop-blur-sm z-[999] flex items-center justify-center">
                    <div className="text-blue-600 font-bold text-lg animate-pulse">Memuat data...</div>
                </div>
            )}

            {/* HEADER */}
            <div className="flex justify-between items-center px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 shrink-0">
                <div className="flex items-center gap-3">
                    {(parentData || currentParentId !== null) && (
                        <button onClick={handleGoBack} className="p-2 bg-zinc-100 hover:bg-zinc-200 rounded-full transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-5 h-5 text-zinc-700">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    )}
                    <div>
                        <h1 className="text-xl font-bold text-zinc-800 dark:text-white">
                            {parentData ? parentData.label : (mingleData?.plan ? mingleData.plan.name : 'Pilih Floor Plan')}
                        </h1>
                        <p className="text-sm text-zinc-500">
                            {parentData ? `Level ${parentData.level + 1}` : (currentParentId ? 'Level 1 (Area)' : 'Daftar Lantai')}
                        </p>
                    </div>
                </div>

                {/* TOOLBAR */}
                <div className="flex items-center gap-3">
                    
                    {/* ZOOM CONTROL */}
                    <div className="flex items-center bg-zinc-100 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 shadow-sm overflow-hidden">
                        <button onClick={handleZoomOut} className="px-3 py-2 hover:bg-zinc-200 dark:hover:bg-zinc-700 font-bold text-zinc-600 dark:text-zinc-300">
                            -
                        </button>
                        <button onClick={resetZoom} className="px-2 py-2 text-xs font-semibold text-zinc-600 dark:text-zinc-300 min-w-[50px]">
                            {zoomLevel}%
                        </button>
                        <button onClick={handleZoomIn} className="px-3 py-2 hover:bg-zinc-200 dark:hover:bg-zinc-700 font-bold text-zinc-600 dark:text-zinc-300">
                            +
                        </button>
                    </div>

                    <div className="flex items-center gap-1 bg-zinc-50 p-1 rounded-lg border border-zinc-200 shadow-sm">
                        {COLORS.map(color => (
                            <button key={color.hex} onClick={() => setSelectedColor(color.hex)}
                                className={`w-6 h-6 rounded-full border-2 transition-transform hover:scale-110 ${selectedColor === color.hex ? 'border-zinc-800 scale-110' : 'border-transparent'}`}
                                style={{ backgroundColor: color.hex }} />
                        ))}
                    </div>

                    <button 
                        onClick={() => { setIsDrawMode(!isDrawMode); setDrawnPoints([]); }}
                        className={`px-4 py-2 rounded-lg text-sm font-semibold transition-colors ${isDrawMode ? 'bg-red-600 text-white' : 'bg-zinc-200 text-zinc-700'}`}
                    >
                        {isDrawMode ? 'Batal' : '✏️ Gambar'}
                    </button>

                    <button onClick={handleAddItem} className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow-sm transition-colors">
                        + Tambah
                    </button>
                </div>
            </div>

            <div className="flex flex-1 overflow-hidden">
                
                {/* KANVAS AREA */}
                <div className="flex-1 overflow-auto bg-zinc-100 dark:bg-zinc-900 p-8 relative">
                    
                    {/* WRAPPER ZOOM */}
                    <div 
                        style={{ 
                            transform: `scale(${zoomLevel / 100})`, 
                            transformOrigin: 'top left',
                            width: '1000px', 
                            height: '800px',
                            transition: 'transform 0.2s ease-in-out'
                        }}
                        className="relative bg-white border border-zinc-300 rounded-xl overflow-hidden shadow-sm"
                    >
                        <div className="absolute inset-0 pointer-events-none" style={{ backgroundImage: 'radial-gradient(#cbd5e1 1px, transparent 1px)', backgroundSize: '20px 20px' }}></div>

                        {/* RENDER ITEMS */}
                        {items.map(item => {
                            const bgColor = item.config?.color || '#3b82f6';
                            const isFloorPlan = item.level === 0 || String(item.id).startsWith('plan_');
                            
                            // POLYGON
                            if (item.shape_type === 'polygon' && item.points) {
                                const parsedPoints = typeof item.points === 'string' ? JSON.parse(item.points) : item.points;
                                const pathD = getSmoothPath(parsedPoints, 8);
                                const labelX = item.config?.label_x ?? parsedPoints[0].x;
                                const labelY = item.config?.label_y ?? parsedPoints[0].y + 20;

                                return (
                                    <React.Fragment key={item.id}>
                                        <svg className="absolute inset-0 z-10 w-full h-full pointer-events-none">
                                            <path 
                                                d={pathD} 
                                                fill={bgColor} 
                                                stroke="white" 
                                                strokeWidth="4" 
                                                strokeLinejoin="round" 
                                                strokeLinecap="round"
                                                className="pointer-events-auto cursor-pointer hover:opacity-90"
                                                onClick={(e) => { e.stopPropagation(); setSelectedItem(item); }}
                                                onDoubleClick={(e) => { e.stopPropagation(); handleNavigate(item); }}
                                            />
                                        </svg>

                                        <Rnd
                                            size={{ width: 150, height: 40 }}
                                            position={{ x: labelX, y: labelY }}
                                            onDragStop={async (e, d) => {
                                                const newX = snapToGrid(d.x); const newY = snapToGrid(d.y);
                                                setItems(items.map(i => i.id === item.id ? { ...i, config: { ...i.config, label_x: newX, label_y: newY } } : i));
                                                await wire.updateItemLabelPosition(item.id, newX, newY);
                                            }}
                                            enableResizing={true} 
                                            bounds="parent"
                                            dragGrid={[20, 20]} resizeGrid={[20, 20]}
                                            className="z-20 flex items-center justify-center cursor-move pointer-events-auto"
                                            onClick={(e) => { e.stopPropagation(); setSelectedItem(item); }}
                                        >
                                            <span className="drop-shadow-md text-center text-white text-sm font-bold truncate px-1 select-none">
                                                {item.label}
                                            </span>
                                        </Rnd>
                                    </React.Fragment>
                                );
                            }

                            // KOTAK BIASA
                            return (
                                <Rnd
                                    key={item.id}
                                    size={{ width: item.width, height: item.height }}
                                    position={{ x: item.x, y: item.y }}
                                    onDragStop={(e, d) => handleDragStop(item.id, e, d)}
                                    onResizeStop={(e, dir, ref, delta, pos) => handleResizeStop(item.id, e, dir, ref, delta, pos)}
                                    onClick={(e) => { e.stopPropagation(); setSelectedItem(item); }}
                                    onDoubleClick={(e) => { e.stopPropagation(); handleNavigate(item); }}
                                    bounds="parent"
                                    dragGrid={[20, 20]} resizeGrid={[20, 20]}
                                    style={{ backgroundColor: bgColor }}
                                    className={`group relative border-2 rounded-lg shadow-lg cursor-pointer hover:opacity-90 transition-colors ${
                                        selectedItem?.id === item.id ? 'border-zinc-800 ring-4 ring-blue-500/30 z-50' : 'border-white/20'
                                    }`}
                                >
                                    <div className="absolute inset-0 flex items-center justify-center p-2 pointer-events-none">
                                        <span className="drop-shadow-md text-center text-white text-sm font-bold w-full truncate px-1">{item.label}</span>
                                    </div>
                                    {item.level < 4 && (
                                        <div className="absolute bottom-1 left-0 right-0 flex justify-center pointer-events-none">
                                            <span className="text-[9px] text-white opacity-0 group-hover:opacity-80 transition-opacity">
                                                {isFloorPlan ? 'Double Click untuk Masuk' : 'Double Click'}
                                            </span>
                                        </div>
                                    )}
                                </Rnd>
                            )
                        })}

                        {/* LAYER GAMBAR */}
                        {isDrawMode && (
                            <svg 
                                className="absolute inset-0 z-[100] cursor-crosshair w-full h-full" 
                                onClick={handleCanvasClick}
                                onMouseMove={handleCanvasMouseMove}
                            >
                                {drawnPoints.length > 1 && (
                                    <path
                                        d={getSmoothPath([...drawnPoints, mousePos], 8)}
                                        fill={selectedColor}
                                        opacity="0.3"
                                        stroke={selectedColor}
                                        strokeWidth="4"
                                        strokeLinejoin="round"
                                    />
                                )}
                                {drawnPoints.length > 0 && (
                                    <line
                                        x1={drawnPoints[drawnPoints.length - 1].x} y1={drawnPoints[drawnPoints.length - 1].y}
                                        x2={mousePos.x} y2={mousePos.y}
                                        stroke={selectedColor} strokeWidth="2" strokeDasharray="5,5"
                                    />
                                )}
                                {drawnPoints.map((p, i) => (
                                    <circle key={i} cx={p.x} cy={p.y} r="5" fill="white" stroke={selectedColor} strokeWidth="3" />
                                ))}
                                <circle cx={mousePos.x} cy={mousePos.y} r="6" fill={selectedColor} opacity="0.6" />
                            </svg>
                        )}
                    </div>
                </div>

                {/* PANEL KANAN */}
                <div className="w-80 bg-white dark:bg-zinc-800 border-l border-zinc-200 dark:border-zinc-700 p-4 overflow-y-auto shrink-0">
                    <h2 className="text-lg font-bold text-zinc-800 dark:text-white mb-4">Properties</h2>
                    
                    {selectedItem ? (
                        <div className="space-y-4">
                            <div>
                                <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">Label</label>
                                <input 
                                    type="text" 
                                    value={selectedItem.label}
                                    onChange={(e) => {
                                        const val = e.target.value;
                                        setSelectedItem({...selectedItem, label: val});
                                        setItems(items.map(i => i.id === selectedItem.id ? {...i, label: val} : i));
                                        wire.updateItemLabel(selectedItem.id, val);
                                    }}
                                    className="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 rounded p-2 text-zinc-800 dark:text-white"
                                />
                            </div>

                            {!String(selectedItem.id).startsWith('plan_') && (
                                <>
                                    <div>
                                        <label className="block text-sm font-semibold text-zinc-700 dark:text-zinc-300 mb-1">URL / Link</label>
                                        <input 
                                            type="url" 
                                            placeholder="https://example.com"
                                            value={selectedItem.config?.link || ''}
                                            onChange={(e) => {
                                                const val = e.target.value;
                                                const newConfig = { ...selectedItem.config, link: val };
                                                setSelectedItem({...selectedItem, config: newConfig});
                                                setItems(items.map(i => i.id === selectedItem.id ? {...i, config: newConfig} : i));
                                                wire.updateItemLink(selectedItem.id, val);
                                            }}
                                            className="w-full bg-zinc-50 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-600 rounded p-2 text-zinc-800 dark:text-white"
                                        />
                                    </div>
                                </>
                            )}

                            {selectedItem.level < 4 && (
                                <button 
                                    onClick={() => handleNavigate(selectedItem)}
                                    className="w-full mt-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors"
                                >
                                    {String(selectedItem.id).startsWith('plan_') ? 'Masuk ke Lantai' : `Masuk ke ${selectedItem.label}`}
                                </button>
                            )}
                        </div>
                    ) : (
                        <div className="text-center py-10 text-zinc-500 text-sm">
                            Klik kotak/shape untuk melihat detail.<br/>
                            <strong>Double-click</strong> untuk masuk.
                        </div>
                    )}
                </div>
            </div>
        </div>
    )
}