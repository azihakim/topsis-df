<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Penilaiandb;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{

    public function generatePdf($id)
    {
        // Ambil data penilaian dari database
        $penilaian = Penilaiandb::select('data_penilaian')->find($id);

        // Decode JSON menjadi array PHP
        $data = json_decode($penilaian->data_penilaian, true);
        // dd($data);
        // Inisialisasi DomPDF
        $pdf = app('dompdf.wrapper');

        // Load view dengan data penilaian yang sudah di-decode
        $pdf->loadView('pdf.pdf', compact('data'));

        // Return PDF stream
        return $pdf->stream('pdf.pdf');
    }


    public function index()
    {
        // Mengambil semua penilaian dan mengelompokkannya berdasarkan divisi
        $data = Penilaiandb::all();

        // dd($data);
        return view('penilaian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penilaian.penilaian');
    }

    /**
     * Display the specified resource.
     */
    public function show($divisi, $tgl_penilaian)
    {
        $penilaian = PenilaianDb::with('karyawans')->where('divisi', $divisi)
            ->where('tgl_penilaian', $tgl_penilaian)
            ->get();
        // dd($penilaian);
        return view('penilaian.show', compact('penilaian', 'divisi', 'tgl_penilaian'));
    }

    public function destroy($divisi, $tgl_penilaian)
    {
        Penilaiandb::where('divisi', $divisi)
            ->where('tgl_penilaian', $tgl_penilaian)
            ->delete();

        return redirect()->route('penilaian.index')->with('error', 'Penilaian berhasil dihapus');
    }
}
