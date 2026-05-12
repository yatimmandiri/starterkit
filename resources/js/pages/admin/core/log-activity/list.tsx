import { DataTableComponent } from '@/components/partials/dataTables';
import { DataTableProvider } from '@/components/partials/dataTables/hooks/useDataTables';
import {
    renderRowDate,
    renderRowHeader,
} from '@/components/partials/dataTables/utils/dataTable-utils';
import logActivity from '@/routes/admin/core/log-activity';
import moment from 'moment-timezone';
import { useState } from 'react';

export default function ListPage() {
    const [refreshData, setRefreshData] = useState(false);
    const [filterValue, setFilterValue] = useState({});

    const columns = [
        {
            header: (info: any) => renderRowHeader(info, 'Name'),
            accessorKey: 'log_name',
        },
        {
            header: (info: any) => renderRowHeader(info, 'User'),
            accessorKey: 'users.name',
        },
        {
            header: (info: any) => renderRowHeader(info, 'Subject Type'),
            accessorKey: 'subject_type',
        },
        {
            header: (info: any) => renderRowHeader(info, 'Action Event'),
            accessorKey: 'event',
        },
        {
            header: (info: any) => renderRowHeader(info, 'Attribute Changes'),
            accessorKey: 'attribute_changes',
            cell: (info: any) => renderRowJson(info.getValue()),
        },
        {
            header: (info: any) => renderRowHeader(info, 'Properties'),
            accessorKey: 'properties',
            cell: (info: any) => renderRowJson(info.getValue()),
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

    const renderRowJson = (value: any) => {
        return (
            <span className="max-w-125 text-sm wrap-break-word whitespace-pre-wrap">
                {JSON.stringify(value, null, 2)}
            </span>
        );
    };

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
                    urlFetchData={logActivity.data().url}
                    formatDataExport={formatDataExport}
                    withActions={false}
                >
                    <DataTableComponent buttonActive={{ export: false }} />
                </DataTableProvider>
            </div>
        </div>
    );
}
