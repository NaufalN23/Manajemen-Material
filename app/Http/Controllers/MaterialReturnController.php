<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialReturn;
use Illuminate\Http\Request;

class MaterialReturnController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $returns = MaterialReturn::with(['user', 'material'])->paginate(10);
        } else {
            $returns = MaterialReturn::with('material')
                ->where('user_id', $user->id)
                ->paginate(10);
        }
        
        return view('material_returns.index', compact('returns'));
    }

    public function create()
    {
        $materials = Material::where('status', 'aktif')->get();
        return view('material_returns.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'jumlah_dikembalikan' => 'required|integer|min:1',
            'kondisi_material' => 'required',
            'keterangan' => 'nullable',
        ]);

        $validated['user_id'] = auth()->id();

        MaterialReturn::create($validated);
        return redirect()->route('material-returns.index')->with('success', 'Pengembalian material berhasil dibuat');
    }

    public function show(MaterialReturn $materialReturn)
    {
        return view('material_returns.show', compact('materialReturn'));
    }

    public function edit(MaterialReturn $materialReturn)
    {
        // Ambil hanya material yang aktif
        $materials = Material::where('status', 'aktif')->get();
        return view('material_returns.edit', compact('materialReturn', 'materials'));
    }

    public function update(Request $request, MaterialReturn $materialReturn)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'jumlah_dikembalikan' => 'required|integer|min:1',
            'kondisi_material' => 'required',
            'keterangan' => 'nullable',
        ]);

        $materialReturn->update($validated);

        return redirect()->route('material-returns.index')->with('success', 'Data pengembalian berhasil diperbarui');
    }

    public function destroy(MaterialReturn $materialReturn)
    {
        $materialReturn->delete();
        return redirect()->route('material-returns.index')->with('success', 'Data pengembalian berhasil dihapus');
    }

    public function accept(Request $request, MaterialReturn $materialReturn)
    {
        $materialReturn->update([
            'status' => 'diterima',
            'received_by' => auth()->id(),
        ]);

        $materialReturn->material->increment('stok', $materialReturn->jumlah_dikembalikan);

        return redirect()->route('material-returns.index')->with('success', 'Pengembalian berhasil diterima');
    }

    public function reject(Request $request, MaterialReturn $materialReturn)
    {
        $validated = $request->validate([
            'keterangan' => 'required',
        ]);

        $materialReturn->update([
            'status' => 'ditolak',
            'keterangan' => $materialReturn->keterangan . ' | Admin: ' . $validated['keterangan'],
            'received_by' => auth()->id(),
        ]);

        return redirect()->route('material-returns.index')->with('success', 'Pengembalian berhasil ditolak');
    }
}
