@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white">
            <h4>Form Pengembalian Material</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('material-returns.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="material_id" class="form-label">Pilih Material</label>
                    <select name="material_id" id="material_id" class="form-control" required>
                        <option value="">-- Pilih Material --</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}">{{ $material->nama_material }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Dikembalikan</label>
                    <input type="number" name="jumlah_dikembalikan" id="jumlah_dikembalikan" class="form-control" required min="1">
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Kondisi material</label>
                    <textarea name="kondisi_material" id="kondisi_material" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('material-returns.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Batal
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
