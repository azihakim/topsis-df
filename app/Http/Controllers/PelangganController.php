<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Pelanggan::all();
        return view('pelanggan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = new Pelanggan();
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->save();
        return redirect()->route('pelanggan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Pelanggan::find($id);
        return view('pelanggan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = Pelanggan::find($id);
        $data->nama = $request->nama;
        $data->no_hp = $request->no_hp;
        $data->save();

        return redirect()->route('pelanggan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Pelanggan::find($id)->first();
        $data->delete();
        return redirect()->route('pelanggan.index');
    }
}
