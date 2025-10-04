@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Dashboard Admin</h1>
    <div class="text-muted">
        <i class="fas fa-calendar-alt me-1"></i>
        {{ now()->format('d F Y') }}
    </div>
</div>




<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Total Material</h5>
                        <h2 class="mb-0">{{ $totalMaterials }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-boxes fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Stok Menipis</h5>
                        <h2 class="mb-0">{{ $lowStockMaterials }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Permintaan Pending</h5>
                        <h2 class="mb-0">{{ $pendingRequests }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h5 class="card-title">Pengembalian Pending</h5>
                        <h2 class="mb-0">{{ $pendingReturns }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-undo fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-list me-2"></i>
                    Permintaan Terbaru
                </h5>
            </div>
            <div class="card-body">
                @forelse($recentRequests as $request)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $request->material->nama_material }}</h6>
                            <small class="text-muted">
                                Oleh: {{ $request->user->name }} | 
                                Jumlah: {{ $request->jumlah_diminta }} {{ $request->material->satuan }}
                            </small>
                        </div>
                        <div>
                            @if($request->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($request->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Belum ada permintaan</p>
                @endforelse
                
                <div class="text-center mt-3">
                    <a href="{{ route('material-requests.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua Permintaan
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Pengembalian Terbaru
                </h5>
            </div>
            <div class="card-body">
                @forelse($recentReturns as $return)
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $return->material->nama_material }}</h6>
                            <small class="text-muted">
                                Oleh: {{ $return->user->name }} | 
                                Jumlah: {{ $return->jumlah_dikembalikan }} {{ $return->material->satuan }}
                            </small>
                        </div>
                        <div>
                            @if($return->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($return->status === 'diterima')
                                <span class="badge bg-success">Diterima</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Belum ada pengembalian</p>
                @endforelse
                
                <div class="text-center mt-3">
                    <a href="{{ route('material-returns.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua Pengembalian
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

