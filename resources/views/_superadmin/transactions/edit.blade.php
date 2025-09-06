@extends('layout.layout')
@php
    $title='Edit Transaksi';
    $subTitle = 'Cryptocracy';
@endphp

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary">✏️ Edit Transaksi</h5>
            <a href="{{ route('superadmin.transactions') }}" class="btn btn-sm btn-secondary fw-semibold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Form Edit Transaksi -->
        <form action="{{ route('superadmin.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-semibold">ID Transaksi</label>
                    <input type="text" class="form-control" value="#{{ $transaction->id }}" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-semibold">Nama Penitip</label>
                    <input type="text" class="form-control" value="{{ $transaction->user->name ?? '-' }}" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="text" class="form-control" value="{{ $transaction->created_at->format('d-m-Y H:i') }}" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="pending" {{ $transaction->status=='pending' ? 'selected' : '' }}>Berjalan</option>
                        <option value="success" {{ $transaction->status=='success' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $transaction->status=='cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-semibold">Total Transaksi</label>
                    <input type="number" name="amount" class="form-control" value="{{ $transaction->amount }}">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="form-label fw-semibold">Metode Pembayaran</label>
                    <input type="text" class="form-control" value="{{ $transaction->payment_method ?? '-' }}" readonly>
                </div>
            </div>

            <!-- Aksi -->
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-sm btn-primary rounded-pill action-btn">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
                <a href="{{ route('superadmin.transactions') }}" class="btn btn-sm btn-secondary rounded-pill action-btn">
                    <i class="bi bi-x me-1"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

{{-- CSS Tambahan --}}
<style>
    .action-btn {
        transition: all 0.3s ease;
    }
    .action-btn:hover {
        transform: scale(1.05);
    }
</style>
@endsection
