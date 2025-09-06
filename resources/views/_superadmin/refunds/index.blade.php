@extends('layout.layout')

@php
    $title = 'Super Admin';
    $subTitle = 'Refunds';
@endphp

{{-- CSS langsung di halaman ini --}}
<style>
    .action-btn {
        transition: all 0.3s ease-in-out;
    }
    .action-btn:hover {
        transform: scale(1.05);
        background: #f8f9fa;
    }
    .dropdown-item {
        transition: all 0.2s ease-in-out;
        border-radius: 8px;
    }
    .dropdown-item:hover {
        background-color: #f1f5f9;
        transform: translateX(4px);
    }
    .dropdown-menu {
        animation: fadeIn 0.25s ease-in-out;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(5px);}
        to {opacity: 1; transform: translateY(0);}
    }
</style>

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">

            {{-- Filter & Search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <form method="GET" action="{{ route('superadmin.refunds.index') }}" class="d-flex gap-2">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ $status == '' ? 'selected' : '' }}>Semua</option>
                        <option value="Proses" {{ $status == 'Proses' ? 'selected' : '' }}>Proses</option>
                        <option value="Selesai" {{ $status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>

                    <input type="text" name="search" value="{{ $search }}" class="form-control"
                           placeholder="Cari nama penitip..."
                           onkeydown="if(event.key==='Enter'){this.form.submit();}">
                </form>

                <a href="{{ route('superadmin.refunds.export') }}" class="btn btn-warning fw-bold shadow-sm">
                    <i class="bi bi-download me-1"></i> Unduh Data
                </a>
            </div>

            {{-- Table Refund --}}
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Penitip</th>
                            <th>ID Transaksi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total Transaksi</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($refunds as $key => $refund)
                            <tr>
                                <td class="text-center">{{ $refunds->firstItem() + $key }}</td>
                                <td>{{ $refund->user->name ?? '-' }}</td>
                                <td>{{ $refund->transaction_id }}</td>
                                <td>{{ $refund->created_at->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $refund->status == 'Selesai' ? 'success' : 'warning' }} px-3 py-2 rounded-pill">
                                        {{ $refund->status }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($refund->amount, 0, ',', '.') }}</td>
                                <td>{{ $refund->payment_method ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="dropdown custom-dropdown">
                                        <button class="btn btn-light btn-sm rounded-pill px-3 shadow-sm action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill me-1"></i> Aksi
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3">
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center py-2">
                                                    <span class="badge bg-info-subtle text-info me-2 p-2 rounded-circle"><i class="bi bi-eye"></i></span>
                                                    <span>Lihat</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="dropdown-item d-flex align-items-center py-2">
                                                    <span class="badge bg-warning-subtle text-warning me-2 p-2 rounded-circle"><i class="bi bi-pencil"></i></span>
                                                    <span>Edit</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="m-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item d-flex align-items-center py-2 text-danger">
                                                        <span class="badge bg-danger-subtle text-danger me-2 p-2 rounded-circle"><i class="bi bi-trash"></i></span>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data refund</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $refunds->links() }}
            </div>

        </div>
    </div>
</div>




   <!-- <div class="row gy-4 mb-24"> -->
        <!-- ======================= First Row Cards Start =================== -->
       <!-- <div class="col-xxl-8">
            <div class="card radius-8 border-0 p-20">
                <div class="row gy-4">
                    <div class="col-xxl-4">
                        <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-1 mb-12">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                                    <div class="d-flex align-items-center gap-2 mb-12">
                                        <span class="mb-0 w-48-px h-48-px bg-base text-pink text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="ri-group-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-0 fw-medium text-secondary-light text-lg">Total Students</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                                    <h5 class="fw-semibold mb-0">15,000</h5>
                                    <p class="text-sm mb-0 d-flex align-items-center gap-8">
                                        <span class="text-white px-1 rounded-2 fw-medium bg-success-main text-sm">+2.5k</span>
                                        This Month
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-2 mb-12">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                                    <div class="d-flex align-items-center gap-2 mb-12">
                                        <span class="mb-0 w-48-px h-48-px bg-base text-purple text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="ri-youtube-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-0 fw-medium text-secondary-light text-lg">Total Courses</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                                    <h5 class="fw-semibold mb-0">420</h5>
                                    <p class="text-sm mb-0 d-flex align-items-center gap-8">
                                        <span class="text-white px-1 rounded-2 fw-medium bg-success-main text-sm">+30</span>
                                        This Month
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card p-3 radius-8 shadow-none bg-gradient-dark-start-3 mb-0">
                            <div class="card-body p-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-0">
                                    <div class="d-flex align-items-center gap-2 mb-12">
                                        <span class="mb-0 w-48-px h-48-px bg-base text-info text-2xl flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                            <i class="ri-money-dollar-circle-fill"></i>
                                        </span>
                                        <div>
                                            <span class="mb-0 fw-medium text-secondary-light text-lg">Overall Revenue</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-8">
                                    <h5 class="fw-semibold mb-0">$50,000</h5>
                                    <p class="text-sm mb-0 d-flex align-items-center gap-8">
                                        <span class="text-white px-1 rounded-2 fw-medium bg-success-main text-sm">+1.5k</span>
                                        This Month
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-8">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                                <h6 class="mb-2 fw-bold text-lg">Average Enrollment Rate
                                </h6>
                                <div class="">
                                    <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                                        <option>Yearly</option>
                                        <option>Monthly</option>
                                        <option>Weekly</option>
                                        <option>Today</option>
                                    </select>
                                </div>
                            </div>
                            <ul class="d-flex flex-wrap align-items-center justify-content-center mt-3 gap-3">
                                <li class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                    <span class="text-secondary-light text-sm fw-semibold">Paid Course:
                                        <span class="text-primary-light fw-bold">350</span>
                                    </span>
                                </li>
                                <li class="d-flex align-items-center gap-2">
                                    <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                                    <span class="text-secondary-light text-sm fw-semibold">Free Course:
                                        <span class="text-primary-light fw-bold">70</span>
                                    </span>
                                </li>
                            </ul>
                            <div class="mt-40">
                                <div id="enrollmentChart" class="apexcharts-tooltip-style-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-md-6">
            <div class="card h-100 radius-8 border-0">
                <div class="card-body p-24 d-flex flex-column justify-content-between gap-8">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Traffic Sources</h6>
                        <select class="form-select form-select-sm w-auto bg-base border text-secondary-light">
                            <option>Yearly</option>
                            <option>Monthly</option>
                            <option>Weekly</option>
                            <option>Today</option>
                        </select>
                    </div>
                    <div id="userOverviewDonutChart" class="margin-16-minus y-value-left apexcharts-tooltip-z-none"></div>

                    <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">
                        <li class="d-flex flex-column gap-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle bg-warning-600"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Organic Search</span>
                            </div>
                            <span class="text-primary-light fw-bold">875</span>
                        </li>
                        <li class="d-flex flex-column gap-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle bg-success-600"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Referrals</span>
                            </div>
                            <span class="text-primary-light fw-bold">450</span>
                        </li>
                        <li class="d-flex flex-column gap-8">
                            <div class="d-flex align-items-center gap-2">
                                <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                                <span class="text-secondary-light text-sm fw-semibold">Social Media</span>
                            </div>
                            <span class="text-primary-light fw-bold">4,305</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div> -->
        <!-- ======================= First Row Cards End =================== -->

        <!-- ================== Second Row Cards Start ======================= -->
        <!-- Top Categories Card Start -->
        <!-- <div class="col-xxl-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Top Categories</h6>
                        <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center gap-12">
                            <div class="w-40-px h-40-px radius-8 flex-shrink-0 bg-info-50 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/home-six/category-icon1.png') }}" alt="" class="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-normal">Web Development</h6>
                                <span class="text-sm text-secondary-light fw-normal">40+ Courses</span>
                            </div>
                        </div>
                        <a href="#" class="w-24-px h-24-px bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg bg-hover-primary-100 radius-4">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center gap-12">
                            <div class="w-40-px h-40-px radius-8 flex-shrink-0 bg-success-50 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/home-six/category-icon2.png') }}" alt="" class="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-normal">Graphic Design</h6>
                                <span class="text-sm text-secondary-light fw-normal">40+ Courses</span>
                            </div>
                        </div>
                        <a href="#" class="w-24-px h-24-px bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg bg-hover-primary-100 radius-4">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center gap-12">
                            <div class="w-40-px h-40-px radius-8 flex-shrink-0 bg-lilac-50 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/home-six/category-icon3.png') }}" alt="" class="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-normal">UI/UX Design</h6>
                                <span class="text-sm text-secondary-light fw-normal">40+ Courses</span>
                            </div>
                        </div>
                        <a href="#" class="w-24-px h-24-px bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg bg-hover-primary-100 radius-4">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center gap-12">
                            <div class="w-40-px h-40-px radius-8 flex-shrink-0 bg-warning-50 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/home-six/category-icon4.png') }}" alt="" class="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-normal">Digital Marketing</h6>
                                <span class="text-sm text-secondary-light fw-normal">40+ Courses</span>
                            </div>
                        </div>
                        <a href="#" class="w-24-px h-24-px bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg bg-hover-primary-100 radius-4">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center gap-12">
                            <div class="w-40-px h-40-px radius-8 flex-shrink-0 bg-danger-50 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/home-six/category-icon5.png') }}" alt="" class="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-normal">3d Illustration & Art Design</h6>
                                <span class="text-sm text-secondary-light fw-normal">40+ Courses</span>
                            </div>
                        </div>
                        <a href="#" class="w-24-px h-24-px bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg bg-hover-primary-100 radius-4">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-0">
                        <div class="d-flex align-items-center gap-12">
                            <div class="w-40-px h-40-px radius-8 flex-shrink-0 bg-primary-50 d-flex justify-content-center align-items-center">
                                <img src="{{ asset('assets/images/home-six/category-icon6.png') }}" alt="" class="">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-normal">Logo Design</h6>
                                <span class="text-sm text-secondary-light fw-normal">40+ Courses</span>
                            </div>
                        </div>
                        <a href="#" class="w-24-px h-24-px bg-primary-50 text-primary-600 d-flex justify-content-center align-items-center text-lg bg-hover-primary-100 radius-4">
                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div> -->
        <!-- Top Categories Card End -->

        <!-- Instructor Card Start -->
        <!-- <div class="col-xxl-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Top Instructors</h6>
                        <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user1.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Dianne Russell</h6>
                                <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center gap-6 mb-1">
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                            </div>
                            <span class="text-primary-light text-sm d-block text-end">25 Reviews</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user2.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Wade Warren</h6>
                                <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center gap-6 mb-1">
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                            </div>
                            <span class="text-primary-light text-sm d-block text-end">25 Reviews</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user3.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Albert Flores</h6>
                                <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center gap-6 mb-1">
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                            </div>
                            <span class="text-primary-light text-sm d-block text-end">25 Reviews</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user4.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Bessie Cooper</h6>
                                <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center gap-6 mb-1">
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                            </div>
                            <span class="text-primary-light text-sm d-block text-end">25 Reviews</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user5.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Arlene McCoy</h6>
                                <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center gap-6 mb-1">
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                            </div>
                            <span class="text-primary-light text-sm d-block text-end">25 Reviews</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/users/user1.png') }}" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Arlene McCoy</h6>
                                <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                            </div>
                        </div>
                        <div class="">
                            <div class="d-flex align-items-center gap-6 mb-1">
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                                <span class="text-lg text-warning-600 d-flex line-height-1"><i class="ri-star-fill"></i></span>
                            </div>
                            <span class="text-primary-light text-sm d-block text-end">25 Reviews</span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Instructor Card End -->

        <!-- Student Progress Card Start -->
        <!--<div class="col-xxl-4 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Student"s Progress</h6>
                        <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/home-six/student-img1.png') }}" alt="" class="w-40-px h-40-px radius-8 flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Theresa Webb</h6>
                                <span class="text-sm text-secondary-light fw-medium">UI/UX Design Course</span>
                            </div>
                        </div>
                        <div class="">
                            <span class="text-primary-light text-sm d-block text-end">
                                <svg class="radial-progress" data-percentage="33" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                    <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">33</text>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/home-six/student-img2.png') }}" alt="" class="w-40-px h-40-px radius-8 flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Robert Fox</h6>
                                <span class="text-sm text-secondary-light fw-medium">Graphic Design Course</span>
                            </div>
                        </div>
                        <div class="">
                            <span class="text-primary-light text-sm d-block text-end">
                                <svg class="radial-progress" data-percentage="70" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                    <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">70</text>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/home-six/student-img3.png') }}" alt="" class="w-40-px h-40-px radius-8 flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Guy Hawkins</h6>
                                <span class="text-sm text-secondary-light fw-medium">Web developer Course</span>
                            </div>
                        </div>
                        <div class="">
                            <span class="text-primary-light text-sm d-block text-end">
                                <svg class="radial-progress" data-percentage="80" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                    <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">80</text>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/home-six/student-img4.png') }}" alt="" class="w-40-px h-40-px radius-8 flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Cody Fisher</h6>
                                <span class="text-sm text-secondary-light fw-medium">UI/UX Design Course</span>
                            </div>
                        </div>
                        <div class="">
                            <span class="text-primary-light text-sm d-block text-end">
                                <svg class="radial-progress" data-percentage="20" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                    <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">20</text>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/home-six/student-img5.png') }}" alt="" class="w-40-px h-40-px radius-8 flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Jacob Jones</h6>
                                <span class="text-sm text-secondary-light fw-medium">UI/UX Design Course</span>
                            </div>
                        </div>
                        <div class="">
                            <span class="text-primary-light text-sm d-block text-end">
                                <svg class="radial-progress" data-percentage="40" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                    <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">40</text>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-0">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/images/home-six/student-img6.png') }}" alt="" class="w-40-px h-40-px radius-8 flex-shrink-0 me-12 overflow-hidden">
                            <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Darlene Robertson</h6>
                                <span class="text-sm text-secondary-light fw-medium">UI/UX Design Course</span>
                            </div>
                        </div>
                        <div class="">
                            <span class="text-primary-light text-sm d-block text-end">
                                <svg class="radial-progress" data-percentage="24" viewBox="0 0 80 80">
                                    <circle class="incomplete" cx="40" cy="40" r="35"></circle>
                                    <circle class="complete" cx="40" cy="40" r="35" style="stroke-dashoffset: 39.58406743523136;"></circle>
                                    <text class="percentage" x="50%" y="57%" transform="matrix(0, 1, -1, 0, 80, 0)">24</text>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- Student Progress Card End -->
        <!-- ================== Second Row Cards End ======================= -->

        <!-- ================== Third Row Cards Start ======================= -->
        <!-- <div class="col-xxl-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Courses</h6>
                        <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="card-body p-24">
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Registered On</th>
                                    <th scope="col">Instructors </th>
                                    <th scope="col">Users</th>
                                    <th scope="col">Enrolled</th>
                                    <th scope="col">Price </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="text-secondary-light">24 Jun 2024</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">Ronald Richards</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary-light">
                                            <h6 class="text-md mb-0 fw-normal">3d Illustration &amp; Art Design</h6>
                                            <span class="text-sm fw-normal">34 Lessons</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">257</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">$29.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-secondary-light">24 Jun 2024</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">Jerome Bell</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary-light">
                                            <h6 class="text-md mb-0 fw-normal">Advanced JavaScript Development</h6>
                                            <span class="text-sm fw-normal">20 Lessons</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">375</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">$29.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-secondary-light">24 Jun 2024</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">Cody Fisher</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary-light">
                                            <h6 class="text-md mb-0 fw-normal">Portrait Drawing Fundamentals </h6>
                                            <span class="text-sm fw-normal">16 Lessons</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">220</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">$29.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-secondary-light">24 Jun 2024</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">Floyd Miles</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary-light">
                                            <h6 class="text-md mb-0 fw-normal">Advanced App Development</h6>
                                            <span class="text-sm fw-normal">25 Lessons</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">57</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">$29.00</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-secondary-light">24 Jun 2024</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">Ralph Edwards</span>
                                    </td>
                                    <td>
                                        <div class="text-secondary-light">
                                            <h6 class="text-md mb-0 fw-normal">HTML Fundamental Course</h6>
                                            <span class="text-sm fw-normal">17 Lessons </span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">27</span>
                                    </td>
                                    <td>
                                        <span class="text-secondary-light">$29.00</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Course Activity</h6>
                        <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                </div>
                <div class="card-body p-24">
                    <ul class="d-flex flex-wrap align-items-center justify-content-center my-3 gap-3">
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px rounded-circle bg-warning-600"></span>
                            <span class="text-secondary-light text-sm fw-semibold">Paid Course:
                                <span class="text-primary-light fw-bold">500</span>
                            </span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <span class="w-12-px h-12-px rounded-circle bg-success-main"></span>
                            <span class="text-secondary-light text-sm fw-semibold">Free Course:
                                <span class="text-primary-light fw-bold">300</span>
                            </span>
                        </li>
                    </ul>
                    <div id="paymentStatusChart" class="margin-16-minus y-value-left"></div>
                </div>
            </div>
        </div> -->
        <!-- ================== Third Row Cards End ======================= -->

   <!-- </div> -->

@endsection

