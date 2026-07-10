<?php

namespace Database\Seeders;

use App\Models\Core\Permission;
use App\Models\Sdm\Contract;
use App\Models\Sdm\Grade;
use App\Models\Sdm\Office;
use App\Models\Sdm\Position;
use App\Models\Sdm\Shift;
use Illuminate\Database\Seeder;

class SdmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            ['name' => 'view-office', 'guard_name' => 'web'],
            ['name' => 'create-office', 'guard_name' => 'web'],
            ['name' => 'update-office', 'guard_name' => 'web'],
            ['name' => 'delete-office', 'guard_name' => 'web'],
            ['name' => 'data-office', 'guard_name' => 'web'],

            ['name' => 'view-grade', 'guard_name' => 'web'],
            ['name' => 'create-grade', 'guard_name' => 'web'],
            ['name' => 'update-grade', 'guard_name' => 'web'],
            ['name' => 'delete-grade', 'guard_name' => 'web'],
            ['name' => 'data-grade', 'guard_name' => 'web'],

            ['name' => 'view-position', 'guard_name' => 'web'],
            ['name' => 'create-position', 'guard_name' => 'web'],
            ['name' => 'update-position', 'guard_name' => 'web'],
            ['name' => 'delete-position', 'guard_name' => 'web'],
            ['name' => 'data-position', 'guard_name' => 'web'],

            ['name' => 'view-contract', 'guard_name' => 'web'],
            ['name' => 'create-contract', 'guard_name' => 'web'],
            ['name' => 'update-contract', 'guard_name' => 'web'],
            ['name' => 'delete-contract', 'guard_name' => 'web'],
            ['name' => 'data-contract', 'guard_name' => 'web'],

            ['name' => 'view-shift', 'guard_name' => 'web'],
            ['name' => 'create-shift', 'guard_name' => 'web'],
            ['name' => 'update-shift', 'guard_name' => 'web'],
            ['name' => 'delete-shift', 'guard_name' => 'web'],
            ['name' => 'data-shift', 'guard_name' => 'web'],

            ['name' => 'view-holiday', 'guard_name' => 'web'],
            ['name' => 'create-holiday', 'guard_name' => 'web'],
            ['name' => 'update-holiday', 'guard_name' => 'web'],
            ['name' => 'delete-holiday', 'guard_name' => 'web'],
            ['name' => 'data-holiday', 'guard_name' => 'web'],

            ['name' => 'view-employee', 'guard_name' => 'web'],
            ['name' => 'create-employee', 'guard_name' => 'web'],
            ['name' => 'update-employee', 'guard_name' => 'web'],
            ['name' => 'delete-employee', 'guard_name' => 'web'],
            ['name' => 'data-employee', 'guard_name' => 'web'],
        ])->each(fn($data) => Permission::create($data)->assignRole(['Administrators']));

        $offices = collect();

        collect([
            // ==========================
            // PUSAT
            // ==========================
            [
                'key' => 'pusat',
                'name' => 'Kantor Pusat',
                'type' => 'Pusat',
                'parent' => null,
            ],

            // ==========================
            // REGIONAL
            // ==========================
            ['key' => 'jatim', 'name' => 'Regional Jawa Timur', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'jateng', 'name' => 'Regional Jawa Tengah', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'jabar', 'name' => 'Regional Jawa Barat', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'jakarta', 'name' => 'Regional DKI Jakarta', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'banten', 'name' => 'Regional Banten', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'sumut', 'name' => 'Regional Sumatera Utara', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'sumsel', 'name' => 'Regional Sumatera Selatan', 'type' => 'Regional', 'parent' => 'pusat'],
            ['key' => 'kalimantan', 'name' => 'Regional Kalimantan', 'type' => 'Regional', 'parent' => 'pusat'],

            // ==========================
            // CABANG JATIM
            // ==========================
            ['name' => 'Cabang Surabaya', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Sidoarjo', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Gresik', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Lamongan', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Mojokerto', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Jombang', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Kediri', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Blitar', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Malang', 'type' => 'Cabang', 'parent' => 'jatim'],
            ['name' => 'Cabang Pasuruan', 'type' => 'Cabang', 'parent' => 'jatim'],

            // ==========================
            // CABANG JATENG
            // ==========================
            ['name' => 'Cabang Semarang', 'type' => 'Cabang', 'parent' => 'jateng'],
            ['name' => 'Cabang Solo', 'type' => 'Cabang', 'parent' => 'jateng'],
            ['name' => 'Cabang Purwokerto', 'type' => 'Cabang', 'parent' => 'jateng'],
            ['name' => 'Cabang Tegal', 'type' => 'Cabang', 'parent' => 'jateng'],
            ['name' => 'Cabang Pekalongan', 'type' => 'Cabang', 'parent' => 'jateng'],

            // ==========================
            // CABANG JABAR
            // ==========================
            ['name' => 'Cabang Bandung', 'type' => 'Cabang', 'parent' => 'jabar'],
            ['name' => 'Cabang Bekasi', 'type' => 'Cabang', 'parent' => 'jabar'],
            ['name' => 'Cabang Bogor', 'type' => 'Cabang', 'parent' => 'jabar'],
            ['name' => 'Cabang Depok', 'type' => 'Cabang', 'parent' => 'jabar'],
            ['name' => 'Cabang Cirebon', 'type' => 'Cabang', 'parent' => 'jabar'],
            ['name' => 'Cabang Tasikmalaya', 'type' => 'Cabang', 'parent' => 'jabar'],

            // ==========================
            // CABANG DKI
            // ==========================
            ['name' => 'Cabang Jakarta Selatan', 'type' => 'Cabang', 'parent' => 'jakarta'],
            ['name' => 'Cabang Jakarta Timur', 'type' => 'Cabang', 'parent' => 'jakarta'],
            ['name' => 'Cabang Jakarta Barat', 'type' => 'Cabang', 'parent' => 'jakarta'],
            ['name' => 'Cabang Jakarta Utara', 'type' => 'Cabang', 'parent' => 'jakarta'],
            ['name' => 'Cabang Jakarta Pusat', 'type' => 'Cabang', 'parent' => 'jakarta'],

            // ==========================
            // CABANG BANTEN
            // ==========================
            ['name' => 'Cabang Tangerang', 'type' => 'Cabang', 'parent' => 'banten'],
            ['name' => 'Cabang Serang', 'type' => 'Cabang', 'parent' => 'banten'],
            ['name' => 'Cabang Cilegon', 'type' => 'Cabang', 'parent' => 'banten'],
            ['name' => 'Cabang Pandeglang', 'type' => 'Cabang', 'parent' => 'banten'],

            // ==========================
            // CABANG SUMUT
            // ==========================
            ['name' => 'Cabang Medan', 'type' => 'Cabang', 'parent' => 'sumut'],
            ['name' => 'Cabang Binjai', 'type' => 'Cabang', 'parent' => 'sumut'],
            ['name' => 'Cabang Tebing Tinggi', 'type' => 'Cabang', 'parent' => 'sumut'],
            ['name' => 'Cabang Pematang Siantar', 'type' => 'Cabang', 'parent' => 'sumut'],

            // ==========================
            // CABANG SUMSEL
            // ==========================
            ['name' => 'Cabang Palembang', 'type' => 'Cabang', 'parent' => 'sumsel'],
            ['name' => 'Cabang Lubuklinggau', 'type' => 'Cabang', 'parent' => 'sumsel'],
            ['name' => 'Cabang Prabumulih', 'type' => 'Cabang', 'parent' => 'sumsel'],

            // ==========================
            // CABANG KALIMANTAN
            // ==========================
            ['name' => 'Cabang Balikpapan', 'type' => 'Cabang', 'parent' => 'kalimantan'],
            ['name' => 'Cabang Samarinda', 'type' => 'Cabang', 'parent' => 'kalimantan'],
            ['name' => 'Cabang Banjarmasin', 'type' => 'Cabang', 'parent' => 'kalimantan'],
            ['name' => 'Cabang Pontianak', 'type' => 'Cabang', 'parent' => 'kalimantan'],
        ])->values()->each(function ($item, $i) use ($offices) {
            $office = Office::create([
                'name' => $item['name'],
                'type' => $item['type'],
                'parent_id' => $item['parent']
                    ? optional($offices->get($item['parent']))->id
                    : null,
                'sort' => $i + 1,
                'status' => true,
            ]);

            if (isset($item['key'])) {
                $offices->put($item['key'], $office);
            }
        });

        collect([
            [
                'name' => 'G1',
                'description' => 'Golongan I',
            ],
            [
                'name' => 'G2',
                'description' => 'Golongan II',
            ],
            [
                'name' => 'G3',
                'description' => 'Golongan III',
            ],
            [
                'name' => 'G4',
                'description' => 'Golongan IV',
            ],
            [
                'name' => 'G5',
                'description' => 'Golongan V',
            ],
            [
                'name' => 'G6',
                'description' => 'Golongan VI',
            ]
        ])->each(fn($data) => Grade::create($data));

        collect([
            [
                'name' => 'PKWT 3 Bulan',
                'duration_month' => 3,
                'is_permanent' => false,
            ],
            [
                'name' => 'PKWT 6 Bulan',
                'duration_month' => 6,
                'is_permanent' => false,
            ],
            [
                'name' => 'PKWT 12 Bulan',
                'duration_month' => 12,
                'is_permanent' => false,
            ],
            [
                'name' => 'PKWT 24 Bulan',
                'duration_month' => 24,
                'is_permanent' => false,
            ],
            [
                'name' => 'PKWTT (Karyawan Tetap)',
                'duration_month' => null,
                'is_permanent' => true,
            ],
            [
                'name' => 'Magang',
                'duration_month' => 6,
                'is_permanent' => false,
            ],
            [
                'name' => 'Freelance',
                'duration_month' => null,
                'is_permanent' => false,
            ],
            [
                'name' => 'Outsource',
                'duration_month' => 12,
                'is_permanent' => false,
            ],
        ])->each(fn($data) => Contract::create($data));

        collect([
            [
                'name' => 'Shift Pagi',
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
            ],
            [
                'name' => 'Shift Siang',
                'start_time' => '13:00:00',
                'end_time' => '22:00:00',
            ],
            [
                'name' => 'Shift Malam',
                'start_time' => '22:00:00',
                'end_time' => '07:00:00',
            ],
            [
                'name' => 'Jam Kerja Fleksibel',
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
            ],
        ])->each(fn($data) => Shift::create($data));

        $positions = collect([
            ["id" => "1", "name" => "DIREKTUR UTAMA LAZ", "parent_id" => null, "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "2", "name" => "DIREKTUR FUNDRAISING RETAIL", "parent_id" => "1", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "3", "name" => "DIREKTUR GZ", "parent_id" => null, "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "4", "name" => "DIREKTUR TB", "parent_id" => null, "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "5", "name" => "DIREKTUR SDM & OPERASIONAL", "parent_id" => "1", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "6", "name" => "KEPALA DIKLAT MEC", "parent_id" => "138", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "7", "name" => "KEPALA REGIONAL", "parent_id" => "1", "office_type" => "Regional", "work_type" => "Dalam", "status" => true],
            ["id" => "8", "name" => "SPV KEUANGAN REGIONAL", "parent_id" => "7", "office_type" => "Regional", "work_type" => "Dalam", "status" => true],
            ["id" => "9", "name" => "SPV PROGRAM REGIONAL", "parent_id" => "7", "office_type" => "Regional", "work_type" => "Dalam", "status" => true],
            ["id" => "10", "name" => "KEPALA CABANG", "parent_id" => "7", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "11", "name" => "STAF DATA CABANG", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "12", "name" => "STAF KEUANGAN CABANG", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "13", "name" => "STAF KEUANGAN DAN DATA CABANG", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "14", "name" => "ZISCO", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Lapangan", "status" => true],
            ["id" => "15", "name" => "STAF PROGRAM CABANG", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "16", "name" => "SPV CRM REGIONAL", "parent_id" => "7", "office_type" => "Regional", "work_type" => "Dalam", "status" => true],
            ["id" => "17", "name" => "MANAJER LAYANAN DAKWAH", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "18", "name" => "MANAJER CSR DAN PARTNERSHIP", "parent_id" => "150", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "19", "name" => "MANAJER DIGITAL FUNDRAISING", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "20", "name" => "MANAJER CRM", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "21", "name" => "SPV RETAIL DAN PELATIHAN", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "22", "name" => "KEPALA YM BENDUL MERISI", "parent_id" => "7", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "23", "name" => "STAF LAYANAN DAKWAH", "parent_id" => "17", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "24", "name" => "STAF VIDEOGRAFER", "parent_id" => "32", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "25", "name" => "SPV MARKOM", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "26", "name" => "STAF CSR DAN PARTNERSHIP", "parent_id" => "18", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "27", "name" => "SPV CRM PUSAT", "parent_id" => "20", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "28", "name" => "STAF CRM", "parent_id" => "20", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "29", "name" => "STAF LAYANAN DONGENG", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "30", "name" => "SPV ZISCO PUSAT", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Lapangan", "status" => true],
            ["id" => "31", "name" => "ZISCO PUSAT", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Lapangan", "status" => true],
            ["id" => "32", "name" => "MANAJER BRAND COMMUNICATION", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "33", "name" => "MANAJER PROGRAM P2", "parent_id" => "138", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "34", "name" => "STAF FUNDRAISING SUPPORT", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "35", "name" => "SPV PENGEMBANGAN DINIYAH", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "36", "name" => "STAF AKADEMIK PROGRAM", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "37", "name" => "STAF PROGRAM PENDISTRIBUSIAN", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "38", "name" => "STAF PROGRAM PEMBERDAYAAN", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "39", "name" => "STAF ADMIN PROGRAM", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "40", "name" => "STAF R&D PROGRAM", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "41", "name" => "MANAJER PERSONALIA", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "42", "name" => "SPV PERSONALIA", "parent_id" => "41", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "43", "name" => "STAF PERSONALIA", "parent_id" => "41", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "44", "name" => "MANAJER HRD", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "45", "name" => "SPV HRD", "parent_id" => "44", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "46", "name" => "STAF HRD", "parent_id" => "44", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "47", "name" => "MANAJER KEUANGAN", "parent_id" => "146", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "48", "name" => "MANAJER AKUNTING DAN PERBANKAN", "parent_id" => "146", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "49", "name" => "MANAJER ASSET & STRATEGIC RECOVERY ADMINISTRATION", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "50", "name" => "SPV KEUANGAN PUSAT", "parent_id" => "47", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "51", "name" => "STAF KASIR", "parent_id" => "47", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "52", "name" => "SPV AKUNTING", "parent_id" => "48", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "53", "name" => "STAF AKUNTING", "parent_id" => "48", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "54", "name" => "STAF PERBANKAN / PENERIMAAN", "parent_id" => "48", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "55", "name" => "SPV AKUNTING DAN PERBANKAN", "parent_id" => "48", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "56", "name" => "STAF ADMIN PENGENDALIAN", "parent_id" => "49", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "57", "name" => "STAF ASET DAN PURCHASING", "parent_id" => "49", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "58", "name" => "SEKRETARIS UMUM", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "59", "name" => "STAF KESEKRETARIATAN", "parent_id" => "58", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "60", "name" => "STAF R&D KESEKRETARIATAN", "parent_id" => "58", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "61", "name" => "MANAJER PROGRAM & SOCIAL PARTNERSHIP DEVELOPMENT", "parent_id" => "138", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "62", "name" => "SPV BRAND COMMUNICATION", "parent_id" => "32", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "63", "name" => "STAF BRAND COMMUNICATION", "parent_id" => "32", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "64", "name" => "WAKA KESISWAAN MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "65", "name" => "WAKA OPERASIONAL MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "66", "name" => "WAKA KURIKULUM MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "67", "name" => "KEPALA PROGRAM MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "68", "name" => "SPV AKUNTING DAN KASIR", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "69", "name" => "STAF MULTIMEDIA &  IT MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "70", "name" => "STAF SOSMED DAN DESAIN MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "71", "name" => "STAF UMUM MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "72", "name" => "STAF OPERASIONAL MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "73", "name" => "STAF GA MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "74", "name" => "MENTOR MEC", "parent_id" => "67", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "75", "name" => "DIREKTUR WAKAF", "parent_id" => null, "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "76", "name" => "WAKIL DIREKTUR WAKAF", "parent_id" => "75", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "77", "name" => "MANAJER KEUANGAN WAKAF", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "78", "name" => "KEPALA STAF PENGURUS", "parent_id" => "1", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "79", "name" => "MANAJER AUDIT INTERNAL", "parent_id" => "78", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "80", "name" => "STAF AUDIT INTERNAL", "parent_id" => "79", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "81", "name" => "DIREKTUR LBA", "parent_id" => null, "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "82", "name" => "SPV DIGITAL FUNDRAISING", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "83", "name" => "STAF CAMPAIGN DIGIFUND", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "84", "name" => "MANAJER OPERASIONAL", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "85", "name" => "MANAJER IT DAN DATA CENTER", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "86", "name" => "STAF IT", "parent_id" => "85", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "87", "name" => "STAF DATA CENTER", "parent_id" => "85", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "88", "name" => "SECURITY", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "89", "name" => "STAF GA", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "90", "name" => "DRIVER", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "91", "name" => "STAF FRONT OFFICE", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "92", "name" => "STAF CLEANING SERVICE", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "93", "name" => "SPV CLEANING SERVICE", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "94", "name" => "MITRA MANDIRI", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Lapangan", "status" => true],
            ["id" => "95", "name" => "MITRA GERAI FUNDRAISING", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Lapangan", "status" => true],
            ["id" => "96", "name" => "KANTOR", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "97", "name" => "PERAWAT", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "98", "name" => "STAF WAKAF", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "99", "name" => "STAF RSM", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "100", "name" => "STAF AKADEMIK MEC", "parent_id" => "6", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "101", "name" => "STAF KEUANGAN PUSAT 2", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "102", "name" => "STAF PROGRAM PUSAT 2", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "103", "name" => "STAF DATA PUSAT 2", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "104", "name" => "STAF DATA PROGRAM CABANG", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "105", "name" => "STAF CLEANING SERVICE CABANG", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "106", "name" => "STAF DIGITAL PARTNER", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "107", "name" => "STAF DIGITAL FUNDRAISING", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "108", "name" => "STAF ADMIN DIGIFUND", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "109", "name" => "STAF DESAIN DIGIFUND", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "110", "name" => "MANAJER FUNDRAISING WAKAF", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "111", "name" => "MANAJER WAKAF PRODUKTIF", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "112", "name" => "STAF DESAIN WAKAF", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "113", "name" => "STAF SEO SPESIALIS DIGIFUND", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "114", "name" => "STAF SOSMED MARKOM", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "115", "name" => "SPV ZISCO", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Lapangan", "status" => true],
            ["id" => "116", "name" => "STAF DESAIN BRAND COMMUNICATION", "parent_id" => "32", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "117", "name" => "STAF DM MARKOM", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "118", "name" => "STAF MARKETING ANALIS", "parent_id" => "19", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "119", "name" => "STAF JURNALIS DAKWAH", "parent_id" => "32", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "120", "name" => "STAF CREATIVE PROGRAM", "parent_id" => "61", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "121", "name" => "SPV DIGITAL MARKETING GZ", "parent_id" => "3", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "122", "name" => "STAF DESAIN GZ", "parent_id" => "3", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "123", "name" => "SPV FUNDRAISING GZ", "parent_id" => "3", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "124", "name" => "STAF SOSMED SPESIALIS GZ", "parent_id" => "121", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "125", "name" => "STAF CRO GZ", "parent_id" => "121", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "126", "name" => "STAF DESIGN TB", "parent_id" => "134", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "127", "name" => "SPV KEUANGAN BANOM", "parent_id" => "76", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "128", "name" => "STAF KASIR MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "129", "name" => "SPV KERELAWANAN DAN LAYANAN KESEHATAN", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "130", "name" => "DRIVER REGIONAL", "parent_id" => "7", "office_type" => "Regional", "work_type" => "Dalam", "status" => true],
            ["id" => "131", "name" => "STAF AKUNTING MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "132", "name" => "KEPALA ASRAMA TANAM BERKAH", "parent_id" => "136", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "133", "name" => "KEPALA DINIYAH LPYM", "parent_id" => "139", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "134", "name" => "MANAJER FUNDRAISING TB", "parent_id" => "149", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "135", "name" => "STAF CRM PUSAT 2", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "136", "name" => "WAKIL DIREKTUR TANAM BERKAH", "parent_id" => null, "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "137", "name" => "SPV FUNDRAISING SUPPORT", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "138", "name" => "DIREKTUR P2", "parent_id" => "1", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "139", "name" => "DIREKTUR KEMAKMURAN MASJID", "parent_id" => "1", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "140", "name" => "SPV OPERASIONAL", "parent_id" => "84", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "141", "name" => "SPV PERFORMANCE MANAGEMENT SISTEM", "parent_id" => "44", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "142", "name" => "SPV DONGENG & CHARITY RELATIONS", "parent_id" => "2", "office_type" => "Pusat", "work_type" => "Dalam", "status" => false],
            ["id" => "143", "name" => "HUMAS & PENGKARYAAN", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "144", "name" => "STAF CLEANING SERVICE BENDUL", "parent_id" => "22", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "145", "name" => "SENIOR MANAJER TANAM BERKAH", "parent_id" => "149", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "146", "name" => "SENIOR MANAJER KEUANGAN", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "147", "name" => "KEPALA ASRAMA MEC", "parent_id" => "6", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "148", "name" => "SPV KESEKRETARIATAN DAN DATA CENTER", "parent_id" => "58", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "149", "name" => "WAKIL DIREKTUR UTAMA LAZ", "parent_id" => "1", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "150", "name" => "WAKIL DIREKTUR PROGRAM", "parent_id" => "138", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "151", "name" => "RELAWAN RAMADHAN PUSAT", "parent_id" => "22", "office_type" => "Pusat", "work_type" => "Lapangan", "status" => true],
            ["id" => "152", "name" => "RELAWAN RAMADHAN", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Lapangan", "status" => true],
            ["id" => "153", "name" => "MAGANG (CABANG)", "parent_id" => "10", "office_type" => "Cabang", "work_type" => "Dalam", "status" => true],
            ["id" => "154", "name" => "MAGANG (PUSAT)", "parent_id" => "44", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "155", "name" => "MANAJER PEMBERDAYAAN PETERNAKAN", "parent_id" => "150", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "156", "name" => "MANAJER PENGEMBANGAN CABANG", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "157", "name" => "WAKIL REKTOR", "parent_id" => "5", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "158", "name" => "DOSEN", "parent_id" => "157", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "159", "name" => "STAF IT DAN SOSIAL MEDIA", "parent_id" => "157", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "160", "name" => "STAF BIRO ADMINISTRASI UMUM & KEUANGAN", "parent_id" => "157", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "161", "name" => "STAF BIRO ADMINISTRASI AKADEMIK & KEMAHASISWAAN", "parent_id" => "157", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "162", "name" => "STAF DVO PROGRAM", "parent_id" => "33", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true],
            ["id" => "163", "name" => "SECURITY - LPYM", "parent_id" => "41", "office_type" => "Pusat", "work_type" => "Dalam", "status" => true]
        ]);

        foreach ($positions as $i => $data) {
            Position::create([
                'id' => $data['id'],
                'name' => $data['name'],
                'office_type' => $data['office_type'],
                'work_type' => $data['work_type'],
                'status' => $data['status'],
                'sort' => $i + 1,
            ]);
        }

        // Tahap 2
        foreach ($positions as $data) {
            Position::whereKey($data['id'])->update([
                'parent_id' => $data['parent_id'],
            ]);
        }
    }
}
