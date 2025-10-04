<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialRequest;
use Illuminate\Http\Request;

class MaterialRequestController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $requests = MaterialRequest::with(['user', 'material'])->paginate(10);
        } else {
            $requests = MaterialRequest::with('material')
                ->where('user_id', $user->id)
                ->paginate(10);
        }
        
        return view('material_requests.index', compact('requests'));
    }

    public function create()
    {
        $materials = Material::where('status', 'aktif')->get();
        return view('material_requests.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_id' => 'required|exists:materials,id',
            'jumlah_diminta' => 'required|integer|min:1',
            'keterangan' => 'nullable',
        ]);

        $validated['user_id'] = auth()->id();

        MaterialRequest::create($validated);
        return redirect()->route('material-requests.index')->with('success', 'Permintaan material berhasil dibuat');
    }

    // ✅ FIX show pakai snake_case
    public function show(MaterialRequest $material_request)
    {
        return view('material_requests.show', compact('material_request'));
    }

    public function approve(Request $request, MaterialRequest $material_request)
    {
        $validated = $request->validate([
            'jumlah_disetujui' => 'required|integer|min:1',
            'keterangan' => 'nullable',
        ]);

        //dd($material_request);
        $material = $material_request->material;
        
        if ($validated['jumlah_disetujui'] > $request->stok) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        MaterialRequest::where('id',$request->rowid)->update([
            'jumlah_disetujui' => $validated['jumlah_disetujui'],
            'keterangan' => $validated['keterangan'],
            'status' => 'disetujui',
            'tanggal_persetujuan' => now(),
            'approved_by' => auth()->id(),
        ]);

        // $material_request->update([
        //     'jumlah_disetujui' => $validated['jumlah_disetujui'],
        //     'keterangan' => $validated['keterangan'],
        //     'status' => 'disetujui',
        //     'tanggal_persetujuan' => now(),
        //     'approved_by' => auth()->id(),
        // ]);

        //$material->decrement('stok', $validated['jumlah_disetujui']);

        return redirect()->route('material-requests.index')->with('success', 'Permintaan berhasil disetujui');
    }

    public function reject(Request $request, MaterialRequest $material_request)
    {
        $validated = $request->validate([
            'keterangan' => 'required',
        ]);

        MaterialRequest::where('id',$request->rowid)->update([
            'keterangan' => $validated['keterangan'],
            'status' => 'ditolak',
            'tanggal_persetujuan' => now(),
            'approved_by' => auth()->id(),
        ]);

        // $material_request->update([
        //     'keterangan' => $validated['keterangan'],
        //     'status' => 'ditolak',
        //     'tanggal_persetujuan' => now(),
        //     'approved_by' => auth()->id(),
        // ]);

        return redirect()->route('material-requests.index')->with('success', 'Permintaan berhasil ditolak');
    }
}
