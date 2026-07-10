import { Button } from '@/components/ui/button';
import positions from '@/routes/admin/sdm/positions';
import { Link, router } from '@inertiajs/react';
import axios from 'axios';
import {
    Briefcase,
    EditIcon,
    EyeIcon,
    EyeOffIcon,
    GripVertical,
    Plus,
    RefreshCw,
    Save,
    UserCheck,
} from 'lucide-react';
import { useCallback, useEffect, useState } from 'react';

// Import core & sortable komponen dari @dnd-kit
import { Badge } from '@/components/ui/badge';
import { ButtonGroup } from '@/components/ui/button-group';
import {
    closestCenter,
    DndContext,
    DragEndEvent,
    DragOverlay,
    DragStartEvent,
    PointerSensor,
    useSensor,
    useSensors,
} from '@dnd-kit/core';
import {
    SortableContext,
    useSortable,
    verticalListSortingStrategy,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';

// ==========================================
// 1. KOMPONEN CHILD: SortableJabatanNode
// ==========================================
interface NodeProps {
    fetchData: any;
    jabatan: any;
    depth: number; // Melacak tingkat kedalaman hierarki (0 = Root, 1 = Manager, dst)
}

function SortableJabatanNode({ jabatan, depth, fetchData }: NodeProps) {
    const {
        attributes,
        listeners,
        setNodeRef,
        transform,
        transition,
        isDragging,
    } = useSortable({ id: String(jabatan.id) });

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
        // Memberikan efek menjorok ke kanan berdasarkan kedalaman level jabatan
        paddingLeft: `${depth * 28}px`,
    };

    const handleUpdateStatus = (id: number, fetchData: any) => {
        router.put(
            positions.status(id).url,
            {},
            {
                preserveScroll: true,
                onSuccess: () => {
                    // setRefreshData(true);
                    router.reload({ only: ['flash'] });
                    fetchData();
                },
            },
        );
    };

    return (
        <div
            ref={setNodeRef}
            style={style}
            className={`relative mt-2 flex flex-col ${isDragging ? 'opacity-40' : ''}`}
        >
            <div
                className={`group relative flex items-center gap-3 rounded-md border bg-card px-3 py-2 transition-all hover:border-primary/40 ${
                    isDragging ? 'z-50 border-primary bg-accent shadow-md' : ''
                }`}
            >
                {/* Garis bantu siku-siku visual untuk anak jabatan */}
                {depth > 0 && (
                    <div
                        className="absolute top-4 border-b border-dashed border-muted-foreground/30"
                        style={{
                            left: `${(depth - 1) * 28 + 14}px`,
                            width: '14px',
                        }}
                    />
                )}

                {/* Drag Handle menggunakan listeners dnd-kit */}
                <div
                    {...attributes}
                    {...listeners}
                    className="cursor-grab p-1 text-muted-foreground hover:text-foreground active:cursor-grabbing"
                >
                    <GripVertical className="h-3.5 w-3.5" />
                </div>

                <Briefcase className="h-4 w-4 text-primary/80" />
                <div className="flex flex-col">
                    <span className="text-sm font-medium text-foreground/90">
                        {jabatan.name}
                    </span>
                </div>
                <div className="ml-auto flex items-center gap-4">
                    {jabatan.children?.length > 0 && (
                        <span className="rounded-full border bg-background px-2 py-0.5 text-xs font-normal text-muted-foreground">
                            {jabatan.children?.length || 0} Position
                        </span>
                    )}
                    <div className="flex items-center gap-1">
                        <Badge
                            variant={jabatan.status ? 'default' : 'destructive'}
                            className="ml-auto"
                        >
                            {jabatan.status ? 'Aktif' : 'Tidak Aktif'}
                        </Badge>
                        <Button
                            variant="ghost"
                            size="sm"
                            onClick={() =>
                                handleUpdateStatus(jabatan.id, fetchData)
                            }
                        >
                            {jabatan.status ? (
                                <EyeOffIcon className="size-4" />
                            ) : (
                                <EyeIcon className="size-4" />
                            )}
                        </Button>
                        <Button variant="ghost" size="sm" asChild>
                            <Link href={positions.edit(jabatan.id)}>
                                <EditIcon className="size-4" />
                            </Link>
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}

// ==========================================
// 2. KOMPONEN UTAMA: ListPage
// ==========================================
export default function ListPage() {
    const [refreshData, setRefreshData] = useState(false);
    const [rawList, setRawList] = useState<any[]>([]);
    const [treeData, setTreeData] = useState<any[]>([]);
    const [loading, setLoading] = useState(false);
    const [activeId, setActiveId] = useState<string | null>(null);

    // Sensor dnd-kit agar klik biasa tidak memicu drag tidak sengaja
    const sensors = useSensors(
        useSensor(PointerSensor, {
            activationConstraint: {
                distance: 8,
            },
        }),
    );

    // HELPER A: Mengubah Data Flat Array dari API Menjadi Struktur Pohon (Tree/Nested)
    const buildTree = (items: any[], parentId: number | null = null): any[] => {
        return items
            .filter((item) => item.parent_id === parentId)
            .map((item) => ({
                ...item,
                children: buildTree(items, item.id),
            }))
            .sort((a, b) => (a.sort || 0) - (b.sort || 0));
    };

    // HELPER B: Meratakan Struktur Pohon Kembali Menjadi Array Datar Berurutan untuk Dnd Context
    const flattenTree = (nodes: any[], depth = 0): any[] => {
        let result: any[] = [];
        nodes.forEach((node) => {
            result.push({ ...node, depth });
            if (node.children && node.children.length > 0) {
                result.push(...flattenTree(node.children, depth + 1));
            }
        });
        return result;
    };

    // FETCH DATA DARI BACKEND
    const fetchData = useCallback(async () => {
        try {
            const response = await axios.get(positions.data().url);
            setRawList(response.data);
            setTreeData(buildTree(response.data, null));
        } catch (error) {
            console.error('Gagal memuat data jabatan:', error);
        }
    }, []);

    useEffect(() => {
        fetchData();
    }, [refreshData, fetchData]);

    // DRAG START
    const handleDragStart = (event: DragStartEvent) => {
        setActiveId(String(event.active.id));
    };

    // DRAG END (Pengganti onDragEnd lama)
    const handleDragEnd = (event: DragEndEvent) => {
        const { active, over } = event;
        setActiveId(null);

        if (!over || active.id === over.id) return;

        const draggedId = parseInt(String(active.id));
        const overId = parseInt(String(over.id));

        const draggedItem = rawList.find((item) => item.id === draggedId);
        const overItem = rawList.find((item) => item.id === overId);

        if (!draggedItem || !overItem) return;

        // PROTEKSI: Mencegah Atasan (Parent) dimasukkan ke dalam anak buahnya sendiri (Circular reference)
        const isDescendant = (parentId: number, childId: number): boolean => {
            const child = rawList.find((i) => i.id === childId);
            if (!child || !child.parent_id) return false;
            if (child.parent_id === parentId) return true;
            return isDescendant(parentId, child.parent_id);
        };

        if (isDescendant(draggedId, overItem.id)) {
            console.warn(
                'Tidak bisa memindahkan atasan ke dalam struktur bawahannya.',
            );
            return;
        }

        // Tentukan Target Parent Baru (Ditempatkan di bawah item yang di-over)
        const targetParentId = overItem.id;

        // Perbarui data flat list
        let updatedRawList = rawList.map((item) => {
            if (item.id === draggedId) {
                return { ...item, parent_id: targetParentId };
            }
            return { ...item };
        });

        // RE-SORTING: Normalisasi urutan indeks 'sort' agar berurutan 1, 2, 3... per kelompok parent
        const groupedByParent: { [key: string]: any[] } = {};
        updatedRawList.forEach((item) => {
            const pKey =
                item.parent_id === null ? 'root' : String(item.parent_id);
            if (!groupedByParent[pKey]) groupedByParent[pKey] = [];
            groupedByParent[pKey].push(item);
        });

        const finalItems: any[] = [];
        Object.keys(groupedByParent).forEach((pKey) => {
            const group = groupedByParent[pKey];

            group.sort((a, b) => {
                if (a.id === draggedId) return 1; // Taruh item yang baru di-drop di bagian paling bawah kelompok
                if (b.id === draggedId) return -1;
                return (a.sort || 0) - (b.sort || 0);
            });

            group.forEach((item, index) => {
                item.sort = index + 1;
                finalItems.push(item);
            });
        });

        setRawList(finalItems);
        setTreeData(buildTree(finalItems, null));
    };

    // SIMPAN PERUBAHAN STRUKTUR KE LARAVEL
    const handleSaveOrder = async () => {
        setLoading(true);

        // Membersihkan payload dari string id kontainer seperti 'j0' dll.
        const payload = rawList.map((item) => {
            let cleanParentId = item.parent_id;
            if (
                cleanParentId === 'j0' ||
                cleanParentId === 0 ||
                !cleanParentId
            ) {
                cleanParentId = null;
            }

            return {
                id: parseInt(String(item.id)),
                parent_id: cleanParentId,
                sort: parseInt(String(item.sort)),
            };
        });

        router.post(
            positions.reorder().url,
            { data: payload },
            {
                preserveScroll: true,
                onSuccess: () => {
                    setRefreshData((prev) => !prev);
                },
                onError: (errors) => {
                    console.error(
                        'Gagal menyimpan struktur ke backend. Detail:',
                        errors,
                    );
                },
                onFinish: () => {
                    setLoading(false);
                    router.reload({ only: ['flash'] });
                },
            },
        );
    };

    // Dapatkan data item yang sedang aktif di-drag untuk render visual overlay
    const flattenedItems = flattenTree(treeData);
    const activeItem = rawList.find((i) => String(i.id) === activeId);

    return (
        <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            {/* Header / Top Control Bar */}
            <div className="flex flex-col items-start justify-between gap-4 border-b pb-4 sm:flex-row sm:items-center">
                <div>
                    <h1 className="flex items-center gap-2 text-xl font-semibold">
                        <UserCheck className="h-5 w-5 text-primary" />
                        Manajemen Jabatan
                    </h1>
                    <p className="mt-0.5 text-xs text-muted-foreground">
                        Tarik jabatan menggunakan handle grid untuk mengubah
                        urutan ataupun memindahkannya ke bawah atasan lain
                        secara lintas-level.
                    </p>
                </div>
                <ButtonGroup>
                    <Button
                        onClick={() => router.visit(positions.create().url)}
                    >
                        <Plus className="size-4" />
                        Create
                    </Button>
                    <Button
                        onClick={handleSaveOrder}
                        disabled={loading}
                        className="gap-2 shadow-sm"
                    >
                        {loading ? (
                            <RefreshCw className="size-4 animate-spin" />
                        ) : (
                            <Save className="size-4" />
                        )}
                        Save Order
                    </Button>
                </ButtonGroup>
            </div>

            {/* Tree Workspace */}
            <div className="relative min-h-screen flex-1 overflow-auto rounded-xl border border-sidebar-border/70 bg-card/20 p-4 md:p-8">
                <DndContext
                    sensors={sensors}
                    collisionDetection={closestCenter}
                    onDragStart={handleDragStart}
                    onDragEnd={handleDragEnd}
                >
                    {/* SortableContext diisi array datar ID yang sudah diurutkan mengikuti struktur pohon */}
                    <SortableContext
                        items={flattenedItems.map((item) => String(item.id))}
                        strategy={verticalListSortingStrategy}
                    >
                        <div className="flex flex-col gap-2 rounded-lg">
                            {flattenedItems.length === 0 ? (
                                <div className="py-10 text-center text-muted-foreground">
                                    Data Jabatan Kosong...
                                </div>
                            ) : (
                                flattenedItems.map((jabatan) => (
                                    <SortableJabatanNode
                                        key={jabatan.id}
                                        jabatan={jabatan}
                                        depth={jabatan.depth}
                                        fetchData={fetchData}
                                    />
                                ))
                            )}
                        </div>
                    </SortableContext>

                    {/* Drag Overlay: Membuat salinan visual bayangan saat proses drag-and-drop */}
                    <DragOverlay>
                        {activeId && activeItem ? (
                            <div className="flex cursor-grabbing items-center gap-3 rounded-md border border-primary bg-accent px-3 py-2 opacity-80 shadow-md">
                                <GripVertical className="h-3.5 w-3.5 text-muted-foreground" />
                                <Briefcase className="h-4 w-4 text-primary/80" />
                                <span className="text-sm font-medium text-foreground/90">
                                    {activeItem.name}
                                </span>
                            </div>
                        ) : null}
                    </DragOverlay>
                </DndContext>
            </div>
        </div>
    );
}
