@extends('template')

@section('title')
List User - User Control
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-users"></i>
                        List User
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.user-control.create-user') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah User
                        </a>
                    </div>
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="userTable">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Status Akses</th>
                                    <th>Tipe Akses</th>
                                    <th>Bergabung</th>
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
                                        @if($user->userDataAccess && $user->userDataAccess->is_active)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->userDataAccess)
                                            @if($user->userDataAccess->access_type === 'all')
                                                <span class="badge badge-primary">Semua Data</span>
                                            @else
                                                <span class="badge badge-warning">Terbatas</span>
                                            @endif
                                        @else
                                            <span class="badge badge-secondary">Belum Diatur</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.user-control.edit-user', $user->id) }}"
                                               class="btn btn-sm btn-warning"
                                               title="Edit User">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if($user->id != auth()->id())
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')"
                                                    title="Hapus User">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus user <strong id="userName"></strong>?</p>
                <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[1, 'asc']]
    });
});

function confirmDelete(userId, userName) {
    $('#userName').text(userName);
    $('#deleteForm').attr('action', '/adminTL/user-control/delete-user/' + userId);
    $('#deleteModal').modal('show');
}
</script>
@endsection
