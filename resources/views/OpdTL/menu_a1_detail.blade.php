@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-file-document-box-outline"></i>
            </span>
            Detail Data Dukung Rekomendasi
            <span class="badge badge-warning ml-3" style="background-color: #ff6b35 !important; color: white !important; font-weight: 600; font-size: 0.85em;">
                <i class="mdi mdi-eye mr-1"></i>Read Only Mode
            </span>
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('opdTL.dashboard') }}" style="color: #4fc3f7 !important; text-decoration: none;">
                        <i class="mdi mdi-home mr-1"></i>Dashboard
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('opdTL.menuA1') }}" style="color: #4fc3f7 !important; text-decoration: none;">
                        <i class="mdi mdi-clipboard-list mr-1"></i>Menu A1
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="color: #ffffff !important;">
                    <i class="mdi mdi-file-document mr-1"></i>Detail
                </li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <!-- Data Pengawasan Info (Read Only) -->
        <div class="col-12 grid-margin">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-gradient-info text-white border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-white mb-0">
                            <i class="mdi mdi-information-outline mr-2"></i>
                            Informasi Pengawasan
                        </h4>
                        <span class="badge" style="background-color: #ff8a80 !important; color: white !important; font-weight: 600; padding: 8px 12px;">
                            <i class="mdi mdi-lock mr-1"></i>Read Only
                        </span>
                    </div>
                </div>
                <div class="card-body bg-dark text-light">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #60a5fa !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-file-document-outline mr-2"></i>Nomor Surat:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #3b82f6 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['noSurat'] ?? 'Tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #10b981 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-clipboard-check-outline mr-2"></i>Jenis Pengawasan:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #10b981 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['jenis'] ?? 'Tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #f59e0b !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-office-building mr-2"></i>Obrik Pengawasan:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #f59e0b !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['obrik'] ?? 'Tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="info-item">
                                <label style="color: #ef4444 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-calendar-clock mr-2"></i>Tanggal Pelaksanaan:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #ef4444 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan['tglkeluar'] ?? 'Tidak tersedia' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="info-item">
                                <label style="color: #e2e8f0 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-clipboard-text mr-2"></i>Status LHP:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #e2e8f0 !important; border: 1px solid #6b7280;">
                                    <span class="badge px-3 py-2" style="background: {{ $pengawasan['status_LHP'] == 'Selesai' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)' }} !important; color: white !important; font-weight: 600; font-size: 0.9em;">
                                        <i class="mdi mdi-{{ $pengawasan['status_LHP'] == 'Selesai' ? 'check-circle' : 'clock' }} mr-1"></i>
                                        {{ $pengawasan['status_LHP'] ?? 'Belum Diproses' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tambah Rekomendasi (Simple Table View) -->
        <div class="col-12 grid-margin">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-gradient-primary text-white border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">
                            <i class="mdi mdi-clipboard-text-outline mr-2"></i>
                            Tambah Rekomendasi
                        </h4>
                        <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-weight: 600; padding: 8px 12px;">
                            <i class="mdi mdi-shield-check mr-1"></i>Read Only Mode
                        </span>
                    </div>
                </div>
                <div class="card-body bg-dark text-light p-0">
                    @if($data && count($data) > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover mb-0">
                                <thead style="background: linear-gradient(135deg, #37474f 0%, #546e7a 100%) !important;">
                                    <tr>
                                        <th class="font-weight-bold py-3" style="width: 80px; color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-counter mr-2"></i>Nomor
                                        </th>
                                        <th class="font-weight-bold py-3" style="color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-clipboard-text mr-2"></i>Nama Rekomendasi
                                        </th>
                                        <th class="font-weight-bold py-3" style="color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-information mr-2"></i>Keterangan Rekomendasi
                                        </th>
                                        <th class="font-weight-bold py-3 text-right" style="width: 180px; color: #4fc3f7 !important; border-bottom: 2px solid #4fc3f7;">
                                            <i class="mdi mdi-cash mr-2"></i>Pengembalian Keuangan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $rowNumber = 1; @endphp
                                    @foreach($data as $index => $parent)
                                        <!-- Parent Row -->
                                        <tr class="parent-row" style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%) !important; border-left: 4px solid #4fc3f7;">
                                            <td class="py-3">
                                                <div class="number-badge text-white rounded text-center font-weight-bold" style="width: 35px; height: 35px; line-height: 35px; background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); box-shadow: 0 4px 8px rgba(79, 195, 247, 0.3);">
                                                    {{ $rowNumber++ }}
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="rekomendasi-content">
                                                    <h6 class="font-weight-bold mb-0" style="color: #ffffff !important; font-size: 1.1em;">
                                                        {{ $parent->rekomendasi }}
                                                    </h6>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <span style="color: #e2e8f0 !important;">{{ $parent->keterangan ?? 'Tidak ada keterangan' }}</span>
                                            </td>
                                            <td class="py-3 text-right">
                                                <span class="badge px-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; font-size: 0.9em;">
                                                    Rp {{ number_format($parent->pengembalian ?? 0, 0, '.', '.') }}
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Sub Items -->
                                        @if($parent->sub && count($parent->sub) > 0)
                                            @foreach($parent->sub as $subIndex => $sub)
                                            <tr class="sub-row" style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; border-left: 4px solid #fbbf24;">
                                                <td class="py-3 pl-4">
                                                    <div class="number-badge text-dark rounded text-center font-weight-bold" style="width: 32px; height: 32px; line-height: 32px; background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); box-shadow: 0 3px 6px rgba(251, 191, 36, 0.3);">
                                                        {{ $rowNumber++ }}
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <div class="rekomendasi-content pl-3">
                                                        <i class="mdi mdi-subdirectory-arrow-right mr-2" style="color: #fbbf24 !important;"></i>
                                                        <span class="font-weight-bold" style="color: #fbbf24 !important;">{{ $sub->rekomendasi }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-3">
                                                    <span style="color: #d1d5db !important;">{{ $sub->keterangan ?? 'Tidak ada keterangan' }}</span>
                                                </td>
                                                <td class="py-3 text-right">
                                                    <span class="badge px-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white;">
                                                        Rp {{ number_format($sub->pengembalian ?? 0, 0, '.', '.') }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <!-- Nested Sub Items -->
                                            @if($sub->sub && count($sub->sub) > 0)
                                                @foreach($sub->sub as $nestedIndex => $nested)
                                                <tr class="nested-row" style="background: linear-gradient(135deg, #1f2937 0%, #374151 100%) !important; border-left: 4px solid #a78bfa;">
                                                    <td class="py-3 pl-5">
                                                        <div class="number-badge text-white rounded text-center font-weight-bold" style="width: 30px; height: 30px; line-height: 30px; background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%); box-shadow: 0 2px 4px rgba(167, 139, 250, 0.3);">
                                                            {{ $rowNumber++ }}
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        <div class="rekomendasi-content pl-4">
                                                            <i class="mdi mdi-subdirectory-arrow-right mr-2" style="color: #a78bfa !important;"></i>
                                                            <i class="mdi mdi-subdirectory-arrow-right mr-2" style="color: #a78bfa !important;"></i>
                                                            <span style="color: #a78bfa !important;">{{ $nested->rekomendasi }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3">
                                                        <span style="color: #9ca3af !important;">{{ $nested->keterangan ?? 'Tidak ada keterangan' }}</span>
                                                    </td>
                                                    <td class="py-3 text-right">
                                                        <span class="badge px-3 py-2 font-weight-bold" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white;">
                                                            Rp {{ number_format($nested->pengembalian ?? 0, 0, '.', '.') }}
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
                                <i class="mdi mdi-information-outline mdi-72px text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak Ada Data Tersedia</h5>
                                <p class="text-muted">Tidak ada data rekomendasi yang dapat diakses sesuai permission Anda</p>
                                <div class="mt-3">
                                    <span class="badge badge-warning px-3 py-2">
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

        <!-- Upload Data Dukung (Only allowed action) -->
        <div class="col-12 grid-margin">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-gradient-success text-white border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">
                            <i class="mdi mdi-cloud-upload-outline mr-2"></i>
                            Upload Data Dukung
                        </h4>
                        <span class="badge" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; font-weight: 600; padding: 8px 12px;">
                            <i class="mdi mdi-check-circle mr-1"></i>Aksi yang Diizinkan
                        </span>
                    </div>
                </div>
                <div class="card-body bg-dark text-light">
                    <div class="alert" style="background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(245, 158, 11, 0.1) 100%) !important; border: 2px solid #fbbf24 !important; color: #fbbf24 !important; border-radius: 12px; backdrop-filter: blur(10px);">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-alert-circle-outline mr-3 mdi-24px" style="color: #fbbf24 !important; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>
                            <div>
                                <strong style="color: #fbbf24 !important;">Perhatian:</strong> <span style="color: #ffffff !important;">Anda hanya dapat mengunggah file sebagai data dukung.</span>
                                <br><small style="color: #d1d5db !important;">Tidak dapat mengedit atau menghapus data lainnya dalam sistem.</small>
                            </div>
                        </div>
                    </div>                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">

                        <div class="upload-zone rounded p-4" style="background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important; border: 2px dashed #28a745 !important; position: relative; overflow: hidden;">
                            <div class="text-center mb-4">
                                <i class="mdi mdi-cloud-upload mdi-48px mb-3" style="color: #28a745 !important; filter: drop-shadow(0 3px 6px rgba(40, 167, 69, 0.4));"></i>
                                <h5 style="color: #ffffff !important; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3); font-size: 1.4em; margin-bottom: 10px;">Upload File Data Dukung</h5>
                                <p style="color: #cbd5e1 !important; font-size: 1.05em; margin-bottom: 0;">Drag & drop file atau klik untuk memilih</p>
                            </div>

                            <div class="form-group">
                                <label for="file" style="color: #10b981 !important; font-weight: 700 !important; font-size: 1.1em; margin-bottom: 10px;">
                                    <i class="mdi mdi-file-document-outline mr-2"></i>Pilih File:
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file" name="file"
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip,.xlsx,.xls,.ppt,.pptx" style="background: transparent !important; color: #ffffff !important;">
                                    <label class="custom-file-label border-secondary" for="file" style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; color: #ffffff !important; border: 2px solid #6b7280 !important;">
                                        <i class="mdi mdi-attachment mr-2"></i>Pilih file...
                                    </label>
                                </div>
                                <div class="mt-3">
                                    <small style="color: #60a5fa !important; font-weight: 600; font-size: 0.9em;">
                                        <i class="mdi mdi-information mr-1"></i>
                                        <strong>Format yang didukung:</strong>
                                    </small>
                                    <div class="mt-2">
                                        <span class="badge mr-1" style="background: rgba(59, 130, 246, 0.2) !important; color: #3b82f6 !important; border: 1px solid #3b82f6; padding: 6px 10px; font-weight: 600;">PDF</span>
                                        <span class="badge mr-1" style="background: rgba(6, 182, 212, 0.2) !important; color: #06b6d4 !important; border: 1px solid #06b6d4; padding: 6px 10px; font-weight: 600;">DOC</span>
                                        <span class="badge mr-1" style="background: rgba(16, 185, 129, 0.2) !important; color: #10b981 !important; border: 1px solid #10b981; padding: 6px 10px; font-weight: 600;">DOCX</span>
                                        <span class="badge mr-1" style="background: rgba(245, 158, 11, 0.2) !important; color: #f59e0b !important; border: 1px solid #f59e0b; padding: 6px 10px; font-weight: 600;">JPG</span>
                                        <span class="badge mr-1" style="background: rgba(239, 68, 68, 0.2) !important; color: #ef4444 !important; border: 1px solid #ef4444; padding: 6px 10px; font-weight: 600;">PNG</span>
                                        <span class="badge mr-1" style="background: rgba(107, 114, 128, 0.2) !important; color: #6b7280 !important; border: 1px solid #6b7280; padding: 6px 10px; font-weight: 600;">ZIP</span>
                                        <span class="badge mr-1" style="background: rgba(34, 197, 94, 0.2) !important; color: #22c55e !important; border: 1px solid #22c55e; padding: 6px 10px; font-weight: 600;">XLSX</span>
                                        <span class="badge mr-1" style="background: rgba(168, 85, 247, 0.2) !important; color: #a855f7 !important; border: 1px solid #a855f7; padding: 6px 10px; font-weight: 600;">PPT</span>
                                    </div>
                                    <small class="d-block mt-2" style="color: #9ca3af !important; font-size: 0.85em;">
                                        <i class="mdi mdi-information-outline mr-1"></i>
                                        Ukuran maksimal: 10MB
                                    </small>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-gradient-success btn-lg px-5">
                                    <i class="mdi mdi-upload mr-2"></i> Upload File
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Berkas Data Dukung yang Sudah Upload -->
        <div class="col-12 grid-margin">
            <div class="card bg-dark border-secondary">
                <div class="card-header bg-gradient-info text-white border-secondary">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0" style="color: #ffffff !important; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            <i class="mdi mdi-folder-multiple-outline mr-2"></i>
                            Berkas Data Dukung
                        </h4>
                        <span class="badge" style="background: rgba(255,255,255,0.2) !important; color: white !important; border: 1px solid rgba(255,255,255,0.3) !important; backdrop-filter: blur(10px); font-weight: 600; padding: 8px 12px;">
                            <i class="mdi mdi-file-multiple mr-1"></i>
                            {{ $uploadedFiles ? count($uploadedFiles) : 0 }} File{{ count($uploadedFiles) > 1 ? 's' : '' }}
                        </span>
                    </div>
                </div>
                <div class="card-body bg-dark text-light">
                    @if($uploadedFiles && count($uploadedFiles) > 0)
                        <div class="file-list">
                            @foreach($uploadedFiles as $index => $file)
                            <div class="file-item p-4 rounded mb-3" style="background: linear-gradient(135deg, #2a2a2a 0%, #343434 100%) !important; border: 1px solid #404040 !important; border-left: 4px solid #17a2b8 !important;">
                                <div class="row align-items-center">
                                    <div class="col-md-1 text-center">
                                        <div class="file-number rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important; color: white !important; font-weight: 800; font-size: 18px; box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3); border: 2px solid rgba(255,255,255,0.2);">
                                            <strong>{{ $index + 1 }}</strong>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="file-info">
                                            <div class="d-flex align-items-center mb-2">
                                                @php
                                                    $extension = strtolower(pathinfo($file->nama_file, PATHINFO_EXTENSION));
                                                    $iconClass = 'mdi-file-document'; // default
                                                    $iconColor = '#adb5bd'; // default

                                                    if ($extension === 'pdf') {
                                                        $iconClass = 'mdi-file-pdf-box';
                                                        $iconColor = '#dc3545';
                                                    } elseif (in_array($extension, ['doc', 'docx'])) {
                                                        $iconClass = 'mdi-file-word-box';
                                                        $iconColor = '#0d6efd';
                                                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                                        $iconClass = 'mdi-file-excel-box';
                                                        $iconColor = '#198754';
                                                    } elseif (in_array($extension, ['ppt', 'pptx'])) {
                                                        $iconClass = 'mdi-file-powerpoint-box';
                                                        $iconColor = '#fd7e14';
                                                    } elseif (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                                                        $iconClass = 'mdi-file-image';
                                                        $iconColor = '#0dcaf0';
                                                    } elseif ($extension === 'zip') {
                                                        $iconClass = 'mdi-folder-zip';
                                                        $iconColor = '#6c757d';
                                                    }
                                                @endphp
                                                <i class="mdi {{ $iconClass }} mdi-24px mr-2" style="color: {{ $iconColor }} !important;"></i>
                                                <div>
                                                    <h6 class="mb-0" style="color: #ffffff !important; font-weight: 600; font-size: 1.05em;">{{ basename($file->nama_file) }}</h6>
                                                    <small style="color: #9ca3af !important; font-size: 0.85em;">{{ strtoupper($extension) }} File</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="upload-info">
                                            <small style="color: #60a5fa !important; font-weight: 500; font-size: 0.85em;">
                                                <i class="mdi mdi-clock mr-1"></i>
                                                Diupload:
                                            </small>
                                            <div style="color: #ffffff !important; font-weight: 600; font-size: 1em;">
                                                {{ $file->created_at->format('d/m/Y') }}
                                            </div>
                                            <small style="color: #9ca3af !important; font-size: 0.8em;">
                                                {{ $file->created_at->format('H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <div class="file-actions">
                                            <a href="{{ asset($file->nama_file) }}" class="btn btn-gradient-info btn-sm" target="_blank">
                                                <i class="mdi mdi-download mr-1"></i> Download
                                            </a>
                                            <div class="mt-2">
                                                <span class="badge" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important; color: white !important; font-weight: 600; padding: 6px 10px;">
                                                    <i class="mdi mdi-eye mr-1"></i>View Only
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="mdi mdi-folder-open-outline mdi-72px mb-3" style="color: #6b7280 !important; opacity: 0.7;"></i>
                                <h5 style="color: #9ca3af !important; font-weight: 600; margin-top: 20px;">Belum Ada File</h5>
                                <p style="color: #6b7280 !important;">Belum ada file data dukung yang diupload</p>
                                <div class="mt-3">
                                    <span class="badge px-3 py-2" style="background: rgba(23, 162, 184, 0.15) !important; color: #17a2b8 !important; border: 1px solid #17a2b8; font-weight: 600;">
                                        <i class="mdi mdi-information mr-1"></i>
                                        Upload file untuk menambahkan data dukung
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Enhanced Dark Theme for Better Readability */
:root {
    --dark-bg: #1a1a1a;
    --dark-card: #2c2c2c;
    --dark-secondary: #3c3c3c;
    --dark-border: #4a4a4a;
    --dark-text: #e9ecef;
    --dark-muted: #adb5bd;
}

/* Global Dark Theme Override */
.content-wrapper {
    background-color: var(--dark-bg) !important;
}

.card.bg-dark {
    background-color: var(--dark-card) !important;
    border: 1px solid var(--dark-border) !important;
}

/* Enhanced Visibility Improvements */
.page-title {
    color: #ffffff !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    font-weight: 700 !important;
}

.page-title-icon {
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
}

/* Info item styling improvements */
.info-item label {
    font-size: 0.95em !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    margin-bottom: 8px !important;
}

.info-item .bg-secondary {
    background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important;
    border: 1px solid #6b7280 !important;
    transition: all 0.3s ease;
}

.info-item .bg-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%) !important;
}

/* Table improvements for better contrast */
.table-dark th {
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    font-size: 0.85em !important;
}

.table-dark td {
    border-color: #475569 !important;
    vertical-align: middle !important;
}

/* Enhanced hover effects */
.table-hover tbody tr:hover {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(29, 78, 216, 0.05) 100%) !important;
    transform: translateX(3px);
    transition: all 0.3s ease;
    border-left-width: 6px !important;
}

/* Number badge improvements */
.number-badge {
    font-family: 'Segoe UI', system-ui, sans-serif !important;
    border: 2px solid rgba(255,255,255,0.2) !important;
    transition: all 0.3s ease !important;
    font-size: 0.9em !important;
}

/* Text contrast improvements */
.text-white {
    color: #ffffff !important;
}

.text-light {
    color: #e2e8f0 !important;
}

.text-muted {
    color: #94a3b8 !important;
}

/* Global text color overrides for dark theme */
.bg-dark .text-muted,
.card.bg-dark .text-muted,
.card-body.bg-dark .text-muted {
    color: #9ca3af !important;
}

.bg-dark .text-info,
.card.bg-dark .text-info,
.card-body.bg-dark .text-info {
    color: #60a5fa !important;
}

.bg-dark .text-success,
.card.bg-dark .text-success,
.card-body.bg-dark .text-success {
    color: #10b981 !important;
}

.bg-dark .text-warning,
.card.bg-dark .text-warning,
.card-body.bg-dark .text-warning {
    color: #f59e0b !important;
}

.bg-dark .text-danger,
.card.bg-dark .text-danger,
.card-body.bg-dark .text-danger {
    color: #ef4444 !important;
}

.bg-dark .text-primary,
.card.bg-dark .text-primary,
.card-body.bg-dark .text-primary {
    color: #3b82f6 !important;
}

/* Ensure all text elements are readable */
.bg-dark small,
.card.bg-dark small,
.card-body.bg-dark small {
    color: #9ca3af !important;
}

.bg-dark p,
.card.bg-dark p,
.card-body.bg-dark p {
    color: #e2e8f0 !important;
}

.bg-dark h1, .bg-dark h2, .bg-dark h3, .bg-dark h4, .bg-dark h5, .bg-dark h6,
.card.bg-dark h1, .card.bg-dark h2, .card.bg-dark h3, .card.bg-dark h4, .card.bg-dark h5, .card.bg-dark h6 {
    color: #ffffff !important;
}

.card-header.bg-gradient-info,
.card-header.bg-gradient-primary {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
    border-bottom: 2px solid #3498db !important;
}

/* Info Items Styling */
.info-item {
    transition: all 0.3s ease;
}

.info-item:hover {
    transform: translateY(-2px);
}

.info-item .bg-secondary {
    background-color: var(--dark-secondary) !important;
    border: 1px solid var(--dark-border) !important;
    color: var(--dark-text) !important;
    transition: all 0.3s ease;
}

.info-item:hover .bg-secondary {
    background-color: #4a4a4a !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.5);
}

/* Enhanced Table Dark Styling */
.table-dark {
    background-color: var(--dark-card) !important;
    color: var(--dark-text) !important;
}

.table-dark th {
    background-color: #2c3e50 !important;
    border-color: var(--dark-border) !important;
    color: #3498db !important;
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.75rem;
}

.table-dark td {
    background-color: var(--dark-card) !important;
    border-color: var(--dark-border) !important;
    color: var(--dark-text) !important;
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

/* Row Styling with Better Contrast */
.parent-row {
    background-color: #2c3e50 !important;
    transition: all 0.3s ease;
}

.parent-row:hover {
    background-color: #34495e !important;
    transform: translateX(3px);
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

.parent-row td {
    background-color: #2c3e50 !important;
    border-left: 3px solid #3498db;
}

.sub-row {
    background-color: #34495e !important;
    transition: all 0.3s ease;
}

.sub-row:hover {
    background-color: #3c5a78 !important;
    transform: translateX(5px);
    box-shadow: 0 2px 8px rgba(241, 196, 15, 0.3);
}

.sub-row td {
    background-color: #34495e !important;
    border-left: 3px solid #f1c40f;
}

.nested-row {
    background-color: #404040 !important;
    transition: all 0.3s ease;
}

.nested-row:hover {
    background-color: #4a4a4a !important;
    transform: translateX(7px);
    box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
}

.nested-row td {
    background-color: #404040 !important;
    border-left: 3px solid #17a2b8;
}

/* Enhanced Number Badge */
.number-badge {
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
    min-width: 32px;
    min-height: 32px;
    line-height: 32px !important;
}

.number-badge:hover {
    transform: scale(1.15);
    box-shadow: 0 4px 12px rgba(0,0,0,0.6);
}

/* Rekomendasi Content */
.rekomendasi-content {
    line-height: 1.5;
}

.rekomendasi-content .text-white {
    color: #f8f9fa !important;
    font-weight: 500;
}

.rekomendasi-content .text-warning {
    color: #ffc107 !important;
    font-weight: 500;
}

.rekomendasi-content .text-info {
    color: #17a2b8 !important;
    font-weight: 500;
}

/* Enhanced Badge Styling */
.badge {
    font-size: 0.9rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    transition: all 0.3s ease;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.badge:hover {
    transform: scale(1.08);
    box-shadow: 0 4px 8px rgba(0,0,0,0.4);
}

.badge-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: 1px solid #1e7e34;
}

.badge-info {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important;
    border: 1px solid #138496;
}

.badge-light {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
    color: #343a40 !important;
    border: 1px solid #dee2e6;
}

/* Text Color Enhancements */
.text-light {
    color: var(--dark-text) !important;
}

.text-muted {
    color: var(--dark-muted) !important;
}

.text-white {
    color: #ffffff !important;
}

/* Icon Color Enhancements */
.mdi {
    filter: brightness(1.2);
}

/* Enhanced Contrast for Better Readability */
.card-body.bg-dark {
    background-color: var(--dark-card) !important;
    color: var(--dark-text) !important;
}

.card-header h4.text-white {
    color: #ffffff !important;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

/* Breadcrumb Dark Theme */
.breadcrumb {
    background-color: var(--dark-secondary) !important;
    border: 1px solid var(--dark-border);
}

.breadcrumb-item a {
    color: #3498db !important;
}

.breadcrumb-item.active {
    color: var(--dark-text) !important;
}

/* Upload Zone Dark Theme - Enhanced */
.upload-zone {
    transition: all 0.3s ease;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
    border: 2px dashed #28a745 !important;
    color: var(--dark-text) !important;
    position: relative;
    overflow: hidden;
}

.upload-zone::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, rgba(40, 167, 69, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.upload-zone:hover {
    border-color: #20c997 !important;
    background: linear-gradient(135deg, #1e1e1e 0%, #323232 100%) !important;
    transform: translateY(-3px);
    box-shadow:
        0 10px 30px rgba(32, 201, 151, 0.2),
        0 0 0 1px rgba(32, 201, 151, 0.1);
}

.upload-zone .mdi-cloud-upload {
    color: #28a745 !important;
    filter: drop-shadow(0 3px 6px rgba(40, 167, 69, 0.4));
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.upload-zone h5 {
    color: #ffffff !important;
    font-weight: 700 !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.upload-zone .text-muted {
    color: #b8bcc8 !important;
}

.upload-zone .custom-file {
    position: relative;
    z-index: 2;
}

.upload-zone .custom-file-input {
    background-color: transparent !important;
    border: none !important;
    color: var(--dark-text) !important;
}

.upload-zone .custom-file-label {
    background: linear-gradient(135deg, #343a40 0%, #495057 100%) !important;
    border: 2px solid #6c757d !important;
    color: #ffffff !important;
    border-radius: 8px !important;
    transition: all 0.3s ease;
}

.upload-zone .custom-file-label:hover {
    border-color: #17a2b8 !important;
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
}

.upload-zone .custom-file-label::after {
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important;
    border: none !important;
    color: white !important;
    border-radius: 0 6px 6px 0 !important;
}

.upload-zone .badge {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%) !important;
    color: #ffffff !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    backdrop-filter: blur(10px);
    margin: 2px;
    transition: all 0.3s ease;
}

.upload-zone .badge:hover {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* File List Dark Theme - Enhanced */
.file-list {
    padding: 15px;
}

.file-item {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background: linear-gradient(135deg, #2a2a2a 0%, #343434 100%) !important;
    border: 1px solid #404040 !important;
    border-left: 4px solid #17a2b8 !important;
    border-radius: 12px !important;
    position: relative;
    overflow: hidden;
}

.file-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(23, 162, 184, 0.02) 0%, transparent 50%);
    pointer-events: none;
}

.file-item:hover {
    transform: translateX(8px) translateY(-2px);
    box-shadow:
        0 12px 35px rgba(23, 162, 184, 0.3),
        0 0 0 1px rgba(23, 162, 184, 0.1);
    border-left-width: 6px !important;
    background: linear-gradient(135deg, #2e2e2e 0%, #383838 100%) !important;
}

.file-number {
    width: 50px !important;
    height: 50px !important;
    background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%) !important;
    color: white !important;
    font-weight: 800 !important;
    font-size: 18px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.4s ease !important;
    box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    position: relative;
    z-index: 2;
}

.file-number::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 50%);
    border-radius: 50%;
    pointer-events: none;
}

.file-item:hover .file-number {
    transform: scale(1.2) rotate(5deg);
    box-shadow: 0 8px 20px rgba(23, 162, 184, 0.5);
    background: linear-gradient(135deg, #138496 0%, #1ea085 100%) !important;
}

.file-info {
    position: relative;
    z-index: 2;
}

.file-info h6 {
    color: #ffffff !important;
    font-weight: 600 !important;
    margin-bottom: 4px !important;
}

.file-info .text-muted {
    color: #9ca3af !important;
    font-size: 0.85em;
}

.file-info .mdi {
    transition: all 0.3s ease;
}

.file-item:hover .file-info .mdi {
    transform: scale(1.1);
}

.upload-info {
    position: relative;
    z-index: 2;
}

.upload-info .text-info {
    color: #60a5fa !important;
    font-weight: 500 !important;
}

.upload-info .text-white {
    color: #ffffff !important;
    font-weight: 600 !important;
}

.upload-info .text-muted {
    color: #9ca3af !important;
}

.file-actions {
    position: relative;
    z-index: 2;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state .mdi {
    color: #6b7280 !important;
    opacity: 0.7;
    animation: pulse 2s infinite;
}

.empty-state h5 {
    color: #9ca3af !important;
    font-weight: 600 !important;
    margin-top: 20px !important;
}

.empty-state p {
    color: #6b7280 !important;
}

@keyframes pulse {
    0%, 100% { opacity: 0.7; }
    50% { opacity: 1; }
}

/* Alert Styling Dark Theme */
.alert {
    border-radius: 10px !important;
    border: none !important;
    backdrop-filter: blur(10px);
    position: relative;
    overflow: hidden;
}

.alert::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.alert-warning {
    background: linear-gradient(135deg, rgba(251, 191, 36, 0.15) 0%, rgba(245, 158, 11, 0.1) 100%) !important;
    border: 2px solid #f59e0b !important;
    color: #fbbf24 !important;
}

.alert-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.1) 100%) !important;
    border: 2px solid #10b981 !important;
    color: #34d399 !important;
}

.alert-danger {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(220, 38, 38, 0.1) 100%) !important;
    border: 2px solid #ef4444 !important;
    color: #f87171 !important;
}

.alert .mdi {
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}

/* Button and Badge Dark Theme */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.4);
}

.btn-gradient-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    border: none !important;
    color: white !important;
    font-weight: 600 !important;
    padding: 12px 30px !important;
    border-radius: 8px !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    position: relative;
    overflow: hidden;
}

.btn-gradient-success::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-gradient-success:hover::before {
    left: 100%;
}

.btn-gradient-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%) !important;
    box-shadow:
        0 10px 25px rgba(16, 185, 129, 0.4),
        0 0 0 1px rgba(16, 185, 129, 0.1) !important;
    transform: translateY(-2px);
}

.btn-gradient-info {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
    border: none !important;
    color: white !important;
    font-weight: 600 !important;
    border-radius: 6px !important;
    position: relative;
    overflow: hidden;
}

.btn-gradient-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-gradient-info:hover::before {
    left: 100%;
}

.btn-gradient-info:hover {
    background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
    box-shadow:
        0 8px 20px rgba(59, 130, 246, 0.4),
        0 0 0 1px rgba(59, 130, 246, 0.1) !important;
    transform: translateY(-2px);
}

.badge {
    transition: all 0.3s ease;
    color: var(--dark-text) !important;
}

.badge:hover {
    transform: scale(1.05);
}

.badge-light {
    background-color: rgba(255, 255, 255, 0.15) !important;
    color: var(--dark-text) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
}

.badge-warning {
    background-color: #ffc107 !important;
    color: #212529 !important;
}

.badge-info {
    background-color: rgba(23, 162, 184, 0.15) !important;
    color: #17a2b8 !important;
    border: 1px solid #17a2b8 !important;
}

.empty-state i {
    transition: all 0.3s ease;
}

.empty-state:hover i {
    transform: scale(1.1);
    color: #6c757d !important;
}

/* Custom scrollbar for dark theme */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #2c3e50;
}

::-webkit-scrollbar-thumb {
    background: #34495e;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #4a5f7a;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .parent-temuan .row {
        flex-direction: column;
    }

    .file-item .row {
        flex-direction: column;
        text-align: center;
    }

    .file-item .col-md-3 {
        margin-top: 1rem;
    }
}

/* Animation keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.5s ease-out;
}

/* Enhanced focus states for accessibility */
.custom-file-input:focus + .custom-file-label {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
}

.btn:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Card Header Dark Theme - Enhanced */
.card-header.bg-gradient-info {
    background: linear-gradient(135deg, #7c3aed 0%, #3b82f6 50%, #06b6d4 100%) !important;
    border-bottom: 3px solid #7c3aed !important;
    color: white !important;
    position: relative;
    overflow: hidden;
}

.card-header.bg-gradient-info::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
    pointer-events: none;
}

.card-header h4 {
    color: white !important;
    font-weight: 700 !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    position: relative;
    z-index: 2;
}

.card-header .badge-light {
    background: rgba(255,255,255,0.2) !important;
    color: white !important;
    border: 1px solid rgba(255,255,255,0.3) !important;
    backdrop-filter: blur(10px);
    font-weight: 600 !important;
}

.card.bg-dark {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%) !important;
    border: 1px solid #404040 !important;
}

/* Upload Zone Icon and Text Enhancement */
.upload-zone .mdi-cloud-upload {
    color: #20c997 !important;
    filter: drop-shadow(0 2px 4px rgba(32, 201, 151, 0.3));
}

.upload-zone h5 {
    color: var(--dark-text) !important;
    font-weight: 600 !important;
}

.upload-zone .text-muted {
    color: #adb5bd !important;
}

.upload-zone .text-info {
    color: #17a2b8 !important;
}

/* File Icons Enhancement */
.mdi-file-pdf-box { color: #dc3545 !important; }
.mdi-file-word-box { color: #0d6efd !important; }
.mdi-file-excel-box { color: #198754 !important; }
.mdi-file-powerpoint-box { color: #fd7e14 !important; }
.mdi-file-image { color: #0dcaf0 !important; }
.mdi-folder-zip { color: #6c757d !important; }
.mdi-file-document { color: #adb5bd !important; }

/* Responsive Dark Theme */
@media (max-width: 768px) {
    .file-item {
        padding: 20px 15px !important;
    }

    .file-item:hover {
        transform: translateX(0) !important;
    }

    .upload-zone {
        padding: 20px 15px !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // File name display
    $('.custom-file-input').on('change', function() {
        const fileName = $(this)[0].files[0]?.name || 'Pilih file...';
        $(this).next('.custom-file-label').text(fileName);
    });

    // Upload form submission
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();

        // Show loading
        submitBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin"></i> Uploading...');

        $.ajax({
            url: '{{ route("opdTL.uploadFile") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    // Show success message
                    showAlert('success', response.message);

                    // Reset form
                    $('#uploadForm')[0].reset();
                    $('.custom-file-label').text('Pilih file...');

                    // Reload page after delay
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('error', response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                const message = response?.message || 'Terjadi kesalahan saat upload file';
                showAlert('error', message);
            },
            complete: function() {
                // Restore button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        `;

        $('.card-body:first').prepend(alertHtml);

        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endpush
@endsection
