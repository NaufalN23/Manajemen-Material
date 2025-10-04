<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_material' => 'required|unique:materials',
            'nama_material' => 'required',
            'deskripsi' => 'nullable',
            'satuan' => 'required',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable',
        ]);

        Material::create($validated);
        return redirect()->route('materials.index')->with('success', 'Material berhasil ditambahkan');
    }

    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'kode_material' => 'required|unique:materials,kode_material,' . $material->id,
            'nama_material' => 'required',
            'deskripsi' => 'nullable',
            'satuan' => 'required',
            'stok' => 'required|integer|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $material->update($validated);
        return redirect()->route('materials.index')->with('success', 'Material berhasil diperbarui');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus');
    }
}