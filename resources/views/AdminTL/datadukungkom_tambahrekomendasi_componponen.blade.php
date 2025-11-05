<style>
    /* Component Spacing and Layout */
    #card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid var(--bs-border-color, #dee2e6);
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        background-color: var(--bs-body-bg, #ffffff);
    }

    #card .card-header {
        background-color: var(--bs-primary, #0d6efd);
        color: white;
        border-bottom: 1px solid var(--bs-border-color, #dee2e6);
        padding: 1rem 1.25rem;
    }

    #card .card-body {
        padding: 1.5rem 1.25rem;
    }

    /* Hierarchy Table Styles */
    .hierarchy-container {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        width: 100%;
        overflow-x: auto;
        min-width: 900px;
        position: relative;
        background-color: var(--bs-body-bg, #ffffff);
        margin-bottom: 1rem;
    }

    .hierarchy-container {
        width: 100%;
        font-family: Arial, Helvetica, sans-serif;
        overflow-x: auto;
        min-width: 900px;
        position: relative;
    }

    .hierarchy-item {
        margin-bottom: 2px;
        position: relative;
        clear: both;
    }

    .hierarchy-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        border: 2px solid var(--bs-border-color, #dee2e6);
        background-color: var(--bs-body-bg, #ffffff);
    }

    .hierarchy-table td {
        border: 2px solid var(--bs-border-color, #dee2e6);
        padding: 8px;
        vertical-align: top;
        color: var(--bs-body-color, #212529);
        position: relative;
    }

    .number-cell {
        width: 80px;
        min-width: 80px;
        text-align: center;
        font-weight: bold;
        background-color: var(--bs-secondary-bg, #f8f9fa);
        vertical-align: middle;
        color: var(--bs-body-color, #212529);
    }

    .content-cell {
        padding: 0 !important;
        background-color: var(--bs-body-bg, #ffffff);
        width: auto;
        max-width: calc(100% - 260px);
    }

    .action-cell {
        width: 180px;
        min-width: 180px;
        max-width: 180px;
        text-align: center;
        vertical-align: middle;
        background-color: var(--bs-secondary-bg, #f8f9fa);
        position: relative;
        padding: 8px !important;
        box-sizing: border-box;
        white-space: nowrap;
        overflow: visible;
    }

    .field-group {
        width: 100%;
        background-color: var(--bs-body-bg, #ffffff);
    }

    .field-row {
        display: flex;
        align-items: center;
        border-bottom: 1px solid var(--bs-border-color, #dee2e6);
        min-height: 40px;
        padding: 4px 8px;
        background-color: var(--bs-body-bg, #ffffff);
    }

    .field-row:last-child {
        border-bottom: none;
    }

    .field-row label {
        min-width: 120px;
        font-weight: normal;
        margin: 0;
        padding-right: 10px;
        font-size: 14px;
        text-align: left;
        color: var(--bs-body-color, #212529);
    }

    .field-row .form-control {
        flex: 1;
        border: none;
        background: var(--bs-body-bg, #ffffff);
        resize: none;
        min-height: 30px;
        padding: 4px;
        font-size: 14px;
        color: var(--bs-body-color, #212529);
    }

    .field-row textarea.form-control {
        resize: vertical;
        min-height: 30px;
    }

    .field-row .form-control:focus {
        box-shadow: none;
        outline: 2px solid var(--bs-primary, #0d6efd);
        background-color: var(--bs-body-bg, #ffffff);
        color: var(--bs-body-color, #212529);
    }

    /* Level indentation - Prevent overlap */
    .level-0 {
        margin-left: 0;
        z-index: 3;
    }

    .level-1 {
        margin-left: 30px;
        margin-top: 2px;
        z-index: 2;
        position: relative;
    }

    .level-2 {
        margin-left: 60px;
        margin-top: 2px;
        z-index: 1;
        position: relative;
    }

    .level-3 {
        margin-left: 90px;
        margin-top: 2px;
        z-index: 1;
        position: relative;
    }

    /* Ensure proper stacking */
    .hierarchy-item .hierarchy-table {
        position: relative;
        margin-bottom: 0;
    }

    /* Container styling to prevent overlap */
    .sub-items-container,
    .sub-sub-items-container,
    .sub-sub-sub-items-container {
        width: 100%;
        clear: both;
        overflow: hidden;
    }

    .sub-items-container {
        margin-top: 2px;
    }

    .sub-sub-items-container {
        margin-top: 2px;
        margin-left: 0; /* Reset margin since level-2 already has margin */
    }

    .sub-sub-sub-items-container {
        margin-top: 2px;
        margin-left: 0; /* Reset margin since level-3 already has margin */
    }

    /* Fix width calculation for indented items */
    .level-0 .hierarchy-table {
        width: 100%;
        min-width: 800px;
    }

    .level-1 .hierarchy-table {
        width: calc(100% - 30px);
        min-width: 750px;
    }

    .level-2 .hierarchy-table {
        width: calc(100% - 60px);
        min-width: 700px;
    }

    .level-3 .hierarchy-table {
        width: calc(100% - 90px);
        min-width: 650px;
    }

    /* Responsive wrapper */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Specific styling for sub levels */
    .level-1 .action-cell,
    .level-2 .action-cell,
    .level-3 .action-cell {
        position: sticky;
        right: 0;
        z-index: 10;
        box-shadow: -2px 0 4px rgba(0,0,0,0.1);
    }

    .level-1 .content-cell {
        max-width: calc(100% - 250px);
    }

    .level-2 .content-cell {
        max-width: calc(100% - 280px);
    }

    .level-3 .content-cell {
        max-width: calc(100% - 310px);
    }

    /* Ensure buttons stack properly */
    .level-1 .action-cell .btn,
    .level-2 .action-cell .btn,
    .level-3 .action-cell .btn {
        display: block !important;
        margin: 2px auto !important;
        width: 30px;
        height: 30px;
        padding: 0;
        font-size: 0.8rem;
    }

    /* Prevent floating issues */
    .hierarchy-item::after {
        content: "";
        display: table;
        clear: both;
    }

    /* Button styling */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        margin: 2px;
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .add-sub, .remove-item, .add-main, #add_btn, #add_main_btn, #add_main_btn_default, #add_sub_0 {
        display: inline-block !important;
        visibility: visible !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    .action-cell .btn {
        display: inline-block !important;
        margin: 1px;
        font-size: 0.75rem;
        padding: 0.2rem 0.4rem;
        visibility: visible !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }

    /* Ensure buttons are always clickable */
    button.add-sub:disabled {
        opacity: 0.65;
        cursor: not-allowed;
        pointer-events: none;
    }

    button.add-sub:not(:disabled) {
        cursor: pointer;
        pointer-events: auto;
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

    /* Dark theme specific styles */
    @media (prefers-color-scheme: dark) {
        #card {
            background-color: #212529;
            border-color: #495057;
            box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
        }

        #card .card-header {
            background-color: #0d6efd;
            border-bottom-color: #495057;
            color: #ffffff;
        }

        #card .card-body {
            background-color: #212529;
        }

        .hierarchy-container {
            background-color: #212529;
        }

        .hierarchy-table {
            border-color: #495057;
            background-color: #212529;
        }

        .hierarchy-table td {
            border-color: #495057;
            color: #ffffff;
        }

        .number-cell {
            background-color: #343a40;
            color: #ffffff;
        }

        .content-cell {
            background-color: #212529;
        }

        .action-cell {
            background-color: #343a40;
        }

        .level-1 .action-cell,
        .level-2 .action-cell,
        .level-3 .action-cell {
            background-color: #343a40 !important;
            box-shadow: -2px 0 4px rgba(0,0,0,0.3);
        }

        .field-group {
            background-color: #212529;
        }

        .field-row {
            border-bottom-color: #495057;
            background-color: #212529;
        }

        .field-row label {
            color: #ffffff;
        }

        .field-row .form-control {
            background-color: #212529;
            color: #ffffff;
        }

        .field-row .form-control:focus {
            background-color: #212529;
            color: #ffffff;
            outline-color: #0d6efd;
        }
    }

    /* Bootstrap dark theme class support */
    [data-bs-theme="dark"] #card {
        background-color: #212529;
        border-color: #495057;
        box-shadow: 0 0.125rem 0.25rem rgba(255, 255, 255, 0.075);
    }

    [data-bs-theme="dark"] #card .card-header {
        background-color: #0d6efd;
        border-bottom-color: #495057;
        color: #ffffff;
    }

    [data-bs-theme="dark"] #card .card-body {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .hierarchy-container {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .hierarchy-table {
        border-color: #495057;
        background-color: #212529;
    }

    [data-bs-theme="dark"] .hierarchy-table td {
        border-color: #495057;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .number-cell {
        background-color: #343a40;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .content-cell {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .action-cell {
        background-color: #343a40;
    }

    [data-bs-theme="dark"] .level-1 .action-cell,
    [data-bs-theme="dark"] .level-2 .action-cell,
    [data-bs-theme="dark"] .level-3 .action-cell {
        background-color: #343a40 !important;
        box-shadow: -2px 0 4px rgba(0,0,0,0.3);
    }

    [data-bs-theme="dark"] .field-group {
        background-color: #212529;
    }

    [data-bs-theme="dark"] .field-row {
        border-bottom-color: #495057;
        background-color: #212529;
    }

    [data-bs-theme="dark"] .field-row label {
        color: #ffffff;
    }

    [data-bs-theme="dark"] .field-row .form-control {
        background-color: #212529;
        color: #ffffff;
    }

    [data-bs-theme="dark"] .field-row .form-control:focus {
        background-color: #212529;
        color: #ffffff;
        outline-color: #0d6efd;
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

        /* Delete button styling */
        .delete-main-item {
            transition: all 0.2s ease-in-out;
        }

        .delete-main-item:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }

        .delete-main-item:active {
            transform: scale(0.95);
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

    /* Validation error styles */
    .is-invalid {
        border-color: #dc3545 !important;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-3px); }
        20%, 40%, 60%, 80% { transform: translateX(3px); }
    }

    /* Error highlight animation */
    @keyframes errorPulse {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        50% { box-shadow: 0 0 0 6px rgba(220, 53, 69, 0.1); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    .error-pulse {
        animation: errorPulse 1s ease-out;
    }

    /* Success validation styles */
    .is-valid {
        border-color: #28a745 !important;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.94-.94-.94-.94L1.36 5.8z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
</style>

<div class="card mb-4" id="card" style="width: 100%; margin-top: 0;">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fa-solid fa-list-check"></i> Tambah Rekomendasi
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ url('adminTL/rekom') }}" method="post" enctype="multipart/form-data" id="recommendationForm">
            @method('POST')
            @csrf
            <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
            <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">
            <div class="table-responsive">
                <div class="hierarchy-container">
                    @if(isset($data) && count($data) > 0)
                    @foreach($data as $key => $item)
                        <!-- Main Item -->
                        <div class="hierarchy-item level-0" data-level="0" data-index="{{ $key }}">
                            <table class="hierarchy-table">
                                <tr class="main-row">
                                    <td class="number-cell">{{ $loop->iteration }}</td>
                                    <td class="content-cell">
                                        <div class="field-group">
                                            <div class="field-row">
                                                <label>rekomendasi</label>
                                                <textarea class="form-control" name="tipeA[{{ $key }}][rekomendasi]" required placeholder="Masukkan rekomendasi...">{{ $item->rekomendasi }}</textarea>
                                            </div>
                                            <div class="field-row">
                                                <label>keterangan</label>
                                                <textarea class="form-control" name="tipeA[{{ $key }}][keterangan]">{{ $item->keterangan }}</textarea>
                                            </div>
                                            <div class="field-row">
                                                <label>pengembalian</label>
                                                <input type="text" class="form-control tanparupiah" name="tipeA[{{ $key }}][pengembalian]" value="{{ number_format($item->pengembalian,0,',','.') }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-cell">
                                        <button type="button" data-level1="{{ $key }}" data-parentid="{{ $item->id }}" class="btn btn-purple btn-sm add-sub" id="add_sub_{{ $key }}">
                                            <i class="fas fa-indent"></i>
                                        </button>
                                        <button type="button" data-itemid="{{ $item->id }}" data-level="{{ $key }}" class="btn btn-danger btn-sm delete-main-item" id="delete_main_{{ $key }}" title="Hapus item ini dan semua sub-item">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        @if($key == 0)
                                            <button type="button" class="btn btn-primary btn-sm add-main" id="add_main_btn">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </table>

                            <!-- Sub Items Container -->
                            <div class="sub-items-container">
                                @if(isset($item->sub))
                                    @foreach($item->sub as $subKey => $subItem)
                                        <!-- Sub Item -->
                                        <div class="hierarchy-item level-1" data-level="1" data-item-id="{{ $subItem->id }}" data-parent="{{ $key }}" data-index="{{ $subKey }}">
                                            <table class="hierarchy-table">
                                                <tr>
                                                    <td class="number-cell">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                    <td class="content-cell">
                                                        <div class="field-group">
                                                            <div class="field-row">
                                                                <label>rekomendasi</label>
                                                                <textarea class="form-control" name="tipeA[{{ $key }}][sub][{{ $subKey }}][rekomendasi]" required placeholder="Masukkan sub rekomendasi...">{{ $subItem->rekomendasi }}</textarea>
                                                            </div>
                                                            <div class="field-row">
                                                                <label>keterangan</label>
                                                                <input type="text" class="form-control" name="tipeA[{{ $key }}][sub][{{ $subKey }}][keterangan]" value="{{ $subItem->keterangan }}">
                                                            </div>
                                                            <div class="field-row">
                                                                <label>pengembalian</label>
                                                                <input type="text" class="form-control tanparupiah" name="tipeA[{{ $key }}][sub][{{ $subKey }}][pengembalian]" value="{{ number_format($subItem->pengembalian,0,',','.') }}">
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="action-cell">
                                                        <button type="button" data-level1="{{ $key }}" data-level2="{{ $subKey }}" data-parentid="{{ $subItem->id }}" class="btn btn-pink btn-sm add-sub" id="add_sub_{{ $key }}_{{ $subKey }}">
                                                            <i class="fas fa-indent"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="removeHierarchyItem('{{ $subItem->id }}', this)"
                                                                title="Hapus item ini dan semua sub-itemnya">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>

                                            <!-- Sub-Sub Items Container -->
                                            <div class="sub-sub-items-container">
                                                @if(isset($subItem->sub))
                                                    @foreach($subItem->sub as $nestedKey => $nestedItem)
                                                        <!-- Sub-Sub Item -->
                                                        <div class="hierarchy-item level-2" data-level="2" data-item-id="{{ $nestedItem->id }}" data-parent="{{ $key }}-{{ $subKey }}" data-index="{{ $nestedKey }}">
                                                            <table class="hierarchy-table">
                                                                <tr>
                                                                    <td class="number-cell">{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                                    <td class="content-cell">
                                                                        <div class="field-group">
                                                                            <div class="field-row">
                                                                                <label>rekomendasi</label>
                                                                                <textarea class="form-control" name="tipeA[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][rekomendasi]" required placeholder="Masukkan sub-sub rekomendasi...">{{ $nestedItem->rekomendasi }}</textarea>
                                                                            </div>
                                                                            <div class="field-row">
                                                                                <label>keterangan</label>
                                                                                <input type="text" class="form-control" name="tipeA[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][keterangan]" value="{{ $nestedItem->keterangan }}">
                                                                            </div>
                                                                            <div class="field-row">
                                                                                <label>pengembalian</label>
                                                                                <input type="text" class="form-control tanparupiah" name="tipeA[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][pengembalian]" value="{{ number_format($nestedItem->pengembalian,0,',','.') }}">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="action-cell">
                                                                        <button type="button" class="btn btn-success btn-sm add-sub-sub-sub-item"
                                                                                onclick="addSubSubSubItem({{ $key }}, {{ $subKey }}, {{ $nestedKey }})"
                                                                                title="Tambah Sub-Sub-Sub Item">
                                                                            <i class="fa-solid fa-plus"></i>
                                                                        </button>
                                                                        <button type="button"
                                                                                class="btn btn-danger btn-sm"
                                                                                onclick="removeHierarchyItem('{{ $nestedItem->id }}', this)"
                                                                                title="Hapus item ini dan semua sub-itemnya">
                                                                            <i class="fa-solid fa-minus"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                            <!-- Sub-Sub-Sub Items Container -->
                                                            <div class="sub-sub-sub-items-container">
                                                                @if(isset($nestedItem->sub))
                                                                    @foreach($nestedItem->sub as $subNestedKey => $subNestedItem)
                                                                        <!-- Sub-Sub-Sub Item (Level 4) -->
                                                                        <div class="hierarchy-item level-3" data-level="3" data-parent="{{ $key }}-{{ $subKey }}-{{ $nestedKey }}" data-index="{{ $subNestedKey }}" data-item-id="{{ $subNestedItem->id }}">
                                                                            <table class="hierarchy-table">
                                                                                <tr>
                                                                                    <td class="number-cell">{{ $loop->parent->parent->parent->iteration }}.{{ $loop->parent->parent->iteration }}.{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                                                                                    <td class="content-cell">
                                                                                        <div class="field-group">
                                                                                            <div class="field-row">
                                                                                                <label>rekomendasi</label>
                                                                                                <textarea class="form-control" name="tipeA[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][sub][{{ $subNestedKey }}][rekomendasi]" required placeholder="Masukkan sub-sub-sub rekomendasi...">{{ $subNestedItem->rekomendasi }}</textarea>
                                                                                            </div>
                                                                                            <div class="field-row">
                                                                                                <label>keterangan</label>
                                                                                                <input type="text" class="form-control" name="tipeA[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][sub][{{ $subNestedKey }}][keterangan]" value="{{ $subNestedItem->keterangan }}">
                                                                                            </div>
                                                                                            <div class="field-row">
                                                                                                <label>pengembalian</label>
                                                                                                <input type="text" class="form-control tanparupiah" name="tipeA[{{ $key }}][sub][{{ $subKey }}][sub][{{ $nestedKey }}][sub][{{ $subNestedKey }}][pengembalian]" value="{{ number_format($subNestedItem->pengembalian,0,',','.') }}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="action-cell">
                                                                                        <button type="button"
                                                                                                class="btn btn-danger btn-sm"
                                                                                                onclick="removeHierarchyItem('{{ $subNestedItem->id }}', this)"
                                                                                                title="Hapus item ini">
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
                                @endif
                            </div>
                        </div>
                    @endforeach
                    @else
                        <!-- Default empty item -->
                        <div class="hierarchy-item level-0" data-level="0" data-index="0">
                            <table class="hierarchy-table">
                                <tr>
                                    <td class="number-cell">1</td>
                                    <td class="content-cell">
                                        <div class="field-group">
                                            <div class="field-row">
                                                <label>rekomendasi</label>
                                                <textarea class="form-control" name="tipeA[0][rekomendasi]" required placeholder="Masukkan rekomendasi..."></textarea>
                                            </div>
                                            <div class="field-row">
                                                <label>keterangan</label>
                                                <textarea class="form-control" name="tipeA[0][keterangan]"></textarea>
                                            </div>
                                            <div class="field-row">
                                                <label>pengembalian</label>
                                                <input type="text" class="form-control tanparupiah" name="tipeA[0][pengembalian]" value="0">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-cell">
                                        <button type="button" data-level1="0" data-parentid="" class="btn btn-purple btn-sm add-sub" id="add_sub_0" title="Tambah Sub Rekomendasi">
                                            <i class="fas fa-indent"></i>
                                        </button>
                                        <button type="button" class="btn btn-primary btn-sm add-main" id="add_main_btn_default" title="Tambah Rekomendasi Baru">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                            <div class="sub-items-container"></div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 mb-3 text-center border-top pt-3">
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button type="submit" class="btn btn-success btn-lg px-4" id="submitBtn">
                        <i class="fa-solid fa-save me-2"></i> Simpan Rekomendasi
                    </button>
                    {{-- <button type="button" class="btn btn-info btn-lg px-4" onclick="previewData()" id="previewBtn">
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
            <div id="validationSummary" class="alert alert-info" style="display: none;">
                <h6><i class="fa-solid fa-info-circle"></i> Ringkasan Data:</h6>
                <div id="validationContent"></div>
            </div>
        </form>
    </div>
</div>

<script>
    let mainItemCounter = @if(isset($data) && count($data) > 0) {{ count($data) }} @else 1 @endif;
    let subItemCounters = {};
    let subSubItemCounters = {};
    let subSubSubItemCounters = {};

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded - Initializing hierarchy component');

        // Initialize counters based on existing data
        initializeCounters();

        // Make sure all buttons are visible
        ensureButtonsVisible();

        // Add event listeners using delegation
        addEventListeners();

        // Add mobile responsive styles
        addMobileStyles();

        // Initialize currency formatting
        initializeCurrencyFormatting();

        // Debug: Check if buttons are properly set up
        setTimeout(function() {
            const addSubButtons = document.querySelectorAll('.add-sub');
            console.log('Found', addSubButtons.length, 'add-sub buttons');
            addSubButtons.forEach((btn, index) => {
                console.log(`Button ${index}:`, {
                    id: btn.id,
                    level1: btn.getAttribute('data-level1'),
                    level2: btn.getAttribute('data-level2'),
                    parentid: btn.getAttribute('data-parentid'),
                    disabled: btn.disabled,
                    style: btn.style.display,
                    visibility: btn.style.visibility
                });
            });
        }, 500);
    });

    function initializeCounters() {
        const mainItems = document.querySelectorAll('.hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            const level1 = item.getAttribute('data-index') || index;
            subItemCounters[level1] = 0;
            subSubItemCounters[level1] = {};

            const subItems = item.querySelectorAll('.hierarchy-item[data-level="1"]');
            subItems.forEach((subItem, subIndex) => {
                subItemCounters[level1] = Math.max(subItemCounters[level1], subIndex + 1);
                const level2 = subItem.getAttribute('data-index') || subIndex;
                subSubItemCounters[level1][level2] = 0;

                const subSubItems = subItem.querySelectorAll('.hierarchy-item[data-level="2"]');
                subSubItems.forEach((subSubItem, subSubIndex) => {
                    subSubItemCounters[level1][level2] = Math.max(subSubItemCounters[level1][level2], subSubIndex + 1);
                });
            });
        });
    }

    function ensureButtonsVisible() {
        const allButtons = document.querySelectorAll('.add-sub, .add-main, .remove-item');
        allButtons.forEach(function(btn) {
            btn.style.display = 'inline-block';
            btn.style.visibility = 'visible';
        });
    }

    function addEventListeners() {
        // Use event delegation for dynamic buttons
        document.addEventListener('click', function(e) {
            if (e.target.closest('.add-main')) {
                console.log('Add main button clicked');
                addMainItem();
            } else if (e.target.closest('.add-sub')) {
                const button = e.target.closest('.add-sub');
                const level1 = button.getAttribute('data-level1');
                const level2 = button.getAttribute('data-level2');

                console.log('Add sub button clicked - level1:', level1, 'level2:', level2);

                if (level2 !== null && level2 !== undefined) {
                    console.log('Adding sub-sub item');
                    addSubSubItem(level1, level2);
                } else {
                    console.log('Adding sub item');
                    addSubItem(level1);
                }
            } else if (e.target.closest('.remove-item')) {
                const button = e.target.closest('.remove-item');
                console.log('Remove button clicked');
                removeItem(button);
            }
        });

        // Also add specific handlers for the initial buttons
        document.addEventListener('DOMContentLoaded', function() {
            const addSubButtons = document.querySelectorAll('.add-sub');
            addSubButtons.forEach(button => {
                console.log('Found add-sub button with id:', button.id, 'level1:', button.getAttribute('data-level1'));
            });
        });
    }

    function addMainItem() {
        const container = document.querySelector('.hierarchy-container');
        const newIndex = mainItemCounter;

        // Initialize counters for new main item
        subItemCounters[newIndex] = 0;
        subSubItemCounters[newIndex] = {};

        const newMainItem = createMainItemHTML(newIndex);
        container.insertAdjacentHTML('beforeend', newMainItem);

        mainItemCounter++;
        updateNumbering();
        ensureButtonsVisible();
    }

    function addSubItem(level1) {
        console.log('Adding sub item for level1:', level1);
        const parentItem = document.querySelector(`.hierarchy-item[data-level="0"][data-index="${level1}"]`);
        if (!parentItem) {
            console.log('Parent item not found for level1:', level1);
            return;
        }

        const subContainer = parentItem.querySelector('.sub-items-container');
        if (!subContainer) {
            console.log('Sub container not found');
            return;
        }

        const newSubIndex = subItemCounters[level1] || 0;

        // Initialize sub-sub counter for new sub item
        if (!subSubItemCounters[level1]) subSubItemCounters[level1] = {};
        subSubItemCounters[level1][newSubIndex] = 0;

        const newSubItem = createSubItemHTML(level1, newSubIndex);
        subContainer.insertAdjacentHTML('beforeend', newSubItem);

        subItemCounters[level1] = (subItemCounters[level1] || 0) + 1;
        updateNumbering();
        ensureButtonsVisible();
        console.log('Sub item added successfully');
    }

    function addSubSubItem(level1, level2) {
        const parentSubItem = document.querySelector(`.hierarchy-item[data-level="1"][data-parent="${level1}"][data-index="${level2}"]`);
        if (!parentSubItem) return;

        const subSubContainer = parentSubItem.querySelector('.sub-sub-items-container');
        const newSubSubIndex = subSubItemCounters[level1][level2] || 0;

        const newSubSubItem = createSubSubItemHTML(level1, level2, newSubSubIndex);
        subSubContainer.insertAdjacentHTML('beforeend', newSubSubItem);

        if (!subSubItemCounters[level1]) subSubItemCounters[level1] = {};
        subSubItemCounters[level1][level2] = (subSubItemCounters[level1][level2] || 0) + 1;
        updateNumbering();
        ensureButtonsVisible();
    }

    function addSubSubSubItem(level1, level2, level3) {
        const parentSubSubItem = document.querySelector(`.hierarchy-item[data-level="2"][data-parent="${level1}-${level2}"][data-index="${level3}"]`);
        if (!parentSubSubItem) return;

        const subSubSubContainer = parentSubSubItem.querySelector('.sub-sub-sub-items-container');
        if (!subSubSubContainer) {
            // Create container if it doesn't exist
            const table = parentSubSubItem.querySelector('.hierarchy-table');
            const containerHTML = `<div class="sub-sub-sub-items-container"></div>`;
            table.insertAdjacentHTML('afterend', containerHTML);
        }

        const container = parentSubSubItem.querySelector('.sub-sub-sub-items-container');
        const newSubSubSubIndex = subSubSubItemCounters[level1]?.[level2]?.[level3] || 0;

        const newSubSubSubItem = createSubSubSubItemHTML(level1, level2, level3, newSubSubSubIndex);
        container.insertAdjacentHTML('beforeend', newSubSubSubItem);

        if (!subSubSubItemCounters[level1]) subSubSubItemCounters[level1] = {};
        if (!subSubSubItemCounters[level1][level2]) subSubSubItemCounters[level1][level2] = {};
        subSubSubItemCounters[level1][level2][level3] = (subSubSubItemCounters[level1][level2][level3] || 0) + 1;
        updateNumbering();
        ensureButtonsVisible();
    }

    function removeItem(button) {
        const item = button.closest('.hierarchy-item');
        if (!item) return;

        const level = item.getAttribute('data-level');

        // Don't allow removing the last main item
        if (level === '0') {
            const mainItems = document.querySelectorAll('.hierarchy-item[data-level="0"]');
            if (mainItems.length <= 1) {
                alert('Tidak dapat menghapus item utama terakhir');
                return;
            }
        }

        if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
            item.remove();
            updateNumbering();
        }
    }

    function createMainItemHTML(index) {
        return `
            <div class="hierarchy-item level-0" data-level="0" data-index="${index}">
                <table class="hierarchy-table">
                    <tr class="main-row">
                        <td class="number-cell">${index + 1}</td>
                        <td class="content-cell">
                            <div class="field-group">
                                <div class="field-row">
                                    <label>rekomendasi</label>
                                    <textarea class="form-control" name="tipeA[${index}][rekomendasi]" required placeholder="Masukkan rekomendasi..."></textarea>
                                </div>
                                <div class="field-row">
                                    <label>keterangan</label>
                                    <textarea class="form-control" name="tipeA[${index}][keterangan]"></textarea>
                                </div>
                                <div class="field-row">
                                    <label>pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeA[${index}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="action-cell">
                            <button type="button" data-level1="${index}" class="btn btn-purple btn-sm add-sub" title="Tambah Sub Item">
                                <i class="fas fa-indent"></i>
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="removeHierarchyItem('new_item_id', this)"
                                    title="Hapus Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <div class="sub-items-container"></div>
            </div>
        `;
    }

    function createSubItemHTML(level1, level2) {
        return `
            <div class="hierarchy-item level-1" data-level="1" data-parent="${level1}" data-index="${level2}">
                <table class="hierarchy-table">
                    <tr>
                        <td class="number-cell">${parseInt(level1) + 1}.${level2 + 1}</td>
                        <td class="content-cell">
                            <div class="field-group">
                                <div class="field-row">
                                    <label>rekomendasi</label>
                                    <textarea class="form-control" name="tipeA[${level1}][sub][${level2}][rekomendasi]" required placeholder="Masukkan sub rekomendasi..."></textarea>
                                </div>
                                <div class="field-row">
                                    <label>keterangan</label>
                                    <input type="text" class="form-control" name="tipeA[${level1}][sub][${level2}][keterangan]">
                                </div>
                                <div class="field-row">
                                    <label>pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeA[${level1}][sub][${level2}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="action-cell">
                            <button type="button" data-level1="${level1}" data-level2="${level2}" class="btn btn-pink btn-sm add-sub" title="Tambah Sub-Sub Item">
                                <i class="fas fa-indent"></i>
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="removeHierarchyItem('new_sub_item_id', this)"
                                    title="Hapus Sub Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <div class="sub-sub-items-container"></div>
            </div>
        `;
    }

    function createSubSubItemHTML(level1, level2, level3) {
        return `
            <div class="hierarchy-item level-2" data-level="2" data-parent="${level1}-${level2}" data-index="${level3}">
                <table class="hierarchy-table">
                    <tr>
                        <td class="number-cell">${parseInt(level1) + 1}.${parseInt(level2) + 1}.${level3 + 1}</td>
                        <td class="content-cell">
                            <div class="field-group">
                                <div class="field-row">
                                    <label>rekomendasi</label>
                                    <textarea class="form-control" name="tipeA[${level1}][sub][${level2}][sub][${level3}][rekomendasi]" required placeholder="Masukkan sub-sub rekomendasi..."></textarea>
                                </div>
                                <div class="field-row">
                                    <label>keterangan</label>
                                    <input type="text" class="form-control" name="tipeA[${level1}][sub][${level2}][sub][${level3}][keterangan]">
                                </div>
                                <div class="field-row">
                                    <label>pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeA[${level1}][sub][${level2}][sub][${level3}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="action-cell">
                            <button type="button" class="btn btn-success btn-sm add-sub-sub-sub-item"
                                    onclick="addSubSubSubItem(${level1}, ${level2}, ${level3})"
                                    title="Tambah Sub-Sub-Sub Item">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="removeHierarchyItem('new_sub_sub_item_id', this)"
                                    title="Hapus Sub-Sub Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
                <div class="sub-sub-sub-items-container"></div>
            </div>
        `;
    }

    function createSubSubSubItemHTML(level1, level2, level3, level4) {
        return `
            <div class="hierarchy-item level-3" data-level="3" data-parent="${level1}-${level2}-${level3}" data-index="${level4}">
                <table class="hierarchy-table">
                    <tr>
                        <td class="number-cell">${parseInt(level1) + 1}.${parseInt(level2) + 1}.${parseInt(level3) + 1}.${level4 + 1}</td>
                        <td class="content-cell">
                            <div class="field-group">
                                <div class="field-row">
                                    <label>rekomendasi</label>
                                    <textarea class="form-control" name="tipeA[${level1}][sub][${level2}][sub][${level3}][sub][${level4}][rekomendasi]" required placeholder="Masukkan sub-sub-sub rekomendasi..."></textarea>
                                </div>
                                <div class="field-row">
                                    <label>keterangan</label>
                                    <input type="text" class="form-control" name="tipeA[${level1}][sub][${level2}][sub][${level3}][sub][${level4}][keterangan]">
                                </div>
                                <div class="field-row">
                                    <label>pengembalian</label>
                                    <input type="text" class="form-control tanparupiah" name="tipeA[${level1}][sub][${level2}][sub][${level3}][sub][${level4}][pengembalian]" value="0">
                                </div>
                            </div>
                        </td>
                        <td class="action-cell">
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="removeHierarchyItem('new_sub_sub_sub_item_id', this)"
                                    title="Hapus Sub-Sub-Sub Item">
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        `;
    }

    function updateNumbering() {
        // Update main item numbering
        const mainItems = document.querySelectorAll('.hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            const numberCell = item.querySelector('.number-cell');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }

            // Update sub item numbering
            const subItems = item.querySelectorAll('.hierarchy-item[data-level="1"]');
            subItems.forEach((subItem, subIndex) => {
                const subNumberCell = subItem.querySelector('.number-cell');
                if (subNumberCell) {
                    subNumberCell.textContent = `${index + 1}.${subIndex + 1}`;
                }

                // Update sub-sub item numbering
                const subSubItems = subItem.querySelectorAll('.hierarchy-item[data-level="2"]');
                subSubItems.forEach((subSubItem, subSubIndex) => {
                    const subSubNumberCell = subSubItem.querySelector('.number-cell');
                    if (subSubNumberCell) {
                        subSubNumberCell.textContent = `${index + 1}.${subIndex + 1}.${subSubIndex + 1}`;
                    }

                    // Update sub-sub-sub item numbering
                    const subSubSubItems = subSubItem.querySelectorAll('.hierarchy-item[data-level="3"]');
                    subSubSubItems.forEach((subSubSubItem, subSubSubIndex) => {
                        const subSubSubNumberCell = subSubSubItem.querySelector('.number-cell');
                        if (subSubSubNumberCell) {
                            subSubSubNumberCell.textContent = `${index + 1}.${subIndex + 1}.${subSubIndex + 1}.${subSubSubIndex + 1}`;
                        }
                    });
                });
            });
        });
    }

    function initializeCurrencyFormatting() {
        // Format existing currency fields
        formatAllCurrencyFields();

        // Add event listeners for new currency fields
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('tanparupiah')) {
                formatCurrencyField(e.target);
            }
        });
    }

    function formatAllCurrencyFields() {
        const currencyFields = document.querySelectorAll('.tanparupiah');
        currencyFields.forEach(formatCurrencyField);
    }

    function formatCurrencyField(field) {
        let value = field.value.replace(/[^0-9]/g, '');
        if (value) {
            value = parseInt(value).toLocaleString('id-ID');
        }
        field.value = value;
    }

    function addMobileStyles() {
        const style = document.createElement('style');
        style.textContent = `
            @media (max-width: 768px) {
                .hierarchy-container {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }

                .hierarchy-table {
                    min-width: 700px;
                }

                .action-cell {
                    position: sticky;
                    right: 0;
                    background-color: var(--bs-secondary-bg, #f8f9fa) !important;
                    z-index: 10;
                    box-shadow: -2px 0 4px rgba(0,0,0,0.1);
                }

                .number-cell {
                    position: sticky;
                    left: 0;
                    z-index: 10;
                    box-shadow: 2px 0 4px rgba(0,0,0,0.1);
                }

                .btn {
                    margin: 1px !important;
                    font-size: 0.7rem !important;
                    padding: 0.2rem 0.3rem !important;
                }
            }

            /* Form submission preparation */
            .hierarchy-container input[type="text"],
            .hierarchy-container textarea {
                border: 1px solid var(--bs-border-color, #dee2e6) !important;
            }

            .hierarchy-container input[type="text"]:focus,
            .hierarchy-container textarea:focus {
                border-color: var(--bs-primary, #0d6efd) !important;
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25) !important;
            }
        `;
        document.head.appendChild(style);
    }

    // Form validation and submission handling
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'recommendationForm') {
            console.log('Hierarchy component form submit detected');
            e.preventDefault();

            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;

            // Convert currency fields back to numeric format for submission
            const currencyFields = document.querySelectorAll('.tanparupiah');
            currencyFields.forEach(function(field) {
                const numericValue = field.value.replace(/[^0-9]/g, '') || '0';
                field.value = numericValue;
            });

            // Validate required fields - specifically target rekomendasi fields within the form
            const form = document.getElementById('recommendationForm');
            const requiredFields = form.querySelectorAll('textarea[name*="rekomendasi"], input[name*="rekomendasi"]');
            let hasEmpty = false;
            let emptyFields = [];

            console.log('Found', requiredFields.length, 'rekomendasi fields to validate');

            requiredFields.forEach(function(field, index) {
                console.log(`Checking field ${index + 1}:`, field.name, 'Value:', field.value.trim());
                if (!field.value.trim()) {
                    field.style.borderColor = '#dc3545';
                    field.style.backgroundColor = '#ffebee';
                    field.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                    field.classList.add('is-invalid');
                    hasEmpty = true;

                    // Get field context for better error message
                    let itemNumber = 'Unknown';
                    const fieldName = field.getAttribute('name') || '';

                    console.log('Validating field:', fieldName, 'Value:', field.value);

                    // First try to parse from field name pattern (most reliable)
                    const matches = fieldName.match(/tipeA\[(\d+)\](?:\[sub\]\[(\d+)\])?(?:\[sub\]\[(\d+)\])?/);
                    if (matches) {
                        const level1 = parseInt(matches[1]) + 1;
                        const level2 = matches[2] ? parseInt(matches[2]) + 1 : null;
                        const level3 = matches[3] ? parseInt(matches[3]) + 1 : null;

                        if (level3) {
                            itemNumber = `${level1}.${level2}.${level3}`;
                        } else if (level2) {
                            itemNumber = `${level1}.${level2}`;
                        } else {
                            itemNumber = `${level1}`;
                        }
                        console.log('Item number from field name:', itemNumber);
                    } else {
                        // Fallback to DOM traversal
                        const fieldContainer = field.closest('.hierarchy-item');
                        if (fieldContainer) {
                            // Try to find the number cell in the same hierarchy item
                            let numberCell = fieldContainer.querySelector('.number-cell');

                            // If not found in direct container, look in the parent table row
                            if (!numberCell) {
                                const tableRow = field.closest('tr');
                                if (tableRow) {
                                    numberCell = tableRow.querySelector('.number-cell');
                                }
                            }

                            if (numberCell) {
                                itemNumber = numberCell.textContent.trim();
                                console.log('Item number from DOM:', itemNumber);
                            } else {
                                console.log('Could not find number cell for field:', fieldName);
                                itemNumber = fieldName; // Use field name as fallback
                            }
                        }
                    }

                    emptyFields.push(`Item ${itemNumber}`);
                } else {
                    field.style.borderColor = '';
                    field.style.backgroundColor = '';
                    field.style.boxShadow = '';
                    field.classList.remove('is-invalid');
                }
            });

            if (hasEmpty) {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Restore currency formatting
                currencyFields.forEach(formatCurrencyField);

                // Create a more detailed error message
                let errorMessage = 'Mohon isi field rekomendasi yang masih kosong:\n\n';
                emptyFields.forEach((field, index) => {
                    errorMessage += `${index + 1}. ${field}\n`;
                });
                errorMessage += '\nSemua field rekomendasi harus diisi sebelum menyimpan data.';

                alert(errorMessage);

                // Add pulse animation to all error fields
                const errorFields = document.querySelectorAll('.is-invalid');
                errorFields.forEach(field => {
                    field.classList.add('error-pulse');
                    setTimeout(() => field.classList.remove('error-pulse'), 1000);
                });

                // Scroll to first empty field
                const firstEmptyField = document.querySelector('.is-invalid');
                if (firstEmptyField) {
                    firstEmptyField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        firstEmptyField.focus();
                        // For textarea/input fields, select all content
                        if (firstEmptyField.select) {
                            firstEmptyField.select();
                        }
                    }, 300);
                }
                return false;
            }

            // Collect form data for debugging
            console.log('Form data being submitted:');
            const formData = new FormData(e.target);
            for (let pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }

            // Submit the form
            try {
                console.log('Submitting hierarchy component form to:', e.target.action);
                console.log('Form method:', e.target.method);
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

    // Add auto-save functionality and real-time validation
    let autoSaveTimeout;
    document.addEventListener('input', function(e) {
        if (e.target.closest('#recommendationForm')) {
            // Real-time validation for rekomendasi fields
            if (e.target.name && e.target.name.includes('rekomendasi')) {
                if (e.target.value.trim()) {
                    // Field has content - mark as valid
                    e.target.style.borderColor = '#28a745';
                    e.target.style.backgroundColor = '#d4edda';
                    e.target.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
                    e.target.classList.remove('is-invalid');
                    e.target.classList.add('is-valid');
                } else {
                    // Field is empty - remove validation styles
                    e.target.style.borderColor = '';
                    e.target.style.backgroundColor = '';
                    e.target.style.boxShadow = '';
                    e.target.classList.remove('is-invalid', 'is-valid');
                }
            }

            // Clear previous timeout
            clearTimeout(autoSaveTimeout);

            // Set new timeout for auto-save (5 seconds after last input)
            autoSaveTimeout = setTimeout(function() {
                console.log('Auto-save triggered');
                // You can implement auto-save to localStorage here
                saveToLocalStorage();
            }, 5000);
        }
    });

    function saveToLocalStorage() {
        try {
            const formData = {};
            const form = document.getElementById('recommendationForm');
            const inputs = form.querySelectorAll('input, textarea');

            inputs.forEach(function(input) {
                if (input.name && input.value) {
                    formData[input.name] = input.value;
                }
            });

            localStorage.setItem('recommendationForm_' + document.querySelector('input[name="id_pengawasan"]').value, JSON.stringify(formData));
            console.log('Data saved to localStorage');
        } catch (error) {
            console.error('Auto-save error:', error);
        }
    }

    function loadFromLocalStorage() {
        try {
            const savedData = localStorage.getItem('recommendationForm_' + document.querySelector('input[name="id_pengawasan"]').value);
            if (savedData) {
                const formData = JSON.parse(savedData);

                Object.keys(formData).forEach(function(fieldName) {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (field && !field.value) { // Only fill empty fields
                        field.value = formData[fieldName];
                        if (field.classList.contains('tanparupiah')) {
                            formatCurrencyField(field);
                        }
                    }
                });

                console.log('Data loaded from localStorage');
            }
        } catch (error) {
            console.error('Auto-load error:', error);
        }
    }

    // Load saved data on page load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(loadFromLocalStorage, 1000); // Delay to ensure form is fully rendered
    });

    // Clear localStorage after successful submission
    window.addEventListener('beforeunload', function() {
        // Only clear if form was submitted (you can add a flag for this)
        if (document.getElementById('submitBtn').disabled) {
            localStorage.removeItem('recommendationForm_' + document.querySelector('input[name="id_pengawasan"]').value);
        }
    });

    // Preview function
    function previewData() {
        const form = document.getElementById('recommendationForm');
        const formData = new FormData(form);
        let summary = '<ul>';
        let itemCount = 0;
        let totalPengembalian = 0;

        // Count items and calculate totals
        const mainItems = document.querySelectorAll('.hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            const rekomendasi = item.querySelector('textarea[name*="rekomendasi"]').value;
            if (rekomendasi.trim()) {
                itemCount++;
                const pengembalian = item.querySelector('input[name*="pengembalian"]').value.replace(/[^0-9]/g, '') || '0';
                totalPengembalian += parseInt(pengembalian);
                summary += `<li><strong>Item ${index + 1}:</strong> ${rekomendasi.substring(0, 50)}...</li>`;

                // Check sub items
                const subItems = item.querySelectorAll('.hierarchy-item[data-level="1"]');
                subItems.forEach((subItem, subIndex) => {
                    const subRekomendasi = subItem.querySelector('input[name*="rekomendasi"]').value;
                    if (subRekomendasi.trim()) {
                        itemCount++;
                        const subPengembalian = subItem.querySelector('input[name*="pengembalian"]').value.replace(/[^0-9]/g, '') || '0';
                        totalPengembalian += parseInt(subPengembalian);
                        summary += `<li style="margin-left: 20px;"><strong>Sub ${index + 1}.${subIndex + 1}:</strong> ${subRekomendasi.substring(0, 40)}...</li>`;

                        // Check sub-sub items
                        const subSubItems = subItem.querySelectorAll('.hierarchy-item[data-level="2"]');
                        subSubItems.forEach((subSubItem, subSubIndex) => {
                            const subSubRekomendasi = subSubItem.querySelector('input[name*="rekomendasi"]').value;
                            if (subSubRekomendasi.trim()) {
                                itemCount++;
                                const subSubPengembalian = subSubItem.querySelector('input[name*="pengembalian"]').value.replace(/[^0-9]/g, '') || '0';
                                totalPengembalian += parseInt(subSubPengembalian);
                                summary += `<li style="margin-left: 40px;"><strong>Sub ${index + 1}.${subIndex + 1}.${subSubIndex + 1}:</strong> ${subSubRekomendasi.substring(0, 30)}...</li>`;
                            }
                        });
                    }
                });
            }
        });

        summary += '</ul>';

        const validationContent = document.getElementById('validationContent');
        validationContent.innerHTML = `
            <p><strong>Total Items:</strong> ${itemCount}</p>
            <p><strong>Total Pengembalian:</strong> ${totalPengembalian.toLocaleString('id-ID')}</p>
            <div><strong>Daftar Rekomendasi:</strong></div>
            ${summary}
        `;

        const validationSummary = document.getElementById('validationSummary');
        validationSummary.style.display = 'block';
        validationSummary.scrollIntoView({ behavior: 'smooth' });
    }

    // Add keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to save
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.getElementById('submitBtn').click();
        }

        // Ctrl + P to preview
        if (e.ctrlKey && e.key === 'p') {
            e.preventDefault();
            previewData();
        }
    });

    // Handle delete main item functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-main-item')) {
            const button = e.target.closest('.delete-main-item');
            const itemId = button.getAttribute('data-itemid');
            const levelIndex = button.getAttribute('data-level');

            // Get item info for confirmation
            const hierarchyItem = button.closest('.hierarchy-item[data-level="0"]');
            const rekomendasiText = hierarchyItem.querySelector('textarea[name*="rekomendasi"]').value;
            const truncatedText = rekomendasiText.length > 50 ? rekomendasiText.substring(0, 50) + '...' : rekomendasiText;

            // Count all children (sub and sub-sub items)
            let childCount = 0;
            const subItems = hierarchyItem.querySelectorAll('.hierarchy-item[data-level="1"]');
            childCount += subItems.length;
            subItems.forEach(subItem => {
                childCount += subItem.querySelectorAll('.hierarchy-item[data-level="2"]').length;
            });

            let confirmMessage = `Apakah Anda yakin ingin menghapus item "${truncatedText}"?`;
            if (childCount > 0) {
                confirmMessage += `\n\nItem ini memiliki ${childCount} sub-item yang juga akan dihapus.`;
            }

            if (confirm(confirmMessage)) {
                deleteMainItem(itemId, levelIndex);
            }
        }
    });

    // Function to delete main item and all its children (CLIENT-SIDE ONLY)
    function deleteMainItem(itemId, levelIndex) {
        console.log('Deleting main item client-side:', itemId, 'at level index:', levelIndex);

        // Find the hierarchy item to remove
        const hierarchyItem = document.querySelector(`.hierarchy-item[data-level="0"][data-index="${levelIndex}"]`);
        if (!hierarchyItem) {
            console.error('Hierarchy item not found for level index:', levelIndex);
            showNotification('Item tidak ditemukan!', 'error');
            return;
        }

        console.log('Found hierarchy item to delete:', hierarchyItem);

        // Show loading state briefly for visual feedback
        const button = document.querySelector(`#delete_main_${levelIndex}`);
        if (button) {
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;
        }

        // Add fade out animation
        hierarchyItem.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
        hierarchyItem.style.opacity = '0';
        hierarchyItem.style.transform = 'scale(0.95)';

        // Remove the item after animation
        setTimeout(() => {
            try {
                // Remove the entire hierarchy item from DOM
                hierarchyItem.remove();
                console.log('Hierarchy item removed from DOM');

                // Update numbering for remaining items
                updateMainItemNumbering();
                console.log('Main item numbering updated');

                // Show success message
                showNotification('Item dan semua sub-item berhasil dihapus dari daftar', 'success');
            } catch (error) {
                console.error('Error during item removal:', error);
                showNotification('Terjadi kesalahan saat menghapus item: ' + error.message, 'error');
            }
        }, 300);
    }

    // Function to update numbering after deletion
    function updateMainItemNumbering() {
        const mainItems = document.querySelectorAll('.hierarchy-item[data-level="0"]');
        mainItems.forEach((item, index) => {
            // Update data-index attribute
            item.setAttribute('data-index', index);

            // Update number cell
            const numberCell = item.querySelector('.number-cell');
            if (numberCell) {
                numberCell.textContent = index + 1;
            }

            // Update sub-item numbering
            const subItems = item.querySelectorAll('.hierarchy-item[data-level="1"]');
            subItems.forEach((subItem, subIndex) => {
                const subNumberCell = subItem.querySelector('.number-cell');
                if (subNumberCell) {
                    subNumberCell.textContent = `${index + 1}.${subIndex + 1}`;
                }

                // Update sub-sub-item numbering
                const subSubItems = subItem.querySelectorAll('.hierarchy-item[data-level="2"]');
                subSubItems.forEach((subSubItem, subSubIndex) => {
                    const subSubNumberCell = subSubItem.querySelector('.number-cell');
                    if (subSubNumberCell) {
                        subSubNumberCell.textContent = `${index + 1}.${subIndex + 1}.${subSubIndex + 1}`;
                    }
                });
            });
        });
    }

    // Function to show notifications
    function showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        // Add to page
        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Handle hierarchy item removal (client-side only) for level 1 and above
    function removeHierarchyItem(itemId, buttonElement) {
        console.log('removeHierarchyItem called with itemId:', itemId);

        // Find the item container
        const itemContainer = buttonElement.closest('.hierarchy-item');
        if (!itemContainer) {
            console.error('Item container not found');
            alert('Item tidak ditemukan!');
            return;
        }

        console.log('Found item container:', itemContainer);

        // Get item info for confirmation
        const itemLevel = itemContainer.dataset.level;
        const itemHeaderElement = itemContainer.querySelector('textarea[name*="rekomendasi"], input[name*="rekomendasi"]');
        const itemHeaderText = itemHeaderElement ? itemHeaderElement.value.trim() : 'Item';

        console.log('Item level:', itemLevel, 'Header text:', itemHeaderText);

        // Check if item has children - improved logic
        const allItems = document.querySelectorAll('.hierarchy-item');
        const currentIndex = Array.from(allItems).indexOf(itemContainer);
        let hasChildren = false;

        // Check following items for children
        for (let i = currentIndex + 1; i < allItems.length; i++) {
            const nextItem = allItems[i];
            const nextLevel = parseInt(nextItem.dataset.level);

            if (nextLevel > parseInt(itemLevel)) {
                hasChildren = true;
                break;
            } else if (nextLevel <= parseInt(itemLevel)) {
                break;
            }
        }

        console.log('Has children:', hasChildren);

        let confirmMessage = `Yakin ingin menghapus "${itemHeaderText.substring(0, 50)}${itemHeaderText.length > 50 ? '...' : ''}"?`;
        if (hasChildren) {
            confirmMessage += '\n\nPerhatian: Item ini memiliki sub-item yang juga akan ikut terhapus.';
        }

        if (!confirm(confirmMessage)) {
            console.log('User cancelled deletion');
            return;
        }

        console.log('User confirmed deletion, proceeding...');

        // Create removal animation
        itemContainer.style.transition = 'all 0.3s ease';
        itemContainer.style.opacity = '0.5';
        itemContainer.style.transform = 'scale(0.95)';

        // Remove the item after animation
        setTimeout(() => {
            try {
                // Also remove any child items that might be nested
                const allChildItems = getAllChildItems(itemContainer);
                console.log('Found child items to remove:', allChildItems.length);
                allChildItems.forEach(child => child.remove());

                // Remove the main item
                itemContainer.remove();
                console.log('Item successfully removed from DOM');

                // Show success message
                showNotification('Item berhasil dihapus dari daftar', 'success');

                // Update numbering for remaining items
                updateMainItemNumbering();
                console.log('Item numbering updated');
            } catch (error) {
                console.error('Error during item removal:', error);
                alert('Terjadi kesalahan saat menghapus item: ' + error.message);
            }
        }, 300);
    }

    // Helper function to get all child items recursively
    function getAllChildItems(parentContainer) {
        const childItems = [];
        const parentLevel = parseInt(parentContainer.dataset.level);

        // Get all hierarchy items
        const allItems = document.querySelectorAll('.hierarchy-item');
        const parentIndex = Array.from(allItems).indexOf(parentContainer);

        console.log('Parent level:', parentLevel, 'Parent index:', parentIndex);

        // Check all items after the parent
        for (let i = parentIndex + 1; i < allItems.length; i++) {
            const item = allItems[i];
            const itemLevel = parseInt(item.dataset.level);

            // If item level is greater than parent, it's a child
            if (itemLevel > parentLevel) {
                childItems.push(item);
                console.log('Added child item at level:', itemLevel);
            } else {
                // If we encounter an item at same or lower level, stop
                console.log('Stopped at item with level:', itemLevel);
                break;
            }
        }

        console.log('Total child items found:', childItems.length);
        return childItems;
    }
</script>
