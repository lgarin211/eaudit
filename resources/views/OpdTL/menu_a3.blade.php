@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-clipboard-check-outline"></i>
            </span>
            Menu A3 - Rekomendasi dengan Upload Access
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opdTL.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu A3</li>
            </ul>
        </nav>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($data) && count($data) > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0 text-white">
                            <i class="mdi mdi-clipboard-list-outline mr-2"></i>
                            Daftar Pengawasan dengan Rekomendasi Upload Access
                        </h4>
                        <p class="mb-0 mt-2" style="opacity: 0.9; font-size: 0.9em;">
                            <i class="mdi mdi-information-outline mr-1"></i>
                            Klik "Lihat Detail" untuk melihat dan mengupload file pendukung rekomendasi
                        </p>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="pengawasanTable">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Penugasan Info</th>
                                        <th>Tipe & Jenis</th>
                                        <th>Status LHP</th>
                                        <th>Rekomendasi</th>
                                        <th>File Upload</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $index => $pengawasan)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">
                                                        <strong>{{ $pengawasan['penugasan_info']['nama_obrik'] ?? 'N/A' }}</strong>
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="mdi mdi-file-document-outline mr-1"></i>
                                                        No: {{ $pengawasan['penugasan_info']['noSurat'] ?? 'N/A' }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="mdi mdi-clipboard-text-outline mr-1"></i>
                                                        {{ $pengawasan['penugasan_info']['nama_jenispengawasan'] ?? 'N/A' }}
                                                    </small>
                                                    <br>
                                                    <small class="text-primary">
                                                        <i class="mdi mdi-account-multiple-outline mr-1"></i>
                                                        {{ $pengawasan['pemeriksa'] ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary text-white px-2 py-1 mb-1 d-block">
                                                    {{ $pengawasan['tipe'] ?? 'N/A' }}
                                                </span>
                                                <span class="badge bg-secondary text-white px-2 py-1">
                                                    {{ $pengawasan['jenis'] ?? 'N/A' }}
                                                </span>

                                                @if($pengawasan['wilayah'])
                                                    <br><small class="text-muted mt-1">
                                                        <i class="mdi mdi-map-marker-outline mr-1"></i>
                                                        {{ $pengawasan['wilayah'] }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $status = $pengawasan['status_LHP'] ?? 'Belum Jadi';
                                                    $statusClass = '';
                                                    $statusIcon = '';
                                                    
                                                    switch($status) {
                                                        case 'Belum Jadi':
                                                            $statusClass = 'bg-warning text-dark';
                                                            $statusIcon = 'mdi-clock-outline';
                                                            break;
                                                        case 'Di Proses':
                                                            $statusClass = 'bg-info text-white';
                                                            $statusIcon = 'mdi-cog-outline';
                                                            break;
                                                        case 'Diterima':
                                                            $statusClass = 'bg-success text-white';
                                                            $statusIcon = 'mdi-check-circle-outline';
                                                            break;
                                                        case 'Ditolak':
                                                            $statusClass = 'bg-danger text-white';
                                                            $statusIcon = 'mdi-close-circle-outline';
                                                            break;
                                                        default:
                                                            $statusClass = 'bg-secondary text-white';
                                                            $statusIcon = 'mdi-help-circle-outline';
                                                    }
                                                @endphp
                                                <span class="badge {{ $statusClass }} px-3 py-2">
                                                    <i class="mdi {{ $statusIcon }} mr-1"></i>
                                                    {{ $status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <i class="mdi mdi-clipboard-check-outline text-success mr-2" style="font-size: 1.3em;"></i>
                                                    <span class="badge bg-success text-white px-3 py-2">
                                                        {{ $pengawasan['rekomendasi_count'] }} Item
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex align-items-center justify-content-center">
                                                    @if($pengawasan['file_count'] > 0)
                                                        <i class="mdi mdi-file-upload-outline text-info mr-2" style="font-size: 1.3em;"></i>
                                                        <span class="badge bg-info text-white px-3 py-2">
                                                            {{ $pengawasan['file_count'] }} File
                                                        </span>
                                                    @else
                                                        <i class="mdi mdi-file-outline text-muted mr-2" style="font-size: 1.3em;"></i>
                                                        <span class="badge bg-light text-dark px-3 py-2">
                                                            0 File
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('opdTL.menuA3.detail', ['id' => $pengawasan['id']]) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="mdi mdi-eye mr-1"></i>
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Upload -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="mdi mdi-information-outline mr-2"></i>
                            Panduan Upload File
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="mdi mdi-check-circle text-success mr-2"></i>Upload Diizinkan Untuk:</h6>
                                <ul class="list-unstyled ml-3">
                                    <li class="mb-2">
                                        <i class="mdi mdi-arrow-right text-primary mr-2"></i>
                                        Rekomendasi dengan status <span class="badge bg-info text-white">Di Proses</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="mdi mdi-arrow-right text-primary mr-2"></i>
                                        File format: JPG, PNG, PDF, DOC, XLS, PPT, ZIP
                                    </li>
                                    <li class="mb-2">
                                        <i class="mdi mdi-arrow-right text-primary mr-2"></i>
                                        Maksimal ukuran file: 10MB
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="mdi mdi-close-circle text-danger mr-2"></i>Upload Tidak Diizinkan Untuk:</h6>
                                <ul class="list-unstyled ml-3">
                                    <li class="mb-2">
                                        <i class="mdi mdi-arrow-right text-primary mr-2"></i>
                                        Status <span class="badge bg-warning text-dark">Belum Jadi</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="mdi mdi-arrow-right text-primary mr-2"></i>
                                        Status <span class="badge bg-success text-white">Diterima</span>
                                    </li>
                                    <li class="mb-2">
                                        <i class="mdi mdi-arrow-right text-primary mr-2"></i>
                                        Status <span class="badge bg-danger text-white">Ditolak</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="mdi mdi-information-outline mdi-72px text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak Ada Data Rekomendasi</h4>
                        <p class="text-muted">
                            @if(auth()->check())
                                Belum ada data rekomendasi yang dapat Anda akses untuk upload file pendukung.
                            @else
                                Silakan login untuk melihat data.
                            @endif
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('opdTL.dashboard') }}" class="btn btn-gradient-primary">
                                <i class="mdi mdi-arrow-left mr-2"></i> Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
<script>
$(document).ready(function() {
    $('#pengawasanTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            },
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
            infoFiltered: "(difilter dari _MAX_ total data)",
            zeroRecords: "Tidak ditemukan data yang sesuai",
            emptyTable: "Tidak ada data tersedia"
        },
        columnDefs: [
            { orderable: false, targets: [6] } // Disable sorting for Action column
        ],
        order: [[3, 'asc']] // Sort by Status LHP column by default
    });

    // Add tooltips
    $('[title]').tooltip();
});
</script>
@endsection
@endsection