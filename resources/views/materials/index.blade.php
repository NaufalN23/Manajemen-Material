@extends('layouts.app')

@section('title', 'Daftar Material')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Daftar Material</h1>
    @if(auth()->user()->isAdmin())
        <a href="{{ url('/materials/create/2') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Tambah Material
        </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama Material</th>
                        <th>Stok</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Status</th>
                        @if(auth()->user()->isAdmin())
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($materials as $material)
                        <tr>
                            <td>
                                <code>{{ $material->kode_material }}</code>
                            </td>
                            <td>
                                <strong>{{ $material->nama_material }}</strong>
                                @if($material->deskripsi)
                                    <br><small class="text-muted">{{ Str::limit($material->deskripsi, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold {{ $material->isLowStock() ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($material->stok) }}
                                </span>
                                @if($material->isLowStock())
                                    <br><small class="text-danger">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Stok Menipis
                                    </small>
                                @endif
                            </td>
                            <td>{{ $material->satuan }}</td>
                            <td>Rp {{ number_format($material->harga, 0, ',', '.') }}</td>
                            <td>
                                @if($material->status === 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            @if(auth()->user()->isAdmin())
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('materials.show', $material) }}" class="btn btn-outline-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('materials.edit', $material) }}" class="btn btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('materials.destroy', $material) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus material ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '7' : '6' }}" class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada material tersedia</p>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('materials.create') }}" class="btn btn-primary">
                                        Tambah Material Pertama
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">Kembali</button>
        </div>
        
        {{ $materials->links() }}
    </div>
</div>
@endsection