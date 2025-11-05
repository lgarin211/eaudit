<style>
    /* Component Spacing and Layout */
    #temuan-card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid var(--bs-border-color, #dee2e6);
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        background-color: var(--bs-body-bg, #ffffff);
    }

    #temuan-card .card-header {
        background-color: var(--bs-success, #198754);
        color: white;
        border-bottom: 1px solid var(--bs-border-color, #dee2e6);
        padding: 1rem 1.25rem;
    }

    #temuan-card .card-body {
        padding: 1.5rem 1.25rem;
    }

    /* Hierarchy Table Styles */
    .temuan-hierarchy-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        width: 100%;
        overflow-x: auto;
        min-width: 900px;
        position: relative;
        background-color: var(--bs-body-bg, #ffffff);
        margin-bottom: 1rem;
    }

    .temuan-hierarchy-item {
        margin-bottom: 2px;
        position: relative;
        clear: both;
    }

    .temuan-hierarchy-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        border: 2px solid var(--bs-border-color, #dee2e6);
        background-color: var(--bs-body-bg, #ffffff);
    }

    .temuan-hierarchy-table td {
        border: 2px solid var(--bs-border-color, #dee2e6);
        padding: 8px;
        vertical-align: top;
        color: var(--bs-body-color, #212529);
        position: relative;
    }

    .temuan-number-cell {
        width: 80px;
        min-width: 80px;
        text-align: center;
        font-weight: bold;
        background-color: var(--bs-secondary-bg, #f8f9fa);
        vertical-align: middle;
        color: var(--bs-body-color, #212529);
    }

    .temuan-content-cell {
        padding: 0 !important;
        background-color: var(--bs-body-bg, #ffffff);
        width: auto;
        max-width: calc(100% - 220px);
    }

    .temuan-action-cell {
        width: 140px;
        min-width: 140px;
        max-width: 140px;
        text-align: center;
        vertical-align: middle;
        background-color: var(--bs-secondary-bg, #f8f9fa);
        position: relative;
        padding: 8px !important;
        box-sizing: border-box;
        white-space: nowrap;
        overflow: visible;
    }

    .temuan-field-group {
        width: 100%;
        background-color: var(--bs-body-bg, #ffffff);
    }

    .temuan-field-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--bs-border-color, #dee2e6);
        min-height: 40px;
        padding: 4px 8px;
        background-color: var(--bs-body-bg, #ffffff);
    }

    .temuan-field-row:last-child {
        border-bottom: none;
    }

    .temuan-field-row label {
        min-width: 150px;
        font-weight: normal;
        margin: 0;
        padding-right: 10px;
        font-size: 14px;
        text-align: left;
        color: var(--bs-body-color, #212529);
    }

    .temuan-field-row .form-control {
        flex: 1;
        border: none;
        background: var(--bs-body-bg, #ffffff);
        resize: none;
        min-height: 30px;
        padding: 4px;
        font-size: 14px;
        color: var(--bs-body-color, #212529);
    }

    .temuan-field-row textarea.form-control {
        resize: vertical;
        min-height: 30px;
    }

    .temuan-field-row .form-control:focus {
        box-shadow: none;
        outline: 2px solid var(--bs-success, #198754);
        background-color: var(--bs-body-bg, #ffffff);
        color: var(--bs-body-color, #212529);
    }

    /* Level indentation - Prevent overlap */
    .temuan-level-0 {
        margin-left: 0;
        z-index: 3;
    }

    .temuan-level-1 {
        margin-left: 30px;
        margin-top: 2px;
        z-index: 2;
        position: relative;
    }

    .temuan-level-2 {
        margin-left: 60px;
        margin-top: 2px;
        z-index: 1;
        position: relative;
    }

    /* Ensure proper stacking */
    .temuan-hierarchy-item .temuan-hierarchy-table {
        position: relative;
        margin-bottom: 0;
    }

    /* Container styling to prevent overlap */
    .temuan-sub-items-container,
    .temuan-sub-sub-items-container {
        width: 100%;
        clear: both;
        overflow: hidden;
    }

    .temuan-sub-items-container {
        margin-top: 2px;
    }

    .temuan-sub-sub-items-container {
        margin-top: 2px;
        margin-left: 0;
    }

    /* Fix width calculation for indented items */
    .temuan-level-0 .temuan-hierarchy-table {
        width: 100%;
        min-width: 800px;
    }

    .temuan-level-1 .temuan-hierarchy-table {
        width: calc(100% - 30px);
        min-width: 750px;
    }

    .temuan-level-2 .temuan-hierarchy-table {
        width: calc(100% - 60px);
        min-width: 700px;
    }

    /* Responsive wrapper */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Specific styling for sub levels */
    .temuan-level-1 .temuan-action-cell,
    .temuan-level-2 .temuan-action-cell {
        position: sticky;
        right: 0;
        z-index: 10;
        box-shadow: -2px 0 4px rgba(0,0,0,0.1);
    }

    .temuan-level-1 .temuan-content-cell {
        max-width: calc(100% - 250px);
    }

    .temuan-level-2 .temuan-content-cell {
        max-width: calc(100% - 280px);
    }

    /* Ensure buttons stack properly */
    .temuan-level-1 .temuan-action-cell .btn,
    .temuan-level-2 .temuan-action-cell .btn {
        display: block !important;
        margin: 2px auto !important;
        width: 30px;
        height: 30px;
        padding: 0;
        font-size: 0.8rem;
    }

    /* Prevent floating issues */
    .temuan-hierarchy-item::after {
        content: "";
        display: table;
        clear: both;
    }

    /* Button styling */
    .temuan-btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        margin: 2px;
        display: inline-block !important;
        visibility: visible !important;
    }

    .temuan-add-sub, .temuan-remove-item, .temuan-add-main {
        display: inline-block !important;
        visibility: visible !important;
    }

    .temuan-action-cell .btn {
        display: inline-block !important;
        margin: 1px;
        font-size: 0.75rem;
        padding: 0.2rem 0.4rem;
    }

    /* Custom button colors untuk sub dan sub-sub */
    .btn-purple {
        background-color: #8B5CF6;
        border-color: #8B5CF6;
        color: white;
    }

    .btn-purple:hover {
        background-color: #7C3AED;
        border-color: #7C3AED;
        color: white;
    }

    .btn-pink {
        background-color: #EC4899;
        border-color: #EC4899;
        color: white;
    }

    .btn-pink:hover {
        background-color: #DB2777;
        border-color: #DB2777;
        color: white;
    }

    /* Dark theme support untuk custom buttons */
    @media (prefers-color-scheme: dark) {
        .btn-purple {
            background-color: #A855F7;
            border-color: #A855F7;
        }

        .btn-purple:hover {
            background-color: #9333EA;
            border-color: #9333EA;
        }

        .btn-pink {
            background-color: #F472B6;
            border-color: #F472B6;
        }

        .btn-pink:hover {
            background-color: #EC4899;
            border-color: #EC4899;
        }
    }

    [data-bs-theme="dark"] .btn-purple {
        background-color: #A855F7;
        border-color: #A855F7;
    }

    [data-bs-theme="dark"] .btn-purple:hover {
        background-color: #9333EA;
        border-color: #9333EA;
    }

    [data-bs-theme="dark"] .btn-pink {
        background-color: #F472B6;
        border-color: #F472B6;
    }

    [data-bs-theme="dark"] .btn-pink:hover {
        background-color: #EC4899;
        border-color: #EC4899;
    }

    /* Dark theme specific styles */
    @media (prefers-color-scheme: dark) {
        #temuan-card {
            background-color: #212529;
            border-color: #495057;
            box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
        }

        #temuan-card .card-header {
            background-color: #198754;
            border-bottom-color: #495057;
            color: #ffffff;
        }

        #temuan-card .card-body {
            background-color: #212529;
        }

        .temuan-hierarchy-container {
            background-color: #212529;
        }

        .temuan-hierarchy-table {
            border-color: #495057;
            background-color: #212529;
        }

        .temuan-hierarchy-table td {
            border-color: #495057;
            color: #ffffff;
        }

        .temuan-number-cell {
            background-color: #343a40;
            color: #ffffff;
        }

        .temuan-content-cell {
            background-color: #212529;
        }

        .temuan-action-cell {
            background-color: #343a40;
        }

        .temuan-level-1 .temuan-action-cell,
        .temuan-level-2 .temuan-action-cell {
            background-color: #343a40 !important;
            box-shadow: -2px 0 4px rgba(0,0,0,0.3);
        }

        .temuan-field-group {
            background-color: #212529;
        }

        .temuan-field-row {
            border-bottom-color: #495057;
            background-color: #212529;
        }

        .temuan-field-row label {
            color: #ffffff;
        }

        .temuan-field-row .form-control {
            background-color: #212529;
            color: #ffffff;
        }

        .temuan-field-row .form-control:focus {
            background-color: #212529;
            color: #ffffff;
            outline-color: #198754;
        }
    }

    /* Bootstrap dark theme class support */
    [data-bs-theme="dark"] #temuan-card {
        background-color: #212529;
        border-color: #495057;
        box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
    }

    [data-bs-theme="dark"] #temuan-card .card-header {
        background-color: #198754;
        border-bottom-color: #495057;
        color: #ffffff;
    }

    [data-bs-theme="dark"] #temuan-card .card-body {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .temuan-hierarchy-container {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .temuan-hierarchy-table {
        border-color: #495057;
        background-color: #212529;
    }

    [data-bs-theme="dark"] .temuan-hierarchy-table td {
        border-color: #495057;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .temuan-number-cell {
        background-color: #343a40;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .temuan-content-cell {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .temuan-action-cell {
        background-color: #343a40;
    }

    [data-bs-theme="dark"] .temuan-level-1 .temuan-action-cell,
    [data-bs-theme="dark"] .temuan-level-2 .temuan-action-cell {
        background-color: #343a40 !important;
        box-shadow: -2px 0 4px rgba(0,0,0,0.3);
    }

    [data-bs-theme="dark"] .temuan-field-group {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .temuan-field-row {
        border-bottom-color: #495057;
        background-color: #212529;
    }

    [data-bs-theme="dark"] .temuan-field-row label {
        color: #ffffff;
    }

    [data-bs-theme="dark"] .temuan-field-row .form-control {
        background-color: #212529;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .temuan-field-row .form-control:focus {
        background-color: #212529;
        color: #ffffff;
        outline-color: #198754;
    }
</style>

<div class="card mb-4" id="temuan-card" style="width: 100%; margin-top: 0;">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fa-solid fa-exclamation-triangle"></i> Tambah Temuan dan Rekomendasi
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ url('adminTL/temuan') }}" method="post" enctype="multipart/form-data" id="temuanForm">
            @method('POST')
            @csrf
            <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
            <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">
            <div class="table-responsive">
                <div class="temuan-hierarchy-container">
                    @if(isset($existingData) && is_countable($existingData) && count($existingData) > 0)
                    @foreach($existingData as $key => $item)
                        <!-- Main Temuan Item -->
                        <div class="temuan-hierarchy-item temuan-level-0" data-level="0" data-index="{{ $key }}">
                            <table class="temuan-hierarchy-table">
                                <tr class="main-row">
                                    <td class="temuan-number-cell">{{ $loop->iteration }}</td>
                                    <td class="temuan-content-cell">
                                        <div class="temuan-field-group">
                                            <div class="temuan-field-row">
                                                <label>Kode Temuan</label>
                                                <input type="text" class="form-control" name="tipeB[{{ $key }}][kode_temuan]" value="{{ $item->kode_temuan ?? '' }}">
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Nama Temuan</label>
                                                <textarea class="form-control" name="tipeB[{{ $key }}][nama_temuan]">{{ $item->nama_temuan ?? '' }}</textarea>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Kode Rekomendasi</label>
                                                <input type="text" class="form-control" name="tipeB[{{ $key }}][kode_rekomendasi]" value="{{ $item->kode_rekomendasi ?? '' }}" placeholder="Contoh: REC-001">
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Rekomendasi</label>
                                                <textarea class="form-control" name="tipeB[{{ $key }}][rekomendasi]">{{ $item->rekomendasi ?? '' }}</textarea>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Keterangan</label>
                                                <textarea class="form-control" name="tipeB[{{ $key }}][keterangan]">{{ $item->keterangan ?? '' }}</textarea>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Pengembalian</label>
                                                <input type="text" class="form-control tanparupiah" name="tipeB[{{ $key }}][pengembalian]" value="{{ isset($item->pengembalian) && is_numeric($item->pengembalian) ? number_format($item->pengembalian,0,',','.') : '0' }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="temuan-action-cell">
                                        <button type="button" data-level1="{{ $key }}" data-parentid="{{ $item->id ?? '' }}" class="btn btn-purple btn-sm temuan-add-sub" title="Tambah Sub Temuan">
                                            <i class="fas fa-indent"></i>
                                        </button>
                                        @if($loop->first)
                                            <button type="button" class="btn btn-primary btn-sm temuan-add-main" title="Tambah Temuan Baru">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        @endif
                                        @if(!$loop->first)
                                            <button type="button" class="btn btn-danger btn-sm temuan-remove-item" title="Hapus Temuan">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Sub Items Container -->
                            <div class="temuan-sub-items-container">
                                @if(isset($item->recommendations) && is_countable($item->recommendations) && count($item->recommendations) > 0)
                                    @foreach($item->recommendations as $subKey => $subItem)
                                        <!-- Sub Item -->
                                        <div class="temuan-hierarchy-item temuan-level-1" data-level="1" data-parent="{{ $key }}" data-index="{{ $subKey }}">
                                            <table class="temuan-hierarchy-table">
                                                <tr>
                                                    <td class="temuan-number-cell">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                    <td class="temuan-content-cell">
                                                        <div class="temuan-field-group">
                                                            <div class="temuan-field-row">
                                                                <label>Kode Rekomendasi</label>
                                                                <input type="text" class="form-control" name="tipeB[{{ $key }}][sub][{{ $subKey }}][kode_rekomendasi]" value="{{ $subItem->kode_rekomendasi ?? '' }}" placeholder="Contoh: REC-001.1">
                                                            </div>
                                                            <div class="temuan-field-row">
                                                                <label>Rekomendasi</label>
                                                                <textarea class="form-control" name="tipeB[{{ $key }}][sub][{{ $subKey }}][rekomendasi]">{{ $subItem->rekomendasi ?? '' }}</textarea>
                                                            </div>
                                                            <div class="temuan-field-row">
                                                                <label>Keterangan</label>
                                                                <textarea class="form-control" name="tipeB[{{ $key }}][sub][{{ $subKey }}][keterangan]">{{ $subItem->keterangan ?? '' }}</textarea>
                                                            </div>
                                                            <div class="temuan-field-row">
                                                                <label>Pengembalian</label>
                                                                <input type="text" class="form-control tanparupiah" name="tipeB[{{ $key }}][sub][{{ $subKey }}][pengembalian]" value="{{ isset($subItem->pengembalian) && is_numeric($subItem->pengembalian) ? number_format($subItem->pengembalian,0,',','.') : '0' }}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="temuan-action-cell">
                                                        <button type="button" data-level1="{{ $key }}" data-level2="{{ $subKey }}" data-parentid="{{ $subItem->id ?? '' }}" class="btn btn-pink btn-sm temuan-add-sub" title="Tambah Sub-Sub Item">
                                                            <i class="fas fa-indent"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm temuan-remove-item" title="Hapus Sub Item">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Sub-Sub Items Container -->
                                            <div class="temuan-sub-sub-items-container">
                                                @if(isset($subItem->children) && is_countable($subItem->children) && count($subItem->children) > 0)
                                                    @foreach($subItem->children as $nestedKey => $nestedItem)
                                                        <!-- Sub-Sub Item -->
                                                        <div class="temuan-hierarchy-item temuan-level-2" data-level="2" data-parent="{{ $key }}-{{ $subKey }}" data-index="{{ $nestedKey }}">
                                                            <table class="temuan-hierarchy-table">
                                                                <tr>
                                                                    <td class="temuan-number-cell">{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                                    <td class="temuan-content-cell">
                                                                        <div class="temuan-field-group">
                                                                            <div class="temuan-field-row">
                                                                                <label>Kode Rekomendasi</label>
                                                                                <input type="text" class="form-control" name="tipeB[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][kode_rekomendasi]" value="{{ $nestedItem->kode_rekomendasi ?? '' }}" placeholder="Contoh: REC-001.1.1">
                                                                            </div>
                                                                            <div class="temuan-field-row">
                                                                                <label>Rekomendasi</label>
                                                                                <textarea class="form-control" name="tipeB[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][rekomendasi]">{{ $nestedItem->rekomendasi ?? '' }}</textarea>
                                                                            </div>
                                                                            <div class="temuan-field-row">
                                                                                <label>Keterangan</label>
                                                                                <textarea class="form-control" name="tipeB[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][keterangan]">{{ $nestedItem->keterangan ?? '' }}</textarea>
                                                                            </div>
                                                                            <div class="temuan-field-row">
                                                                                <label>Pengembalian</label>
                                                                                <input type="text" class="form-control tanparupiah" name="tipeB[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][pengembalian]" value="{{ isset($nestedItem->pengembalian) && is_numeric($nestedItem->pengembalian) ? number_format($nestedItem->pengembalian,0,',','.') : '0' }}">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="temuan-action-cell">
                                                                        <button type="button" class="btn btn-danger btn-sm temuan-remove-item" title="Hapus Sub-Sub Item">
                                                                            <i class="fa-solid fa-minus"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @else
                        <!-- Default empty item -->
                        <div class="temuan-hierarchy-item temuan-level-0" data-level="0" data-index="0">
                            <table class="temuan-hierarchy-table">
                                <tr>
                                    <td class="temuan-number-cell">1</td>
                                    <td class="temuan-content-cell">
                                        <div class="temuan-field-group">
                                            <div class="temuan-field-row">
                                                <label>Kode Temuan</label>
                                                <input type="text" class="form-control" name="tipeB[0][kode_temuan]" required>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Nama Temuan</label>
                                                <textarea class="form-control" name="tipeB[0][nama_temuan]" required></textarea>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Kode Rekomendasi</label>
                                                <input type="text" class="form-control" name="tipeB[0][kode_rekomendasi]" placeholder="Contoh: REC-001">
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Rekomendasi</label>
                                                <textarea class="form-control" name="tipeB[0][rekomendasi]"></textarea>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Keterangan</label>
                                                <textarea class="form-control" name="tipeB[0][keterangan]"></textarea>
                                            </div>
                                            <div class="temuan-field-row">
                                                <label>Pengembalian</label>
                                                <input type="text" class="form-control tanparupiah" name="tipeB[0][pengembalian]" value="0">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="temuan-action-cell">
                                        <button type="button" data-level1="0" class="btn btn-purple btn-sm temuan-add-sub">
                                            <i class="fas fa-indent"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm temuan-add-main">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <div class="temuan-sub-items-container"></div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 mb-3 text-center border-top pt-3">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button type="submit" class="btn btn-success btn-lg px-4" id="temuanSubmitBtn">
                        <i class="fa-solid fa-save me-2"></i> Simpan Temuan
                    </button>
                    {{-- <button type="button" class="btn btn-info btn-lg px-4" onclick="previewTemuanData()" id="temuanPreviewBtn">
                        <i class="fa-solid fa-eye me-2"></i> Preview Data
                    </button> --}}
                    <button type="button" class="btn btn-secondary btn-lg px-4" onclick="window.history.back()">
                        <i class="fa-solid fa-arrow-left me-2"></i> Kembali
                    </button>
                </div>
                <div class="mt-2 small text-muted">
                    <i class="fa-solid fa-info-circle me-1"></i>
                    Shortcut: Ctrl+S untuk simpan, Ctrl+P untuk preview
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Summary -->
            <div id="temuanValidationSummary" class="alert alert-info" style="display: none;">
                <h6><i class="fa-solid fa-info-circle"></i> Ringkasan Data:</h6>
                <div id="temuanValidationContent"></div>
            </div>
        </form>
    </div>
</div>

<script>
    let temuanMainItemCounter = @if(isset($existingData) && is_countable($existingData) && count($existingData) > 0) {{ count($existingData) }} @else 1 @endif;
    let temuanSubItemCounters = {};
    let temuanSubSubItemCounters = {};

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize counters based on existing data
        initializeTemuanCounters();

        // Make sure all buttons are visible
        ensureTemuanButtonsVisible();

        // Add event listeners using delegation
        addTemuanEventListeners();

        // Add mobile responsive styles
        addTemuanMobileStyles();

        // Initialize currency formatting
        initializeTemuanCurrencyFormatting();
    });

    function initializeTemuanCounters() {
        const mainItems = document.querySelectorAll('.temuan-hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            const level1 = item.getAttribute('data-index') || index;
            temuanSubItemCounters[level1] = 0;
            temuanSubSubItemCounters[level1] = {};

            const subItems = item.querySelectorAll('.temuan-hierarchy-item[data-level="1"]');
            subItems.forEach((subItem, subIndex) => {
                temuanSubItemCounters[level1] = Math.max(temuanSubItemCounters[level1], subIndex + 1);
                const level2 = subItem.getAttribute('data-index') || subIndex;
                temuanSubSubItemCounters[level1][level2] = 0;

                const subSubItems = subItem.querySelectorAll('.temuan-hierarchy-item[data-level="2"]');
                subSubItems.forEach((subSubItem, subSubIndex) => {
                    temuanSubSubItemCounters[level1][level2] = Math.max(temuanSubSubItemCounters[level1][level2], subSubIndex + 1);
                });
            });
        });
    }

    function ensureTemuanButtonsVisible() {
        const allButtons = document.querySelectorAll('.temuan-add-sub, .temuan-add-main, .temuan-remove-item');
        allButtons.forEach(function(btn) {
            btn.style.display = 'inline-block';
            btn.style.visibility = 'visible';
        });
    }

    function addTemuanEventListeners() {
        // Use event delegation for dynamic buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.temuan-add-main')) {
                addTemuanMainItem();
            } else if (e.target.closest('.temuan-add-sub')) {
                const button = e.target.closest('.temuan-add-sub');
                const level1 = button.getAttribute('data-level1');
                const level2 = button.getAttribute('data-level2');

                if (level2) {
                    addTemuanSubSubItem(level1, level2);
                } else {
                    addTemuanSubItem(level1);
                }
            } else if (e.target.closest('.temuan-remove-item')) {
                const button = e.target.closest('.temuan-remove-item');
                removeTemuanItem(button);
            }
        });
    }

    function addTemuanMainItem() {
        const container = document.querySelector('.temuan-hierarchy-container');
        const newIndex = temuanMainItemCounter;

        // Initialize counters for new main item
        temuanSubItemCounters[newIndex] = 0;
        temuanSubSubItemCounters[newIndex] = {};

        const newMainItem = createTemuanMainItemHTML(newIndex);
        container.insertAdjacentHTML('beforeend', newMainItem);

        temuanMainItemCounter++;
        updateTemuanNumbering();
        ensureTemuanButtonsVisible();
    }

    function addTemuanSubItem(level1) {
        const parentItem = document.querySelector(`.temuan-hierarchy-item[data-level="0"][data-index="${level1}"]`);
        if (!parentItem) return;

        const subContainer = parentItem.querySelector('.temuan-sub-items-container');
        const newSubIndex = temuanSubItemCounters[level1] || 0;

        // Initialize sub-sub counter for new sub item
        if (!temuanSubSubItemCounters[level1]) temuanSubSubItemCounters[level1] = {};
        temuanSubSubItemCounters[level1][newSubIndex] = 0;

        const newSubItem = createTemuanSubItemHTML(level1, newSubIndex);
        subContainer.insertAdjacentHTML('beforeend', newSubItem);

        temuanSubItemCounters[level1] = (temuanSubItemCounters[level1] || 0) + 1;
        updateTemuanNumbering();
        ensureTemuanButtonsVisible();
    }

    function addTemuanSubSubItem(level1, level2) {
        const parentSubItem = document.querySelector(`.temuan-hierarchy-item[data-level="1"][data-parent="${level1}"][data-index="${level2}"]`);
        if (!parentSubItem) return;

        const subSubContainer = parentSubItem.querySelector('.temuan-sub-sub-items-container');
        const newSubSubIndex = temuanSubSubItemCounters[level1][level2] || 0;

        const newSubSubItem = createTemuanSubSubItemHTML(level1, level2, newSubSubIndex);
        subSubContainer.insertAdjacentHTML('beforeend', newSubSubItem);

        if (!temuanSubSubItemCounters[level1]) temuanSubSubItemCounters[level1] = {};
        temuanSubSubItemCounters[level1][level2] = (temuanSubSubItemCounters[level1][level2] || 0) + 1;
        updateTemuanNumbering();
        ensureTemuanButtonsVisible();
    }

    function removeTemuanItem(button) {
        const item = button.closest('.temuan-hierarchy-item');
        if (!item) return;

        const level = item.getAttribute('data-level');

        // Don't allow removing the last main item
        if (level === '0') {
            const mainItems = document.querySelectorAll('.temuan-hierarchy-item[data-level="0"]');
            if (mainItems.length <= 1) {
                alert('Tidak dapat menghapus item utama terakhir');
                return;
            }
        }

        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            item.remove();
            updateTemuanNumbering();
        }
    }

    function createTemuanMainItemHTML(index) {
        return `
            <div class="temuan-hierarchy-item temuan-level-0" data-level="0" data-index="${index}">
                <table class="temuan-hierarchy-table">
                    <tr class="main-row">
                        <td class="temuan-number-cell">${index + 1}</td>
                        <td class="temuan-content-cell">
                            <div class="temuan-field-group">
                                <div class="temuan-field-row">
                                    <label>Kode Temuan</label>
                                    <input type="text" class="form-control" name="tipeB[${index}][kode_temuan]" required>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Nama Temuan</label>
                                    <textarea class="form-control" name="tipeB[${index}][nama_temuan]" required></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Kode Rekomendasi</label>
                                    <input type="text" class="form-control" name="tipeB[${index}][kode_rekomendasi]" placeholder="Contoh: REC-001">
                                </div>
                                <div class="temuan-field-row">
                                    <label>Rekomendasi</label>
                                    <textarea class="form-control" name="tipeB[${index}][rekomendasi]"></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="tipeB[${index}][keterangan]"></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeB[${index}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="temuan-action-cell">
                            <button type="button" data-level1="${index}" class="btn btn-purple btn-sm temuan-add-sub" title="Tambah Sub Item">
                                <i class="fas fa-indent"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm temuan-remove-item" title="Hapus Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <div class="temuan-sub-items-container"></div>
            </div>
        `;
    }

    function createTemuanSubItemHTML(level1, level2) {
        return `
            <div class="temuan-hierarchy-item temuan-level-1" data-level="1" data-parent="${level1}" data-index="${level2}">
                <table class="temuan-hierarchy-table">
                    <tr>
                        <td class="temuan-number-cell">${parseInt(level1) + 1}.${level2 + 1}</td>
                        <td class="temuan-content-cell">
                            <div class="temuan-field-group">
                                <div class="temuan-field-row">
                                    <label>Kode Rekomendasi</label>
                                    <input type="text" class="form-control" name="tipeB[${level1}][sub][${level2}][kode_rekomendasi]" placeholder="Contoh: REC-001.1">
                                </div>
                                <div class="temuan-field-row">
                                    <label>Rekomendasi</label>
                                    <textarea class="form-control" name="tipeB[${level1}][sub][${level2}][rekomendasi]"></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="tipeB[${level1}][sub][${level2}][keterangan]"></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeB[${level1}][sub][${level2}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="temuan-action-cell">
                            <button type="button" data-level1="${level1}" data-level2="${level2}" class="btn btn-pink btn-sm temuan-add-sub" title="Tambah Sub-Sub Item">
                                <i class="fas fa-indent"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm temuan-remove-item" title="Hapus Sub Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <div class="temuan-sub-sub-items-container"></div>
            </div>
        `;
    }

    function createTemuanSubSubItemHTML(level1, level2, level3) {
        return `
            <div class="temuan-hierarchy-item temuan-level-2" data-level="2" data-parent="${level1}-${level2}" data-index="${level3}">
                <table class="temuan-hierarchy-table">
                    <tr>
                        <td class="temuan-number-cell">${parseInt(level1) + 1}.${parseInt(level2) + 1}.${level3 + 1}</td>
                        <td class="temuan-content-cell">
                            <div class="temuan-field-group">
                                <div class="temuan-field-row">
                                    <label>Kode Rekomendasi</label>
                                    <input type="text" class="form-control" name="tipeB[${level1}][sub][${level2}][sub][${level3}][kode_rekomendasi]" placeholder="Contoh: REC-001.1.1">
                                </div>
                                <div class="temuan-field-row">
                                    <label>Rekomendasi</label>
                                    <textarea class="form-control" name="tipeB[${level1}][sub][${level2}][sub][${level3}][rekomendasi]"></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" name="tipeB[${level1}][sub][${level2}][sub][${level3}][keterangan]"></textarea>
                                </div>
                                <div class="temuan-field-row">
                                    <label>Pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeB[${level1}][sub][${level2}][sub][${level3}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="temuan-action-cell">
                            <button type="button" class="btn btn-danger btn-sm temuan-remove-item" title="Hapus Sub-Sub Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        `;
    }

    function updateTemuanNumbering() {
        // Update main item numbering
        const mainItems = document.querySelectorAll('.temuan-hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            const numberCell = item.querySelector('.temuan-number-cell');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }

            // Update sub item numbering
            const subItems = item.querySelectorAll('.temuan-hierarchy-item[data-level="1"]');
            subItems.forEach((subItem, subIndex) => {
                const subNumberCell = subItem.querySelector('.temuan-number-cell');
                if (subNumberCell) {
                    subNumberCell.textContent = `${index + 1}.${subIndex + 1}`;
                }

                // Update sub-sub item numbering
                const subSubItems = subItem.querySelectorAll('.temuan-hierarchy-item[data-level="2"]');
                subSubItems.forEach((subSubItem, subSubIndex) => {
                    const subSubNumberCell = subSubItem.querySelector('.temuan-number-cell');
                    if (subSubNumberCell) {
                        subSubNumberCell.textContent = `${index + 1}.${subIndex + 1}.${subSubIndex + 1}`;
                    }
                });
            });
        });
    }

    function initializeTemuanCurrencyFormatting() {
        // Format existing currency fields
        formatAllTemuanCurrencyFields();

        // Add event listeners for new currency fields
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('tanparupiah') && e.target.closest('#temuan-card')) {
                formatCurrencyField(e.target);
            }
        });
    }

    function formatAllTemuanCurrencyFields() {
        const currencyFields = document.querySelectorAll('#temuan-card .tanparupiah');
        currencyFields.forEach(formatCurrencyField);
    }

    function formatCurrencyField(field) {
        if (!field || !field.value) return;

        // Remove all non-numeric characters
        let value = field.value.replace(/[^0-9]/g, '');

        // If empty, set to 0
        if (value === '') {
            value = '0';
        }

        // Convert to number and format with thousands separator
        const numericValue = parseInt(value);
        const formattedValue = numericValue.toLocaleString('id-ID');

        // Set the formatted value back to the field
        field.value = formattedValue;
    }

    function addTemuanMobileStyles() {
        const style = document.createElement('style');
        style.textContent = `
            @media (max-width: 768px) {
                .temuan-hierarchy-container {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }

                .temuan-hierarchy-table {
                    min-width: 700px;
                }

                .temuan-action-cell {
                    position: sticky;
                    right: 0;
                    background-color: var(--bs-secondary-bg, #f8f9fa) !important;
                    z-index: 10;
                    box-shadow: -2px 0 4px rgba(0,0,0,0.1);
                }

                .temuan-number-cell {
                    position: sticky;
                    left: 0;
                    z-index: 10;
                    box-shadow: 2px 0 4px rgba(0,0,0,0.1);
                }
            }
        `;
        document.head.appendChild(style);
    }

    // Form validation and submission handling
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'temuanForm') {
            e.preventDefault();

            // Show loading state
            const submitBtn = document.getElementById('temuanSubmitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;

            // Convert currency fields back to numeric format for submission
            const currencyFields = document.querySelectorAll('#temuan-card .tanparupiah');
            currencyFields.forEach(function(field) {
                const numericValue = field.value.replace(/[^0-9]/g, '') || '0';
                field.value = numericValue;
            });

            // Validate required fields
            const requiredFields = document.querySelectorAll('#temuan-card input[name*="kode_temuan"], #temuan-card textarea[name*="nama_temuan"]');
            let hasEmpty = false;
            let emptyFields = [];

            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    field.style.borderColor = 'red';
                    field.style.backgroundColor = '#ffebee';
                    hasEmpty = true;

                    // Get field context for better error message
                    const fieldContainer = field.closest('.temuan-hierarchy-item');
                    const numberCell = fieldContainer ? fieldContainer.querySelector('.temuan-number-cell') : null;
                    const itemNumber = numberCell ? numberCell.textContent : 'Unknown';
                    emptyFields.push(`Item ${itemNumber}`);
                } else {
                    field.style.borderColor = '';
                    field.style.backgroundColor = '';
                }
            });

            if (hasEmpty) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Restore currency formatting
                currencyFields.forEach(formatCurrencyField);

                alert(`Mohon isi field wajib pada: ${emptyFields.join(', ')}`);

                // Scroll to first empty field
                const firstEmptyField = document.querySelector('#temuan-card input[style*="red"], #temuan-card textarea[style*="red"]');
                if (firstEmptyField) {
                    firstEmptyField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstEmptyField.focus();
                }
                return false;
            }

            // Submit the form
            try {
                e.target.submit();
            } catch (error) {
                console.error('Submission error:', error);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Restore currency formatting
                currencyFields.forEach(formatCurrencyField);

                alert('Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
            }
        }
    });

    // Preview function
    function previewTemuanData() {
        const form = document.getElementById('temuanForm');
        let summary = '<ul>';
        let itemCount = 0;
        let totalPengembalian = 0;

        // Count items and calculate totals
        const mainItems = document.querySelectorAll('.temuan-hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            const kodeTemuan = item.querySelector('input[name*="kode_temuan"]').value;
            const namaTemuan = item.querySelector('textarea[name*="nama_temuan"]').value;
            if (kodeTemuan.trim() && namaTemuan.trim()) {
                itemCount++;
                const pengembalian = item.querySelector('input[name*="pengembalian"]').value.replace(/[^0-9]/g, '') || '0';
                totalPengembalian += parseInt(pengembalian);
                summary += `<li><strong>Temuan ${index + 1}:</strong> ${kodeTemuan} - ${namaTemuan.substring(0, 50)}...</li>`;
            }
        });

        summary += '</ul>';

        const validationContent = document.getElementById('temuanValidationContent');
        validationContent.innerHTML = `
            <p><strong>Total Temuan:</strong> ${itemCount}</p>
            <p><strong>Total Pengembalian:</strong> ${totalPengembalian.toLocaleString('id-ID')}</p>
            <div><strong>Daftar Temuan:</strong></div>
            ${summary}
        `;

        const validationSummary = document.getElementById('temuanValidationSummary');
        validationSummary.style.display = 'block';
        validationSummary.scrollIntoView({ behavior: 'smooth' });
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Only if focused within temuan form
        if (document.activeElement.closest('#temuan-card')) {
            // Ctrl + S to save
            if (e.ctrlKey && e.key === 's') {
                e.preventDefault();
                document.getElementById('temuanSubmitBtn').click();
            }

            // Ctrl + P to preview
            if (e.ctrlKey && e.key === 'p') {
                e.preventDefault();
                previewTemuanData();
            }
        }
    });
</script>
