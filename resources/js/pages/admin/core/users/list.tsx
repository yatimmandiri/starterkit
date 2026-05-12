import { DataTableComponent } from '@/components/partials/dataTables';
import { DataTableProvider } from '@/components/partials/dataTables/hooks/useDataTables';
import {
    renderRowDate,
    renderRowHeader,
} from '@/components/partials/dataTables/utils/dataTable-utils';
import { SelectComponent } from '@/components/partials/select-component';
import users from '@/routes/admin/core/users';
import { usePage } from '@inertiajs/react';
import moment from 'moment-timezone';
import { useState } from 'react';

export default function ListPage() {
    const { roles } = usePage<any>().props;

    const [refreshData, setRefreshData] = useState(false);
    const [filterValue, setFilterValue] = useState<any>({});

    const columns = [
        {
            header: (info: any) => renderRowHeader(info, 'Name'),
            accessorKey: 'name',
        },
        {
            header: (info: any) => renderRowHeader(info, 'Email'),
            accessorKey: 'email',
        },
        {
            header: (info: any) => renderRowHeader(info, 'Roles'),
            accessorKey: 'roles',
            accessorFn: (row: any) =>
                row.roles.map((item: any) => item.name).join(', '),
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
            'Created At': moment(item.created_at)
                .tz('Asia/Jakarta')
                .format('YYYY-MM-DD HH:mm:ss'),
            'Updated At': moment(item.updated_at)
                .tz('Asia/Jakarta')
                .format('YYYY-MM-DD HH:mm:ss'),
        }));
    };

    return (
        <div className="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div className="relative min-h-screen flex-1 overflow-hidden rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <DataTableProvider
                    columns={columns}
                    filterValue={filterValue}
                    refreshData={refreshData}
                    setRefreshData={setRefreshData}
                    urlFetchData={users.data().url}
                    formatDataExport={formatDataExport}
                >
                    <div className="flex flex-col space-y-4 px-4 pt-8 md:px-8">
                        <div className="grid grid-cols-1 gap-4 md:grid-cols-4">
                            <SelectComponent
                                label="Roles"
                                placeholder="Filter by Roles..."
                                data={roles?.map((item: any) => ({
                                    value: item.id.toString(),
                                    label: item.name,
                                }))}
                                dataSelected={filterValue.roles}
                                handleOnChange={(value: any) =>
                                    setFilterValue((prev: any) => ({
                                        ...prev,
                                        roles: value,
                                    }))
                                }
                            />
                        </div>
                    </div>
                    <DataTableComponent buttonActive={{ export: false }} />
                </DataTableProvider>
            </div>
        </div>
    );
}
