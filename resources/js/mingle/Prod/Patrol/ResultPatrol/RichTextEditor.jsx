import React, { useRef, useEffect, useState } from 'react'

export default function RichTextEditor({ 
    value = '', 
    onChange, 
    placeholder = 'Tulis sesuatu...', 
    rows = 4,
    disabled = false 
}) {
    const editorRef = useRef(null)
    const savedRangeRef = useRef(null)
    const [isFocused, setIsFocused] = useState(false)

    // ============ SYNC VALUE DARI LUAR ============
    useEffect(() => {
        if (editorRef.current && editorRef.current.innerHTML !== value) {
            editorRef.current.innerHTML = value || ''
        }
    }, [value])

    // ============ SELECTION MANAGEMENT ============
    const saveSelection = () => {
        const sel = window.getSelection()
        if (sel && sel.rangeCount > 0) {
            const range = sel.getRangeAt(0)
            if (editorRef.current?.contains(range.commonAncestorContainer)) {
                savedRangeRef.current = range.cloneRange()
            }
        }
    }

    const restoreSelection = () => {
        if (!savedRangeRef.current) return false
        const sel = window.getSelection()
        sel.removeAllRanges()
        sel.addRange(savedRangeRef.current)
        return true
    }

    const handleInput = () => {
        if (!editorRef.current) return
        onChange?.(editorRef.current.innerHTML)
        saveSelection()
    }

    // ============ INLINE FORMAT (Bold/Italic/Underline/Strike) ============
    const execInline = (command) => {
        if (disabled) return
        editorRef.current?.focus()
        restoreSelection()
        document.execCommand(command, false, null)
        saveSelection()
        handleInput()
    }

    // ============ LIST TOGGLE (MANUAL DOM) ============
    const toggleList = (listType) => {
        if (disabled) return
        editorRef.current?.focus()
        restoreSelection()

        const sel = window.getSelection()
        if (!sel || sel.rangeCount === 0) return

        const range = sel.getRangeAt(0)
        
        let node = range.startContainer
        if (node.nodeType === Node.TEXT_NODE) node = node.parentNode

        // Cari apakah sedang di dalam <ul> atau <ol>
        let listParent = null
        let current = node
        while (current && current !== editorRef.current) {
            if (current.tagName === 'UL' || current.tagName === 'OL') {
                listParent = current
                break
            }
            current = current.parentNode
        }

        // Kalau sudah di list TIPE SAMA → toggle OFF (unwrap)
        if (listParent && listParent.tagName === (listType === 'ul' ? 'UL' : 'OL')) {
            unwrapList(listParent)
            handleInput()
            return
        }

        // Kalau di list TIPE BEDA → ganti tipe
        if (listParent) {
            const newList = document.createElement(listType)
            newList.innerHTML = listParent.innerHTML
            listParent.replaceWith(newList)
            handleInput()
            return
        }

        // Kalau TIDAK di list → bungkus block sekarang jadi list
        wrapInList(listType)
        handleInput()
    }

    const wrapInList = (listType) => {
        const sel = window.getSelection()
        if (!sel.rangeCount) return
        const range = sel.getRangeAt(0)

        let block = range.startContainer
        if (block.nodeType === Node.TEXT_NODE) block = block.parentNode
        while (block && block !== editorRef.current) {
            if (['P', 'DIV'].includes(block.tagName)) break
            block = block.parentNode
        }

        if (!block || block === editorRef.current) {
            const p = document.createElement('p')
            p.innerHTML = '<br>'
            if (editorRef.current.childNodes.length === 0) {
                editorRef.current.appendChild(p)
            }
            block = p
        }

        const list = document.createElement(listType)
        const li = document.createElement('li')
        li.innerHTML = block.innerHTML || '<br>'
        list.appendChild(li)
        block.replaceWith(list)

        const newRange = document.createRange()
        newRange.selectNodeContents(li)
        newRange.collapse(false)
        sel.removeAllRanges()
        sel.addRange(newRange)
        savedRangeRef.current = newRange.cloneRange()
    }

    const unwrapList = (listEl) => {
        const fragment = document.createDocumentFragment()
        Array.from(listEl.children).forEach(li => {
            const p = document.createElement('p')
            p.innerHTML = li.innerHTML || '<br>'
            fragment.appendChild(p)
        })
        listEl.replaceWith(fragment)
    }

    // ============ CLEAR FORMAT ============
    const clearFormat = () => {
        if (disabled) return
        editorRef.current?.focus()
        restoreSelection()
        document.execCommand('removeFormat', false, null)
        handleInput()
    }

    // ============ PASTE PLAIN TEXT ============
    const handlePaste = (e) => {
        e.preventDefault()
        const text = (e.clipboardData || window.clipboardData).getData('text/plain')
        document.execCommand('insertText', false, text)
        handleInput()
    }

    // ============ KEYBOARD: Enter di list ============
    const handleKeyDown = (e) => {
        if (e.key === 'Enter') {
            const sel = window.getSelection()
            if (!sel.rangeCount) return
            let node = sel.getRangeAt(0).startContainer
            if (node.nodeType === Node.TEXT_NODE) node = node.parentNode
            const li = node.closest?.('li')
            if (li && li.textContent.trim() === '') {
                e.preventDefault()
                const p = document.createElement('p')
                p.innerHTML = '<br>'
                const list = li.closest('ul, ol')
                list.after(p)
                li.remove()
                if (list.children.length === 0) list.remove()
                const range = document.createRange()
                range.selectNodeContents(p)
                range.collapse(false)
                sel.removeAllRanges()
                sel.addRange(range)
                handleInput()
            }
        }
    }

    const toolbarButtons = [
        { action: () => execInline('bold'),          icon: 'B', title: 'Bold',      className: 'font-bold' },
        { action: () => execInline('italic'),        icon: 'I', title: 'Italic',    className: 'italic' },
        { action: () => execInline('underline'),     icon: 'U', title: 'Underline', className: 'underline' },
        { action: () => execInline('strikeThrough'), icon: 'S', title: 'Strike',    className: 'line-through' },
    ]

    return (
        <div className={`border rounded-lg overflow-hidden bg-white dark:bg-zinc-800 transition-colors ${
            isFocused 
                ? 'ring-2 ring-blue-500 border-blue-400 dark:border-blue-500' 
                : 'border-zinc-300 dark:border-zinc-600'
        } ${disabled ? 'opacity-60 cursor-not-allowed' : ''}`}>
            
            {/* Toolbar */}
            <div className="flex items-center gap-0.5 px-2 py-1.5 bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700 flex-wrap">
                {toolbarButtons.map((btn, i) => (
                    <button
                        key={i}
                        type="button"
                        onMouseDown={(e) => e.preventDefault()}
                        onClick={btn.action}
                        title={btn.title}
                        disabled={disabled}
                        className={`w-7 h-7 flex items-center justify-center text-sm rounded text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 disabled:opacity-40 disabled:cursor-not-allowed transition-colors ${btn.className}`}
                    >
                        {btn.icon}
                    </button>
                ))}
                <div className="w-px h-5 bg-zinc-300 dark:bg-zinc-600 mx-1" />

                {/* Bullet List */}
                <button
                    type="button"
                    onMouseDown={(e) => e.preventDefault()}
                    onClick={() => toggleList('ul')}
                    title="Bullet List"
                    disabled={disabled}
                    className="w-7 h-7 flex items-center justify-center text-sm rounded text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 disabled:opacity-40 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                        <path fillRule="evenodd" d="M2.625 6.75a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875 0A.75.75 0 0 1 8.25 6h12a.75.75 0 0 1 0 1.5h-12a.75.75 0 0 1-.75-.75ZM2.625 12a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0ZM7.5 12a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5h-12A.75.75 0 0 1 7.5 12Zm-4.875 5.25a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Zm4.875 0a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5h-12a.75.75 0 0 1-.75-.75Z" clipRule="evenodd" />
                    </svg>
                </button>

                {/* Numbered List */}
                <button
                    type="button"
                    onMouseDown={(e) => e.preventDefault()}
                    onClick={() => toggleList('ol')}
                    title="Numbered List"
                    disabled={disabled}
                    className="w-7 h-7 flex items-center justify-center text-sm rounded text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 disabled:opacity-40 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" className="w-4 h-4">
                        <path fillRule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h1.5a.75.75 0 0 1 .75.75V10.5a.75.75 0 0 1-1.5 0V7.5h-.75a.75.75 0 0 1-.75-.75Zm5.25 0A.75.75 0 0 1 9 6h12a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75Zm-5.25 6a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 .638 1.146l-1.49 2.104h1.127a.75.75 0 0 1 0 1.5h-2.25a.75.75 0 0 1-.638-1.146l1.49-2.104H3.75A.75.75 0 0 1 3 12.75Zm6.75 0a.75.75 0 0 1 .75-.75h12a.75.75 0 0 1 0 1.5H9a.75.75 0 0 1-.75-.75ZM3 18.75a.75.75 0 0 1 .75-.75h2.25a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clipRule="evenodd" />
                    </svg>
                </button>

                <div className="w-px h-5 bg-zinc-300 dark:bg-zinc-600 mx-1" />

                {/* Clear Formatting */}
                <button
                    type="button"
                    onMouseDown={(e) => e.preventDefault()}
                    onClick={clearFormat}
                    title="Clear Formatting"
                    disabled={disabled}
                    className="w-7 h-7 flex items-center justify-center text-sm rounded text-zinc-700 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700 disabled:opacity-40 transition-colors"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" className="w-4 h-4">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {/* Editor Area */}
            <div className="relative bg-white dark:bg-zinc-800">
                {!value && !isFocused && (
                    <div className="absolute inset-0 px-3 py-2 text-sm text-zinc-400 dark:text-zinc-500 pointer-events-none">
                        {placeholder}
                    </div>
                )}
                <div
                    ref={editorRef}
                    contentEditable={!disabled}
                    onInput={handleInput}
                    onPaste={handlePaste}
                    onKeyDown={handleKeyDown}
                    onFocus={() => { setIsFocused(true); saveSelection() }}
                    onBlur={() => setIsFocused(false)}
                    onKeyUp={saveSelection}
                    onMouseUp={saveSelection}
                    className="rte-editor px-3 py-2 text-sm outline-none overflow-y-auto text-zinc-800 dark:text-zinc-100 bg-white dark:bg-zinc-800"
                    style={{ minHeight: `${rows * 1.5}rem`, maxHeight: `${rows * 2.5}rem` }}
                />
            </div>
        </div>
    )
}