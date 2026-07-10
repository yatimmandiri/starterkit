<?php

namespace Database\Seeders;

use App\Models\Sdm\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://calendarific.com/api/v2/holidays', [
            'api_key' => '1D0XYCD9gV26hKjsUkiyk7RbtxfoC4DB',
            'country' => 'ID',
            'year' => 2026,
        ]);

        if ($response->successful()) {
            $holidays = $response->json('response.holidays');

            foreach ($holidays as $holiday) {
                Holiday::updateOrCreate(
                    [
                        'date' => Carbon::parse($holiday['date']['iso'])->format('Y-m-d'),
                    ],
                    [
                        'name' => $holiday['name'],
                        'description' => $holiday['description'] ?? null,
                        'is_national' => collect($holiday['type'])
                            ->contains('National holiday'),
                    ]
                );
            }
        }
    }
}
