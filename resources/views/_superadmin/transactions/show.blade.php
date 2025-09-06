@extends('layout.layout')
@php
    $title='Detail Transaksi';
    $subTitle = 'Cryptocracy';
@endphp

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-primary">🔍 Detail Transaksi</h5>
            <a href="{{ route('superadmin.transactions') }}" class="btn btn-sm btn-secondary fw-semibold shadow-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <!-- Info Transaksi -->
        <div class="row mb-3">
            <div class="col-md-6 mb-2">
                <strong>ID Transaksi:</strong> #{{ $transaction->id }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Nama Penitip:</strong> {{ $transaction->user->name ?? '-' }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Tanggal:</strong> {{ $transaction->created_at->format('d-m-Y H:i') }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Status:</strong>
                <span class="badge rounded-pill px-3 py-2 
                    {{ $transaction->status=='success' ? 'bg-success-subtle text-success' : ($transaction->status=='pending' ? 'bg-warning-subtle text-warning' : 'bg-danger-subtle text-danger') }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
            <div class="col-md-6 mb-2">
                <strong>Total Transaksi:</strong> Rp {{ number_format($transaction->amount,0,',','.') }}
            </div>
            <div class="col-md-6 mb-2">
                <strong>Pembayaran:</strong> {{ $transaction->payment_method ?? '-' }}
            </div>
        </div>

        <!-- Aksi -->
        <div class="d-flex gap-2 mt-3">
            <a href="{{ route('superadmin.transactions.edit', $transaction->id) }}" 
               class="btn btn-sm btn-outline-warning rounded-pill action-btn">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <form action="{{ route('superadmin.transactions.destroy', $transaction->id) }}" method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill action-btn">
                    <i class="bi bi-trash me-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- CSS Tambahan --}}
<style>
    .action-btn {
        transition: all 0.3s ease;
    }
    .action-btn:hover {
        background: #f1f5f9;
        transform: scale(1.05);
    }
    .badge {
        font-size: 0.85rem;
    }
</style>
@endsection
