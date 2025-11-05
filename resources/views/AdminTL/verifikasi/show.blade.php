@extends('template')

@section('title', $pageTitle ?? 'Detail Verifikasi Data')
<style>
    :root {
        /* Light theme colors */
        --bg-primary: #ffffff;
        --bg-secondary: #f8f9fa;
        --bg-tertiary: #e9ecef;
        --text-primary: #212529;
        --text-secondary: #6c757d;
        --text-muted: #6c757d;
        --border-color: #e9ecef;
        --border-hover: #0d6efd;
        --shadow-color: rgba(0,0,0,0.1);
        --form-bg: #f8f9fa;
        --form-border: #dee2e6;

        /* Status colors - consistent in both themes */
        --status-belum-jadi-bg: #fff3cd;
        --status-belum-jadi-text: #856404;
        --status-belum-jadi-border: #ffeaa7;

        --status-di-proses-bg: #cce5ff;
        --status-di-proses-text: #004085;
        --status-di-proses-border: #74c0fc;

        --status-diterima-bg: #d4edda;
        --status-diterima-text: #155724;
        --status-diterima-border: #c3e6cb;

        --status-ditolak-bg: #f8d7da;
        --status-ditolak-text: #721c24;
        --status-ditolak-border: #f5c6cb;
    }

    /* Dark theme support */
    body.sidebar-dark {
        --bg-primary: #2c2c34;
        --bg-secondary: #393941;
        --bg-tertiary: #4a4a52;
        --text-primary: #ffffff;
        --text-secondary: #b8b9bd;
        --text-muted: #8e8e93;
        --border-color: #4a4a52;
        --border-hover: #0d6efd;
        --shadow-color: rgba(0,0,0,0.3);
        --form-bg: #393941;
        --form-border: #4a4a52;

        /* Status colors for dark theme - adjusted for better contrast */
        --status-belum-jadi-bg: #664d03;
        --status-belum-jadi-text: #fff3cd;
        --status-belum-jadi-border: #664d03;

        --status-di-proses-bg: #052c65;
        --status-di-proses-text: #cce5ff;
        --status-di-proses-border: #052c65;

        --status-diterima-bg: #0a3622;
        --status-diterima-text: #d4edda;
        --status-diterima-border: #0a3622;

        --status-ditolak-bg: #58151c;
        --status-ditolak-text: #f8d7da;
        --status-ditolak-border: #58151c;
    }

    .status-badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
    }

    .status-belum-jadi {
        background-color: var(--status-belum-jadi-bg);
        color: var(--status-belum-jadi-text);
        border: 1px solid var(--status-belum-jadi-border);
    }

    .status-di-proses {
        background-color: var(--status-di-proses-bg);
        color: var(--status-di-proses-text);
        border: 1px solid var(--status-di-proses-border);
    }

    .status-diterima {
        background-color: var(--status-diterima-bg);
        color: var(--status-diterima-text);
        border: 1px solid var(--status-diterima-border);
    }

    .status-ditolak {
        background-color: var(--status-ditolak-bg);
        color: var(--status-ditolak-text);
        border: 1px solid var(--status-ditolak-border);
    }

    .verification-card {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .verification-card .card-header {
        background-color: var(--bg-secondary);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .file-item {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        color: var(--text-primary);
    }

    /* CSS for read-only hierarchical display */
    .verification-readonly-card {
        transition: all 0.3s ease;
    }

    .verification-readonly-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .verification-file-card {
        transition: all 0.2s ease;
    }

    .verification-file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .file-item:hover {
        border-color: var(--border-hover);
        box-shadow: 0 2px 4px var(--shadow-color);
    }

    .update-status-form {
        background-color: var(--form-bg);
        border-radius: 10px;
        padding: 1.5rem;
        border: 2px dashed var(--form-border);
    }

    .form-control {
        background-color: var(--bg-primary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .form-control:focus {
        background-color: var(--bg-primary);
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        color: var(--text-primary);
    }

    .form-select {
        background-color: var(--bg-primary);
        border-color: var(--border-color);
        color: var(--text-primary);
    }

    .form-select:focus {
        background-color: var(--bg-primary);
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        color: var(--text-primary);
    }

    .btn-update {
        background: linear-gradient(45deg, #007bff, #0056b3);
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        background: linear-gradient(45deg, #0056b3, #004085);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px var(--shadow-color);
        color: white;
    }

    .info-item {
        border-bottom: 1px solid var(--border-color);
        padding: 0.75rem 0;
        color: var(--text-primary);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item strong {
        color: var(--text-primary);
    }

    .info-item .text-muted {
        color: var(--text-muted) !important;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .text-center.py-4 {
        color: var(--text-muted);
    }

    .form-text {
        color: var(--text-muted) !important;
    }

    .form-label {
        color: var(--text-primary);
    }

    .modal-content {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }

    .bg-light {
        background-color: var(--bg-secondary) !important;
        color: var(--text-primary);
    }

    /* Info section styling */
    .info-section {
        background-color: var(--bg-secondary);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        border: 1px solid var(--border-color);
    }

    /* Ensure proper contrast for small text */
    small.text-muted,
    .small.text-muted {
        color: var(--text-muted) !important;
    }

    /* Button outline adjustments for dark theme */
    .btn-outline-secondary {
        border-color: var(--border-color);
        color: var(--text-secondary);
    }

    .btn-outline-secondary:hover {
        background-color: var(--bg-secondary);
        border-color: var(--text-secondary);
        color: var(--text-primary);
    }

    /* Additional text color fixes for dark theme */
    h1, h2, h3, h4, h5, h6 {
        color: var(--text-primary) !important;
    }

    p, span, div {
        color: var(--text-primary);
    }

    /* Specific fixes for form elements */
    .form-label, label {
        color: var(--text-primary) !important;
    }

    /* Card body text */
    .card-body, .card-body p, .card-body div, .card-body span {
        color: var(--text-primary);
    }

    /* Status flow section */
    .status-flow-section h6 {
        color: var(--text-primary) !important;
    }

    /* File section text */
    .file-item h6, .file-item p, .file-item span {
        color: var(--text-primary);
    }

    /* Update status form text */
    .update-status-form label,
    .update-status-form small,
    .update-status-form .form-text {
        color: var(--text-primary) !important;
    }

    /* Override Bootstrap default colors */
    body.sidebar-dark .text-dark {
        color: var(--text-primary) !important;
    }

    body.sidebar-dark .text-secondary {
        color: var(--text-secondary) !important;
    }

    /* Ensure proper text color inheritance */
    body.sidebar-dark * {
        color: inherit;
    }

    /* Force text color for specific elements that might inherit wrong colors */
    body.sidebar-dark .container-fluid,
    body.sidebar-dark .row,
    body.sidebar-dark .col-12,
    body.sidebar-dark .col-lg-8,
    body.sidebar-dark .col-lg-4,
    body.sidebar-dark .col-md-6,
    body.sidebar-dark .col-md-8,
    body.sidebar-dark .col-md-4 {
        color: var(--text-primary);
    }

    /* Form control placeholder text */
    .form-control::placeholder,
    .form-select::placeholder,
    textarea::placeholder {
        color: var(--text-muted) !important;
        opacity: 0.7;
    }

    /* Info labels and values */
    .info-item strong {
        color: var(--text-primary) !important;
        font-weight: 600;
    }

    .info-item span {
        color: var(--text-secondary) !important;
    }

    /* Status badge text contrast enhancement */
    body.sidebar-dark .status-badge {
        font-weight: 700;
    }

    /* Small text elements */
    body.sidebar-dark small {
        color: var(--text-muted) !important;
    }

    /* Link colors in dark theme */
    body.sidebar-dark a:not(.btn) {
        color: #66b3ff !important;
    }

    body.sidebar-dark a:not(.btn):hover {
        color: #4da6ff !important;
    }

    /* Modal dialog fixes for dark theme */
    body.sidebar-dark .modal-content {
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color);
    }

    body.sidebar-dark .modal-header {
        border-bottom: 1px solid var(--border-color);
    }

    body.sidebar-dark .modal-footer {
        border-top: 1px solid var(--border-color);
    }

    body.sidebar-dark .modal-body {
        color: var(--text-primary) !important;
    }

    body.sidebar-dark .modal-body p {
        color: var(--text-primary) !important;
    }

    /* Loading overlay spinner text */
    body.sidebar-dark .loading-overlay .spinner-border {
        color: var(--text-primary) !important;
    }

    body.sidebar-dark .visually-hidden {
        color: var(--text-primary) !important;
    }

    /* Ensure icons maintain proper colors */
    body.sidebar-dark .fas,
    body.sidebar-dark .far,
    body.sidebar-dark .fab {
        color: inherit;
    }

    /* Special handling for text-info class in dark theme */
    body.sidebar-dark .text-info {
        color: #66b3ff !important;
    }

    /* Override any remaining Bootstrap text utilities */
    body.sidebar-dark .text-dark {
        color: var(--text-primary) !important;
    }

    body.sidebar-dark .text-light {
        color: var(--text-primary) !important;
    }

    /* Force override for text-muted class in dark theme */
    body.sidebar-dark .text-muted {
        color: var(--text-secondary) !important;
    }

    /* Specific override for info-item text */
    body.sidebar-dark .info-item .text-muted,
    body.sidebar-dark .info-item span {
        color: var(--text-secondary) !important;
    }

    /* Override Bootstrap's default text-muted color */
    body.sidebar-dark span.text-muted {
        color: var(--text-secondary) !important;
    }

    /* Ensure text-white works in both themes */
    .text-white {
        color: #ffffff !important;
    }

    /* In light theme, use dark color for better contrast */
    /* body:not(.sidebar-dark) .text-white {
        color: #212529 !important;
    } */

    /* Read-only form styling */
    .form-control[readonly],
    .form-control[disabled],
    .form-select[disabled] {
        background-color: var(--bg-primary) !important;
        color: var(--text-primary) !important;
        border-color: var(--border-color) !important;
        opacity: 0.8;
    }

    /* Input group styling for dark theme */
    .input-group-text {
        background-color: var(--bg-secondary) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    /* Label styling */
    .fw-bold {
        font-weight: 600 !important;
    }

    /* Hierarchy item styling */
    .hierarchy-item {
        background-color: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        padding: 1rem;
    }

    .hierarchy-item .sub-item {
        background-color: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        margin: 0.5rem 0 0.5rem 2rem;
        padding: 0.75rem;
    }

    .hierarchy-item .sub-sub-item {
        background-color: var(--bg-tertiary);
        border: 1px solid var(--border-color);
        border-radius: 4px;
        margin: 0.5rem 0 0.5rem 2rem;
        padding: 0.5rem;
    }
</style>

@section('content')
<div class="container-fluid">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1" style="color: var(--text-primary) !important;">
                                <i class="fas fa-check-circle text-primary"></i>
                                {{ $pageTitle ?? 'Detail Verifikasi Data' }}
                            </h4>
                            <p class="mb-0" style="color: var(--text-muted) !important;">ID Pengawasan: <strong style="color: var(--text-primary) !important;">{{ $pengawasan->id }}</strong></p>
                        </div>
                        <div>
                            @php
                                $backRoute = isset($pageType) && $pageType === 'temuan'
                                    ? route('adminTL.verifikasi.temuan')
                                    : route('adminTL.verifikasi.rekomendasi');
                            @endphp
                            <a href="{{ $backRoute }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Penugasan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fas fa-clipboard-list"></i>
                        Data Penugasan
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        // Use penugasanData from API if available, otherwise use pengawasan data
                        $displayData = $penugasanData ?? [];
                    @endphp

                    <div class="row">
                        <div class="col-md-3">
                            <label class="fw-bold text-white">Nomor Surat</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="700.1.1" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ $displayData['noSurat'] ?? $pengawasan->noSurat ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="03/2025" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="fw-bold text-white">Jenis Pengawasan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $displayData['nama_jenispengawasan'] ?? $pengawasan->nama_jenispengawasan ?? $pengawasan->jenis ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="fw-bold text-white">Obrik Pengawasan</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $displayData['nama_obrik'] ?? $pengawasan->nama_obrik ?? $pengawasan->wilayah ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="fw-bold text-white">Tanggal Pelaksanaan</label>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ $displayData['tanggalAwalPenugasan'] ?? $pengawasan->tanggalAwalPenugasan ?? ($pengawasan->tglkeluar ? $pengawasan->tglkeluar->format('Y-m-d') : 'N/A') }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <span class="text-white">s/d</span>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ $displayData['tanggalAkhirPenugasan'] ?? $pengawasan->tanggalAkhirPenugasan ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>

                    @if(isset($displayData['pemeriksa']) || $pengawasan->pemeriksa)
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label class="fw-bold text-white">Pemeriksa</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" value="{{ $displayData['pemeriksa'] ?? $pengawasan->pemeriksa ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Data Pengawasan -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fas fa-search"></i>
                        Data Pengawasan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="fw-bold text-white">ID Pengawasan</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->id }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold text-white">ID Penugasan</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->id_penugasan ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold text-white">Tanggal Surat Keluar</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->tglkeluar ? $pengawasan->tglkeluar->format('d/m/Y') : 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="fw-bold text-white">Tipe Rekomendasi</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->tipe ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold text-white">Jenis Pemeriksaan</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->jenis ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold text-white">Wilayah</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->wilayah ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-white">Pemeriksa</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->pemeriksa ?? 'N/A' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-white">Status LHP</label>
                            <div class="input-group mt-2">
                                <input type="text" class="form-control" value="{{ $pengawasan->status_LHP ?? 'Belum Jadi' }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                                <div class="input-group-append">
                                    <span class="input-group-text" style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                                        @php $status = $pengawasan->status_LHP ?? 'Belum Jadi'; @endphp
                                        @if($status == 'Belum Jadi')
                                            <i class="fas fa-clock text-warning" title="Belum Jadi"></i>
                                        @elseif($status == 'Di Proses')
                                            <i class="fas fa-cogs text-info" title="Di Proses"></i>
                                        @elseif($status == 'Diterima')
                                            <i class="fas fa-check-circle text-success" title="Diterima"></i>
                                        @elseif($status == 'Ditolak')
                                            <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                        @else
                                            <i class="fas fa-question-circle text-muted" title="Status Tidak Dikenal"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($pengawasan->tgl_verifikasi)
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-white">Tanggal Verifikasi</label>
                            <input type="text" class="form-control mt-2" value="{{ $pengawasan->tgl_verifikasi->format('d/m/Y H:i:s') }}" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        </div>
                        @if($pengawasan->alasan_verifikasi)
                        <div class="col-md-6">
                            <label class="fw-bold text-white">Alasan Verifikasi</label>
                            <textarea class="form-control mt-2" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);" rows="2">{{ $pengawasan->alasan_verifikasi }}</textarea>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Data Rekomendasi & Upload File Pendukung -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fa-solid fa-list-check"></i>
                        Data Rekomendasi & Upload File Pendukung (Detail Hierarkis)
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($hierarchicalData) && $hierarchicalData->count() > 0)
                        @php $itemCounter = 1; @endphp
                        @foreach($hierarchicalData as $item)
                            @include('AdminTL.partials.hierarchy_item_readonly', ['item' => $item, 'itemNumber' => $itemCounter, 'parentNumber' => ''])
                            @php $itemCounter++; @endphp
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fa-solid fa-exclamation-circle fa-2x mb-3 text-white"></i>
                            <h5 class="text-white">Belum Ada Data Rekomendasi</h5>
                            <p class="text-white">Silakan buat data temuan dan rekomendasi terlebih dahulu melalui halaman Data Dukung.</p>
                            <div class="mt-3">
                                <a href="{{ url('/adminTL/datadukung/' . ($pageType === 'rekomendasi' ? 'rekom' : 'temuan') . '/' . $pengawasan->id) }}"
                                   class="btn btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                    Lihat Halaman Data Dukung
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ringkasan Data -->
    @if(isset($hierarchicalData) && $hierarchicalData->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fas fa-chart-bar"></i>
                        Ringkasan Data Rekomendasi
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        // Calculate statistics
                        $totalItems = 0;
                        $totalFiles = 0;
                        $totalPengembalian = 0;

                        function calculateStats($items, &$totalItems, &$totalFiles, &$totalPengembalian) {
                            foreach($items as $item) {
                                $totalItems++;
                                if(isset($item->uploadedFiles)) {
                                    $totalFiles += $item->uploadedFiles->count();
                                }
                                if(isset($item->pengembalian) && is_numeric($item->pengembalian)) {
                                    $totalPengembalian += $item->pengembalian;
                                }
                                if(isset($item->children) && count($item->children) > 0) {
                                    calculateStats($item->children, $totalItems, $totalFiles, $totalPengembalian);
                                }
                            }
                        }

                        calculateStats($hierarchicalData, $totalItems, $totalFiles, $totalPengembalian);
                    @endphp

                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-list-ol fa-2x text-primary"></i>
                                </div>
                                <h4 class="text-white">{{ $totalItems }}</h4>
                                <p class="text-muted mb-0">Total Item Rekomendasi</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-file fa-2x text-info"></i>
                                </div>
                                <h4 class="text-white">{{ $totalFiles }}</h4>
                                <p class="text-muted mb-0">Total File Data Dukung</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                                </div>
                                <h4 class="text-white">{{ number_format($totalPengembalian, 0, ',', '.') }}</h4>
                                <p class="text-muted mb-0">Total Pengembalian (Rp)</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas fa-calendar fa-2x text-warning"></i>
                                </div>
                                <h4 class="text-white">{{ $pengawasan->created_at ? $pengawasan->created_at->format('d/m/Y') : 'N/A' }}</h4>
                                <p class="text-muted mb-0">Tanggal Dibuat</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Data Information -->
        <div class="col-lg-8">
            <div class="card verification-card border-0 shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fas fa-info-circle"></i>
                        Informasi Data Pengawasan
                    </h5>
                </div>
                <div class="card-body" style="background-color: var(--form-bg)">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>ID Pengawasan:</strong><br>
                                <span class="text-white">{{ $pengawasan->id }}</span>
                            </div>
                            <div class="info-item">
                                <strong>ID Penugasan:</strong><br>
                                <span class="text-white">{{ $pengawasan->id_penugasan ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Tipe:</strong><br>
                                <span class="text-white">{{ $pengawasan->tipe ?? 'N/A' }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <strong>Jenis:</strong><br>
                                <span class="text-white">{{ $pengawasan->jenis ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Wilayah:</strong><br>
                                <span class="text-white">{{ $pengawasan->wilayah ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <strong>Pemeriksa:</strong><br>
                                <span class="text-white">{{ $pengawasan->pemeriksa ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="info-item">
                                <strong>Status Saat Ini:</strong><br>
                                @if($pengawasan->status_LHP == 'Belum Jadi')
                                    <span class="status-badge status-belum-jadi">
                                        <i class="fas fa-clock"></i> Belum Jadi
                                    </span>
                                @elseif($pengawasan->status_LHP == 'Di Proses')
                                    <span class="status-badge status-di-proses">
                                        <i class="fas fa-cogs"></i> Di Proses
                                    </span>
                                @elseif($pengawasan->status_LHP == 'Diterima')
                                    <span class="status-badge status-diterima">
                                        <i class="fas fa-check"></i> Diterima
                                    </span>
                                @elseif($pengawasan->status_LHP == 'Ditolak')
                                    <span class="status-badge status-ditolak">
                                        <i class="fas fa-times"></i> Ditolak
                                    </span>
                                @endif
                            </div>
                            <div class="info-item">
                                <strong>Tanggal Keluar:</strong><br>
                                <span class="text-white">{{ $pengawasan->tglkeluar ? \Carbon\Carbon::parse($pengawasan->tglkeluar)->format('d/m/Y') : 'N/A' }}</span>
                            </div>
                            @if($pengawasan->tgl_verifikasi)
                            <div class="info-item">
                                <strong>Tanggal Verifikasi:</strong><br>
                                <span class="text-white">{{ \Carbon\Carbon::parse($pengawasan->tgl_verifikasi)->format('d/m/Y H:i:s') }}</span>
                            </div>
                            @endif
                            @if($pengawasan->alasan_verifikasi)
                            <div class="info-item">
                                <strong>Alasan Verifikasi Terakhir:</strong><br>
                                <div class="info-section mt-1">
                                    {{ $pengawasan->alasan_verifikasi }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Files Section -->
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fas fa-files"></i>
                        Ringkasan File Data Dukung ({{ $pengawasan->dataDukung->count() }} file)
                    </h5>
                </div>
                <div class="card-body">
                    @if($pengawasan->dataDukung->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm" style="color: var(--text-primary);">
                                <thead style="background-color: var(--bg-secondary);">
                                    <tr>
                                        <th style="border-color: var(--border-color);">No</th>
                                        <th style="border-color: var(--border-color);">Nama File</th>
                                        <th style="border-color: var(--border-color);">Terkait Item</th>
                                        <th style="border-color: var(--border-color);">Keterangan</th>
                                        <th style="border-color: var(--border-color);">Upload</th>
                                        <th style="border-color: var(--border-color);">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengawasan->dataDukung as $index => $file)
                                    <tr style="background-color: var(--bg-primary);">
                                        <td style="border-color: var(--border-color);">{{ $index + 1 }}</td>
                                        <td style="border-color: var(--border-color);">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-file-alt text-primary me-2"></i>
                                                <span>{{ basename($file->nama_file) }}</span>
                                            </div>
                                        </td>
                                        <td style="border-color: var(--border-color);">
                                            @if($file->id_jenis_temuan)
                                                @php
                                                    $relatedItem = DB::table('jenis_temuans')->find($file->id_jenis_temuan);
                                                @endphp
                                                @if($relatedItem)
                                                    <small class="badge bg-info">{{ strlen($relatedItem->rekomendasi ?? 'N/A') > 30 ? substr($relatedItem->rekomendasi ?? 'N/A', 0, 30) . '...' : ($relatedItem->rekomendasi ?? 'N/A') }}</small>
                                                @else
                                                    <small class="text-muted">Item terhapus</small>
                                                @endif
                                            @else
                                                <small class="badge bg-secondary">Global</small>
                                            @endif
                                        </td>
                                        <td style="border-color: var(--border-color);">
                                            <small>{{ $file->keterangan_file ?? '-' }}</small>
                                        </td>
                                        <td style="border-color: var(--border-color);">
                                            <small>{{ $file->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                        <td style="border-color: var(--border-color);">
                                            <div class="btn-group" role="group">
                                                <a href="{{ asset($file->nama_file) }}" target="_blank" class="btn btn-sm btn-info" title="Lihat File">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ asset($file->nama_file) }}" download class="btn btn-sm btn-success" title="Download File">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x mb-3 text-white"></i>
                            <h6 class="mt-2 text-white">Belum ada file yang diupload</h6>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Update Status Form -->
        <div class="col-lg-4">
            <div class="card verification-card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0" style="color: var(--text-primary) !important;">
                        <i class="fas fa-edit"></i>
                        Update Status
                    </h5>
                </div>
                <div class="card-body" style="background-color: var(--form-bg);">
                    @if($canUpdateStatus ?? true)
                    <div class="update-status-form">
                        <form id="updateStatusForm">
                            @csrf
                            <div class="mb-3">
                                <label for="status_LHP" class="form-label fw-bold" style="color: var(--text-primary) !important;">Status Baru *</label>
                                <select class="form-select" id="status_LHP" name="status_LHP" required>
                                    <option value="">-- Pilih Status --</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <label for="alasan_verifikasi" class="form-label fw-bold" style="color: var(--text-primary) !important;">Alasan Verifikasi *</label>
                                <textarea class="form-control"
                                          id="alasan_verifikasi"
                                          name="alasan_verifikasi"
                                          rows="4"
                                          placeholder="Masukkan alasan perubahan status..."
                                          maxlength="1000"
                                          required></textarea>
                                <div class="form-text" style="color: var(--text-muted) !important;">Maksimal 1000 karakter</div>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="mb-3">
                                <small style="color: var(--text-muted) !important;">
                                    <i class="fas fa-info-circle"></i>
                                    Pastikan alasan yang diberikan jelas dan dapat dipertanggungjawabkan
                                </small>
                            </div>

                            <button type="submit" class="btn btn-update w-100">
                                <i class="fas fa-save"></i> Update Status
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-info" style="background-color: var(--bg-info); border-color: var(--border-color); color: var(--text-primary);">
                        <i class="fas fa-info-circle"></i>
                        <strong>Status Sudah Final</strong><br>
                        Data ini sudah memiliki status final ({{ $pengawasan->status_LHP ?? 'N/A' }}) dan tidak dapat diubah lagi.
                        @if($pengawasan->alasan_verifikasi)
                        <br><br>
                        <strong>Alasan Terakhir:</strong> {{ $pengawasan->alasan_verifikasi }}
                        @endif
                    </div>
                    @endif

                    <!-- Status Flow Info -->
                    <div class="mt-4 status-flow-section">
                        <h6 class="fw-bold" style="color: var(--text-primary) !important;">
                            <i class="fas fa-route"></i>
                            Alur Status:
                        </h6>
                        <div class="small">
                            <div class="d-flex align-items-center mb-2">
                                <span class="status-badge status-belum-jadi me-2">Belum Jadi</span>
                                <i class="fas fa-arrow-right me-2" style="color: var(--text-muted);"></i>
                                <span class="status-badge status-di-proses">Di Proses</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="status-badge status-di-proses me-2">Di Proses</span>
                                <i class="fas fa-arrow-right me-2" style="color: var(--text-muted);"></i>
                                <span class="status-badge status-diterima me-1">Diterima</span>
                                <span style="color: var(--text-muted);">/</span>
                                <span class="status-badge status-ditolak ms-1">Ditolak</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle"></i> Berhasil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-circle"></i> Error
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="errorMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        @if($canUpdateStatus ?? true)
        // Load status options
        loadStatusOptions();

        // Handle form submission
        $('#updateStatusForm').on('submit', function(e) {
            e.preventDefault();
            updateStatus();
        });

        // Character count for textarea
        $('#alasan_verifikasi').on('input', function() {
            const current = $(this).val().length;
            const max = 1000;
            const remaining = max - current;
            $(this).siblings('.form-text').text(`${current}/1000 karakter (${remaining} tersisa)`);
        });
        @endif
    });

    function loadStatusOptions() {
        $.get('{{ route("adminTL.verifikasi.statusOptions", [$pageType ?? "rekomendasi", $pengawasan->id]) }}')
        .done(function(response) {
            if (response.success) {
                const select = $('#status_LHP');
                select.empty().append('<option value="">-- Pilih Status --</option>');

                response.options.forEach(function(option) {
                    select.append(`<option value="${option.value}">${option.label}</option>`);
                });
            }
        })
        .fail(function() {
            showError('Gagal memuat opsi status');
        });
    }

    function updateStatus() {
        const formData = {
            status_LHP: $('#status_LHP').val(),
            alasan_verifikasi: $('#alasan_verifikasi').val(),
            _token: $('input[name="_token"]').val()
        };

        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        $('#loadingOverlay').show();

        $.post('{{ route("adminTL.verifikasi.updateStatus", [$pageType ?? "rekomendasi", $pengawasan->id]) }}', formData)
        .done(function(response) {
            if (response.success) {
                showSuccess(response.message);
                // Refresh page after 2 seconds
                setTimeout(function() {
                    window.location.reload();
                }, 2000);
            } else {
                showError(response.message || 'Gagal mengupdate status');
            }
        })
        .fail(function(xhr) {
            if (xhr.status === 422) {
                // Validation errors
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(function(field) {
                    const input = $(`[name="${field}"]`);
                    input.addClass('is-invalid');
                    input.siblings('.invalid-feedback').text(errors[field][0]);
                });
            } else {
                showError(xhr.responseJSON?.message || 'Terjadi kesalahan sistem');
            }
        })
        .always(function() {
            $('#loadingOverlay').hide();
        });
    }

    function showSuccess(message) {
        $('#successMessage').text(message);
        $('#successModal').modal('show');
    }

    function showError(message) {
        $('#errorMessage').text(message);
        $('#errorModal').modal('show');
    }
</script>
@endsection
