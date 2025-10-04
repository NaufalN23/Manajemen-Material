@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4>Daftar Pengembalian Material</h4>
            <a href="{{ route('material-returns.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Pengembalian
            </a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Material</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $return->material->nama_material ?? '-' }}</td>
                            <td>{{ $return->jumlah_dikembalikan }}</td>
                            <td>{{ $return->keterangan }}</td>
                            <td>{{ \Carbon\Carbon::parse($return->created_at)->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('material-returns.show', $return->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('material-returns.edit', $return->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('material-returns.destroy', $return->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pengembalian material</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination kalau dipakai --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $returns->links() }}
            </div>
        </div>
                <div class="text-end">
            <a class="btn btn-primary"href="{{ route('dashboard') }}">Kembali</a>
        </div>
    </div>
</div>
@endsection
