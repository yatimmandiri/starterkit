import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { ButtonGroup } from '@/components/ui/button-group';
import offices from '@/routes/admin/sdm/offices';
import {
    DragDropContext,
    Draggable,
    Droppable,
    DropResult,
} from '@hello-pangea/dnd';
import { Link, router } from '@inertiajs/react';
import axios from 'axios';
import {
    Building2,
    ChevronDown,
    EditIcon,
    EyeIcon,
    EyeOffIcon,
    GitCommit,
    GripVertical,
    MapPin,
    Plus,
    RefreshCw,
    Save,
} from 'lucide-react';
import { useCallback, useEffect, useState } from 'react';

export default function ListPage() {
    const [refreshData, setRefreshData] = useState(false);
    const [data, setData] = useState<any[]>([]);
    const [loading, setLoading] = useState(false);

    // 1. Fetch Data dari API
    const fetchData = useCallback(() => {
        axios
            .get(offices.data().url)
            .then((response) => {
                setData(response.data);
            })
            .catch((error) => {
                console.error('Error fetching data:', error);
            });
    }, []);

    useEffect(() => {
        fetchData();
    }, [refreshData, fetchData]);

    // 2. Handle Reorder saat drag selesai
    const onDragEnd = (result: DropResult) => {
        const { source, destination } = result;

        // Jika di-drop di luar area droppable yang sah
        if (!destination) return;

        // Jika posisi dan tempatnya sama sekali tidak berubah
        if (
            source.droppableId === destination.droppableId &&
            source.index === destination.index
        )
            return;

        const sourceRegionalId = parseInt(source.droppableId);
        const destRegionalId = parseInt(destination.droppableId);

        const updatedData = [...data];

        // Cari indeks regional asal dan tujuan di dalam state utama
        const sourceRegIndex = updatedData.findIndex(
            (item) => item.id === sourceRegionalId,
        );
        const destRegIndex = updatedData.findIndex(
            (item) => item.id === destRegionalId,
        );

        if (sourceRegIndex === -1 || destRegIndex === -1) return;

        // Salin array children masing-masing agar tidak mutate state secara langsung
        const sourceChildren = [...updatedData[sourceRegIndex].children];

        // Kasus 1: Pindah urutan di DALAM Regional yang SAMA
        if (sourceRegionalId === destRegionalId) {
            const [removed] = sourceChildren.splice(source.index, 1);
            sourceChildren.splice(destination.index, 0, removed);

            updatedData[sourceRegIndex].children = sourceChildren;
        }
        // Kasus 2: Pindah ke BEDA Regional (Beda parent_id)
        else {
            const destChildren = [...updatedData[destRegIndex].children];

            // 1. Ambil cabang dari regional asal
            const [movedBranch] = sourceChildren.splice(source.index, 1);

            // 2. Ubah parent_id cabang tersebut secara dinamis ke ID regional tujuan
            const updatedBranch = {
                ...movedBranch,
                parent_id: destRegionalId,
            };

            // 3. Masukkan cabang ke dalam list regional tujuan sesuai indeks drop-nya
            destChildren.splice(destination.index, 0, updatedBranch);

            // 4. Masukkan kembali ke data utama
            updatedData[sourceRegIndex].children = sourceChildren;
            updatedData[destRegIndex].children = destChildren;
        }

        // Update state untuk merubah UI secara instan (Optimistic UI)
        setData(updatedData);
    };

    // 3. Simpan Urutan ke Laravel
    const handleSaveOrder = async () => {
        setLoading(true);
        const regionalData = data.filter((item) => item.parent_id === 1);

        // Menyusun struktur data baru yang siap disimpan ke database
        const payload = regionalData.map((regional) => ({
            regional_id: regional.id,
            branches: regional.children.map((branch: any, index: number) => ({
                id: branch.id,
                parent_id: regional.id, // Menyertakan parent_id terbaru hasil perpindahan drag
                sort: index + 1, // Mengatur ulang urutan baru dari 1
            })),
        }));

        router.post(
            offices.reorder().url,
            {
                data: payload,
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    setRefreshData((prev) => !prev);
                },
                onError: () => {
                    console.log('Gagal mengubah urutan office');
                },
                onFinish: () => {
                    setLoading(false);
                    router.reload({ only: ['flash'] });
                },
            },
        );
    };

    const handleUpdateStatus = (id: number) => {
        router.put(
            offices.status(id).url,
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

    // 4. Render TreeView Structure
    const renderTreeView = () => {
        // Ambil data Kantor Pusat (Level 1)
        const pusat = data.find((item) => item.id === 1);
        // Ambil data Regional (Level 2)
        const regionalList = data.filter((item) => item.parent_id === 1);

        if (!pusat && regionalList.length === 0) {
            return (
                <div className="py-10 text-center text-muted-foreground">
                    Loading...
                </div>
            );
        }

        return (
            <div className="mx-auto flex w-full flex-col font-sans text-sm select-none">
                {/* LEVEL 1: KANTOR PUSAT */}
                <div className="mb-2 flex items-center gap-2 rounded-lg border border-primary/20 bg-primary/10 p-3 font-semibold text-primary shadow-sm">
                    <Building2 className="h-5 w-5" />
                    <span>{pusat?.name || 'Kantor Pusat'}</span>
                    <ChevronDown className="ml-auto h-4 w-4 text-primary/70" />
                </div>

                <DragDropContext onDragEnd={onDragEnd}>
                    <div className="mt-2 ml-4 flex flex-col gap-4 border-l-2 border-muted pl-4">
                        {/* LEVEL 2: REGIONAL */}
                        {regionalList.map((regional) => (
                            <div key={regional.id} className="flex flex-col">
                                <div className="mb-2 flex items-center gap-2 rounded-md border bg-muted/60 px-3 py-2 font-medium text-foreground/80 hover:bg-muted">
                                    <MapPin className="h-4 w-4 text-destructive/80" />
                                    <span>{regional.name}</span>
                                    <span className="ml-auto rounded-full border bg-background px-2 py-0.5 text-xs font-normal text-muted-foreground">
                                        {regional.children?.length || 0} Cabang
                                    </span>
                                    <div className="flex items-center">
                                        <Badge
                                            variant={
                                                regional.status
                                                    ? 'default'
                                                    : 'destructive'
                                            }
                                            className="ml-auto"
                                        >
                                            {regional.status
                                                ? 'Aktif'
                                                : 'Tidak Aktif'}
                                        </Badge>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            onClick={() =>
                                                handleUpdateStatus(regional.id)
                                            }
                                        >
                                            {regional.status ? (
                                                <EyeOffIcon className="size-4" />
                                            ) : (
                                                <EyeIcon className="size-4" />
                                            )}
                                        </Button>
                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            asChild
                                        >
                                            <Link
                                                href={offices.edit(regional.id)}
                                            >
                                                <EditIcon className="size-4" />
                                            </Link>
                                        </Button>
                                    </div>
                                </div>

                                {/* LEVEL 3: CABANG (DROPPABLE ZONE) */}
                                <Droppable
                                    droppableId={String(regional.id)}
                                    type="BRANCH"
                                >
                                    {(provided, snapshot) => (
                                        <div
                                            {...provided.droppableProps}
                                            ref={provided.innerRef}
                                            className={`ml-6 flex flex-col gap-1.5 rounded border-l border-dashed border-muted-foreground/30 py-1 pl-2 transition-colors ${
                                                snapshot.isDraggingOver
                                                    ? 'bg-accent/50'
                                                    : ''
                                            }`}
                                        >
                                            {regional.children?.length === 0 ? (
                                                <div className="py-1 pl-6 text-xs text-muted-foreground italic">
                                                    Belum ada cabang
                                                </div>
                                            ) : (
                                                regional.children?.map(
                                                    (
                                                        branch: any,
                                                        index: number,
                                                    ) => (
                                                        <Draggable
                                                            key={String(
                                                                branch.id,
                                                            )}
                                                            draggableId={String(
                                                                branch.id,
                                                            )}
                                                            index={index}
                                                        >
                                                            {(
                                                                provided,
                                                                snapshot,
                                                            ) => (
                                                                <div
                                                                    ref={
                                                                        provided.innerRef
                                                                    }
                                                                    {...provided.draggableProps}
                                                                    className={`group flex items-center justify-between gap-3 rounded-md border bg-background px-3 py-2 transition-all hover:border-primary/40 ${
                                                                        snapshot.isDragging
                                                                            ? 'border-primary bg-accent shadow-md'
                                                                            : ''
                                                                    }`}
                                                                >
                                                                    <div className="flex items-center gap-2">
                                                                        {/* Garis penghubung hiasan khas TreeView */}
                                                                        <div className="absolute -left-4 text-muted-foreground/40 transition-colors group-hover:text-primary/40">
                                                                            <GitCommit className="h-3 w-3" />
                                                                        </div>

                                                                        {/* Drag Handle */}
                                                                        <div
                                                                            {...provided.dragHandleProps}
                                                                            className="cursor-grab rounded p-1 text-muted-foreground hover:bg-muted hover:text-foreground active:cursor-grabbing"
                                                                        >
                                                                            <GripVertical className="h-3.5 w-3.5" />
                                                                        </div>

                                                                        <div className="flex flex-col">
                                                                            <span className="font-normal text-foreground/90">
                                                                                {
                                                                                    branch.name
                                                                                }
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div className="flex items-center">
                                                                        <Badge
                                                                            variant={
                                                                                branch.status
                                                                                    ? 'default'
                                                                                    : 'destructive'
                                                                            }
                                                                            className="ml-auto"
                                                                        >
                                                                            {branch.status
                                                                                ? 'Aktif'
                                                                                : 'Tidak Aktif'}
                                                                        </Badge>
                                                                        <Button
                                                                            variant="ghost"
                                                                            size="sm"
                                                                            onClick={() =>
                                                                                handleUpdateStatus(
                                                                                    branch.id,
                                                                                )
                                                                            }
                                                                        >
                                                                            {branch.status ? (
                                                                                <EyeOffIcon className="size-4" />
                                                                            ) : (
                                                                                <EyeIcon className="size-4" />
                                                                            )}
                                                                        </Button>
                                                                        <Button
                                                                            asChild
                                                                            variant="ghost"
                                                                            size="sm"
                                                                        >
                                                                            <Link
                                                                                href={
                                                                                    offices.edit(
                                                                                        branch.id,
                                                                                    )
                                                                                        .url
                                                                                }
                                                                            >
                                                                                <EditIcon className="size-4" />
                                                                            </Link>
                                                                        </Button>
                                                                    </div>
                                                                </div>
                                                            )}
                                                        </Draggable>
                                                    ),
                                                )
                                            )}
                                            {provided.placeholder}
                                        </div>
                                    )}
                                </Droppable>
                            </div>
                        ))}
                    </div>
                </DragDropContext>
            </div>
        );
    };

    return (
        <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            {/* Header Action */}
            <div className="flex flex-col items-start justify-between gap-4 border-b pb-4 sm:flex-row sm:items-center">
                <div className="flex flex-col gap-1">
                    <h1 className="flex items-center gap-2 text-xl font-semibold">
                        <Building2 className="h-5 w-5 text-primary" />
                        Data Kantor
                    </h1>
                    <p className="text-sm text-muted-foreground">
                        Kelola Data Kantor Pusat, Regional, Cabang, dan Unit.
                    </p>
                </div>
                <ButtonGroup>
                    <Button onClick={() => router.visit(offices.create().url)}>
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

            {/* Tree Area */}
            <div className="relative min-h-screen flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 bg-card/20 md:min-h-min dark:border-sidebar-border">
                <div className="p-4 md:p-8">{renderTreeView()}</div>
            </div>
        </div>
    );
}
