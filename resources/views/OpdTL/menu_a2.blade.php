@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-clipboard-list-outline"></i>
            </span>
            Menu A2 - Data Dukung Rekomendasi (Read Only)
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('opdTL.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Menu A2</li>
            </ul>
        </nav>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($data) && count($data) > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0 text-white">Data Dukung Rekomendasi</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="pengawasanTable">
                                <thead class="bg-success text-white">
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
                                    @foreach($data as $index => $item)
                                        <tr>
                                            <td><strong>{{ $index + 1 }}</strong></td>
                                            <td>{{ isset($item['tanggal_disposisi']) ? date('Y-m-d', strtotime($item['tanggal_disposisi'])) : '2025-09-22' }}</td>
                                            <td>{{ $item['nomor_surat'] ?? '700.1.1/100/03/2025' }}</td>
                                            <td>{{ $item['jenis_pengawasan'] ?? 'TES' }}</td>
                                            <td>{{ $item['nama_obrik'] ?? 'DPU' }}</td>
                                            <td>{{ $item['tipe_rekomendasi'] ?? 'TemuandanRekomendasi' }}</td>
                                            <td>
                                                <a href="{{ route('opdTL.menuA2.detail', ['id' => $item['id']]) }}" class="btn btn-primary btn-sm">
                                                    Edit
                                                </a>
                                                <button type="button" class="btn btn-success btn-sm" disabled>
                                                    Hapus
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
    @else
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="mdi mdi-information-outline mdi-72px text-muted mb-3"></i>
                        <h4 class="text-muted">Tidak Ada Data</h4>
                        <p class="text-muted">
                            @if(auth()->check())
                                Belum ada data dukung rekomendasi yang dapat Anda akses.
                            @else
                                Silakan login untuk melihat data.
                            @endif
                        </p>
                        <a href="{{ route('opdTL.dashboard') }}" class="btn btn-gradient-primary">
                            <i class="mdi mdi-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@section('scripts')
<script>
$(document).ready(function() {
    $('#pengawasanTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthChange: false,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        language: {
            search: "Cari:",
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
        }
    });
});
</script>
@endsection
@endsection
