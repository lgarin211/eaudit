{{-- Render item hierarki secara rekursif --}}
@php
    $currentNumber = $parentNumber ? $parentNumber . '.' . $itemNumber : $itemNumber;
    $indentLevel = $item->level ?? 0;
    $hasChildren = isset($item->children) && count($item->children) > 0;

    // Tentukan warna border dan style berdasarkan level
    $borderClass = '';
    $bgClass = '';
    $iconClass = '';

    switch($indentLevel) {
        case 0: // Root level
            $borderClass = 'border-primary';
            $bgClass = 'bg-primary';
            $iconClass = 'fa-folder';
            break;
        case 1: // Sub level
            $borderClass = 'border-success';
            $bgClass = 'bg-success';
            $iconClass = 'fa-folder-open';
            break;
        case 2: // Sub-sub level
            $borderClass = 'border-warning';
            $bgClass = 'bg-warning';
            $iconClass = 'fa-file';
            break;
        case 3: // Sub-sub-sub level
            $borderClass = 'border-danger';
            $bgClass = 'bg-danger';
            $iconClass = 'fa-file-alt';
            break;
        default: // Level 4 and beyond
            $borderClass = 'border-dark';
            $bgClass = 'bg-dark';
            $iconClass = 'fa-file-code';
    }
@endphp

<div class="card mb-3 {{ $borderClass }}" style="margin-left: {{ $indentLevel * 20 }}px;">
    {{-- Header --}}
    @if($indentLevel == 0 || !empty($item->rekomendasi))
    <div class="card-header {{ $bgClass }} text-white">
        <h6 class="mb-0">
            <i class="fas {{ $iconClass }}"></i>
            <strong>{{ $currentNumber }}.</strong>

            {{-- Display content based on level and data availability --}}
            @if($indentLevel == 0)
                {{-- Root level: Show kode_temuan and nama_temuan if available --}}
                @if(!empty($item->kode_temuan) || !empty($item->nama_temuan))
                    {{ $item->kode_temuan ?? 'N/A' }} - {{ $item->nama_temuan ?? 'N/A' }}
                @else
                    {{ $item->rekomendasi ?? 'Kelompok ' . $currentNumber }}
                @endif
            @else
                {{-- Sub levels: Show rekomendasi --}}
                {{ $item->rekomendasi ?? 'Item ' . $currentNumber }}
            @endif
        </h6>
    </div>
    @endif

    {{-- Body --}}
    <div class="card-body">
        {{-- Show item details if it's not just a container --}}
        @if(!empty($item->rekomendasi) && $indentLevel > 0)
            <div class="row mb-3">
                @if(!empty($item->kode_rekomendasi))
                <div class="col-md-3">
                    <strong>Kode Rekomendasi:</strong><br>
                    <span class="badge bg-secondary">{{ $item->kode_rekomendasi }}</span>
                </div>
                @endif

                <div class="col-md-{{ empty($item->kode_rekomendasi) ? '12' : '9' }}">
                    <strong>Rekomendasi:</strong><br>
                    <p class="mb-0">{{ $item->rekomendasi }}</p>
                </div>
            </div>

            <div class="row mb-3">
                @if(!empty($item->keterangan))
                <div class="col-md-6">
                    <strong>Keterangan:</strong><br>
                    <p class="mb-0">{{ $item->keterangan }}</p>
                </div>
                @endif

                @if($item->pengembalian > 0)
                <div class="col-md-{{ empty($item->keterangan) ? '12' : '6' }}">
                    <strong>Pengembalian:</strong><br>
                    <span class="text-success fw-bold">Rp {{ number_format($item->pengembalian, 0, ',', '.') }}</span>
                </div>
                @endif
            </div>
        @endif

        {{-- File Upload Section - Only available for leaf items (items without children) --}}
        @if(!empty($item->id) && !$hasChildren)
            <div class="border-top pt-3">
                <h6><i class="fa-solid fa-upload"></i> Upload File Data Dukung</h6>

                {{-- File Upload Form --}}
                <form class="file-upload-form mb-3" data-rekomendasi-id="{{ $item->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx">
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="keterangan_file" placeholder="Keterangan file (opsional)">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn {{ $indentLevel == 0 ? 'btn-primary' : ($indentLevel == 1 ? 'btn-success' : ($indentLevel == 2 ? 'btn-warning' : 'btn-danger')) }} w-100" onclick="uploadGlobalFile(this)">
                                <i class="fa-solid fa-upload"></i> Upload
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Display uploaded files --}}
                <div class="uploaded-files">
                    @if(isset($item->uploadedFiles) && $item->uploadedFiles->count() > 0)
                        <h6><i class="fa-solid fa-files"></i> File yang sudah diupload:</h6>
                        <div class="row">
                            @foreach($item->uploadedFiles as $file)
                                <div class="col-md-6 mb-2">
                                    <div class="card">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <small class="text-muted">{{ basename($file->nama_file) }}</small>
                                                    @if($file->keterangan_file)
                                                        <br><small>{{ $file->keterangan_file }}</small>
                                                    @endif
                                                </div>
                                                <div>
                                                    <a href="{{ asset($file->nama_file) }}" target="_blank" class="btn btn-sm btn-info me-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" onclick="deleteGlobalFile({{ $file->id }}, this)" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-muted text-center py-2">
                            <i class="fa-solid fa-file-upload"></i> Belum ada file yang diupload
                        </div>
                    @endif
                </div>
            </div>
        @elseif(!empty($item->id) && $hasChildren)
            {{-- Show message for parent items that have children --}}
            <div class="border-top pt-3">
                <div class="alert alert-info">
                    <i class="fa-solid fa-info-circle"></i>
                    <strong>Upload file tersedia di sub-item:</strong> Item ini memiliki {{ count($item->children) }} sub-item. Silakan upload file pada masing-masing sub-item di bawah.
                </div>
            </div>
        @endif

        {{-- Render children recursively --}}
        @if($hasChildren)
            @php $childCounter = 1; @endphp
            @foreach($item->children as $child)
                @include('AdminTL.partials.hierarchy_item', [
                    'item' => $child,
                    'itemNumber' => $childCounter,
                    'parentNumber' => $currentNumber
                ])
                @php $childCounter++; @endphp
            @endforeach
        @endif
    </div>
</div>
