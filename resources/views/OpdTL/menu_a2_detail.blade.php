@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-file-document-box-outline"></i>
            </span>
            Detail Data Dukung Rekomendasi
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opdTL.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('opdTL.menuA2') }}">Menu A2</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <!-- Informasi Pengawasan -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-gradient-info text-white border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            <i class="mdi mdi-information-outline mr-2"></i>
                            Informasi Pengawasan
                        </h4>
                        <a href="{{ route('opdTL.menuA2') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; border: none;">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body bg-dark text-light">

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #60a5fa !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-file-document-outline mr-2"></i>Nomor Surat:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #3b82f6 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ '700.1.1/' . ($pengawasan['noSurat'] ?? '-') . '/03' . '/' . date('Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #ef4444 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-calendar-clock mr-2"></i>Tanggal Keluar:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #ef4444 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['tglkeluar'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #10b981 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-clipboard-check-outline mr-2"></i>Jenis Pengawasan:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #10b981 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['nama_jenispengawasan'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #f59e0b !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-office-building mr-2"></i>Obrik:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #f59e0b !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['nama_obrik'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Temuan dan Rekomendasi -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-gradient-success text-white border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">
                            <i class="mdi mdi-clipboard-list-outline mr-2"></i>
                            Data Temuan & Rekomendasi yang Sudah Ada
                        </h4>
                        <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; padding: 8px 12px;">
                            <i class="mdi mdi-shield-check mr-1"></i>Read Only Mode
                        </span>
                    </div>
                </div>
                <div class="card-body bg-dark text-light p-0">
                    @if(count($data) > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead style="background: linear-gradient(135deg, #37474f 0%, #546e7a 100%) !important;">
                                    <tr>
                                        <th class="font-weight-bold py-3" style="width: 80px; color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-counter mr-2"></i>No
                                        </th>
                                        <th class="font-weight-bold py-3" style="width: 120px; color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-tag mr-2"></i>Kode Temuan
                                        </th>
                                        <th class="font-weight-bold py-3" style="color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-clipboard-text mr-2"></i>Nama Temuan
                                        </th>
                                        <th class="font-weight-bold py-3" style="color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-clipboard-check mr-2"></i>Rekomendasi
                                        </th>
                                        <th class="font-weight-bold py-3" style="color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-information mr-2"></i>Keterangan
                                        </th>
                                        <th class="font-weight-bold py-3 text-right" style="width: 180px; color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-cash mr-2"></i>Pengembalian
                                        </th>
                                        <th class="font-weight-bold py-3 text-center" style="width: 120px; color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-cog mr-2"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $rowNumber = 1; @endphp
                                    @foreach($data as $index => $parent)
                                        <!-- Parent Row -->
                                        <tr class="parent-row" style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%) !important; border-left: 4px solid #4fc3f7;">
                                            <td class="py-3">
                                                <div class="text-white rounded text-center font-weight-bold" style="width: 35px; height: 35px; line-height: 35px; background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); box-shadow: 0 4px 8px rgba(79, 195, 247, 0.3);">
                                                    {{ $rowNumber++ }}
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; font-weight: 600; padding: 6px 10px;">
                                                    {{ $parent->kode_temuan }}
                                                </span>
                                            </td>
                                            <td class="py-3">
                                                <div class="temuan-content">
                                                    <h6 class="font-weight-bold mb-0" style="color: #ffffff !important; font-size: 1.1em;">
                                                        {{ $parent->nama_temuan }}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span style="color: #ffffff !important; font-weight: 500;">{{ $parent->rekomendasi ?? '-' }}</span>
                                            </td>
                                            <td class="py-3">
                                                <span style="color: #e2e8f0 !important;">{{ $parent->keterangan ?? 'Tidak ada keterangan' }}</span>
                                            </td>
                                            <td class="py-3 text-right">
                                                <span class="badge px-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-size: 0.9em;">
                                                    Rp {{ number_format($parent->pengembalian ?? 0, 0, '.', '.') }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-center">
                                                <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 6px 10px;">
                                                    <i class="mdi mdi-eye mr-1"></i>View Only
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Sub Items -->
                                        @if($parent->sub && count($parent->sub) > 0)
                                            @foreach($parent->sub as $subIndex => $sub)
                                            <tr class="sub-row" style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; border-left: 4px solid #fbbf24;">
                                                <td class="py-3 pl-4">
                                                    <div class="text-dark rounded text-center font-weight-bold" style="width: 32px; height: 32px; line-height: 32px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); box-shadow: 0 3px 6px rgba(251, 191, 36, 0.3);">
                                                        {{ $rowNumber++ }}
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 6px 10px;">
                                                        {{ $sub->kode_temuan }}
                                                    </span>
                                                </td>
                                                <td class="py-3">
                                                    <div class="temuan-content pl-3">
                                                        <i class="mdi mdi-subdirectory-arrow-right mr-2" style="color: #fbbf24 !important;"></i>
                                                        <span class="font-weight-bold" style="color: #fbbf24 !important;">{{ $sub->nama_temuan }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <span style="color: #ffffff !important;">{{ $sub->rekomendasi ?? '-' }}</span>
                                                </td>
                                                <td class="py-3">
                                                    <span style="color: #d1d5db !important;">{{ $sub->keterangan ?? 'Tidak ada keterangan' }}</span>
                                                </td>
                                                <td class="py-3 text-right">
                                                    <span class="badge px-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white;">
                                                        Rp {{ number_format($sub->pengembalian ?? 0, 0, '.', '.') }}
                                                    </span>
                                                </td>
                                                <td class="py-3 text-center">
                                                    <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 6px 10px;">
                                                        <i class="mdi mdi-eye mr-1"></i>View Only
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Nested Sub Items -->
                                            @if($sub->sub && count($sub->sub) > 0)
                                                @foreach($sub->sub as $nestedIndex => $nested)
                                                <tr class="nested-row" style="background: linear-gradient(135deg, #1f2937 0%, #374151 100%) !important; border-left: 4px solid #a78bfa;">
                                                    <td class="py-3 pl-5">
                                                        <div class="text-white rounded text-center font-weight-bold" style="width: 30px; height: 30px; line-height: 30px; background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); box-shadow: 0 2px 4px rgba(167, 139, 250, 0.3);">
                                                            {{ $rowNumber++ }}
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        <span class="badge" style="background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); color: white; font-weight: 600; padding: 6px 10px;">
                                                            {{ $nested->kode_temuan }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3">
                                                        <div class="temuan-content pl-4">
                                                            <i class="mdi mdi-subdirectory-arrow-right mr-2" style="color: #a78bfa !important;"></i>
                                                            <i class="mdi mdi-subdirectory-arrow-right mr-2" style="color: #a78bfa !important;"></i>
                                                            <span style="color: #a78bfa !important;">{{ $nested->nama_temuan }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        <span style="color: #ffffff !important;">{{ $nested->rekomendasi ?? '-' }}</span>
                                                    </td>
                                                    <td class="py-3">
                                                        <span style="color: #9ca3af !important;">{{ $nested->keterangan ?? 'Tidak ada keterangan' }}</span>
                                                    </td>
                                                    <td class="py-3 text-right">
                                                        <span class="badge px-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white;">
                                                            Rp {{ number_format($nested->pengembalian ?? 0, 0, '.', '.') }}
                                                        </span>
                                                    </td>
                                                    <td class="py-3 text-center">
                                                        <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; font-weight: 600; padding: 6px 10px;">
                                                            <i class="mdi mdi-eye mr-1"></i>View Only
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="mdi mdi-information-outline mdi-72px mb-3" style="color: #6b7280 !important; opacity: 0.7;"></i>
                                <h5 style="color: #9ca3af !important; font-weight: 600; margin-top: 20px;">Tidak Ada Data Tersedia</h5>
                                <p style="color: #6b7280 !important;">Tidak ada data temuan dan rekomendasi yang dapat diakses sesuai permission Anda</p>
                                <div class="mt-3">
                                    <span class="badge px-3 py-2" style="background: rgba(251, 191, 36, 0.15) !important; color: #fbbf24 !important; border: 1px solid #fbbf24; font-weight: 600;">
                                        <i class="mdi mdi-shield-alert mr-1"></i>
                                        Akses Terbatas
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- File Upload dan Data Dukung -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="mdi mdi-file-multiple-outline text-success me-2"></i>
                        Data Dukung yang Diupload
                    </h4>

                    @if(count($uploadedFiles) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama File</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($uploadedFiles as $index => $file)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <i class="mdi mdi-file-outline me-2"></i>
                                                {{ basename($file->nama_file) }}
                                            </td>
                                            <td>{{ $file->created_at ? $file->created_at->format('d/m/Y H:i') : '-' }}</td>
                                            <td>
                                                <a href="{{ url($file->nama_file) }}" target="_blank"
                                                   class="btn btn-sm btn-success btn-rounded">
                                                    <i class="mdi mdi-download"></i> Unduh
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="mdi mdi-file-outline mdi-48px text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada File</h5>
                            <p class="text-muted">Belum ada file data dukung yang diupload untuk pengawasan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Auto-collapse accordion items except first one
    $('.accordion .collapse:first').addClass('show');
});
</script>
@endpush

<style>
    .info-item {
        transition: all 0.3s ease !important;
    }

    .info-item:hover {
        transform: translateY(-2px) !important;
    }

    .info-item label i {
        font-size: 1.1em !important;
    }

    .info-item div {
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
        transition: all 0.3s ease !important;
    }

    .info-item:hover div {
        box-shadow: 0 6px 25px rgba(0,0,0,0.5) !important;
        transform: translateY(-1px) !important;
    }

    /* Enhanced table styling */
    .table-responsive {
        background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%) !important;
        border-radius: 10px !important;
        border: none !important;
        box-shadow: 0 8px 25px rgba(0,0,0,0.4) !important;
        overflow: hidden !important;
    }

    .table-dark {
        background: transparent !important;
        color: #ffffff !important;
    }

    .table-dark tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        transition: all 0.3s ease !important;
    }

    .table-dark tbody tr:hover {
        background: rgba(66, 153, 225, 0.1) !important;
        transform: translateX(5px) !important;
    }

    /* Parent row styling */
    .parent-row {
        background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%) !important;
        color: white !important;
        font-weight: 700 !important;
    }

    .parent-row:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e3a8a 100%) !important;
    }

    /* Sub row styling */
    .sub-row {
        background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
        color: white !important;
        font-weight: 600 !important;
    }

    .sub-row:hover {
        background: linear-gradient(135deg, #048c5c 0%, #065f46 100%) !important;
    }

    /* Nested row styling */
    .nested-row {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        color: white !important;
        font-weight: 500 !important;
    }

    .nested-row:hover {
        background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%) !important;
    }

    /* Badge improvements */
    .badge {
        box-shadow: 0 2px 8px rgba(0,0,0,0.3) !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        font-size: 0.75em !important;
    }
</style>
@endsection
