<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = Field::all();

        foreach ($fields as $field) {
            for ($i = 1; $i <= 3; $i++) {
                $tanggal = Carbon::tomorrow()->addDays($i - 1);

                $jadwal = [
                    ['08:00:00', '09:00:00'],
                    ['09:00:00', '10:00:00'],
                    ['10:00:00', '11:00:00'],
                    ['13:00:00', '14:00:00'],
                    ['14:00:00', '15:00:00'],
                    ['15:00:00', '16:00:00'],
                ];

                foreach ($jadwal as $jam) {
                    Schedule::create([
                        'field_id' => $field->id,
                        'tanggal' => $tanggal->toDateString(),
                        'jam_mulai' => $jam[0],
                        'jam_selesai' => $jam[1],
                        'status' => 'available',
                    ]);
                }
            }
        }
    }
}
