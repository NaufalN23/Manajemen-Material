@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Pengembalian Material</h3>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('material-returns.update', $materialReturn->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="material_id" class="form-label">Pilih Material</label>
                    <select name="material_id" id="material_id" class="form-control" required>
                        <option value="">-- Pilih Material --</option>
                        @foreach($materials as $material)
                            <option value="{{ $material->id }}" 
                                {{ $materialReturn->material_id == $material->id ? 'selected' : '' }}>
                                {{ $material->nama_material }}
                            </option>
                        @endforeach
                    </select>
                    @error('material_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="jumlah_dikembalikan" class="form-label">Jumlah Dikembalikan</label>
                    <input type="number" name="jumlah_dikembalikan" id="jumlah_dikembalikan" 
                           class="form-control" required min="1"
                           value="{{ old('jumlah_dikembalikan', $materialReturn->jumlah_dikembalikan) }}">
                    @error('jumlah_dikembalikan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kondisi_material" class="form-label">Kondisi Material</label>
                    <textarea name="kondisi_material" id="kondisi_material" 
                              class="form-control" required>{{ old('kondisi_material', $materialReturn->kondisi_material) }}</textarea>
                    @error('kondisi_material')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" 
                              class="form-control">{{ old('keterangan', $materialReturn->keterangan) }}</textarea>
                    @error('keterangan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('material-returns.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
