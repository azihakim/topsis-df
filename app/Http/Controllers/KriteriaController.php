<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Penilaiandb;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datakriteria = Kriteria::all();
        // Ambil data penilaian dari database
        $penilaian = Penilaiandb::latest('data_penilaian')->first();

        if ($penilaian) {
            // Decode JSON menjadi array PHP
            $data = json_decode($penilaian->data_penilaian, true);
        } else {
            $data = [];
        }

        return view('kriteria.index', compact('datakriteria', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kriteria.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Validasi data yang diterima dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required',
            'bobot' => 'required',
        ]);

        // Simpan data kriteria
        Kriteria::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'bobot' => $request->bobot,
        ]);

        // Redirect atau tampilkan pesan sukses jika berhasil disimpan
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Kriteria $kriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Kriteria::find($id);
        return view('kriteria.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Kriteria::find($id);
        $data->nama = $request->nama;
        $data->kode = $request->kode;
        $data->bobot = $request->bobot;
        $data->save();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kriteria = Kriteria::find($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
