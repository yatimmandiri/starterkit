import { DataTableComponent } from '@/components/partials/dataTables';
import { DataTableProvider } from '@/components/partials/dataTables/hooks/useDataTables';
import {
    renderRowDate,
    renderRowHeader,
} from '@/components/partials/dataTables/utils/dataTable-utils';
import { SelectComponent } from '@/components/partials/select-component';
import districts from '@/routes/admin/core/regions/districts';
import regencies from '@/routes/admin/core/regions/regencies';
import { formatDate } from '@/utils/formatDate';
import { useState } from 'react';

export default function ListPage() {
    const [refreshData, setRefreshData] = useState(false);
    const [filterValue, setFilterValue] = useState<any>({});

    const columns = [
        {
            header: (info: any) => renderRowHeader(info, 'Name'),
            accessorKey: 'name',
        },
        {
            header: (info: any) => renderRowHeader(info, 'Regencies'),
            accessorKey: 'regency_id',
            accessorFn: (row: any) => row.regency.name,
        },
        {
            header: (info: any) => renderRowHeader(info, 'Created At'),
            accessorKey: 'created_at',
            cell: (info: any) => renderRowDate(info.getValue()),
        },
        {
            header: (info: any) => renderRowHeader(info, 'Updated At'),
            accessorKey: 'updated_at',
            cell: (info: any) => renderRowDate(info.getValue()),
        },
    ];

    const formatDataExport = (data: any) => {
        return data.map((item: any, i: number) => ({
            No: i + 1,
            Name: item.name,
            'Created At': formatDate(item.created_at, 'datetime'),
            'Updated At': formatDate(item.updated_at, 'datetime'),
        }));
    };

    return (
        <div className="flex h-full flex-1 flex-col gap-6 overflow-x-auto p-6">
            <div className="overflow-hidden rounded-xl border bg-background shadow-sm">
                <DataTableProvider
                    columns={columns}
                    filterValue={filterValue}
                    refreshData={refreshData}
                    setRefreshData={setRefreshData}
                    urlFetchData={districts.data().url}
                    formatDataExport={formatDataExport}
                >
                    <div className="border-b bg-muted/30 p-6">
                        <div className="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <SelectComponent
                                label="Regency"
                                placeholder="Filter by regency..."
                                fetchDataUrl={regencies.data().url}
                                dataSelected={filterValue.regency_id}
                                handleOnChange={(value: any) =>
                                    setFilterValue((prev: any) => ({
                                        ...prev,
                                        regency_id: value,
                                    }))
                                }
                            />
                        </div>
                    </div>
                    <DataTableComponent
                        buttonActive={{
                            export: false,
                        }}
                    />
                </DataTableProvider>
            </div>
        </div>
    );
}
