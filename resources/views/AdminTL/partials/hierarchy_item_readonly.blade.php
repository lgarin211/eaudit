{{-- Read-only hierarchy item partial for verification pages --}}
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

<div class="card mb-3 {{ $borderClass }} verification-readonly-card" style="margin-left: {{ $indentLevel * 20 }}px; background-color: var(--bg-secondary); border-color: var(--border-color);">
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
    <div class="card-body" style="background-color: var(--bg-primary);">
        {{-- Show item details if it's not just a container --}}
        @if(!empty($item->rekomendasi) && $indentLevel > 0)
            <div class="row mb-3">
                @if(!empty($item->kode_rekomendasi))
                <div class="col-md-3">
                    <strong class="text-white">Kode Rekomendasi:</strong><br>
                    <span class="badge bg-secondary">{{ $item->kode_rekomendasi }}</span>
                </div>
                @endif

                <div class="col-md-{{ empty($item->kode_rekomendasi) ? '12' : '9' }}">
                    <strong class="text-white">Rekomendasi:</strong><br>
                    <div class="form-control" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        {{ $item->rekomendasi }}
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                @if(!empty($item->keterangan))
                <div class="col-md-6">
                    <strong class="text-white">Keterangan:</strong><br>
                    <div class="form-control" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        {{ $item->keterangan }}
                    </div>
                </div>
                @endif

                @if($item->pengembalian > 0)
                <div class="col-md-{{ empty($item->keterangan) ? '12' : '6' }}">
                    <strong class="text-white">Pengembalian:</strong><br>
                    <div class="form-control" readonly style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);">
                        <span class="text-success fw-bold">Rp {{ number_format($item->pengembalian, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
            </div>
        @endif

        {{-- Read-only File Display Section - Only for leaf items (items without children) --}}
        @if(!empty($item->id) && !$hasChildren)
            <div class="border-top pt-3" style="border-color: var(--border-color) !important;">
                <h6 class="text-white"><i class="fa-solid fa-files"></i> File Data Dukung</h6>

                {{-- Display uploaded files (read-only) --}}
                <div class="uploaded-files">
                    @if(isset($item->uploadedFiles) && $item->uploadedFiles->count() > 0)
                        <div class="row">
                            @foreach($item->uploadedFiles as $file)
                                <div class="col-md-6 mb-2">
                                    <div class="card verification-file-card" style="background-color: var(--bg-secondary); border-color: var(--border-color);">
                                        <div class="card-body p-2">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <small class="text-white fw-bold">
                                                        <i class="fas fa-file"></i> {{ basename($file->nama_file) }}
                                                    </small>
                                                    @if($file->keterangan_file)
                                                        <br><small class="text-muted">{{ $file->keterangan_file }}</small>
                                                    @endif
                                                    <br><small class="text-muted">
                                                        <i class="fas fa-clock"></i> {{ $file->created_at->format('d/m/Y H:i') }}
                                                    </small>
                                                </div>
                                                <div>
                                                    <a href="{{ asset($file->nama_file) }}" target="_blank" class="btn btn-sm btn-info me-1" title="Lihat File">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ asset($file->nama_file) }}" download class="btn btn-sm btn-success" title="Download File">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info" style="background-color: var(--bg-info); border-color: var(--border-color); color: var(--text-primary);">
                            <i class="fa-solid fa-info-circle"></i> Belum ada file yang diupload untuk item ini
                        </div>
                    @endif
                </div>
            </div>
        @elseif(!empty($item->id) && $hasChildren)
            {{-- Show message for parent items that have children --}}
            <div class="border-top pt-3" style="border-color: var(--border-color) !important;">
                <div class="alert alert-info" style="background-color: var(--bg-info); border-color: var(--border-color); color: var(--text-primary);">
                    <i class="fa-solid fa-info-circle"></i>
                    <strong>File tersedia di sub-item:</strong> Item ini memiliki {{ count($item->children) }} sub-item dengan file data dukung masing-masing.
                </div>
            </div>
        @endif

        {{-- Render children recursively --}}
        @if($hasChildren)
            @php $childCounter = 1; @endphp
            @foreach($item->children as $child)
                @include('AdminTL.partials.hierarchy_item_readonly', [
                    'item' => $child,
                    'itemNumber' => $childCounter,
                    'parentNumber' => $currentNumber
                ])
                @php $childCounter++; @endphp
            @endforeach
        @endif
    </div>
</div>
