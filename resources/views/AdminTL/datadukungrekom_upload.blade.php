@extends('template')
@section('content')
<style>
    /* Upload Progress Styles */
    #progressBarsContainer {
        max-height: 400px;
        overflow-y: auto;
    }

    .progress {
        background-color: #e9ecef;
        border-radius: 0.375rem;
    }

    .progress-bar {
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        background-color: #0d6efd;
        transition: width 0.6s ease;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .upload-item {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background-color: #fff;
    }

    .upload-item:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .file-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .file-name {
        font-weight: 600;
        color: #495057;
        word-break: break-word;
    }

    .file-size {
        font-size: 0.875rem;
        color: #6c757d;
        margin-left: 0.5rem;
    }

    .upload-status {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .btn-delete-file {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    /* Status LHP Styling */
    .status-lhp-container {
        position: relative;
    }

    .status-lhp-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .status-belum-jadi { background-color: #ffc107; color: #000; }
    .status-di-proses { background-color: #17a2b8; color: #fff; }
    .status-diterima { background-color: #28a745; color: #fff; }
    .status-ditolak { background-color: #dc3545; color: #fff; }

    .alasan-verifikasi-box {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-left: 4px solid #007bff;
        font-style: italic;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Button trigger modal -->


<div class="card mb-4" style="width: 100%;">
    <div class="card-header">Data Penugasan</div>
    <div class="card-body">
        <form action="{{ url('/jabatan_baru'.$pengawasan['id']) }}" method="post" enctype="multipart/form-data">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-3 mt-2">
                    <label for="">Nomor Surat </label>
                </div>
                <div class="col-3 mb-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ "700.1.1" }}</textarea>
                </div>
                <div class="col-3 mb-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $pengawasan['noSurat'] }}</textarea>
                </div>
                <div class="col-3 mb-3">
                <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{"03/2025" }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-2">
                    Jenis Pengawasan
                </div>
                <div class="col-9">
                <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $pengawasan['nama_jenispengawasan'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-3">
                    Obrik Pengawasan
                </div>
                <div class="col-9 mt-3">
                <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $pengawasan['nama_obrik'] }}</textarea>
                </div>
            </div>
                <div class="row">
                <div class="col-3 mt-3">
                    Tanggal Pelaksanaan
                </div>
                <div class="col-3 mt-3">
                <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $pengawasan['tanggalAwalPenugasan'] }}</textarea>
                </div>
                <div class="col-3 mt-3">
                    s/d
                </div>
                <div class="col-3 mt-3">
                <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $pengawasan['tanggalAkhirPenugasan'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-3">
                    <label for="">Status LHP </label>
                </div>
                <div class="col-9 mt-3">
                    @php
                        $status = $pengawasan['status_LHP'] ?? 'Belum Jadi';
                    @endphp
                    <div class="position-relative">
                        <div class="input-group">
                            <input type="text"
                                   name="status_lhp"
                                   style="color: black; background-color:white"
                                   class="form-control"
                                   readonly
                                   value="{{ $status }}">
                            <div class="input-group-append">
                                <span class="input-group-text">
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

                        {{-- Status Badge --}}
                        <div class="status-lhp-badge
                                    @if($status == 'Belum Jadi') status-belum-jadi
                                    @elseif($status == 'Di Proses') status-di-proses
                                    @elseif($status == 'Diterima') status-diterima
                                    @elseif($status == 'Ditolak') status-ditolak
                                    @endif">
                            @if($status == 'Belum Jadi')
                                <i class="fas fa-exclamation"></i>
                            @elseif($status == 'Di Proses')
                                <i class="fas fa-sync-alt fa-spin"></i>
                            @elseif($status == 'Diterima')
                                <i class="fas fa-check"></i>
                            @elseif($status == 'Ditolak')
                                <i class="fas fa-times"></i>
                            @endif
                        </div>
                    </div>
                    @if(isset($pengawasan['tgl_verifikasi']) && $pengawasan['tgl_verifikasi'])
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt"></i>
                            Terakhir diverifikasi: {{ \Carbon\Carbon::parse($pengawasan['tgl_verifikasi'])->format('d/m/Y H:i') }}
                        </small>
                    @endif
                    @if(isset($pengawasan['alasan_verifikasi']) && $pengawasan['alasan_verifikasi'])
                        <div class="mt-3">
                            <div class="card">
                                <div class="card-header py-2" style="background-color: #f8f9fa;">
                                    <small class="text-muted mb-0">
                                        <i class="fas fa-comment-alt"></i>
                                        <strong>Alasan Verifikasi:</strong>
                                    </small>
                                </div>
                                <div class="card-body py-2">
                                    <div class="alasan-verifikasi-box p-2 rounded" style="font-size: 0.875rem;">
                                        {{ $pengawasan['alasan_verifikasi'] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Show verification link for eligible statuses --}}
                    @if(in_array($pengawasan['status_LHP'] ?? 'Belum Jadi', ['Belum Jadi', 'Di Proses']))
                        <div class="mt-2">
                            @php
                                $verifikasiType = 'rekomendasi'; // Default type
                                if (isset($pengawasan['jenis']) && strpos(strtolower($pengawasan['jenis']), 'temuan') !== false) {
                                    $verifikasiType = 'temuan';
                                } elseif (isset($pengawasan['tipe']) && strpos(strtolower($pengawasan['tipe']), 'temuan') !== false) {
                                    $verifikasiType = 'temuan';
                                }
                            @endphp
                            <a href="{{ route('adminTL.verifikasi.show', [$verifikasiType, $pengawasan['id']]) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Kelola Verifikasi
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4" style="width: 100%;">
    <div class="card-header">Data Pengawasan</div>
    <div class="card-body">
        {{-- <form action="{{ url('/jabatan_baru'.$penugasan['id']) }}" method="post" enctype="multipart/form-data"> --}}
            @method('post')
            @csrf
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="">Tanggal Surat Keluar </label>
                    <input type="date" name="tglkeluar" style="color: black; background-color:white" class="form-control" value="{{ $pengawasan['tglkeluar'] }}"  >
                </div>
                 <div class="col-4 mb-3">
                    <label for="">Tipe Rekomendasi </label>
                    <select name="tipe" id="" class="form-control" style="color: black; background-color:white">
                        <option value="Rekomendasi" @if ($pengawasan['tipe']=='Rekomendasi')selected='selected' @endif >Rekomendasi</option>
                        <option value="TemuandanRekomendasi" @if ($pengawasan['tipe']=='TemuandanRekomendasi')selected='selected' @endif >Temuan dan Rekomendasi</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label for="">Jenis Pemeriksaan </label>
                     <select name="jenis" id="" class="form-control" style="color: black; background-color:white">
                        <option value="pdtt" @if ($pengawasan['jenis']=='pdtt')selected='selected' @endif>PDTT</option>
                        <option value="nspk" @if ($pengawasan['jenis']=='nspk')selected='selected' @endif>NSPK</option>
                     </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="">Wilayah </label>
                     <select name="wilayah" id="" class="form-control" style="color: black; background-color:white">
                        <option value="wilayah1" @if ($pengawasan['wilayah']=='wilayah1')selected='selected' @endif>Wilayah 1</option>
                        <option value="wilayah2" @if ($pengawasan['wilayah']=='wilayah2')selected='selected' @endif>Wilayah 2</option>
                     </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="">Pemeriksa </label>
                     <select name="pemeriksa" id="" class="form-control" style="color: black; background-color:white">
                        <option value="auditor" @if ($pengawasan['pemeriksa']=='auditor')selected='selected' @endif>Auditor</option>
                        <option value="ppupd"   @if ($pengawasan['pemeriksa']=='ppupd')selected='selected' @endif>PPUPD</option>
                     </select>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Rekomendasi dengan Upload File -->
<div class="card mb-4" style="width: 100%;">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fa-solid fa-list-check"></i> Data Rekomendasi & Upload File Pendukung
        </h5>
    </div>
    <div class="card-body">
        {{-- Debug: Show data structure --}}
        @php
            if (app()->environment(['local', 'testing'])) {
                echo "<!-- DEBUG: existingData count: " . (isset($existingData) ? count($existingData) : 0) . " -->";
                if (isset($existingData) && count($existingData) > 0) {
                    echo "<!-- DEBUG: First item structure: " . json_encode($existingData->first()) . " -->";
                }
            }
        @endphp

        @if(isset($existingData) && count($existingData) > 0)
            @php $itemCounter = 1; @endphp
            @foreach($existingData as $item)
                @include('AdminTL.partials.hierarchy_item', ['item' => $item, 'itemNumber' => $itemCounter, 'parentNumber' => ''])
                @php $itemCounter++; @endphp
            @endforeach
        @else
            <div class="text-center text-muted py-5">
                <i class="fa-solid fa-exclamation-circle fa-3x mb-3"></i>
                <h5>Belum Ada Data Rekomendasi</h5>
                <p>Silakan buat data temuan dan rekomendasi terlebih dahulu.</p>
            </div>
        @endif
    </div>
</div>

<!-- Legacy Upload Section (keep for now) -->
<div class="card mt-3" style="width: 100%; ">
    <div class="card-header">Upload Data Dukung Global</div>
    <div class="card-body">
        <div class="text-center text-muted">
            <p><em>Upload file per rekomendasi sudah tersedia di setiap item rekomendasi di atas.</em></p>
        </div>
    </div>
</div>

<div class="card mt-3" style="width: 100%; ">
    <div class="card-header">Berkas Data Dukung</div>
    <div class="card-body">
        @php
            // Get all uploaded files for this pengawasan
            $allUploadedFiles = \App\Models\DataDukung::where('id_pengawasan', $pengawasan['id'])->get();
        @endphp

        @if($allUploadedFiles->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Terkait Rekomendasi</th>
                            <th>Keterangan</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allUploadedFiles as $file)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <i class="fas fa-file"></i>
                                {{ basename($file->nama_file) }}
                            </td>
                            <td>
                                @if($file->id_jenis_temuan)
                                    @php
                                        $relatedItem = DB::table('jenis_temuans')->find($file->id_jenis_temuan);
                                    @endphp
                                    @if($relatedItem)
                                        {{ $relatedItem->rekomendasi ?? 'N/A' }}
                                    @else
                                        <span class="text-muted">Item terhapus</span>
                                    @endif
                                @else
                                    <span class="text-muted">Global</span>
                                @endif
                            </td>
                            <td>{{ $file->keterangan_file ?? '-' }}</td>
                            <td>{{ $file->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ asset($file->nama_file) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                <a href="{{ asset($file->nama_file) }}" download class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                                <button type="button" onclick="deleteFile({{ $file->id }}, this)" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center text-muted py-4">
                <i class="fas fa-file-upload fa-3x mb-3"></i>
                <p>Belum ada file yang diupload</p>
            </div>
        @endif
    </div>
</div>

<!-- Legacy Upload Section -->
<div class="card mt-3" style="width: 100%;">
    <div class="card-header">Upload Data Dukung Global</div>
    <div class="card-body">
        <form id="uploadForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
            <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">

            <div class="row">
                <div class="col-12">
                    <input type="file" id="fileUpload" multiple placeholder="choose file or browse" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.svg,.zip,.docx,.xlsx,.doc,.xls,.ppt,.pptx"/>
                </div>
            </div>
            <button type="button" onclick="uploadFiles()" class="mt-3 btn btn-info">
                <i class="fas fa-upload"></i> Upload Global
            </button>
        </form>

        <!-- Progress container -->
        <div class="mt-4" id="uploadProgress" style="display: none;">
            <h6>Upload Progress:</h6>
            <div id="progressBarsContainer">
                <!-- Progress bars will be dynamically added here -->
            </div>
        </div>

        <!-- Upload status -->
        <div id="uploadStatus" class="mt-3"></div>

        <div class="mt-3">
            <small class="text-muted">
                <i class="fa-solid fa-info-circle"></i>
                File yang diupload di sini akan menjadi file umum yang tidak terkait dengan rekomendasi spesifik.
                Untuk file yang terkait dengan rekomendasi tertentu, gunakan fitur upload di setiap item rekomendasi.
            </small>
        </div>
    </div>
</div>

    <script>
        let uploadedFiles = []; // Array to store uploaded file information

        function uploadFiles() {
            var fileInput = document.getElementById('fileUpload');
            var files = fileInput.files;

            if (files.length === 0) {
                alert('Please select files to upload');
                return;
            }

            // Show progress container
            document.getElementById('uploadProgress').style.display = 'block';

            // Clear previous progress bars
            document.getElementById('progressBarsContainer').innerHTML = '';
            document.getElementById('uploadStatus').innerHTML = '';

            var allowedExtensions = ['.jpg', '.jpeg', '.png', '.pdf', '.svg', '.zip', '.docx', '.xlsx', '.doc', '.xls', '.ppt', '.pptx'];
            var validFiles = [];

            // Validate files first
            for (var i = 0; i < files.length; i++) {
                var fileExtension = files[i].name.substring(files[i].name.lastIndexOf('.')).toLowerCase();

                if (allowedExtensions.includes(fileExtension)) {
                    validFiles.push(files[i]);
                } else {
                    alert('Invalid file type: ' + files[i].name + ' (' + fileExtension + ')');
                }
            }

            if (validFiles.length === 0) {
                document.getElementById('uploadProgress').style.display = 'none';
                return;
            }

            // Upload each valid file
            for (var i = 0; i < validFiles.length; i++) {
                uploadGlobalFile(validFiles[i], i + 1);
            }
        }

        function uploadGlobalFile(file, index) {
            console.log('Starting upload for file:', file.name, 'Size:', file.size);

            var formData = new FormData();
            formData.append('file', file);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('id_pengawasan', document.querySelector('input[name="id_pengawasan"]').value);
            formData.append('id_penugasan', document.querySelector('input[name="id_penugasan"]').value);

            console.log('FormData prepared:', {
                file_name: file.name,
                file_size: file.size,
                id_pengawasan: document.querySelector('input[name="id_pengawasan"]').value,
                id_penugasan: document.querySelector('input[name="id_penugasan"]').value
            });

            // Create progress bar container
            var progressContainer = document.createElement('div');
            progressContainer.className = 'mb-3 p-3 border rounded';
            progressContainer.id = 'progress_' + index;

            // File info row
            var fileInfoRow = document.createElement('div');
            fileInfoRow.className = 'd-flex justify-content-between align-items-center mb-2';

            var fileName = document.createElement('span');
            fileName.className = 'fw-bold';
            fileName.textContent = file.name;

            var fileSize = document.createElement('span');
            fileSize.className = 'text-muted small';
            fileSize.textContent = formatFileSize(file.size);

            var actionButtons = document.createElement('div');

            fileInfoRow.appendChild(fileName);
            fileInfoRow.appendChild(fileSize);
            fileInfoRow.appendChild(actionButtons);

            // Progress bar
            var progressWrapper = document.createElement('div');
            progressWrapper.className = 'progress';
            progressWrapper.style.height = '25px';

            var progressBar = document.createElement('div');
            progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated';
            progressBar.setAttribute('role', 'progressbar');
            progressBar.style.width = '0%';
            progressBar.textContent = '0%';

            progressWrapper.appendChild(progressBar);

            // Status message
            var statusDiv = document.createElement('div');
            statusDiv.className = 'mt-2 small text-muted';
            statusDiv.textContent = 'Preparing upload...';

            progressContainer.appendChild(fileInfoRow);
            progressContainer.appendChild(progressWrapper);
            progressContainer.appendChild(statusDiv);

            document.getElementById('progressBarsContainer').appendChild(progressContainer);

            var xhr = new XMLHttpRequest();

            // Upload progress
            xhr.upload.addEventListener('progress', function(event) {
                if (event.lengthComputable) {
                    var percent = Math.round((event.loaded / event.total) * 100);
                    progressBar.style.width = percent + '%';
                    progressBar.textContent = percent + '%';

                    if (percent < 100) {
                        statusDiv.textContent = 'Uploading... ' + formatFileSize(event.loaded) + ' / ' + formatFileSize(event.total);
                        progressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-info';
                    }
                }
            });

            // Upload complete
            xhr.addEventListener('load', function(event) {
                try {
                    var response = JSON.parse(event.target.responseText);

                    if (response.success) {
                        progressBar.className = 'progress-bar bg-success';
                        progressBar.style.width = '100%';
                        progressBar.textContent = '100%';
                        statusDiv.innerHTML = '<i class="fas fa-check-circle text-success"></i> Upload successful';

                        // Add delete button
                        var deleteBtn = document.createElement('button');
                        deleteBtn.className = 'btn btn-sm btn-outline-danger';
                        deleteBtn.innerHTML = '<i class="fas fa-times"></i>';
                        deleteBtn.onclick = function() {
                            deleteGlobalFile(response.file_id, progressContainer);
                        };
                        actionButtons.appendChild(deleteBtn);

                        // Store file info
                        uploadedFiles.push({
                            id: response.file_id,
                            original_name: file.name,
                            stored_name: response.stored_name,
                            path: response.path,
                            size: file.size
                        });

                        console.log('File uploaded successfully:', response);

                        // Refresh page after successful upload to show the new file in the list
                        setTimeout(function() {
                            location.reload();
                        }, 1000);

                    } else {
                        throw new Error(response.message || 'Upload failed');
                    }
                } catch (error) {
                    progressBar.className = 'progress-bar bg-danger';
                    progressBar.style.width = '100%';
                    progressBar.textContent = 'Error';
                    statusDiv.innerHTML = '<i class="fas fa-exclamation-circle text-danger"></i> ' + error.message;
                    console.error('Upload error:', error);
                }
            });

            // Upload error
            xhr.addEventListener('error', function(event) {
                progressBar.className = 'progress-bar bg-danger';
                progressBar.style.width = '100%';
                progressBar.textContent = 'Error';
                statusDiv.innerHTML = '<i class="fas fa-exclamation-circle text-danger"></i> Network error occurred';
                console.error('Network error:', event);
            });

            statusDiv.textContent = 'Starting upload...';
            xhr.open('POST', '{{ url("adminTL/rekom/upload-file") }}', true);
            xhr.send(formData);
        }

        function deleteGlobalFile(fileId, progressContainer) {
            if (!confirm('Are you sure you want to delete this file?')) {
                return;
            }

            var formData = new FormData();
            formData.append('file_id', fileId);
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            var xhr = new XMLHttpRequest();

            xhr.addEventListener('load', function(event) {
                try {
                    var response = JSON.parse(event.target.responseText);

                    if (response.success) {
                        progressContainer.remove();

                        // Remove from uploadedFiles array
                        uploadedFiles = uploadedFiles.filter(file => file.id !== fileId);

                        console.log('File deleted successfully');
                    } else {
                        alert('Error deleting file: ' + response.message);
                    }
                } catch (error) {
                    alert('Error deleting file: ' + error.message);
                }
            });

            xhr.addEventListener('error', function(event) {
                alert('Network error occurred while deleting file');
            });

            xhr.open('POST', '{{ url("adminTL/rekom/delete-file") }}', true);
            xhr.send(formData);
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Clear file input after successful uploads
        document.getElementById('fileUpload').addEventListener('change', function() {
            // Reset the upload status when new files are selected
            document.getElementById('uploadProgress').style.display = 'none';
            document.getElementById('uploadStatus').innerHTML = '';
        });

        // Delete uploaded file from database
        function deleteUploadedFile(fileId, buttonElement) {
            if (!confirm('Apakah Anda yakin ingin menghapus file ini?')) {
                return;
            }

            var formData = new FormData();
            formData.append('file_id', fileId);
            formData.append('_token', document.querySelector('input[name="_token"]').value);

            // Disable button during request
            buttonElement.disabled = true;
            buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';

            var xhr = new XMLHttpRequest();

            xhr.addEventListener('load', function(event) {
                try {
                    var response = JSON.parse(event.target.responseText);

                    if (response.success) {
                        // Remove the table row
                        var row = buttonElement.closest('tr');
                        row.remove();

                        // Show success message
                        alert('File berhasil dihapus');

                        // Refresh page to update file list
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                        buttonElement.disabled = false;
                        buttonElement.innerHTML = '<i class="fas fa-trash"></i> Hapus';
                    }
                } catch (error) {
                    alert('Error: ' + error.message);
                    buttonElement.disabled = false;
                    buttonElement.innerHTML = '<i class="fas fa-trash"></i> Hapus';
                }
            });

            xhr.addEventListener('error', function(event) {
                alert('Network error occurred while deleting file');
                buttonElement.disabled = false;
                buttonElement.innerHTML = '<i class="fas fa-trash"></i> Hapus';
            });

            xhr.open('POST', '{{ url("adminTL/rekom/delete-file") }}', true);
            xhr.send(formData);
        }

        // Handle file upload per rekomendasi (for hierarchy items)
        function uploadFile(button) {
            const form = button.closest('.file-upload-form');
            const fileInput = form.querySelector('input[type="file"]');
            const keteranganInput = form.querySelector('input[name="keterangan_file"]');
            const rekomendasiId = form.dataset.rekomendasiId;

            if (!fileInput.files[0]) {
                alert('Pilih file terlebih dahulu!');
                return;
            }

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('keterangan_file', keteranganInput.value);
            formData.append('id_jenis_temuan', rekomendasiId);
            formData.append('id_pengawasan', '{{ $pengawasan["id"] }}');
            formData.append('_token', '{{ csrf_token() }}');

            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading...';

            fetch('{{ url("adminTL/rekom/upload-file-rekomendasi") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('File berhasil diupload!');
                    location.reload(); // Refresh to show new file
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat upload file');
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = '<i class="fa-solid fa-upload"></i> Upload';
            });
        }

        // Handle file upload for hierarchy items (uploadGlobalFile function)
        function uploadGlobalFile(button) {
            const form = button.closest('.file-upload-form');
            const fileInput = form.querySelector('input[name="file"]');
            const keteranganInput = form.querySelector('input[name="keterangan_file"]');
            const rekomendasiId = form.dataset.rekomendasiId;

            if (!fileInput.files[0]) {
                alert('Pilih file terlebih dahulu!');
                return;
            }

            // Debug: Log the data being sent
            console.log('Sending upload request with data:', {
                file_name: fileInput.files[0].name,
                file_size: fileInput.files[0].size,
                keterangan_file: keteranganInput.value,
                id_jenis_temuan: rekomendasiId,
                id_pengawasan: '{{ $pengawasan["id"] }}'
            });

            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            formData.append('keterangan_file', keteranganInput.value);
            formData.append('id_jenis_temuan', rekomendasiId);
            formData.append('id_pengawasan', '{{ $pengawasan["id"] }}');
            formData.append('_token', '{{ csrf_token() }}');

            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Uploading...';

            fetch('{{ url("adminTL/rekom/upload-file-rekomendasi") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert('File berhasil diupload!');
                    location.reload(); // Refresh to show new file
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat upload file: ' + error.message);
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = '<i class="fa-solid fa-upload"></i> Upload';
            });
        }

        // Handle file deletion for hierarchy items
        function deleteFile(fileId, buttonElement) {
            if (!confirm('Yakin ingin menghapus file ini?')) {
                return;
            }

            buttonElement.disabled = true;
            buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            const formData = new FormData();
            formData.append('file_id', fileId);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ url("adminTL/rekom/delete-file-rekomendasi") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh to update file list
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus file');
            })
            .finally(() => {
                buttonElement.disabled = false;
                buttonElement.innerHTML = '<i class="fas fa-trash"></i> Hapus';
            });
        }

        // Handle file deletion for hierarchy items (deleteGlobalFile function)
        function deleteGlobalFile(fileId, buttonElement) {
            if (!confirm('Yakin ingin menghapus file ini?')) {
                return;
            }

            buttonElement.disabled = true;
            buttonElement.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

            const formData = new FormData();
            formData.append('file_id', fileId);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ url("adminTL/rekom/delete-file-rekomendasi") }}', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Refresh to update file list
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus file');
            })
            .finally(() => {
                buttonElement.disabled = false;
                buttonElement.innerHTML = '<i class="fas fa-trash"></i> Hapus';
            });
        }


    </script>






@endsection
