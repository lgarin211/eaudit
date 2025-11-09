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

    /* Simple card design */
    .pengawasan-checkbox:checked + label {
        color: #28a745 !important;
        font-weight: bold;
    }





    /* Clean and simple styling */
    .card {
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .form-check-label {
        cursor: pointer;
    }

    /* Accordion styling */
    .accordion .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .accordion .btn-link {
        text-decoration: none;
        color: #007bff;
        font-weight: 500;
    }

    .accordion .btn-link:hover {
        text-decoration: none;
        color: #0056b3;
    }

    .accordion .btn-link:focus {
        box-shadow: none;
    }

    .accordion-arrow {
        transition: transform 0.2s ease;
        font-size: 0.8rem;
    }

    .accordion .btn-link[aria-expanded="true"] .accordion-arrow {
        transform: rotate(180deg);
    }

    .border-left-primary {
        border-left: 3px solid #007bff !important;
    }

    .badge-sm {
        font-size: 0.7rem;
        padding: 0.2rem 0.4rem;
    }

    /* Detail cards styling */
    .card-body .card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .card-body .card:hover {
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        transform: translateY(-1px);
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
                            <div class="accordion" id="pengawasanAccordion">
                                @foreach($jenisTemuansHierarchy as $penugasanId => $penugasanGroup)
                                    <div class="card mb-2">
                                        <div class="card-header" id="heading{{ $penugasanId }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="flex-grow-1">
                                                    <button class="btn btn-link text-left p-0 collapsed" type="button"
                                                            data-toggle="collapse"
                                                            data-target="#collapse{{ $penugasanId }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse{{ $penugasanId }}">
                                                        <h6 class="mb-0 text-primary">
                                                            <i class="fas fa-database mr-2"></i>
                                                            @if(isset($pengawasanData[$penugasanId]))
                                                                {{ $pengawasanData[$penugasanId]['display_name'] }}
                                                            @else
                                                                Pengawasan ID: {{ $penugasanId }}
                                                            @endif
                                                            <i class="fas fa-chevron-down ml-2 accordion-arrow"></i>
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ count($penugasanGroup) }} jenis temuan tersedia
                                                        </small>
                                                    </button>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                               class="form-check-input pengawasan-checkbox"
                                                               id="pengawasan{{ $penugasanId }}"
                                                               data-pengawasan-id="{{ $penugasanId }}"
                                                               onchange="togglePengawasanSelection({{ $penugasanId }})">
                                                        <label class="form-check-label text-success font-weight-bold" for="pengawasan{{ $penugasanId }}">
                                                            Pilih Data
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="collapse{{ $penugasanId }}"
                                             class="collapse"
                                             aria-labelledby="heading{{ $penugasanId }}"
                                             data-parent="#pengawasanAccordion">
                                            <div class="card-body">
                                                <div class="row">
                                                    @foreach($penugasanGroup as $parentId => $hierarchy)
                                                        @if(isset($hierarchy['parent']))
                                                            <div class="col-md-6 mb-3">
                                                                <div class="card h-100 border-left-primary">
                                                                    <div class="card-body">
                                                                        <h6 class="card-title text-primary">
                                                                            <i class="fas fa-folder-open mr-2"></i>
                                                                            @if($hierarchy['parent']->rekomendasi AND $hierarchy['parent']->kode_temuan)
                                                                                {{ ucwords(strtolower($hierarchy['parent']->nama_temuan ?: $hierarchy['parent']->rekomendasi)) }}
                                                                            @elseif($hierarchy['parent']->rekomendasi AND !$hierarchy['parent']->kode_temuan)
                                                                                {{ ucwords(strtolower($hierarchy['parent']->rekomendasi)) }}
                                                                            @else
                                                                                {{ ucwords(strtolower($hierarchy['parent']->nama_temuan)) }}
                                                                            @endif
                                                                        </h6>

                                                                        @if($hierarchy['parent']->kode_temuan)
                                                                            <p class="mb-2">
                                                                                <span class="badge badge-primary">{{ $hierarchy['parent']->kode_temuan }}</span>
                                                                                <small class="text-muted ml-2">Temuan dan Rekomendasi</small>
                                                                            </p>
                                                                        @else
                                                                            <p class="mb-2">
                                                                                <span class="badge badge-info">Rekomendasi</span>
                                                                            </p>
                                                                        @endif

                                                                        @if(!empty($hierarchy['children']) && is_array($hierarchy['children']))
                                                                            <div class="mt-3">
                                                                                <h6 class="text-muted">Sub Items:</h6>
                                                                                <ul class="list-unstyled ml-3">
                                                                                    @foreach($hierarchy['children'] as $child)
                                                                                        <li class="mb-1">
                                                                                            <i class="fas fa-arrow-right text-muted mr-2"></i>
                                                                                            <small>
                                                                                                @if($child->rekomendasi)
                                                                                                    {{ ucwords(strtolower($child->rekomendasi)) }}
                                                                                                @else
                                                                                                    {{ ucwords(strtolower($child->nama_temuan)) }}
                                                                                                @endif
                                                                                                @if($child->kode_temuan)
                                                                                                    <span class="badge badge-secondary badge-sm ml-1">{{ $child->kode_temuan }}</span>
                                                                                                @endif
                                                                                            </small>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
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

        // Collect selected pengawasan IDs
        const selectedPengawasanIds = [];
        $('.pengawasan-checkbox:checked').each(function() {
            selectedPengawasanIds.push($(this).data('pengawasan-id'));
        });

        // Prepare form data
        const formData = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            user_id: $('#editUserId').val(),
            access_type: $('input[name="access_type"]:checked').val(),
            pengawasan_ids: selectedPengawasanIds,
            notes: $('#notes').val()
        };

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
                $('.pengawasan-checkbox').prop('checked', false);

                // Since we changed to pengawasan-level selection, we need to check which pengawasan contains these IDs
                allowedIds.forEach(function(id) {
                    console.log('Checking ID:', id);
                    // Find which pengawasan this ID belongs to and check that pengawasan
                    const pengawasanId = findPengawasanForId(id);
                    if (pengawasanId) {
                        $('#pengawasan' + pengawasanId).prop('checked', true);
                    }
                });

                // No need to update parent states since we use pengawasan-level selection
                console.log('Pengawasan checkboxes updated based on allowed IDs');
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
    $('.pengawasan-checkbox').prop('checked', true);
    console.log('All pengawasan selected');
}

function deselectAllJenis() {
    $('.pengawasan-checkbox').prop('checked', false);
    console.log('All pengawasan deselected');
}

// Function to toggle selection for entire pengawasan group
function togglePengawasanSelection(pengawasanId) {
    const pengawasanCheckbox = $('#pengawasan' + pengawasanId);
    const isChecked = pengawasanCheckbox.is(':checked');

    // Since we only have pengawasan-level selection now, just update the state
    console.log('Pengawasan ' + pengawasanId + ' toggled to: ' + isChecked);
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

// Simplified functions for pengawasan-level selection only
function updatePengawasanParentStates(pengawasanId) {
    // No child checkboxes, so no need to update parent states  
    console.log('Pengawasan ' + pengawasanId + ' - using simple selection');
}

// Helper function to find which pengawasan an ID belongs to
function findPengawasanForId(jenisTemuanId) {
    try {
        // This should be populated from server-side data
        const hierarchyData = @json($jenisTemuansHierarchy);
        console.log('Finding pengawasan for ID:', jenisTemuanId);
        console.log('Hierarchy data:', hierarchyData);

        for (const pengawasanId in hierarchyData) {
            const penugasanGroup = hierarchyData[pengawasanId];
            for (const parentId in penugasanGroup) {
                const hierarchy = penugasanGroup[parentId];

                // Check parent
                if (hierarchy.parent && hierarchy.parent.id == jenisTemuanId) {
                    console.log('Found in parent:', pengawasanId);
                    return pengawasanId;
                }

                // Check if children exists and is an array
                if (hierarchy.children && Array.isArray(hierarchy.children)) {
                    for (let i = 0; i < hierarchy.children.length; i++) {
                        const child = hierarchy.children[i];
                        if (child && child.id == jenisTemuanId) {
                            console.log('Found in children:', pengawasanId);
                            return pengawasanId;
                        }
                    }
                } else if (hierarchy.children) {
                    console.warn('Children is not an array:', hierarchy.children);
                }
            }
        }
        console.log('ID not found in any pengawasan');
        return null;
    } catch (error) {
        console.error('Error in findPengawasanForId:', error);
        return null;
    }
}// Keep existing group functions for compatibility
// Legacy functions removed - now using pengawasan-level selection only

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
