@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h4>Detail Permintaan Material</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Nomor Permintaan</th>
                    <td>{{ $material_request->nomor_permintaan }}</td>
                </tr>
                <tr>
                    <th>Diajukan Oleh</th>
                    <td>{{ $material_request->user->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Material</th>
                    <td>{{ $material_request->material->nama_material ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Diminta</th>
                    <td>{{ $material_request->jumlah_diminta }}</td>
                </tr>
                <tr>
                    <th>Jumlah Disetujui</th>
                    <td>{{ $material_request->jumlah_disetujui ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($material_request->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($material_request->status == 'disetujui')
                            <span class="badge bg-success">Disetujui</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Permintaan</th>
                    <td>{{ $material_request->tanggal_permintaan ? \Carbon\Carbon::parse($material_request->tanggal_permintaan)->format('d-m-Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal Persetujuan</th>
                    <td>{{ $material_request->tanggal_persetujuan ? \Carbon\Carbon::parse($material_request->tanggal_persetujuan)->format('d-m-Y H:i') : '-' }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $material_request->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('material-requests.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
