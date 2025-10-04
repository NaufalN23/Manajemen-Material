@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Pengembalian Material</h3>
    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label"><strong>Material</strong></label>
                <input type="text" class="form-control" value="{{ $materialReturn->material->nama_material }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Jumlah Dikembalikan</strong></label>
                <input type="number" class="form-control" value="{{ $materialReturn->jumlah_dikembalikan }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Kondisi Material</strong></label>
                <textarea class="form-control" rows="2" readonly>{{ $materialReturn->kondisi_material }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Keterangan</strong></label>
                <textarea class="form-control" rows="2" readonly>{{ $materialReturn->keterangan }}</textarea>
            </div>


            @if($materialReturn->status !== 'diterima')
                <form action="{{ route('material-returns.accept', $materialReturn->id) }}" method="POST" onsubmit="return confirm('Terima pengembalian ini?')">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-success">Terima Pengembalian</button>
                </form>
            @else
                <div class="alert alert-success mt-3">
                    Sudah diterima oleh: {{ $materialReturn->receivedBy->name ?? '-' }}
                </div>
            @endif

            <a href="{{ route('material-returns.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>
@endsection
