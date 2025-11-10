@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-file-document-edit-outline"></i>
            </span>
            Detail Pengawasan - Upload File Pendukung Rekomendasi
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opdTL.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('opdTL.menuA3') }}">Menu A3</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Pengawasan</li>
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
                        <a href="{{ route('opdTL.menuA3') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; border: none;">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body bg-dark text-light">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="info-item">
                                <label style="color: #60a5fa !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-file-document-outline mr-2"></i>Nomor Surat:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #3b82f6 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ '700.1.1/' . ($penugasanInfo['noSurat'] ?? '-') . '/03' . '/' . date('Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-item">
                                <label style="color: #ef4444 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-calendar-clock mr-2"></i>Tanggal Keluar:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #ef4444 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $penugasanInfo['tglkeluar'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-item">
                                <label style="color: #10b981 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-clipboard-check-outline mr-2"></i>Tipe:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #10b981 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan->tipe ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="info-item">
                                <label style="color: #f59e0b !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-tag-outline mr-2"></i>Jenis:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #f59e0b !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan->jenis ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <label style="color: #a78bfa !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-office-building mr-2"></i>Obrik:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #a78bfa !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $penugasanInfo['nama_obrik'] ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <label style="color: #06b6d4 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-account-multiple-outline mr-2"></i>Pemeriksa:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #06b6d4 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan->pemeriksa ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="info-item">
                                <label style="color: #ec4899 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-map-marker-outline mr-2"></i>Wilayah:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #ec4899 !important; border: 1px solid #6b7280;">
                                    <span style="color: #ffffff !important; font-weight: 600; font-size: 1em;">{{ $pengawasan->wilayah ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status LHP Info -->
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="info-item">
                                <label style="color: #84cc16 !important; font-weight: 700 !important; margin-bottom: 8px !important; font-size: 0.95em; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="mdi mdi-clipboard-pulse-outline mr-2"></i>Status LHP:
                                </label>
                                <div style="background: linear-gradient(135deg, #374151 0%, #4b5563 100%) !important; padding: 15px !important; border-radius: 8px !important; border-left: 4px solid #84cc16 !important; border: 1px solid #6b7280;">
                                    @php
                                        $status = $pengawasan->status_LHP ?? 'Belum Jadi';
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
                                    <span class="badge {{ $statusClass }} px-3 py-2" style="font-size: 1em;">
                                        <i class="mdi {{ $statusIcon }} mr-1"></i>
                                        {{ $status }}
                                    </span>
                                    @if($allowUpload)
                                        <span class="badge bg-success text-white px-3 py-2 ml-3" style="font-size: 0.9em;">
                                            <i class="mdi mdi-upload mr-1"></i>
                                            Upload Diizinkan
                                        </span>
                                    @else
                                        <span class="badge bg-secondary text-white px-3 py-2 ml-3" style="font-size: 0.9em;">
                                            <i class="mdi mdi-upload-off mr-1"></i>
                                            Upload Tidak Diizinkan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Rekomendasi dalam Pengawasan -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-gradient-success text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">
                            <i class="mdi mdi-clipboard-list-outline mr-2"></i>
                            Daftar Rekomendasi ({{ count($rekomendasiList) }} item)
                        </h4>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(count($rekomendasiList) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="rekomendasiListTable">
                                <thead class="bg-success text-white">
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th style="width: 120px;">Kode</th>
                                        <th>Nama Temuan</th>
                                        <th>Rekomendasi</th>
                                        <th style="width: 120px;">File</th>
                                        <th style="width: 120px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rekomendasiList as $index => $rekomendasi)
                                        @php
                                            // Count files for this specific rekomendasi
                                            $fileCount = collect($uploadedFiles)->where('id_jenis_temuan', $rekomendasi->id)->count();
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td>
                                                <span class="badge bg-primary text-white px-2 py-1">
                                                    {{ $rekomendasi->kode_temuan }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="mdi mdi-clipboard-text text-primary mr-2" style="font-size: 1.2em;"></i>
                                                    <span class="font-weight-bold">{{ $rekomendasi->nama_temuan }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="max-width: 300px;">
                                                    {{ Str::limit($rekomendasi->rekomendasi, 100) }}
                                                    @if(strlen($rekomendasi->rekomendasi) > 100)
                                                        <a href="#" class="text-primary toggle-full-text" data-full-text="{{ htmlentities($rekomendasi->rekomendasi) }}">
                                                            <small>[Lihat semua]</small>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($fileCount > 0)
                                                    <span class="badge bg-info text-white px-2 py-1">
                                                        <i class="mdi mdi-file-upload-outline mr-1"></i>
                                                        {{ $fileCount }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-dark px-2 py-1">
                                                        <i class="mdi mdi-file-outline mr-1"></i>
                                                        0
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary upload-to-rekomendasi-btn"
                                                        data-rekomendasi-id="{{ $rekomendasi->id }}"
                                                        data-rekomendasi-name="{{ $rekomendasi->nama_temuan }}"
                                                        title="Upload ke Rekomendasi Ini"
                                                        @if(!$allowUpload) disabled @endif>
                                                    <i class="mdi mdi-upload mr-1"></i>
                                                    Upload
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-clipboard-outline mdi-72px text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak Ada Rekomendasi</h5>
                            <p class="text-muted">Tidak ada rekomendasi yang dapat Anda akses dalam pengawasan ini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upload File Section -->
        @if($allowUpload)
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0 text-white">
                        <i class="mdi mdi-cloud-upload-outline mr-2"></i>
                        Upload File Pendukung Rekomendasi
                    </h4>
                </div>
                <div class="card-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_jenis_temuan" id="selected_rekomendasi_id" value="">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rekomendasi_select" class="form-label font-weight-bold">
                                        <i class="mdi mdi-clipboard-check-outline mr-2"></i>Pilih Rekomendasi
                                    </label>
                                    <select class="form-control" id="rekomendasi_select" name="rekomendasi_select" required>
                                        <option value="">-- Pilih Rekomendasi --</option>
                                        @foreach($rekomendasiList as $rekomendasi)
                                            <option value="{{ $rekomendasi->id }}">
                                                {{ $rekomendasi->kode_temuan }} - {{ Str::limit($rekomendasi->nama_temuan, 50) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="file" class="form-label font-weight-bold">
                                        <i class="mdi mdi-file-document-outline mr-2"></i>Pilih File
                                    </label>
                                    <input type="file" class="form-control" id="file" name="file" required>
                                    <small class="form-text text-muted">
                                        Format: JPG, PNG, PDF, DOC, XLS, PPT, ZIP | Max: 10MB
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-gradient-primary btn-lg w-100" id="uploadBtn">
                                    <i class="mdi mdi-upload mr-2"></i>
                                    Upload File
                                </button>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress mt-3" id="uploadProgress" style="display: none;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 style="width: 0%" id="uploadProgressBar"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- File List Section -->
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-gradient-info text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 text-white">
                            <i class="mdi mdi-file-multiple-outline mr-2"></i>
                            File Data Dukung yang Telah Diupload
                        </h4>
                        <span class="badge bg-white text-primary px-3 py-2">
                            {{ count($uploadedFiles) }} file
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($uploadedFiles) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="filesTable">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th>Nama File</th>
                                        <th>Ukuran</th>
                                        <th>Tanggal Upload</th>
                                        <th>Diupload Oleh</th>
                                        <th style="width: 200px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($uploadedFiles as $index => $file)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @php
                                                        $extension = pathinfo($file->nama_file, PATHINFO_EXTENSION);
                                                        $iconClass = '';
                                                        switch(strtolower($extension)) {
                                                            case 'pdf':
                                                                $iconClass = 'mdi-file-pdf text-danger';
                                                                break;
                                                            case 'doc':
                                                            case 'docx':
                                                                $iconClass = 'mdi-file-word text-primary';
                                                                break;
                                                            case 'xls':
                                                            case 'xlsx':
                                                                $iconClass = 'mdi-file-excel text-success';
                                                                break;
                                                            case 'ppt':
                                                            case 'pptx':
                                                                $iconClass = 'mdi-file-powerpoint text-warning';
                                                                break;
                                                            case 'jpg':
                                                            case 'jpeg':
                                                            case 'png':
                                                                $iconClass = 'mdi-file-image text-info';
                                                                break;
                                                            case 'zip':
                                                                $iconClass = 'mdi-zip-box text-secondary';
                                                                break;
                                                            default:
                                                                $iconClass = 'mdi-file-outline text-muted';
                                                        }
                                                    @endphp
                                                    <i class="mdi {{ $iconClass }} mr-2" style="font-size: 1.5em;"></i>
                                                    <div>
                                                        <strong>{{ $file->original_name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ basename($file->nama_file) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($file->file_size)
                                                    {{ number_format($file->file_size / 1024, 2) }} KB
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @php
                                                    $user = \App\Models\User::find($file->uploaded_by);
                                                @endphp
                                                {{ $user->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ asset($file->nama_file) }}" target="_blank"
                                                       class="btn btn-sm btn-info" title="Lihat File">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    <a href="{{ asset($file->nama_file) }}" download
                                                       class="btn btn-sm btn-success" title="Download File">
                                                        <i class="mdi mdi-download"></i>
                                                    </a>
                                                    @if($allowUpload)
                                                        <button type="button" class="btn btn-sm btn-danger delete-file-btn"
                                                                data-file-id="{{ $file->id }}"
                                                                data-file-name="{{ $file->original_name }}"
                                                                title="Hapus File">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="mdi mdi-file-outline mdi-72px text-muted mb-3"></i>
                            <h5 class="text-muted">Belum Ada File</h5>
                            <p class="text-muted">
                                @if($allowUpload)
                                    Belum ada file data dukung yang diupload untuk rekomendasi ini.
                                @else
                                    Status pengawasan tidak memungkinkan untuk upload file.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="mdi mdi-delete mr-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus file <strong id="deleteFileName"></strong>?</p>
                <p class="text-danger"><small>Tindakan ini tidak dapat dibatalkan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                    <i class="mdi mdi-delete mr-2"></i>Hapus
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable for files
    $('#filesTable').DataTable({
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
            { orderable: false, targets: [5] } // Disable sorting for Action column
        ]
    });

    // Initialize DataTable for rekomendasi list
    $('#rekomendasiListTable').DataTable({
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
            { orderable: false, targets: [5] } // Disable sorting for Action column
        ]
    });

    // Handle rekomendasi selection from select dropdown
    $('#rekomendasi_select').on('change', function() {
        var selectedId = $(this).val();
        $('#selected_rekomendasi_id').val(selectedId);
    });

    // Handle upload button click from table
    $('.upload-to-rekomendasi-btn').on('click', function() {
        var rekomendasiId = $(this).data('rekomendasi-id');
        var rekomendasiName = $(this).data('rekomendasi-name');

        // Set the selected rekomendasi in the form
        $('#rekomendasi_select').val(rekomendasiId).trigger('change');

        // Scroll to upload form
        $('html, body').animate({
            scrollTop: $('#uploadForm').offset().top - 100
        }, 500);

        // Focus on file input
        setTimeout(function() {
            $('#file').focus();
        }, 600);

        toastr.info('Rekomendasi "' + rekomendasiName + '" telah dipilih. Silakan pilih file untuk diupload.');
    });

    // Toggle full text for long rekomendasi
    $('.toggle-full-text').on('click', function(e) {
        e.preventDefault();
        var fullText = $(this).data('full-text');
        var parentDiv = $(this).parent();

        if ($(this).text().includes('[Lihat semua]')) {
            parentDiv.html(fullText + ' <a href="#" class="text-primary toggle-full-text" data-full-text="' + fullText + '"><small>[Sembunyikan]</small></a>');
        } else {
            var shortText = fullText.length > 100 ? fullText.substring(0, 100) + '...' : fullText;
            parentDiv.html(shortText + ' <a href="#" class="text-primary toggle-full-text" data-full-text="' + fullText + '"><small>[Lihat semua]</small></a>');
        }

        // Re-bind the click event
        $('.toggle-full-text').off('click').on('click', arguments.callee);
    });

    // File Upload Form
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();

        // Validate rekomendasi selection
        var selectedRekomendasi = $('#selected_rekomendasi_id').val();
        if (!selectedRekomendasi) {
            toastr.error('Silakan pilih rekomendasi terlebih dahulu');
            return;
        }

        var formData = new FormData(this);
        var uploadBtn = $('#uploadBtn');
        var uploadProgress = $('#uploadProgress');
        var uploadProgressBar = $('#uploadProgressBar');

        // Disable button and show progress
        uploadBtn.prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin mr-2"></i>Uploading...');
        uploadProgress.show();

        $.ajax({
            url: '{{ route("opdTL.uploadFileRekomendasi") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        uploadProgressBar.css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    location.reload(); // Reload to show new file
                } else {
                    toastr.error(response.message);
                }
            },
            error: function(xhr) {
                var message = 'Upload gagal';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                toastr.error(message);
            },
            complete: function() {
                uploadBtn.prop('disabled', false).html('<i class="mdi mdi-upload mr-2"></i>Upload File');
                uploadProgress.hide();
                uploadProgressBar.css('width', '0%');
            }
        });
    });

    // Delete File
    var fileIdToDelete = null;

    $('.delete-file-btn').on('click', function() {
        fileIdToDelete = $(this).data('file-id');
        var fileName = $(this).data('file-name');
        $('#deleteFileName').text(fileName);
        $('#deleteModal').modal('show');
    });

    $('#confirmDeleteBtn').on('click', function() {
        if (fileIdToDelete) {
            $.ajax({
                url: '{{ route("opdTL.deleteFileRekomendasi") }}',
                type: 'DELETE',
                data: {
                    file_id: fileIdToDelete,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        location.reload(); // Reload to remove deleted file
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    var message = 'Hapus file gagal';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    toastr.error(message);
                }
            });
            $('#deleteModal').modal('hide');
        }
    });

    // File validation
    $('#file').on('change', function() {
        var file = this.files[0];
        if (file) {
            var maxSize = 10 * 1024 * 1024; // 10 MB
            var allowedTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip'];
            var fileExtension = file.name.split('.').pop().toLowerCase();

            if (file.size > maxSize) {
                toastr.error('Ukuran file terlalu besar. Maksimal 10MB.');
                this.value = '';
                return;
            }

            if (allowedTypes.indexOf(fileExtension) === -1) {
                toastr.error('Format file tidak didukung. Gunakan: ' + allowedTypes.join(', '));
                this.value = '';
                return;
            }
        }
    });
});
</script>
@endsection
@endsection
