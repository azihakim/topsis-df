<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Data;
use App\Models\Karyawan;
use App\Models\Kriteria;
use App\Models\Pelanggan;
use App\Models\SubKriteria;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // User::create([
        //     'name' => 'Admin',
        //     'role' => 'Admin',
        //     'username' => 'admin',
        //     'password' => Hash::make('123'),
        // ]);

        $pelanggan = [
            [
                'nama' => 'Anwar Zemmi',
                'no_hp' => '080880'
            ],
            [
                'nama' => 'Faisal Riza',
                'no_hp' => '080880'
            ],
            [
                'nama' => 'M. Lendra',
                'no_hp' => '080880'
            ],
            [
                'nama' => 'Nicolas Alex',
                'no_hp' => '080880'
            ],
            [
                'nama' => 'Budi',
                'no_hp' => '080880'
            ],
        ];

        foreach ($pelanggan as $k) {
            Pelanggan::create([
                'nama' => $k['nama'],
                'no_hp' => $k['no_hp'],
            ]);
        }

        $kriteria = [
            [
                'nama' => 'Tingkat Pendidikan',
                'kode' => 'C1',
            ],
            [
                'nama' => 'Kompetensi',
                'kode' => 'C2',
            ],
            [
                'nama' => 'Upaya Fisik dan Tekanan Waktu',
                'kode' => 'C3',
            ],
            [
                'nama' => 'Absensi',
                'kode' => 'C4',
            ],
            [
                'nama' => 'Tanggung Jawab',
                'kode' => 'C5',
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create([
                'nama' => $k['nama'],
                'kode' => $k['kode'],
            ]);
        }


        $subKriteria = [
            // Sub-kriteria untuk Kriteria C1
            [
                'kriteria_id' => 1, // Kriteria 'Tingkat Pendidikan'
                'kode' => 'C1.1',
                'rentang' => 'SD',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.2',
                'rentang' => 'SMP',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.3',
                'rentang' => 'SMA',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2, // Kriteria 'Kompetensi'
                'kode' => 'C2.1',
                'rentang' => 'Rendah',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.2',
                'rentang' => 'Sedang',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.3',
                'rentang' => 'Tinggi',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-kriteria untuk Kriteria C3
            [
                'kriteria_id' => 3, // Kriteria 'Upaya Fisik dan Tekanan Waktu'
                'kode' => 'C3.1',
                'rentang' => 'Rendah',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.2',
                'rentang' => 'Sedang',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.3',
                'rentang' => 'Tinggi',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-kriteria untuk Kriteria C4
            [
                'kriteria_id' => 4, // Kriteria 'Absensi'
                'kode' => 'C4.1',
                'rentang' => 'Baik',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.2',
                'rentang' => 'Kurang Baik',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Sub-kriteria untuk Kriteria C5
            [
                'kriteria_id' => 5, // Kriteria 'Tanggung Jawab'
                'kode' => 'C5.1',
                'rentang' => 'Tinggi',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 5,
                'kode' => 'C5.2',
                'rentang' => 'Sedang',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 5,
                'kode' => 'C5.3',
                'rentang' => 'Rendah',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Menyimpan data ke tabel sub_kriteria
        // foreach ($subKriteria as $sk) {
        //     SubKriteria::create([
        //         'kriteria_id' => $sk['kriteria_id'],
        //         'kode' => $sk['kode'],
        //         'rentang' => $sk['rentang'],
        //         'bobot' => $sk['bobot'],
        //     ]);
        // }
    }
}
