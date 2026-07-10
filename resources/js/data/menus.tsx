import permissions from '@/routes/admin/core/permissions';
import districts from '@/routes/admin/core/regions/districts';
import provinces from '@/routes/admin/core/regions/provinces';
import regencies from '@/routes/admin/core/regions/regencies';
import villages from '@/routes/admin/core/regions/villages';
import roles from '@/routes/admin/core/roles';
import users from '@/routes/admin/core/users';
import activities from '@/routes/admin/logs/activities';
import contracts from '@/routes/admin/sdm/contracts';
import employees from '@/routes/admin/sdm/employees';
import grades from '@/routes/admin/sdm/grades';
import holidays from '@/routes/admin/sdm/holidays';
import offices from '@/routes/admin/sdm/offices';
import positions from '@/routes/admin/sdm/positions';
import shifts from '@/routes/admin/sdm/shifts';
import site from '@/routes/admin/settings/site';
import {
    ChevronRight,
    CogIcon,
    CpuIcon,
    DatabaseIcon,
    MapIcon,
    UsersIcon,
    WalletIcon,
} from 'lucide-react';

export const NavigationList = [
    {
        title: 'Platform',
        roles: ['Administrators'],
        children: [
            {
                title: 'System Core',
                roles: ['Administrators'],
                icon: CpuIcon,
                children: [
                    {
                        title: 'Permissions',
                        href: permissions.index().url,
                        permission: 'view-permission',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Roles',
                        href: roles.index().url,
                        permission: 'view-role',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Users',
                        href: users.index().url,
                        permission: 'view-user',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Regions',
                        roles: ['Administrators'],
                        icon: MapIcon,
                        children: [
                            {
                                title: 'Provinces',
                                href: provinces.index().url,
                                permission: 'view-province',
                                icon: ChevronRight,
                            },
                            {
                                title: 'Regencies',
                                href: regencies.index().url,
                                permission: 'view-regency',
                                icon: ChevronRight,
                            },
                            {
                                title: 'Districts',
                                href: districts.index().url,
                                permission: 'view-district',
                                icon: ChevronRight,
                            },
                            {
                                title: 'Villages',
                                href: villages.index().url,
                                permission: 'view-village',
                                icon: ChevronRight,
                            },
                        ],
                    },
                ],
            },
            {
                title: 'Settings',
                roles: ['Administrators'],
                icon: CogIcon,
                children: [
                    {
                        title: 'Site',
                        href: site.edit().url,
                        permission: 'view-settings-site',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Log Activity',
                        href: activities.index().url,
                        permission: 'view-log-activity',
                        icon: ChevronRight,
                    },
                ],
            },
        ],
    },
    {
        title: 'SDM',
        roles: ['Administrators'],
        children: [
            {
                title: 'Employees',
                roles: ['Administrators'],
                icon: UsersIcon,
                children: [
                    {
                        title: 'Karyawan',
                        href: employees.index().url,
                        permission: 'view-employee',
                        icon: ChevronRight,
                    },
                    // {
                    //     title: 'Mutasi',
                    //     href: activities.index().url,
                    //     permission: 'view-mutation',
                    //     icon: ChevronRight,
                    // },
                    // {
                    //     title: 'Riwayat Jabatan',
                    //     href: activities.index().url,
                    //     permission: 'view-history-position',
                    //     icon: ChevronRight,
                    // },
                    // {
                    //     title: 'Kontrak Kerja',
                    //     href: activities.index().url,
                    //     permission: 'view-contract',
                    //     icon: ChevronRight,
                    // },
                ],
            },
            {
                title: 'Attendances',
                roles: ['Administrators'],
                icon: CogIcon,
                children: [
                    // {
                    //     title: 'Absensi Kehadiran',
                    //     href: activities.index().url,
                    //     permission: 'view-presence',
                    //     icon: ChevronRight,
                    // },
                ],
            },
            {
                title: 'Payroll',
                icon: WalletIcon,
                children: [
                    // {
                    //     title: 'Penggajian',
                    //     href: activities.index().url,
                    //     permission: 'view-payroll',
                    //     icon: ChevronRight,
                    // },
                    // {
                    //     title: 'Slip Gaji',
                    //     href: activities.index().url,
                    //     permission: 'view-salary-slip',
                    //     icon: ChevronRight,
                    // },
                ],
            },
            {
                title: 'Master Data',
                roles: ['Administrators'],
                icon: DatabaseIcon,
                children: [
                    {
                        title: 'Offices',
                        href: offices.index().url,
                        permission: 'view-office',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Grades',
                        href: grades.index().url,
                        permission: 'view-grade',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Positions',
                        href: positions.index().url,
                        permission: 'view-position',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Contracts',
                        href: contracts.index().url,
                        permission: 'view-contract',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Shift',
                        href: shifts.index().url,
                        permission: 'view-shift',
                        icon: ChevronRight,
                    },
                    {
                        title: 'Holiday',
                        href: holidays.index().url,
                        permission: 'view-holiday',
                        icon: ChevronRight,
                    },
                ],
            },
        ],
    },
];
