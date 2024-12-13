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
        User::create([
            'name' => 'Admin',
            'role' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('123'),
        ]);

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
                'nama' => 'Jumlah Pesanan',
                'kode' => 'C1',
                'bobot' => 0.25,
            ],
            [
                'nama' => 'Lama Berlangganan',
                'kode' => 'C2',
                'bobot' => 0.25,
            ],
            [
                'nama' => 'Jumlah Pembayaran',
                'kode' => 'C3',
                'bobot' => 0.25,
            ],
            [
                'nama' => 'Riwayat Pembayaran',
                'kode' => 'C4',
                'bobot' => 0.25,
            ],
        ];

        foreach ($kriteria as $k) {
            Kriteria::create([
                'nama' => $k['nama'],
                'kode' => $k['kode'],
                'bobot' => $k['bobot'],
            ]);
        }


        $subKriteria = [
            // Sub-kriteria untuk Kriteria C1
            [
                'kriteria_id' => 1, // Kriteria 'Jumlah Pesanan'
                'kode' => 'C1.1',
                'rentang' => '1-10',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.2',
                'rentang' => '11-20',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.3',
                'rentang' => '21-30',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.4',
                'rentang' => '31-40',
                'bobot' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.5',
                'rentang' => '41-50',
                'bobot' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 1,
                'kode' => 'C1.6',
                'rentang' => 'lebih dari 50',
                'bobot' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Sub-kriteria untuk Kriteria C2
            [
                'kriteria_id' => 2, // Kriteria 'Lama Berlangganan'
                'kode' => 'C2.1',
                'rentang' => '1-6 bulan',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.2',
                'rentang' => '7-12 bulan',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.3',
                'rentang' => '13-18 bulan',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.4',
                'rentang' => '19-24 bulan',
                'bobot' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.5',
                'rentang' => '25-30 bulan',
                'bobot' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 2,
                'kode' => 'C2.6',
                'rentang' => 'lebih dari 30 bulan',
                'bobot' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Sub-kriteria untuk Kriteria C3
            [
                'kriteria_id' => 3, // Kriteria 'Jumlah Pembayaran'
                'kode' => 'C3.1',
                'rentang' => '1-100 ribu',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.2',
                'rentang' => '101-200 ribu',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.3',
                'rentang' => '201-300 ribu',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.4',
                'rentang' => '301-400 ribu',
                'bobot' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.5',
                'rentang' => '401-500 ribu',
                'bobot' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 3,
                'kode' => 'C3.6',
                'rentang' => 'lebih dari 500 ribu',
                'bobot' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Sub-kriteria untuk Kriteria C4
            [
                'kriteria_id' => 4, // Kriteria 'Riwayat Pembayaran'
                'kode' => 'C4.1',
                'rentang' => 'Tidak Pernah Telat',
                'bobot' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.2',
                'rentang' => 'Kadang-kadang Telat',
                'bobot' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.3',
                'rentang' => 'Sering Telat',
                'bobot' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.4',
                'rentang' => 'Selalu Telat',
                'bobot' => '4',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.5',
                'rentang' => 'Sangat Sering Telat',
                'bobot' => '5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kriteria_id' => 4,
                'kode' => 'C4.6',
                'rentang' => 'Hampir Selalu Telat',
                'bobot' => '6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($subKriteria as $sk) {
            SubKriteria::create([
                'kriteria_id' => $sk['kriteria_id'],
                'kode' => $sk['kode'],
                'rentang' => $sk['rentang'],
                'bobot' => $sk['bobot'],
                'created_at' => $sk['created_at'],
                'updated_at' => $sk['updated_at'],
            ]);
        }
    }
}
