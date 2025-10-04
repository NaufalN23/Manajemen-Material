@extends('layouts.app')
@section('title', 'Buat Permintaan Material')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Buat Permintaan Material</h1>
    <a href="{{ route('material-requests.index') }}" class="btn btn-secondary">
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
                    Form Permintaan Material
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('material-requests.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="material_id" class="form-label">Pilih Material</label>
                        <select class="form-select @error('material_id') is-invalid @enderror" 
                                id="material_id" name="material_id" required>
                            <option value="">-- Pilih Material --</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" 
                                        {{ old('material_id') == $material->id ? 'selected' : '' }}
                                        data-stok="{{ $material->stok }}" 
                                        data-satuan="{{ $material->satuan }}">
                                    {{ $material->kode_material }} - {{ $material->nama_material }} 
                                    (Stok: {{ number_format($material->stok) }} {{ $material->satuan }})
                                </option>
                            @endforeach
                        </select>
                        @error('material_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="jumlah_diminta" class="form-label">Jumlah yang Diminta</label>
                        <div class="input-group">
                            <input type="number" class="form-control @error('jumlah_diminta') is-invalid @enderror" 
                                   id="jumlah_diminta" name="jumlah_diminta" value="{{ old('jumlah_diminta') }}" 
                                   min="1" placeholder="0" required>
                            <span class="input-group-text" id="satuan-text">satuan</span>
                        </div>
                        <small class="form-text text-muted">
                            <span id="stok-info">Pilih material terlebih dahulu untuk melihat stok tersedia</span>
                        </small>
                        @error('jumlah_diminta')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan/Keperluan</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="3" 
                                  placeholder="Jelaskan kebutuhan atau project yang memerlukan material ini...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('material-requests.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-1"></i>
                            Kirim Permintaan
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
                    Panduan Permintaan
                </h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Pilih material yang tersedia
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Pastikan jumlah tidak melebihi stok
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Jelaskan keperluan dengan detail
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Tunggu persetujuan dari admin
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Status Permintaan
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-warning me-2">Pending</span>
                    <small>Menunggu review admin</small>
                </div>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge bg-success me-2">Disetujui</span>
                    <small>Material siap diambil</small>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-danger me-2">Ditolak</span>
                    <small>Permintaan tidak disetujui</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('material_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const stok = selectedOption.dataset.stok;
    const satuan = selectedOption.dataset.satuan;
    const jumlahInput = document.getElementById('jumlah_diminta');
    const satuanText = document.getElementById('satuan-text');
    const stokInfo = document.getElementById('stok-info');
    
    if (selectedOption.value) {
        jumlahInput.max = stok;
        satuanText.textContent = satuan;
        stokInfo.textContent = `Stok tersedia: ${parseInt(stok).toLocaleString()} ${satuan}`;
    } else {
        jumlahInput.max = '';
        satuanText.textContent = 'satuan';
        stokInfo.textContent = 'Pilih material terlebih dahulu untuk melihat stok tersedia';
    }
});
</script>
@endsection