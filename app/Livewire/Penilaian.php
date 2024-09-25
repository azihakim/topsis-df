<?php

namespace App\Livewire;

use App\Models\Kriteria;
use App\Models\Pelanggan;
use Livewire\Component;

class Penilaian extends Component
{
    public $step = 1;
    public $pelanggans = [];
    public $selectedPelangganList = [];
    public $kriteriaPenilaian = [];
    public $selectedPelanggan;


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

            $this->selectedPelangganList[] =
                [
                    'id' => $selectedPelanggan->id,
                    'nama' => $selectedPelanggan->nama,
                    'no_hp' => $selectedPelanggan->no_hp,
                ];
            $this->selectedPelanggan = '';
        }
    }

    public function getPelangganList() {}


    public function render()
    {
        return view('livewire.penilaian');
    }
}
