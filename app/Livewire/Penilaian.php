<?php

namespace App\Livewire;

use App\Models\Kriteria;
use App\Models\Pelanggan;
use App\Models\Penilaiandb;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Penilaian extends Component
{
    public $step = 1;
    public $pelanggans = [];
    public $selectedPelangganList = [];
    public $kriteriaPenilaian = [];
    public $selectedPelanggan;
    public $penilaianData = [];
    public $bobot = [
        1 => 0.25,
        2 => 0.25,
        3 => 0.25,
        4 => 0.25,
    ];
    public $kriteriaTypes = [
        1 => 'benefit',
        2 => 'benefit',
        3 => 'benefit',
        4 => 'benefit'
    ];


    public function mount()
    {
        $this->getPelanggan();
        $this->getKriteriaPenilaian();
    }

    public function getPelanggan()
    {
        $this->pelanggans = Pelanggan::all();
        $this->dispatch('select2Refresh');
    }

    public function getKriteriaPenilaian()
    {
        $kriteriaPenilaian = Kriteria::with('subKriterias')->get();

        $kriteriaPenilaianArray = $kriteriaPenilaian->toArray();
        // dd($kriteriaPenilaianArray);
        $this->kriteriaPenilaian = $kriteriaPenilaianArray;
        return $this->kriteriaPenilaian;
    }

    public function tambahPelanggan()
    {
        if ($this->selectedPelanggan) {
            $selectedPelanggan = Pelanggan::find($this->selectedPelanggan);

            // Cek apakah pelanggan sudah ada di selectedPelangganList
            $exists = collect($this->selectedPelangganList)->contains('id', $selectedPelanggan->id);

            if (!$exists) {
                $this->selectedPelangganList[] = [
                    'id' => $selectedPelanggan->id,
                    'nama' => $selectedPelanggan->nama,
                    'no_hp' => $selectedPelanggan->no_hp,
                ];
            } else {
                // Tambahkan pesan notifikasi atau feedback jika pelanggan sudah ada
                session()->flash('message', 'Pelanggan sudah ditambahkan.');
            }

            $this->selectedPelanggan = ''; // Reset pilihan
        }
    }




    public function getPenialaianList()
    {
        $penilaianData = [];

        foreach ($this->selectedPelangganList as $pelanggan) {
            $penilaianData[$pelanggan['id']] = [
                'pelanggan_id' => $pelanggan['id'],
                'kriteria' => [],
            ];

            foreach ($this->kriteriaPenilaian as $kriteria) {
                // Ambil nilai bobot yang dipilih dari penilaianData
                $selectedBobot = $this->penilaianData[$pelanggan['id']][$kriteria['kode']] ?? null;

                $penilaianData[$pelanggan['id']]['kriteria'][$kriteria['id']] = [
                    'kriteria_id' => $kriteria['id'],
                    'nilai' => $selectedBobot, // Ini akan menyimpan nilai bobot yang dipilih
                ];
            }
        }

        $this->penilaianData = $penilaianData;
        // $pembagi = $this->calculatePembagi($penilaianData, count($this->kriteriaPenilaian));
        // $matriksTernormalisasi = $this->calculateMatriksTernormalisasi($penilaianData, $pembagi);
        // $matriksTerbobot = $this->calculateMatriksTerbobot($matriksTernormalisasi, $this->bobot);
        // $solusiIdealPositif = $this->calculateSolusiIdealPositif($matriksTerbobot, $this->kriteriaTypes);
        // $solusiIdealNegatif = $this->calculateSolusiIdealNegatif($matriksTerbobot, $this->kriteriaTypes);
        // $calculateJarakSolusi = $this->calculateJarakSolusi($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif);
        // $nilaiPreferensi = $this->calculatePreferensi($calculateJarakSolusi);

        return $penilaianData;
    }

    public function dataHasil()
    {
        $penilaianData = $this->getPenialaianList();
        $pembagi = $this->calculatePembagi($penilaianData, count($this->kriteriaPenilaian));
        $matriksTernormalisasi = $this->calculateMatriksTernormalisasi($penilaianData, $pembagi);
        $matriksTerbobot = $this->calculateMatriksTerbobot($matriksTernormalisasi, $this->bobot);
        $solusiIdealPositif = $this->calculateSolusiIdealPositif($matriksTerbobot, $this->kriteriaTypes);
        $solusiIdealNegatif = $this->calculateSolusiIdealNegatif($matriksTerbobot, $this->kriteriaTypes);
        $calculateJarakSolusi = $this->calculateJarakSolusi($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif);
        $nilaiPreferensi = $this->calculatePreferensi($calculateJarakSolusi);

        $nilaiPreferensiDenganNama = [];
        foreach ($nilaiPreferensi as $pelangganId => $nilai) {
            $pelanggan = Pelanggan::find($pelangganId); // Ambil data pelanggan dari model
            $nilaiPreferensiDenganNama[] = [
                'nama_pelanggan' => $pelanggan->nama ?? 'Tidak Diketahui',
                'nilai_preferensi' => $nilai
            ];
        }

        foreach ($penilaianData as $key => $data) {
            // Query untuk mendapatkan data pelanggan berdasarkan pelanggan_id
            $pelanggan = Pelanggan::find($data['pelanggan_id']);

            // Tambahkan data pelanggan ke array
            if ($pelanggan) {
                $penilaianData[$key]['pelanggan_nama'] = $pelanggan->nama;
            }
        }

        // Loop melalui penilaianData untuk menambahkan kode kriteria
        foreach ($penilaianData as &$pelangganData) {
            foreach ($pelangganData['kriteria'] as $kriteria_id => &$kriteriaData) {
                // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
                $kriteria = Kriteria::find($kriteriaData['kriteria_id']);

                // Jika kriteria ditemukan, tambahkan kode_kriteria ke dalam array
                if ($kriteria) {
                    $kriteriaData['kode_kriteria'] = $kriteria->kode;
                }
            }
        }

        // Loop melalui array pembagi dan tambahkan kode kriteria
        foreach ($pembagi as $kriteria_id => $nilai_pembagi) {
            // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
            $kriteria = Kriteria::find($kriteria_id);

            // Tambahkan kode kriteria ke array jika kriteria ditemukan
            if ($kriteria) {
                $pembagi[$kriteria_id] = [
                    'nilai_pembagi' => $nilai_pembagi,
                    'kode_kriteria' => $kriteria->kode,
                ];
            }
        }

        // Loop melalui array matriksTernormalisasi dan tambahkan nama pelanggan serta kode kriteria
        foreach ($matriksTernormalisasi as $pelanggan_key => $data) {
            // Query untuk mendapatkan nama pelanggan berdasarkan pelanggan_id
            $pelanggan = Pelanggan::find($data['pelanggan_id']);

            // Tambahkan nama pelanggan jika ditemukan
            if ($pelanggan) {
                $matriksTernormalisasi[$pelanggan_key]['nama_pelanggan'] = $pelanggan->nama;
            }

            // Loop melalui kriteria untuk mendapatkan kode kriteria
            foreach ($data['kriteria'] as $kriteria_key => $kriteria_data) {
                $kriteria = Kriteria::find($kriteria_data['kriteria_id']);

                // Tambahkan kode kriteria jika ditemukan
                if ($kriteria) {
                    $matriksTernormalisasi[$pelanggan_key]['kriteria'][$kriteria_key]['kode_kriteria'] = $kriteria->kode;
                }
            }
        }

        // Loop melalui array matriksTerbobot dan tambahkan nama pelanggan serta kode kriteria
        foreach ($matriksTerbobot as $pelanggan_key => $data) {
            // Query untuk mendapatkan nama pelanggan berdasarkan pelanggan_id
            $pelanggan = Pelanggan::find($data['pelanggan_id']);

            // Tambahkan nama pelanggan jika ditemukan
            if ($pelanggan) {
                $matriksTerbobot[$pelanggan_key]['nama_pelanggan'] = $pelanggan->nama;
            }

            // Loop melalui kriteria untuk mendapatkan kode kriteria
            foreach ($data['kriteria'] as $kriteria_key => $kriteria_data) {
                $kriteria = Kriteria::find($kriteria_data['kriteria_id']);

                // Tambahkan kode kriteria jika ditemukan
                if ($kriteria) {
                    $matriksTerbobot[$pelanggan_key]['kriteria'][$kriteria_key]['kode_kriteria'] = $kriteria->kode;
                }
            }
        }

        // Loop melalui solusiIdealPositif dan tambahkan kode kriteria
        foreach ($solusiIdealPositif as $kriteria_id => $nilai) {
            // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
            $kriteria = Kriteria::find($kriteria_id);

            // Tambahkan kode kriteria ke dalam array jika ditemukan
            if ($kriteria) {
                $solusiIdealPositif[$kriteria_id] = [
                    'nilai' => $nilai,
                    'kode_kriteria' => $kriteria->kode
                ];
            }
        }

        // Loop melalui solusiIdealNegatif dan tambahkan kode kriteria
        foreach ($solusiIdealNegatif as $kriteria_id => $nilai) {
            // Query untuk mendapatkan kode kriteria berdasarkan kriteria_id
            $kriteria = Kriteria::find($kriteria_id);

            // Tambahkan kode kriteria ke dalam array jika ditemukan
            if ($kriteria) {
                $solusiIdealNegatif[$kriteria_id] = [
                    'nilai' => $nilai,
                    'kode_kriteria' => $kriteria->kode
                ];
            }
        }

        // Loop melalui calculateJarakSolusi dan tambahkan nama pelanggan
        foreach ($calculateJarakSolusi as $pelanggan_id => $jarak) {
            // Query untuk mendapatkan nama pelanggan berdasarkan pelanggan_id
            $pelanggan = Pelanggan::find($pelanggan_id);

            // Tambahkan nama pelanggan ke dalam array jika ditemukan
            if ($pelanggan) {
                $calculateJarakSolusi[$pelanggan_id]['nama_pelanggan'] = $pelanggan->nama;
            }
        }

        // Sortir array berdasarkan nilai_preferensi dalam urutan menurun
        usort($nilaiPreferensiDenganNama, function ($a, $b) {
            return $b['nilai_preferensi'] <=> $a['nilai_preferensi'];
        });

        // Tambahkan ranking
        foreach ($nilaiPreferensiDenganNama as $index => &$item) {
            $item['ranking'] = $index + 1; // Ranking dimulai dari 1
        }

        // Ensure UTF-8 encoding for all strings in arrays
        array_walk_recursive($penilaianData, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($pembagi, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($matriksTernormalisasi, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($matriksTerbobot, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($solusiIdealPositif, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($solusiIdealNegatif, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($calculateJarakSolusi, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });
        array_walk_recursive($nilaiPreferensiDenganNama, function (&$item, $key) {
            if (is_string($item)) {
                $item = mb_convert_encoding($item, 'UTF-8');
            }
        });

        return [
            'penilaianData' => $penilaianData,
            'pembagi' => $pembagi,
            'matriksTernormalisasi' => $matriksTernormalisasi,
            'matriksTerbobot' => $matriksTerbobot,
            'solusiIdealPositif' => $solusiIdealPositif,
            'solusiIdealNegatif' => $solusiIdealNegatif,
            'calculateJarakSolusi' => $calculateJarakSolusi,
            'nilaiPreferensiDenganNama' => $nilaiPreferensiDenganNama,
        ];
    }

    public function testing()
    {
        $dataHasil = $this->dataHasil();

        // Save all calculation data to the database in one column
        Penilaiandb::create([
            'data_penilaian' => json_encode([
                'penilaianData' => $dataHasil['penilaianData'],
                'pembagi' => $dataHasil['pembagi'],
                'matriksTernormalisasi' => $dataHasil['matriksTernormalisasi'],
                'matriksTerbobot' => $dataHasil['matriksTerbobot'],
                'solusiIdealPositif' => $dataHasil['solusiIdealPositif'],
                'solusiIdealNegatif' => $dataHasil['solusiIdealNegatif'],
                'calculateJarakSolusi' => $dataHasil['calculateJarakSolusi'],
                'nilaiPreferensiDenganNama' => $dataHasil['nilaiPreferensiDenganNama'],
            ]),
            'tgl_penilaian' => now(),
        ]);
    }

    public function generatePDF()
    {
        try {
            $penilaianData = $this->getPenialaianList();
            $pembagi = $this->calculatePembagi($penilaianData, count($this->kriteriaPenilaian));
            $matriksTernormalisasi = $this->calculateMatriksTernormalisasi($penilaianData, $pembagi);
            $matriksTerbobot = $this->calculateMatriksTerbobot($matriksTernormalisasi, $this->bobot);
            $solusiIdealPositif = $this->calculateSolusiIdealPositif($matriksTerbobot, $this->kriteriaTypes);
            $solusiIdealNegatif = $this->calculateSolusiIdealNegatif($matriksTerbobot, $this->kriteriaTypes);
            $calculateJarakSolusi = $this->calculateJarakSolusi($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif);
            $nilaiPreferensi = $this->calculatePreferensi($calculateJarakSolusi);

            $nilaiPreferensiDenganNama = [];
            foreach ($nilaiPreferensi as $pelangganId => $nilai) {
                $pelanggan = Pelanggan::find($pelangganId); // Ambil data pelanggan dari model
                $nilaiPreferensiDenganNama[] = [
                    'nama_pelanggan' => $pelanggan->nama ?? 'Tidak Diketahui',
                    'nilai_preferensi' => $nilai
                ];
            }
            // dd($nilaiPreferensiDenganNama);
            // Mengurutkan nilai preferensi dari yang terbesar ke terkecil
            arsort($nilaiPreferensi);

            // Menambahkan key ranking berdasarkan urutan nilai preferensi
            // $ranking = 1;
            // foreach ($nilaiPreferensi as $pelanggan_id => $nilai) {
            //     $nilaiPreferensi[$pelanggan_id] = [
            //         'nilai' => $nilai,
            //         'ranking' => $ranking++
            //     ];
            // }

            // Ensure UTF-8 encoding for all strings in arrays
            array_walk_recursive($penilaianData, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($pembagi, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($matriksTernormalisasi, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($matriksTerbobot, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($solusiIdealPositif, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($solusiIdealNegatif, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($calculateJarakSolusi, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });
            array_walk_recursive($nilaiPreferensiDenganNama, function (&$item, $key) {
                if (is_string($item)) {
                    $item = mb_convert_encoding($item, 'UTF-8');
                }
            });

            $content = Pdf::loadView('pdf.pdf', compact('penilaianData', 'pembagi', 'matriksTernormalisasi', 'matriksTerbobot', 'solusiIdealPositif', 'solusiIdealNegatif', 'calculateJarakSolusi', 'nilaiPreferensiDenganNama'))
                ->setPaper('a4', 'landscape'); // Set the paper orientation to landscape

            // $content->stream('Hasil_Penilaian_' . now()->format('Ymd_His') . '.pdf');

            // Save the PDF to storage
            $fileName = 'Hasil_Penilaian_' . now()->format('Ymd_His') . '.pdf';
            $filePath = storage_path('app/public/' . $fileName);
            $content->save($filePath);
            Penilaiandb::create([
                'tgl_penilaian' => now(),
                'penilaian' => $fileName,
            ]);
            session()->flash('message', 'PDF berhasil disimpan di storage.');
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat menghasilkan PDF. Silakan coba lagi.');
            return redirect()->back();
        }
    }

    public function storeData()
    {
        $this->generatePDF();
        return redirect()->route('penilaian.index');
    }

    function calculatePembagi($data, $jumlah_kriteria)
    {
        // Inisialisasi array untuk menampung nilai pembagi tiap kriteria
        $pembagi = array_fill(1, $jumlah_kriteria, 0);

        // Loop melalui setiap pelanggan dan kumpulkan nilai kuadrat untuk setiap kriteria
        foreach ($data as $pelanggan) {
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                // Tambahkan nilai kuadrat untuk kriteria tertentu
                $pembagi[$kriteria_id] += pow($kriteria['nilai'], 2);
            }
        }

        // Hitung akar kuadrat dari penjumlahan kuadrat tiap kriteria
        foreach ($pembagi as $kriteria_id => $total_nilai_kuadrat) {
            $pembagi[$kriteria_id] = sqrt($total_nilai_kuadrat);
        }

        return $pembagi;
    }
    public function calculateMatriksTernormalisasi($penilaianData, $pembagi)
    {
        // Inisialisasi array untuk menampung matriks ternormalisasi
        $matriksTernormalisasi = [];

        // Iterasi melalui setiap pelanggan dan nilai kriteria mereka
        foreach ($penilaianData as $pelanggan_id => $pelanggan) {
            // Buat array untuk menyimpan nilai ternormalisasi dari pelanggan ini
            $matriksTernormalisasi[$pelanggan_id] = [
                'pelanggan_id' => $pelanggan_id,
                'kriteria' => [],
            ];

            // Iterasi melalui setiap kriteria untuk pelanggan ini
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                $nilai = $kriteria['nilai'];

                // Lakukan normalisasi nilai dengan membaginya oleh pembagi yang sesuai
                $nilaiTernormalisasi = ($pembagi[$kriteria_id] != 0) ? $nilai / $pembagi[$kriteria_id] : 0;

                // Simpan nilai yang sudah ternormalisasi
                $matriksTernormalisasi[$pelanggan_id]['kriteria'][$kriteria_id] = [
                    'kriteria_id' => $kriteria_id,
                    'nilai_ternormalisasi' => $nilaiTernormalisasi,
                ];
            }
        }

        return $matriksTernormalisasi;
    }
    public function calculateMatriksTerbobot($matriksTernormalisasi, $bobot)
    {
        // Inisialisasi array untuk menyimpan matriks terbobot (Y)
        $matriksTerbobot = [];

        // Iterasi setiap pelanggan
        foreach ($matriksTernormalisasi as $pelanggan_id => $pelanggan) {
            $matriksTerbobot[$pelanggan_id] = [
                'pelanggan_id' => $pelanggan_id,
                'kriteria' => [],
            ];

            // Iterasi setiap kriteria untuk menghitung nilai terbobot
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                $nilai_ternormalisasi = $kriteria['nilai_ternormalisasi'];

                // Hitung nilai terbobot dengan mengalikan nilai ternormalisasi dengan bobot kriteria
                $nilaiTerbobot = $nilai_ternormalisasi * $bobot[$kriteria_id];

                // Simpan hasil nilai terbobot
                $matriksTerbobot[$pelanggan_id]['kriteria'][$kriteria_id] = [
                    'kriteria_id' => $kriteria_id,
                    'nilai_terbobot' => $nilaiTerbobot,
                ];
            }
        }

        return $matriksTerbobot;
    }
    public function calculateSolusiIdealPositif($matriksTerbobot, $kriteriaTypes)
    {
        // Inisialisasi array untuk menyimpan solusi ideal positif
        $solusiIdealPositif = [];

        // Iterasi setiap kriteria
        foreach ($kriteriaTypes as $kriteria_id => $type) {
            $nilaiKriteria = [];

            // Ambil semua nilai terbobot untuk kriteria ini
            foreach ($matriksTerbobot as $pelanggan) {
                $nilaiKriteria[] = $pelanggan['kriteria'][$kriteria_id]['nilai_terbobot'];
            }

            // Jika tipe kriteria adalah 'benefit', ambil nilai maksimum
            if ($type == 'benefit') {
                $solusiIdealPositif[$kriteria_id] = max($nilaiKriteria);
            }
            // Jika tipe kriteria adalah 'cost', ambil nilai minimum
            else if ($type == 'cost') {
                $solusiIdealPositif[$kriteria_id] = min($nilaiKriteria);
            }
        }

        return $solusiIdealPositif;
    }
    public function calculateSolusiIdealNegatif($matriksTerbobot, $kriteriaTypes)
    {
        // Inisialisasi array untuk menyimpan solusi ideal negatif
        $solusiIdealNegatif = [];

        // Iterasi setiap kriteria
        foreach ($kriteriaTypes as $kriteria_id => $type) {
            $nilaiKriteria = [];

            // Ambil semua nilai terbobot untuk kriteria ini
            foreach ($matriksTerbobot as $pelanggan) {
                $nilaiKriteria[] = $pelanggan['kriteria'][$kriteria_id]['nilai_terbobot'];
            }

            // Jika tipe kriteria adalah 'benefit', ambil nilai minimum
            if ($type == 'benefit') {
                $solusiIdealNegatif[$kriteria_id] = min($nilaiKriteria);
            }
            // Jika tipe kriteria adalah 'cost', ambil nilai maksimum
            else if ($type == 'cost') {
                $solusiIdealNegatif[$kriteria_id] = max($nilaiKriteria);
            }
        }

        return $solusiIdealNegatif;
    }
    public function calculateJarakSolusi($matriksTerbobot, $solusiIdealPositif, $solusiIdealNegatif)
    {
        // Inisialisasi array untuk menyimpan jarak solusi
        $jarakSolusi = [];

        // Iterasi melalui setiap alternatif (pelanggan)
        foreach ($matriksTerbobot as $pelanggan_id => $pelanggan) {
            $sumPositif = 0; // Untuk menyimpan penjumlahan kuadrat selisih ke solusi ideal positif
            $sumNegatif = 0; // Untuk menyimpan penjumlahan kuadrat selisih ke solusi ideal negatif

            // Iterasi setiap kriteria
            foreach ($pelanggan['kriteria'] as $kriteria_id => $kriteria) {
                // Ambil nilai terbobot
                $nilaiTerbobot = $kriteria['nilai_terbobot'];

                // Hitung selisih kuadrat dengan solusi ideal positif
                $sumPositif += pow($nilaiTerbobot - $solusiIdealPositif[$kriteria_id], 2);

                // Hitung selisih kuadrat dengan solusi ideal negatif
                $sumNegatif += pow($nilaiTerbobot - $solusiIdealNegatif[$kriteria_id], 2);
            }

            // Hitung akar kuadrat dari penjumlahan kuadrat selisih
            $jarakSolusi[$pelanggan_id] = [
                'jarakPositif' => sqrt($sumPositif),
                'jarakNegatif' => sqrt($sumNegatif),
            ];
        }

        return $jarakSolusi;
    }
    public function calculatePreferensi($jarakSolusi)
    {
        $nilaiPreferensi = [];

        foreach ($jarakSolusi as $pelanggan_id => $jarak) {
            $jarakPositif = $jarak['jarakPositif'];
            $jarakNegatif = $jarak['jarakNegatif'];

            // Hitung nilai preferensi (V)
            $nilaiPreferensi[$pelanggan_id] = $jarakNegatif / ($jarakPositif + $jarakNegatif);
        }

        return $nilaiPreferensi;
    }






    public function render()
    {
        return view('livewire.penilaian');
    }
}
