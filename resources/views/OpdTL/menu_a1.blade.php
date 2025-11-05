@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-file-document"></i>
            </span>
            Menu A1 - Data Dukung Rekomendasi
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opdTL.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu A1</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">
                        <i class="mdi mdi-view-list"></i>
                        Data Dukung Rekomendasi (Read Only)
                    </h4>
                    <p class="card-description">
                        <span class="badge badge-info">Read Only</span>
                        Anda dapat melihat data sesuai permission yang diberikan. Tidak dapat melakukan edit atau hapus data.
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Tanggal Disposisi</th>
                                    <th>Nomor Surat</th>
                                    <th>Jenis Pengawasan</th>
                                    <th>Obrik</th>
                                    <th>Tipe Rekomendasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data['data'] as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item['tglkeluar'] ?? '-' }}</td>
                                    <td>{{ $item['noSurat'] ?? '-' }}</td>
                                    <td>{{ $item['jenis'] ?? '-' }}</td>
                                    <td>{{ $item['obrik'] ?? '-' }}</td>
                                    <td>
                                        @if(($item['tipe'] ?? '') === 'TES')
                                            <span class="badge badge-success">{{ $item['tipe'] }}</span>
                                        @else
                                            <span class="badge badge-primary">{{ $item['tipe'] ?? 'N/A' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('opdTL.menuA1.detail', $item['id']) }}"
                                           class="btn btn-gradient-info btn-sm"
                                           title="Lihat Detail">
                                            <i class="mdi mdi-eye"></i> Lihat
                                        </a>
                                        <span class="badge badge-secondary ml-2">Read Only</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="mdi mdi-information mdi-24px text-muted"></i>
                                            <p class="text-muted mt-2">Tidak ada data yang dapat diakses sesuai permission Anda</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "responsive": true,
        "autoWidth": false,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
        },
        "pageLength": 25,
        "order": [[0, 'asc']]
    });
});
</script>
@endpush
@endsection
