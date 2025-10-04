@extends('layouts.app')

@section('title', 'Permintaan Material')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        @if(auth()->user()->isAdmin())
            Kelola Permintaan Material
        @else
            Permintaan Material Saya
        @endif
    </h1>
    @if(auth()->user()->isTeknisi())
        <a href="{{ route('material-requests.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i>
            Buat Permintaan
        </a>
    @endif
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No. Permintaan</th>
                        @if(auth()->user()->isAdmin())
                            <th>Pemohon</th>
                        @endif
                        <th>Material</th>
                        <th>Jumlah Diminta</th>
                        <th>Jumlah Disetujui</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>
                                <code>{{ $request->nomor_permintaan }}</code>
                            </td>
                            @if(auth()->user()->isAdmin())
                                <td>{{ $request->user->name }}</td>
                            @endif
                            <td>
                                <strong>{{ $request->material->nama_material }}</strong>
                                <br><small class="text-muted">{{ $request->material->kode_material }}</small>
                            </td>
                            <td>{{ number_format($request->jumlah_diminta) }} {{ $request->material->satuan }}</td>
                            <td>
                                @if($request->jumlah_disetujui)
                                    {{ number_format($request->jumlah_disetujui) }} {{ $request->material->satuan }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @switch($request->status)
                                    @case('pending')
                                        <span class="badge bg-warning">Menunggu Persetujuan</span>
                                        @break
                                    @case('disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                        @break
                                    @case('ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $request->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('material-requests.show', $request) }}" class="btn btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(auth()->user()->isAdmin() && $request->status === 'pending')
                                        <button type="button" class="btn btn-outline-success" 
                                                data-bs-toggle="modal" data-bs-target="#approveModal{{ $request->id }}">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" 
                                                data-bs-toggle="modal" data-bs-target="#rejectModal{{ $request->id }}">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @if(auth()->user()->isAdmin() && $request->status === 'pending')
                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Setujui Permintaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('material-requests.approve', $request) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="rowid" id="rowid" value="{{ $request->id }}">
                                            <input type="hidden" name="materialid" id="materialid" value="{{ $request->material_id }}">
                                            <input type="hidden" name="stok" id="stok" value="{{ $request->material->stok }}">
                                            <div class="modal-body">
                                                <p>Permintaan: <strong>{{ $request->material->nama_material }}</strong></p>
                                                <p>Diminta: <strong>{{ number_format($request->jumlah_diminta) }} {{ $request->material->satuan }}</strong></p>
                                                <p>Stok Tersedia: <strong>{{ number_format($request->material->stok) }} {{ $request->material->satuan }}</strong></p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Jumlah yang Disetujui</label>
                                                    <input type="number" name="jumlah_disetujui" class="form-control" 
                                                           value="{{ $request->jumlah_diminta }}" 
                                                           min="1" max="{{ min($request->jumlah_diminta, $request->material->stok) }}" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Keterangan (Opsional)</label>
                                                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">Setujui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $request->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tolak Permintaan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('material-requests.reject', $request) }}" method="POST">
                                            @csrf

                                            <input type="hidden" name="rowid" id="rowid" value="{{ $request->id }}">
                                            

                                            <div class="modal-body">
                                                <p>Anda akan menolak permintaan: <strong>{{ $request->material->nama_material }}</strong></p>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Alasan Penolakan</label>
                                                    <textarea name="keterangan" class="form-control" rows="3" required 
                                                              placeholder="Berikan alasan penolakan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->isAdmin() ? '8' : '7' }}" class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada permintaan material</p>
                                @if(auth()->user()->isTeknisi())
                                    <a href="{{ route('material-requests.create') }}" class="btn btn-primary">
                                        Buat Permintaan Pertama
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
                <div class="text-end">
            <a class="btn btn-primary"href="{{ route('dashboard') }}">Kembali</a>
        </div>

        {{ $requests->links() }}
    </div>
</div>
@endsection