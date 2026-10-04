<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::insert([
            [
                'nama_lapangan' => 'Lapangan Futsal A',
                'jenis_olahraga' => 'Futsal',
                'lokasi' => 'Samarinda',
                'harga_per_jam' => 100000,
                'fasilitas' => 'Ruang ganti, toilet, parkir',
                'deskripsi' => 'Lapangan futsal dengan rumput sintetis.',
                'foto' => null,
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan Badminton A',
                'jenis_olahraga' => 'Badminton',
                'lokasi' => 'Samarinda',
                'harga_per_jam' => 50000,
                'fasilitas' => 'Toilet, parkir, tempat duduk',
                'deskripsi' => 'Lapangan badminton indoor.',
                'foto' => null,
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_lapangan' => 'Lapangan Basket A',
                'jenis_olahraga' => 'Basket',
                'lokasi' => 'Samarinda',
                'harga_per_jam' => 80000,
                'fasilitas' => 'Toilet, parkir, tribun',
                'deskripsi' => 'Lapangan basket outdoor.',
                'foto' => null,
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
