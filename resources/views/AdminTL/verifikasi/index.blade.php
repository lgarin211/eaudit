@extends('template')

@section('title', $pageTitle ?? 'Verifikasi Data')
<style>
    .status-badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
    }
    .status-belum-jadi {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    .status-di-proses {
        background-color: #cce5ff;
        color: #004085;
        border: 1px solid #74c0fc;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    .file-count {
        background: #28a745;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: bold;
    }
    .no-files {
        background: #6c757d;
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }
</style>

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="breadcrumb-item">Verifikasi Data</li>
                    @if(isset($pageType) && $pageType === 'rekomendasi')
                        <li class="breadcrumb-item active">Rekomendasi</li>
                    @elseif(isset($pageType) && $pageType === 'temuan')
                        <li class="breadcrumb-item active">Temuan dan Rekom</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">
                                <i class="fas fa-check-circle text-primary"></i>
                                {{ $pageTitle ?? 'Verifikasi Data' }}
                            </h4>
                            <p class="text-muted mb-0">
                                @if(isset($pageType) && $pageType === 'rekomendasi')
                                    Kelola dan verifikasi data rekomendasi dengan status Belum Jadi atau Di Proses
                                @elseif(isset($pageType) && $pageType === 'temuan')
                                    Kelola dan verifikasi data temuan dan rekomendasi dengan status Belum Jadi atau Di Proses
                                @else
                                    Kelola dan verifikasi data dengan status Belum Jadi atau Di Proses
                                @endif
                            </p>
                        </div>
                        <div class="text-end">
                            <div class="row text-center">
                                <div class="col">
                                    <div class="text-primary fw-bold fs-5">{{ $data->total() }}</div>
                                    <small class="text-muted">Total Data</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sub Menu Navigation -->
                    <div class="mt-3">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link {{ (isset($pageType) && $pageType === 'rekomendasi') ? 'active' : '' }}"
                                   href="{{ route('adminTL.verifikasi.rekomendasi') }}">
                                    <i class="fas fa-file-alt"></i> Rekomendasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ (isset($pageType) && $pageType === 'temuan') ? 'active' : '' }}"
                                   href="{{ route('adminTL.verifikasi.temuan') }}">
                                    <i class="fas fa-search"></i> Temuan dan Rekom
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Summary -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-warning fs-2 mb-2">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5 class="card-title">Belum Jadi</h5>
                    <h3 class="text-warning">{{ $data->where('status_LHP', 'Belum Jadi')->count() }}</h3>
                    <small class="text-muted">Data menunggu diproses</small>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-info fs-2 mb-2">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h5 class="card-title">Di Proses</h5>
                    <h3 class="text-info">{{ $data->where('status_LHP', 'Di Proses')->count() }}</h3>
                    <small class="text-muted">Data sedang diproses</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i>
                        Daftar Data Verifikasi
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($data->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">ID Pengawasan</th>
                                        <th width="15%">Tipe</th>
                                        <th width="15%">Jenis</th>
                                        <th width="15%">Wilayah</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">File</th>
                                        <th width="10%">Terakhir Update</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $index => $pengawasan)
                                    <tr class="card-hover">
                                        <td>{{ $data->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $pengawasan->id }}</strong>
                                            <br>
                                            <small class="text-muted">ID: {{ $pengawasan->id_penugasan ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ $pengawasan->tipe ?? 'N/A' }}</td>
                                        <td>{{ $pengawasan->jenis ?? 'N/A' }}</td>
                                        <td>{{ $pengawasan->wilayah ?? 'N/A' }}</td>
                                        <td>
                                            @if($pengawasan->status_LHP == 'Belum Jadi')
                                                <span class="status-badge status-belum-jadi">
                                                    <i class="fas fa-clock"></i> Belum Jadi
                                                </span>
                                            @elseif($pengawasan->status_LHP == 'Di Proses')
                                                <span class="status-badge status-di-proses">
                                                    <i class="fas fa-cogs"></i> Di Proses
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($pengawasan->dataDukung->count() > 0)
                                                <span class="file-count">{{ $pengawasan->dataDukung->count() }}</span>
                                            @else
                                                <span class="no-files">0</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                {{ $pengawasan->updated_at->format('d/m/Y') }}<br>
                                                {{ $pengawasan->updated_at->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <a href="{{ route('adminTL.verifikasi.show', [$pageType ?? 'rekomendasi', $pengawasan->id]) }}"
                                               class="btn btn-sm btn-primary"
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($data->hasPages())
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Menampilkan {{ $data->firstItem() }} sampai {{ $data->lastItem() }} dari {{ $data->total() }} data
                                </div>
                                <div>
                                    {{ $data->links() }}
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-inbox text-muted" style="font-size: 3rem;"></i>
                            </div>
                            <h5 class="text-muted">Tidak ada data untuk diverifikasi</h5>
                            <p class="text-muted">Belum ada data dengan status "Belum Jadi" atau "Di Proses"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert">
        <div class="toast-header bg-success text-white">
            <i class="fas fa-check-circle me-2"></i>
            <strong class="me-auto">Sukses</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert">
        <div class="toast-header bg-danger text-white">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif
@endsection

@section('script')
<script>
    // Auto hide toasts after 5 seconds
    setTimeout(function() {
        $('.toast').fadeOut();
    }, 5000);
</script>
@endsection
