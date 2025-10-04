@extends('layouts.app')

@section('title', 'Tambah Material')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Tambah Material Baru</h1>
    <a href="{{ route('materials.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i>
        Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Form Tambah Material
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('materials.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="kode_material" class="form-label">Kode Material</label>
                                <input type="text" class="form-control @error('kode_material') is-invalid @enderror" 
                                       id="kode_material" name="kode_material" value="{{ old('kode_material') }}" 
                                       placeholder="Contoh: MAT001">
                                @error('kode_material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_material" class="form-label">Nama Material</label>
                                <input type="text" class="form-control @error('nama_material') is-invalid @enderror" 
                                       id="nama_material" name="nama_material" value="{{ old('nama_material') }}"
                                       placeholder="Nama material">
                                @error('nama_material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="3" 
                                  placeholder="Deskripsi detail material">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="satuan" class="form-label">Satuan</label>
                                <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                       id="satuan" name="satuan" value="{{ old('satuan') }}"
                                       placeholder="Contoh: pcs, meter, kg">
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" name="harga" value="{{ old('harga') }}" min="0" step="0.01"
                                       placeholder="0">
                                @error('harga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stok" class="form-label">Stok Awal</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                       id="stok" name="stok" value="{{ old('stok', 0) }}" min="0"
                                       placeholder="0">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="minimum_stok" class="form-label">Minimum Stok</label>
                                <input type="number" class="form-control @error('minimum_stok') is-invalid @enderror" 
                                       id="minimum_stok" name="minimum_stok" value="{{ old('minimum_stok', 0) }}" min="0"
                                       placeholder="0">
                                @error('minimum_stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="lokasi_penyimpanan" class="form-label">Lokasi Penyimpanan</label>
                        <input type="text" class="form-control @error('lokasi_penyimpanan') is-invalid @enderror" 
                               id="lokasi_penyimpanan" name="lokasi_penyimpanan" value="{{ old('lokasi_penyimpanan') }}"
                               placeholder="Contoh: Gudang A, Rak 1">
                        @error('lokasi_penyimpanan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('materials.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>
                            Simpan Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Panduan
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Kode Material:</strong> Harus unik dan mudah diingat
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Stok Minimum:</strong> Batas peringatan stok habis
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        <strong>Lokasi:</strong> Memudahkan pencarian material
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection