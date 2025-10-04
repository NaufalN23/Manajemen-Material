@extends('layouts.app')
@section('title', 'Dashboard Teknisi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard Teknisi</h1>
    <div class="text-muted">
        <i class="fas fa-calendar-alt me-1"></i>
        {{ now()->format('d F Y') }}
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Total Permintaan</h5>
                        <h2 class="mb-0">{{ $myRequests }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-clipboard-list fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Total Pengembalian</h5>
                        <h2 class="mb-0">{{ $myReturns }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-undo fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Pending</h5>
                        <h2 class="mb-0">{{ $pendingRequests }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                <h5>Ajukan Permintaan Material</h5>
                <p class="text-muted">Buat permintaan material baru untuk kebutuhan proyek</p>
                <a href="{{ route('material-requests.create') }}" class="btn btn-primary">
                    Buat Permintaan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-arrow-left fa-3x text-success mb-3"></i>
                <h5>Kembalikan Material</h5>
                <p class="text-muted">Lakukan pengembalian material yang sudah tidak digunakan</p>
                <a href="{{ route('material-returns.create') }}" class="btn btn-success">
                    Kembalikan Material
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Requests -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-history me-2"></i>
            Permintaan Terbaru Saya
        </h5>
    </div>
    <div class="card-body">
        @forelse($recentRequests as $request)
            <div class="d-flex align-items-center justify-content-between mb-3 p-3 bg-light rounded">
                <div>
                    <h6 class="mb-1">{{ $request->material->nama_material }}</h6>
                    <small class="text-muted">
                        Nomor: {{ $request->nomor_permintaan }} | 
                        Jumlah: {{ $request->jumlah_diminta }} {{ $request->material->satuan }} |
                        {{ $request->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                <div>
                    @if($request->status === 'pending')
                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                    @elseif($request->status === 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada permintaan material</p>
                <a href="{{ route('material-requests.create') }}" class="btn btn-primary">
                    Buat Permintaan Pertama
                </a>
            </div>
        @endforelse
        
        @if($recentRequests->count() > 0)
            <div class="text-center mt-3">
                <a href="{{ route('material-requests.index') }}" class="btn btn-outline-primary">
                    Lihat Semua Permintaan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection