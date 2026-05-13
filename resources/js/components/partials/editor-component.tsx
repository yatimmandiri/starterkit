import { cn } from '@/lib/utils';
import { Color } from '@tiptap/extension-color';
import Highlight from '@tiptap/extension-highlight';
import Placeholder from '@tiptap/extension-placeholder';
import Subscript from '@tiptap/extension-subscript';
import Superscript from '@tiptap/extension-superscript';
import TextAlign from '@tiptap/extension-text-align';
import { TextStyle } from '@tiptap/extension-text-style';
import Typography from '@tiptap/extension-typography';
import { EditorContent, type Extension, useEditor } from '@tiptap/react';
import StarterKit from '@tiptap/starter-kit';
import { InfoIcon } from 'lucide-react';
import { useEffect, useRef } from 'react';
import { Field, FieldDescription, FieldLabel } from '../ui/field';
import { ImageExtension } from '../ui/tiptap/extensions/image';
import { ImagePlaceholder } from '../ui/tiptap/extensions/image-placeholder';
import SearchAndReplace from '../ui/tiptap/extensions/search-and-replace';
import { EditorToolbar } from '../ui/tiptap/toolbars/editor-toolbar';

const variants: any = {
    default:
        'border-zinc-300 focus:border-blue-500 focus:ring-blue-500 focus-visible:ring-blue-500 focus-visible:shadow-blue-500/30',
    info: 'border-sky-300 focus:border-sky-500 focus:ring-sky-500 focus-visible:ring-sky-500 focus-visible:shadow-sky-500/30',
    success:
        'border-emerald-300 focus:border-emerald-500 focus:ring-emerald-500 focus-visible:ring-emerald-500 focus-visible:shadow-emerald-500/30',
    warning:
        'border-amber-300 focus:border-amber-500 focus:ring-amber-500 focus-visible:ring-amber-500 focus-visible:shadow-amber-500/30',
    danger: 'border-red-300 focus:border-red-500 focus:ring-red-500 focus-visible:ring-red-500 focus-visible:shadow-red-500/30',
};

interface EditorProps {
    label?: string;
    className?: string;
    value: string;
    errors?: any;
    helperText?: string;
    color?: 'default' | 'info' | 'success' | 'warning' | 'danger';
    handleOnChange: (value: string) => void;
    [key: string]: any;
}

export const EditorComponent = ({
    label,
    className,
    value = '',
    color = 'default',
    errors,
    helperText,
    handleOnChange,
}: EditorProps) => {
    const extensions = [
        StarterKit.configure({
            orderedList: {
                HTMLAttributes: {
                    class: 'list-decimal',
                },
            },
            bulletList: {
                HTMLAttributes: {
                    class: 'list-disc',
                },
            },
            heading: {
                levels: [1, 2, 3, 4, 5, 6],
            },
        }),
        Placeholder.configure({
            emptyNodeClass: 'is-editor-empty',
            placeholder: ({ node }) => {
                switch (node.type.name) {
                    case 'heading':
                        return `Heading ${node.attrs.level}`;
                    case 'detailsSummary':
                        return 'Section title';
                    case 'codeBlock':
                        // never show the placeholder when editing code
                        return '';
                    default:
                        return "Write, type '/' for commands";
                }
            },
            includeChildren: false,
        }),
        TextAlign.configure({
            types: ['heading', 'paragraph'],
        }),
        TextStyle,
        Subscript,
        Superscript,
        Color,
        Highlight.configure({
            multicolor: true,
        }),
        ImageExtension,
        ImagePlaceholder,
        SearchAndReplace,
        Typography,
    ];

    const editor = useEditor({
        immediatelyRender: false,
        editable: true,
        extensions: extensions as Extension[],
        content: value || '',
        editorProps: {
            attributes: {
                class: 'max-w-full focus:outline-none',
            },
        },
        onUpdate: ({ editor }) => {
            handleOnChange?.(editor.getHTML());
        },
    });

    const isInitialized = useRef(false);

    useEffect(() => {
        if (!editor) return;

        if (!isInitialized.current) {
            editor.commands.setContent(value || '', {
                emitUpdate: false,
            });

            isInitialized.current = true;
        }
    }, [editor]);

    if (!editor) return null;

    return (
        <Field data-invalid={errors}>
            {label && <FieldLabel htmlFor={label}>{label}</FieldLabel>}
            <div
                className={cn(
                    'relative max-h-[calc(100dvh-6rem)] w-full overflow-hidden overflow-y-scroll border bg-card pb-15 sm:pb-0',
                    className,
                    variants[color],
                )}
            >
                <EditorToolbar editor={editor} />
                <EditorContent
                    editor={editor}
                    className="min-h-150 w-full min-w-full cursor-text sm:p-6"
                />
            </div>
            {helperText && (
                <FieldDescription
                    className={cn(
                        'flex items-center space-x-2',
                        errors ? 'text-red-500' : 'text-yellow-500',
                    )}
                >
                    <InfoIcon
                        className={cn(
                            'h-4 w-4',
                            errors ? 'text-red-500' : 'text-yellow-500',
                        )}
                    />
                    <span>{helperText}</span>
                </FieldDescription>
            )}
        </Field>
    );
};
