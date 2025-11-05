@extends('template')

@section('title')
User Data - User Control
@endsection

@section('content')
<style>
    .jenis-temuan-check:checked + label .card {
        background-color: #007bff !important;
        color: white !important;
        border-color: #007bff !important;
    }

    .jenis-temuan-check:checked + label .text-muted {
        color: #e9ecef !important;
    }

    .jenis-temuan-check + label .card {
        cursor: pointer;
        transition: all 0.2s;
    }

    .jenis-temuan-check + label .card:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }

    /* Group styling */
    .group-header {
        background-color: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 0.5rem;
        border-radius: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .btn-xs {
        padding: 0.125rem 0.5rem;
        font-size: 0.75rem;
        line-height: 1.5;
        border-radius: 0.2rem;
    }

    /* Dark Theme Hierarchical Design */
    .hierarchy-group {
        background: #2c3e50;
        border: 2px solid #34495e;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .parent-row {
        background: linear-gradient(135deg, #3498db, #2980b9) !important;
        border: none;
        position: relative;
        color: white !important;
        font-weight: 600;
        padding: 1rem 1.25rem !important;
    }

    .parent-row::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, rgba(255,255,255,0.4), rgba(255,255,255,0.1));
    }

    .parent-checkbox:checked + .parent-row {
        background: linear-gradient(135deg, #27ae60, #229954) !important;
        animation: parentSelected 0.3s ease;
    }

    .parent-checkbox:indeterminate + .parent-row {
        background: linear-gradient(135deg, #f39c12, #e67e22) !important;
    }

    .parent-section {
        position: relative;
    }

    @keyframes parentSelected {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }

    .children-container {
        background: #34495e !important;
        border-top: 1px solid #4a5f7a;
    }

    .child-row {
        transition: all 0.25s ease;
        background: transparent;
        color: #ecf0f1 !important;
        border-bottom: 1px solid #4a5f7a;
        padding: 0.875rem 1.25rem !important;
    }

    .child-row:last-child {
        border-bottom: none !important;
    }

    .child-row:hover {
        background: #3d566e !important;
        transform: translateX(5px);
    }

    .child-checkbox:checked + label + div,
    .child-checkbox:checked ~ div {
        color: #2ecc71 !important;
        font-weight: 600;
    }

    .child-row:has(.child-checkbox:checked) {
        background: rgba(46, 204, 113, 0.15) !important;
    }

    .child-checkbox:checked + label + div .fas,
    .child-checkbox:checked ~ div .fas {
        color: #2ecc71 !important;
    }

    .parent-checkbox, .child-checkbox {
        cursor: pointer;
        width: 18px !important;
        height: 18px !important;
        border: 2px solid #7f8c8d !important;
        background: #ecf0f1 !important;
        border-radius: 3px !important;
    }

    .parent-checkbox:checked, .child-checkbox:checked {
        background: #2ecc71 !important;
        border-color: #27ae60 !important;
    }

    .parent-checkbox:indeterminate {
        background: #f39c12 !important;
        border-color: #e67e22 !important;
    }

    .parent-checkbox:indeterminate::after {
        content: '−';
        color: white;
        font-weight: bold;
        display: block;
        text-align: center;
        line-height: 14px;
        font-size: 14px;
    }

    .badge-light {
        background-color: rgba(255,255,255,0.9) !important;
        color: #2c3e50 !important;
        font-weight: 600;
        border-radius: 12px;
        padding: 0.25rem 0.75rem;
        font-size: 0.8rem;
    }

    .badge-secondary {
        background-color: #6c757d !important;
        color: white !important;
        border-radius: 10px;
        padding: 0.2rem 0.6rem;
        font-size: 0.75rem;
    }

    .font-weight-medium {
        font-weight: 500;
    }

    /* Icon styling */
    .fas.fa-folder-open {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .fas.fa-arrow-right {
        color: #95a5a6 !important;
        font-size: 0.9rem;
    }

    /* Text improvements */
    .parent-row strong {
        font-size: 1.05rem;
        letter-spacing: 0.3px;
    }

    .child-row .font-weight-medium {
        font-size: 0.95rem;
        letter-spacing: 0.2px;
    }

    /* Small text styling */
    small {
        opacity: 0.8;
        font-size: 0.8rem !important;
    }

    /* Enhancement untuk better visual feedback */
    .parent-checkbox:focus, .child-checkbox:focus {
        outline: 2px solid #3498db;
        outline-offset: 2px;
    }

    /* Loading animation untuk feedback */
    .hierarchy-group:hover {
        box-shadow: 0 6px 12px rgba(0,0,0,0.4);
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    /* Better checkbox styling */
    .form-check-label {
        cursor: pointer;
        margin-left: 0.5rem;
    }

    /* Improved badge contrast */
    .badge-light {
        text-shadow: none;
        font-weight: 700;
    }

    /* Animation untuk smooth transitions */
    .parent-row, .child-row {
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Multi-level styling */
    .level-1 {
        margin-left: 1.5rem;
    }

    .level-2 {
        margin-left: 3rem;
        background-color: #e9ecef !important;
    }

    .level-3 {
        margin-left: 4.5rem;
        background-color: #dee2e6 !important;
    }

    /* Penugasan section styling */
    .penugasan-section {
        background-color: #2c3e50;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid #34495e;
    }

    .penugasan-section h6 {
        border-bottom: 2px solid #3498db;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }

    .sub-child {
        border-left: 3px solid #6c757d;
        padding-left: 1rem;
    }

    .grandchildren-container {
        background-color: rgba(108, 117, 125, 0.1);
        border-left: 2px dashed #6c757d;
        margin-left: 2rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .hierarchy-group {
            margin-bottom: 0.5rem;
        }

        .parent-row, .child-row {
            padding: 1rem !important;
        }

        .level-1, .level-2, .level-3 {
            margin-left: 1rem;
        }
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-database"></i>
                        User Data - Pengaturan Akses Data
                    </h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-12">
                            <button type="button" class="btn btn-sm btn-info" onclick="testAjax()" style="margin-bottom: 10px;">
                                <i class="fas fa-bug"></i> Test AJAX Connection
                            </button>
                            <button type="button" class="btn btn-sm btn-warning test-js-btn" style="margin-bottom: 10px; margin-left: 5px;">
                                <i class="fas fa-cog"></i> Test JavaScript
                            </button>
                            <button type="button" class="btn btn-sm btn-success" onclick="testModal()" style="margin-bottom: 10px; margin-left: 5px;">
                                <i class="fas fa-window-restore"></i> Test Modal
                            </button>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Panduan Penggunaan:</strong>
                                <ul class="mb-0 mt-2">
                                    <li><strong>Semua Data:</strong> User dapat mengakses semua jenis temuan</li>
                                    <li><strong>Akses Terbatas:</strong> User hanya dapat mengakses jenis temuan yang dipilih</li>
                                    <li><strong>Status Aktif/Nonaktif:</strong> Mengontrol apakah user dapat mengakses sistem atau tidak</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="userDataTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama User</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status Akses</th>
                                    <th>Tipe Akses</th>
                                    <th>Catatan</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        @if($user->id == auth()->id())
                                        <span class="badge badge-info badge-sm ml-1">You</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        @switch($user->role ?? 'user')
                                            @case('admin')
                                                <span class="badge badge-danger">Admin</span>
                                                @break
                                            @case('pemeriksa')
                                                <span class="badge badge-warning">Pemeriksa</span>
                                                @break
                                            @case('obrik')
                                                <span class="badge badge-info">Obrik</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">User</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm access-toggle-btn {{ $user->userDataAccess && $user->userDataAccess->is_active ? 'btn-success' : 'btn-secondary' }}"
                                                data-user-id="{{ $user->id }}"
                                                data-status="{{ $user->userDataAccess && $user->userDataAccess->is_active ? '1' : '0' }}">
                                            <i class="fas {{ $user->userDataAccess && $user->userDataAccess->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                            <span class="access-status-text">
                                                {{ $user->userDataAccess && $user->userDataAccess->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </button>
                                    </td>
                                    <td>
                                        @if($user->userDataAccess)
                                            @if($user->userDataAccess->access_type === 'all')
                                                <span class="badge badge-primary">Semua Data</span>
                                            @else
                                                @php
                                                    // Karena jenis_temuan_ids sudah di-cast sebagai array di model
                                                    $jenisIds = $user->userDataAccess->jenis_temuan_ids ?? [];
                                                    $jenisCount = is_array($jenisIds) ? count($jenisIds) : 0;
                                                @endphp
                                                <span class="badge badge-warning">
                                                    Terbatas ({{ $jenisCount }} jenis)
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">Belum Diatur</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>
                                            {{ $user->userDataAccess->notes ?? '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-primary"
                                                onclick="editAccess({{ $user->id }})"
                                                title="Edit Akses Data">
                                            <i class="fas fa-edit"></i> Edit Akses
                                        </button>
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
</div>

<!-- Edit Access Modal -->
<div class="modal fade" id="editAccessModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-cog"></i> Edit Akses Data User
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="accessForm">
                @csrf
                <div class="modal-body" style="background-color: #f8f9fa;">
                    <input type="hidden" id="editUserId" name="user_id">

                    <!-- User Info Card -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-2">
                                <i class="fas fa-user"></i> Informasi User
                            </h6>
                            <p id="editUserInfo" class="mb-0 text-muted"></p>
                        </div>
                    </div>

                    <!-- Access Type Card -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-key"></i> Tipe Akses <span class="text-danger">*</span>
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="accessAll" name="access_type" value="all" class="custom-control-input">
                                        <label class="custom-control-label" for="accessAll">
                                            <strong>Semua Data</strong>
                                            <br><small class="text-muted">User dapat mengakses semua jenis temuan</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="accessSpecific" name="access_type" value="specific" class="custom-control-input">
                                        <label class="custom-control-label" for="accessSpecific">
                                            <strong>Akses Terbatas</strong>
                                            <br><small class="text-muted">Pilih jenis temuan tertentu</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jenis Temuan Selection Card -->
                    <div class="card mb-3" id="jenisTemuanSection" style="display: none;">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-list-check"></i> Jenis Temuan yang Dapat Diakses
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary mr-2" onclick="selectAllJenis()">
                                    <i class="fas fa-check-square"></i> Pilih Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllJenis()">
                                    <i class="fas fa-square"></i> Hapus Semua
                                </button>
                            </div>
                            <!-- Dark Theme Hierarchical Display -->
                            @foreach($jenisTemuansHierarchy as $penugasanId => $penugasanGroup)
                                <div class="penugasan-section mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="text-info mb-0">
                                            <i class="fas fa-tasks mr-2"></i>
                                            Pengawasan ID: {{ $penugasanId }}
                                        </h6>
                                        <div class="pengawasan-controls">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox"
                                                       class="pengawasan-checkbox"
                                                       id="pengawasan{{ $penugasanId }}"
                                                       data-pengawasan-id="{{ $penugasanId }}"
                                                       onchange="togglePengawasanSelection({{ $penugasanId }})">
                                                <label class="form-check-label text-warning" for="pengawasan{{ $penugasanId }}">
                                                    <strong>Pilih Semua dalam Pengawasan Ini</strong>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    @foreach($penugasanGroup as $parentId => $hierarchy)
                                        <div class="hierarchy-group">
                                            <!-- Parent Section -->
                                            <div class="parent-section">
                                                <input type="checkbox"
                                                       class="parent-checkbox"
                                                       id="parent{{ $hierarchy['parent']->id }}"
                                                       name="jenis_temuan_ids[]"
                                                       value="{{ $hierarchy['parent']->id }}"
                                                       data-parent-id="{{ $hierarchy['parent']->id }}"
                                                       data-pengawasan-id="{{ $penugasanId }}">

                                                <div class="parent-row d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check mr-3">
                                                            <label class="form-check-label" for="parent{{ $hierarchy['parent']->id }}">
                                                                <!-- Checkbox handled by CSS -->
                                                            </label>
                                                        </div>
                                                        <div>
                                                            <strong>
                                                                <i class="fas fa-folder-open mr-2"></i>
                                                                @if($hierarchy['parent']->rekomendasi AND $hierarchy['parent']->kode_temuan)
                                                                    {{ strtoupper($hierarchy['parent']->nama_temuan) }}
                                                                    ({{ strtoupper($hierarchy['parent']->rekomendasi) }})
                                                                    <span class="badge badge-light ml-2">{{ $hierarchy['parent']->kode_temuan }}</span>
                                                                    <small class="ml-2">Temuan dan Rekom</small>
                                                                @endif
                                                                @if ($hierarchy['parent']->rekomendasi AND $hierarchy['parent']->kode_temuan == NULL)
                                                                    {{ strtoupper($hierarchy['parent']->rekomendasi) }}
                                                                @endif
                                                            </strong>
                                                        </div>
                                                    </div>
                                                    @if(count($hierarchy['children']) > 0)
                                                    <div>
                                                        <span class="badge badge-light">
                                                            <i class="fas fa-sitemap mr-1"></i>
                                                            {{ count($hierarchy['children']) }} sub-item{{ count($hierarchy['children']) > 1 ? 's' : '' }}
                                                        </span>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Children Section -->
                                            @if(count($hierarchy['children']) > 0)
                                            <div class="children-container">
                                                @foreach($hierarchy['children'] as $index => $child)
                                                <div class="child-row d-flex align-items-center">
                                                    <div class="ml-4 d-flex align-items-center w-100">
                                                        <div class="form-check mr-3">
                                                            <input type="checkbox"
                                                                   class="child-checkbox"
                                                                   id="child{{ $child->id }}"
                                                                   name="jenis_temuan_ids[]"
                                                                   value="{{ $child->id }}"
                                                                   data-parent-id="{{ $hierarchy['parent']->id }}"
                                                                   data-pengawasan-id="{{ $penugasanId }}">
                                                            <label class="form-check-label" for="child{{ $child->id }}"></label>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fas fa-arrow-right mr-3"></i>
                                                                    <span class="font-weight-medium">
                                                                        @if($child->rekomendasi)
                                                                            {{ ucwords(strtolower($child->rekomendasi)) }}
                                                                        @else
                                                                            {{ $child->nama_temuan }}
                                                                        @endif
                                                                    </span>
                                                                    @if($child->kode_temuan)
                                                                        <span class="badge badge-secondary ml-2">{{ $child->kode_temuan }}</span>
                                                                    @endif
                                                                </div>
                                                                <small>(ID: {{ $child->id }})</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Notes Card -->
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title mb-3">
                                <i class="fas fa-sticky-note"></i> Catatan (Opsional)
                            </h6>
                            <textarea class="form-control"
                                      id="notes"
                                      name="notes"
                                      rows="3"
                                      placeholder="Catatan tentang akses pengguna ini..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    console.log('Document ready - jQuery version:', $.fn.jquery);
    console.log('Bootstrap modal available:', typeof $.fn.modal);
    console.log('DataTables available:', typeof $.fn.DataTable);

    // Test if CSRF token is available
    console.log('CSRF token:', $('meta[name="csrf-token"]').attr('content'));

    $('#userDataTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[1, 'asc']]
    });

    // Access toggle handler (using button instead of switch)
    $('.access-toggle-btn').on('click', function() {
        const userId = $(this).data('user-id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus == '1' ? '0' : '1';
        const button = $(this);
        const statusText = button.find('.access-status-text');
        const icon = button.find('i');

        // Show loading
        button.prop('disabled', true);
        button.html('<i class="fas fa-spinner fa-spin"></i> Loading...');

        $.post('/adminTL/user-control/toggle-user-access/' + userId, {
            _token: $('meta[name="csrf-token"]').attr('content')
        })
        .done(function(response) {
            if (response.success) {
                // Update button appearance
                button.data('status', newStatus);
                if (newStatus == '1') {
                    button.removeClass('btn-secondary').addClass('btn-success');
                    button.html('<i class="fas fa-toggle-on"></i> <span class="access-status-text">Aktif</span>');
                } else {
                    button.removeClass('btn-success').addClass('btn-secondary');
                    button.html('<i class="fas fa-toggle-off"></i> <span class="access-status-text">Nonaktif</span>');
                }

                // Show success message
                showAlert('success', response.message);
            } else {
                // Revert button
                button.html(currentStatus == '1' ?
                    '<i class="fas fa-toggle-on"></i> <span class="access-status-text">Aktif</span>' :
                    '<i class="fas fa-toggle-off"></i> <span class="access-status-text">Nonaktif</span>'
                );
                showAlert('error', response.message);
            }
        })
        .fail(function(xhr, status, error) {
            // Revert button
            button.html(currentStatus == '1' ?
                '<i class="fas fa-toggle-on"></i> <span class="access-status-text">Aktif</span>' :
                '<i class="fas fa-toggle-off"></i> <span class="access-status-text">Nonaktif</span>'
            );
            console.error('AJAX Error:', xhr.responseText);
            showAlert('error', 'Terjadi kesalahan saat mengubah status akses: ' + error);
        })
        .always(function() {
            button.prop('disabled', false);
        });
    });

    // Test JavaScript button handler
    $(document).on('click', '.test-js-btn', function() {
        alert('JavaScript bekerja! jQuery version: ' + $.fn.jquery);
    });

    // Edit access button handler
    $(document).on('click', '.edit-access-btn', function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        console.log('Edit access button clicked for user:', userId);

        // Test alert to verify click is working
        alert('Tombol Edit diklik untuk User ID: ' + userId);

        editAccess(userId);
    });

    // Access type change handler (radio buttons)
    $('input[name="access_type"]').on('change', function() {
        if ($(this).val() === 'specific') {
            $('#jenisTemuanSection').show();
        } else {
            $('#jenisTemuanSection').hide();
            $('.jenis-temuan-check').prop('checked', false);
        }
    });

    // Access form submission
    $('#accessForm').on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();

        $.post('/adminTL/user-control/update-user-data-access', formData)
        .done(function(response) {
            if (response.success) {
                $('#editAccessModal').modal('hide');
                showAlert('success', response.message);
                // Reload page after short delay
                setTimeout(function() {
                    location.reload();
                }, 1500);
            } else {
                showAlert('error', response.message);
            }
        })
        .fail(function() {
            showAlert('error', 'Terjadi kesalahan saat menyimpan pengaturan akses');
        });
    });
});

function editAccess(userId) {
    try {
        console.log('editAccess called with userId:', userId);

        // Find user data
        const users = @json($users);
        console.log('Available users:', users);

        const user = users.find(u => u.id === userId);
        console.log('Found user:', user);

        if (!user) {
            console.error('User not found for ID:', userId);
            showAlert('error', 'Data user tidak ditemukan');
            return;
        }

        // Reset form
        $('#accessForm')[0].reset();
        $('#editUserId').val(userId);
        $('#editUserInfo').html('<strong>' + user.name + '</strong> (' + user.username + ')');

        // Set current access data
        if (user.user_data_access) {
            console.log('User access data:', user.user_data_access);

            // Set radio button value
            $('input[name="access_type"][value="' + user.user_data_access.access_type + '"]').prop('checked', true);
            $('#notes').val(user.user_data_access.notes || '');

            if (user.user_data_access.access_type === 'specific') {
                $('#jenisTemuanSection').show();

                // Check specific jenis temuan - sudah berupa array dari model casting
                let allowedIds = user.user_data_access.jenis_temuan_ids || [];
                console.log('Allowed IDs raw:', allowedIds, 'Type:', typeof allowedIds);

                // Jika masih berupa string, parse dulu
                if (typeof allowedIds === 'string') {
                    allowedIds = JSON.parse(allowedIds);
                }

                console.log('Allowed IDs processed:', allowedIds);

                // Clear all checkboxes first
                $('.parent-checkbox, .child-checkbox').prop('checked', false);

                // Set checked states based on allowed IDs
                allowedIds.forEach(function(id) {
                    console.log('Checking ID:', id);
                    $('.parent-checkbox[value="' + id + '"], .child-checkbox[value="' + id + '"]').prop('checked', true);
                });

                // Update parent-child relationships after setting checkboxes
                updateAllParentStates();
            } else {
                $('#jenisTemuanSection').hide();
            }
        } else {
            // Set default to 'all' radio button
            $('input[name="access_type"][value="all"]').prop('checked', true);
            $('#jenisTemuanSection').hide();
        }

        console.log('About to show modal...');
        $('#editAccessModal').modal('show');

    } catch (error) {
        console.error('Error in editAccess:', error);
        showAlert('error', 'Terjadi kesalahan: ' + error.message);
    }
}

function selectAllJenis() {
    $('.parent-checkbox, .child-checkbox').prop('checked', true);
    $('.pengawasan-checkbox').prop('checked', true);
    updateAllParentStates();
    updateAllPengawasanStates();
}

function deselectAllJenis() {
    $('.parent-checkbox, .child-checkbox').prop('checked', false);
    $('.pengawasan-checkbox').prop('checked', false);
    updateAllParentStates();
    updateAllPengawasanStates();
}

// Function to toggle selection for entire pengawasan group
function togglePengawasanSelection(pengawasanId) {
    const pengawasanCheckbox = $('#pengawasan' + pengawasanId);
    const isChecked = pengawasanCheckbox.is(':checked');

    // Select/deselect all checkboxes in this pengawasan
    $('[data-pengawasan-id="' + pengawasanId + '"]').prop('checked', isChecked);

    // Update parent states for this pengawasan
    updatePengawasanParentStates(pengawasanId);
}

// Function to update pengawasan checkbox state based on children
function updatePengawasanStates() {
    $('.pengawasan-checkbox').each(function() {
        const pengawasanId = $(this).data('pengawasan-id');
        const totalCheckboxes = $('[data-pengawasan-id="' + pengawasanId + '"]').length;
        const checkedCheckboxes = $('[data-pengawasan-id="' + pengawasanId + '"]:checked').length;

        if (checkedCheckboxes === 0) {
            $(this).prop('checked', false).prop('indeterminate', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $(this).prop('checked', true).prop('indeterminate', false);
        } else {
            $(this).prop('checked', false).prop('indeterminate', true);
        }
    });
}

// Function to update all pengawasan states
function updateAllPengawasanStates() {
    updatePengawasanStates();
}

// Function to update parent states within a specific pengawasan
function updatePengawasanParentStates(pengawasanId) {
    // Update parent checkboxes within this pengawasan
    $('[data-pengawasan-id="' + pengawasanId + '"].parent-checkbox').each(function() {
        const parentId = $(this).data('parent-id');
        const children = $('[data-parent-id="' + parentId + '"][data-pengawasan-id="' + pengawasanId + '"].child-checkbox');

        if (children.length > 0) {
            const checkedChildren = children.filter(':checked').length;

            if (checkedChildren === 0) {
                $(this).prop('indeterminate', false);
            } else if (checkedChildren === children.length) {
                $(this).prop('checked', true).prop('indeterminate', false);
            } else {
                $(this).prop('indeterminate', true);
            }
        }
    });
}

// Group selection functions
function selectGroupJenis(parentId) {
    $('.group-' + parentId).prop('checked', true);
}

function deselectGroupJenis(parentId) {
    $('.group-' + parentId).prop('checked', false);
}

// Enhanced multi-level parent-child checkbox logic
$(document).ready(function() {
    // Parent checkbox change handler
    $(document).on('change', '.parent-checkbox', function() {
        const parentId = $(this).data('parent-id');
        const isChecked = $(this).is(':checked');

        // Check/uncheck ALL descendants (children, grandchildren, etc.)
        $('.child-checkbox[data-parent-id="' + parentId + '"]').prop('checked', isChecked);

        console.log('Parent ' + parentId + ' changed to: ' + isChecked);
    });

    // Child checkbox change handler
    $(document).on('change', '.child-checkbox', function() {
        const rootParentId = $(this).data('parent-id');
        const directParentId = $(this).data('direct-parent');
        const childId = $(this).val();
        const isChecked = $(this).is(':checked');
        const pengawasanId = $(this).data('pengawasan-id');

        // If this child has its own children, cascade the selection
        if (isChecked) {
            // Check all children of this child
            $('.child-checkbox[data-direct-parent="' + childId + '"]').prop('checked', true);
        } else {
            // Uncheck all children of this child
            $('.child-checkbox[data-direct-parent="' + childId + '"]').prop('checked', false);
        }

        // Update parent states
        updateParentState(rootParentId);

        // Update pengawasan checkbox state
        updatePengawasanStates();

        console.log('Child ' + childId + ' changed, updating parent ' + rootParentId);
    });

    // Parent checkbox change handler (updated)
    $(document).on('change', '.parent-checkbox', function() {
        const parentId = $(this).data('parent-id');
        const isChecked = $(this).is(':checked');
        const pengawasanId = $(this).data('pengawasan-id');

        // Check/uncheck ALL descendants (children, grandchildren, etc.)
        $('.child-checkbox[data-parent-id="' + parentId + '"]').prop('checked', isChecked);

        // Update pengawasan checkbox state
        updatePengawasanStates();

        console.log('Parent ' + parentId + ' changed to: ' + isChecked);
    });
});

function updateParentState(parentId) {
    const allChildren = $('.child-checkbox[data-parent-id="' + parentId + '"]');
    const checkedChildren = $('.child-checkbox[data-parent-id="' + parentId + '"]:checked');
    const parentCheckbox = $('.parent-checkbox[data-parent-id="' + parentId + '"]');

    if (allChildren.length === 0) {
        // No children - parent can be independent
        return;
    }

    if (checkedChildren.length === 0) {
        // No children checked
        parentCheckbox.prop('checked', false);
        parentCheckbox.prop('indeterminate', false);
    } else if (checkedChildren.length === allChildren.length) {
        // All children checked
        parentCheckbox.prop('checked', true);
        parentCheckbox.prop('indeterminate', false);
    } else {
        // Some children checked - indeterminate state
        parentCheckbox.prop('checked', false);
        parentCheckbox.prop('indeterminate', true);
    }

    console.log('Parent ' + parentId + ' updated: checked=' + checkedChildren.length + '/' + allChildren.length);
}

function updateAllParentStates() {
    // Update all parent states based on their children
    $('.parent-checkbox').each(function() {
        const parentId = $(this).data('parent-id');
        updateParentState(parentId);
    });
}

// Keep existing group functions for compatibility
function selectGroupJenis(parentId) {
    $('.parent-checkbox[data-parent-id="' + parentId + '"]').prop('checked', true).trigger('change');
}

function deselectGroupJenis(parentId) {
    $('.parent-checkbox[data-parent-id="' + parentId + '"]').prop('checked', false).trigger('change');
}

function showAlert(type, message) {
    console.log('showAlert called:', type, message);
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            ${message}
        </div>
    `;

    $('.card-body').prepend(alertHtml);

    // Auto dismiss after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}

function testAjax() {
    console.log('Testing AJAX...');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.get('/adminTL/user-control/user-data')
        .done(function() {
            showAlert('success', 'AJAX connection working!');
            console.log('AJAX test successful');
        })
        .fail(function(xhr, status, error) {
            showAlert('error', 'AJAX test failed: ' + error);
            console.error('AJAX test failed:', xhr.responseText);
        });
}

function testModal() {
    console.log('Testing modal...');
    console.log('jQuery loaded:', typeof $);
    console.log('Bootstrap modal:', typeof $.fn.modal);
    console.log('Modal element exists:', $('#editAccessModal').length);

    if (typeof $.fn.modal !== 'undefined') {
        $('#editAccessModal').modal('show');
        showAlert('success', 'Modal test executed - check if modal opened');
    } else {
        showAlert('error', 'Bootstrap modal not loaded');
    }
}
</script>
@endsection
