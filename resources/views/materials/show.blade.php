@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Material</h3>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label"><strong>Kode Material</strong></label>
                <input type="text" class="form-control" value="{{ $material->kode_material }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Nama Material</strong></label>
                <input type="text" class="form-control" value="{{ $material->nama_material }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Deskripsi</strong></label>
                <textarea class="form-control" rows="2" readonly>{{ $material->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Satuan</strong></label>
                <input type="text" class="form-control" value="{{ $material->satuan }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Stok</strong></label>
                <input type="number" class="form-control" value="{{ $material->stok }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Minimum Stok</strong></label>
                <input type="number" class="form-control" value="{{ $material->minimum_stok }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Harga</strong></label>
                <input type="text" class="form-control" value="Rp {{ number_format($material->harga, 0, ',', '.') }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Lokasi Penyimpanan</strong></label>
                <input type="text" class="form-control" value="{{ $material->lokasi_penyimpanan }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Status</strong></label>
                <input type="text" class="form-control" value="{{ ucfirst($material->status) }}" readonly>
            </div>

            <a href="{{ route('materials.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
</div>
@endsection
