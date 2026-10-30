import React, { useEffect } from 'react'
import { useEditor, EditorContent } from '@tiptap/react'
import StarterKit from '@tiptap/starter-kit'
import Placeholder from '@tiptap/extension-placeholder'

export default function RichTextEditor({ value, onChange, placeholder = 'Type here...' }) {
    const editor = useEditor({
        extensions: [
            StarterKit,
            Placeholder.configure({ placeholder }),
        ],
        content: value || '',
        onUpdate: ({ editor }) => onChange(editor.getHTML()),
        editorProps: {
            attributes: {
                class: 'max-w-none focus:outline-none min-h-[100px] px-3 py-2 text-sm text-zinc-800 dark:text-zinc-100',
            },
        },
    })

    useEffect(() => {
        if (editor && value !== editor.getHTML()) {
            editor.commands.setContent(value || '', false)
        }
    }, [value, editor])

    if (!editor) return null

    const ToolbarButton = ({ onClick, active, title, children }) => (
        <button
            type="button"
            onClick={onClick}
            title={title}
            className={`px-2 py-1 rounded text-xs font-semibold transition-colors ${
                active
                    ? 'bg-blue-600 text-white'
                    : 'text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200 dark:hover:bg-zinc-700'
            }`}
        >
            {children}
        </button>
    )

    return (
        <div className="rounded-lg border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 overflow-hidden focus-within:ring-2 focus-within:ring-blue-500">
            <div className="flex flex-wrap items-center gap-1 px-2 py-1.5 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/60">
                <ToolbarButton onClick={() => editor.chain().focus().toggleBold().run()} active={editor.isActive('bold')} title="Bold">B</ToolbarButton>
                <ToolbarButton onClick={() => editor.chain().focus().toggleItalic().run()} active={editor.isActive('italic')} title="Italic"><span className="italic">I</span></ToolbarButton>
                <ToolbarButton onClick={() => editor.chain().focus().toggleStrike().run()} active={editor.isActive('strike')} title="Strike"><span className="line-through">S</span></ToolbarButton>
                <div className="w-px h-4 bg-zinc-300 dark:bg-zinc-600 mx-1" />
                <ToolbarButton onClick={() => editor.chain().focus().toggleBulletList().run()} active={editor.isActive('bulletList')} title="Bullet List">• List</ToolbarButton>
                <ToolbarButton onClick={() => editor.chain().focus().toggleOrderedList().run()} active={editor.isActive('orderedList')} title="Numbered List">1. List</ToolbarButton>
                <div className="w-px h-4 bg-zinc-300 dark:bg-zinc-600 mx-1" />
                <ToolbarButton onClick={() => editor.chain().focus().clearNodes().unsetAllMarks().run()} title="Clear formatting">Clear</ToolbarButton>
            </div>
            <EditorContent editor={editor} />
        </div>
    )
}