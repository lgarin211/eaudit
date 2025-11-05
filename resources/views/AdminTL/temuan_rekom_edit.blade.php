@extends('template')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    #mytable {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #mytable td, #mytable th {
      border: 2px solid #000;
      padding: 8px;
    }



    #mytable th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }

    #mytable1 {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #mytable1 td, #mytable th {
      border: 2px solid #000;
      padding: 8px;
    }



    #mytable1 th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color:#32CD32;
      color: white;
    }
     table #baris1 .kolom1{
        margin-left: 10px;
    }
    table #baris .kolom{
        margin-left: 20px;
    }
    table #baris2 .kolom2{
        margin-left: 30px;
    }

    /* Styling untuk nested sub-rekomendasi */
    .sub-level-1 {
        background-color: #f8f9fa;
        border-left: 3px solid #007bff;
    }

    .sub-level-1 .rekomendasi-text {
        margin-left: 20px;
        font-style: italic;
    }

    .sub-level-2 {
        background-color: #e9ecef;
        border-left: 3px solid #28a745;
    }

    .sub-level-2 .rekomendasi-text {
        margin-left: 40px;
        font-style: italic;
        font-size: 0.9em;
    }

    .sub-level-3 {
        background-color: #dee2e6;
        border-left: 3px solid #ffc107;
    }

    .sub-level-3 .rekomendasi-text {
        margin-left: 60px;
        font-style: italic;
        font-size: 0.85em;
    }

    /* Styling untuk temuan baru */
    .temuan-section {
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .border-success {
        border-color: #198754 !important;
    }

    #addTemuanBtn {
        transition: all 0.3s ease;
        border-radius: 25px;
        padding: 12px 30px;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #addTemuanBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .remove-temuan-btn {
        transition: all 0.2s ease;
    }

    .remove-temuan-btn:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
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
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ 'Belum Jadi' }}</textarea>
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

<div class="card mb-4" style="width: 100%;">
<div class="card-header"> Jenis Temuan dan Rekomendasi</div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Display existing data --}}
        @if(isset($existingData) && $existingData->count() > 0)
        <div class="card mb-4" style="display: none;">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-list"></i> Data Temuan & Rekomendasi yang Sudah Ada</h5>
            </div>
            <div class="card-body">
                @foreach($existingData as $parentIndex => $parent)
                <div class="mb-4 border rounded p-3">
                    <div class="row mb-3 bg-light p-2 rounded">
                        <div class="col-md-3">
                            <strong>Kode Temuan:</strong><br>
                            <span class="badge bg-primary">{{ $parent->kode_temuan ?? '-' }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Nama Temuan:</strong><br>
                            <span class="text-primary fw-bold">{{ $parent->nama_temuan ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 text-end">
                            <strong>Aksi Temuan:</strong><br>
                            <button type="button" class="btn btn-success btn-sm add-new-record-btn"
                                    data-kode-temuan="{{ $parent->kode_temuan ?? '' }}"
                                    data-nama-temuan="{{ $parent->nama_temuan ?? '' }}"
                                    data-temuan-id="{{ $parent->id ?? '' }}"
                                    title="Tambah Record Baru ke Temuan Ini">
                                <i class="fas fa-plus"></i> Add New Record
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-temuan-btn ms-1"
                                    data-kode-temuan="{{ $parent->kode_temuan ?? '' }}"
                                    data-nama-temuan="{{ $parent->nama_temuan ?? '' }}"
                                    data-temuan-id="{{ $parent->id ?? '' }}"
                                    title="Hapus Seluruh Temuan & Rekomendasi">
                                <i class="fas fa-trash"></i> Hapus Temuan
                            </button>
                        </div>
                    </div>

                    {{-- Display recommendations hierarchically --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="8%">Kode Temuan</th>
                                    <th width="12%">Nama Temuan</th>
                                    <th width="8%">Kode Rekomendasi</th>
                                    <th width="25%">Rekomendasi</th>
                                    <th width="17%">Keterangan</th>
                                    <th width="15%">Pengembalian</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Display all recommendations for this temuan --}}
                                @if($parent->recommendations && count($parent->recommendations) > 0)
                                    @php
                                        $rekomCounter = 1;
                                        $renderRecommendations = function($recommendations, $baseNumber = '', $level = 0, $parent = null) use (&$renderRecommendations, &$rekomCounter) {
                                            foreach ($recommendations as $rekom) {
                                                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                                                $number = $baseNumber ? $baseNumber . '.' . $rekomCounter : $rekomCounter;
                                                $levelClass = $level > 0 ? 'sub-level-' . min($level, 3) : '';

                                                echo '<tr class="' . $levelClass . '">';

                                                if ($level > 0) {
                                                    echo '<td>' . $indent . '↳ ' . $number . '</td>';
                                                } else {
                                                    echo '<td><strong>' . $number . '</strong></td>';
                                                }

                                                // Kode Temuan
                                                if ($level == 0) {
                                                    echo '<td><span class="badge bg-primary">' . ($parent->kode_temuan ?? '-') . '</span></td>';
                                                } else {
                                                    echo '<td>' . $indent . '<small class="text-muted">' . ($parent->kode_temuan ?? '-') . '</small></td>';
                                                }

                                                // Nama Temuan
                                                if ($level == 0) {
                                                    echo '<td><strong>' . ($parent->nama_temuan ?? '-') . '</strong></td>';
                                                } else {
                                                    echo '<td>' . $indent . '<small class="text-muted">' . ($parent->nama_temuan ?? '-') . '</small></td>';
                                                }

                                                // Kode Rekomendasi
                                                if ($level == 0) {
                                                    echo '<td><span class="badge bg-success">' . ($rekom->kode_rekomendasi ?? '-') . '</span></td>';
                                                } else {
                                                    echo '<td>' . $indent . '<small class="text-muted">' . ($rekom->kode_rekomendasi ?? '-') . '</small></td>';
                                                }

                                                $rekomStyle = $level > 0 ? '' : 'font-weight: bold;';
                                                echo '<td style="' . $rekomStyle . '">' . $indent . ($rekom->rekomendasi ?? '-') . '</td>';
                                                echo '<td>' . ($rekom->keterangan ?? '-') . '</td>';
                                                echo '<td>';

                                                if ($rekom->pengembalian && $rekom->pengembalian > 0) {
                                                    echo '<span class="text-success fw-bold">Rp ' . number_format($rekom->pengembalian, 0, ',', '.') . '</span>';
                                                } else {
                                                    echo '<span class="text-muted">-</span>';
                                                }

                                                echo '</td>';
                                                echo '<td>';
                                                echo '<button type="button" class="btn btn-warning btn-sm edit-rekom-btn" ';
                                                echo 'data-id="' . $rekom->id . '" ';
                                                echo 'data-kode-rekomendasi="' . htmlspecialchars($rekom->kode_rekomendasi ?? '') . '" ';
                                                echo 'data-rekomendasi="' . htmlspecialchars($rekom->rekomendasi ?? '') . '" ';
                                                echo 'data-keterangan="' . htmlspecialchars($rekom->keterangan ?? '') . '" ';
                                                echo 'data-pengembalian="' . ($rekom->pengembalian ?? 0) . '" ';
                                                echo 'data-kode-temuan="' . htmlspecialchars($parent->kode_temuan ?? '') . '" ';
                                                echo 'data-nama-temuan="' . htmlspecialchars($parent->nama_temuan ?? '') . '" ';
                                                echo 'title="Edit Rekomendasi">';
                                                echo '<i class="fas fa-edit"></i>';
                                                echo '</button> ';
                                                echo '<button type="button" class="btn btn-danger btn-sm delete-rekom-btn" ';
                                                echo 'data-id="' . $rekom->id . '" ';
                                                echo 'data-kode-temuan="' . htmlspecialchars($parent->kode_temuan ?? '') . '" ';
                                                echo 'data-nama-temuan="' . htmlspecialchars($parent->nama_temuan ?? '') . '" ';
                                                echo 'data-rekomendasi="' . htmlspecialchars($rekom->rekomendasi ?? '') . '" ';
                                                echo 'title="Hapus Rekomendasi">';
                                                echo '<i class="fas fa-trash"></i>';
                                                echo '</button>';
                                                echo '</td>';
                                                echo '</tr>';

                                                // Increment counter hanya untuk root level
                                                if ($level == 0) {
                                                    $rekomCounter++;
                                                }

                                                // Recursive call for nested children
                                                if (isset($rekom->children) && count($rekom->children) > 0) {
                                                    $renderRecommendations($rekom->children, $number, $level + 1, $parent);
                                                }
                                            }
                                        };

                                        $renderRecommendations($parent->recommendations, '', 0, $parent);
                                    @endphp
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Tidak ada rekomendasi</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Include Temuan Hierarchy Component --}}
        @include('AdminTL.datadukungkom_tambahtemuan_componponen', ['existingData' => isset($existingData) ? $existingData : [], 'pengawasan' => $pengawasan])

        {{-- Form for adding new data --}}
        <div class="card mb-4" style="display: none;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus"></i> Tambah Temuan & Rekomendasi Baru (Mode Lama)</h5>
            </div>
            <div class="card-body">
        <form action="{{ url('adminTL/temuan/') }}" method="post" enctype="multipart/form-data">
           @method('POST')
           @csrf
           <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
           <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">
           <table class="table">
               <thead>
                   <tr>
                       <th scope="col">KODE TEMUAN <span class="text-danger">*</span></th>
                       <th scope="col">NAMA TEMUAN <span class="text-danger">*</span></th>
                   </tr>
               </thead>
               <tbody>
                   <tr>
                    <td><input type="text" name="temuan[0][kode_temuan]" class="form-control" required></td>
                    <td><input type="text" name="temuan[0][nama_temuan]" class="form-control" required></td>
                   </tr>
               </tbody>
           </table>
           <table class="table">
            <thead>
              <tr>
                <th scope="col">Nomor</th>
                <th scope="col">NAMA REKOMENDASI <span class="text-danger">*</span></th>
                <th scope="col">KETERANGAN REKOMENDASI</th>
                <th scope="col">PENGEMBALIAN KEUANGAN</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="body" id="parenttemuan_0">
              <tr class="sub0" data-temuan-index="0" data-rekom-index="0" data-level="0">
                <td class="nomor-cell">1</td>
                <td><textarea class="form-control" name="temuan[0][rekomendasi][0][rekomendasi]" required></textarea></td>
                <td><textarea class="form-control" name="temuan[0][rekomendasi][0][keterangan]"></textarea></td>
                <td><input type="text" class="form-control tanparupiah" name="temuan[0][rekomendasi][0][pengembalian]" placeholder="Rp. 0"></td>
                <td>
                    <button type="button" data-temuan-index="0" class="btn btn-success btn-sm add_rekom_btn" title="Tambah Rekomendasi"><i class="fa-solid fa-plus"></i></button>
                    <button type="button" data-temuan-index="0" data-rekom-index="0" data-level="1" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button>
                    {{-- <button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button> --}}
                </td>
              </tr>
            </tbody>
          </table>

          <!-- Temuan tambahan akan ditambahkan di sini -->
          <div id="temuanBaru" class="mt-4"></div>

          <!-- Tombol untuk menambah temuan baru -->
          <div class="mt-3 mb-3 text-center">
              <button type="button" id="addTemuanBtn" class="btn btn-success btn-lg">
                  <i class="fas fa-plus-circle"></i> Tambah Temuan Baru (Contoh: 3, 4, dll)
              </button>
              <small class="d-block mt-2 text-muted">
                  Klik untuk menambah temuan baru seperti data 3, data 4, dan seterusnya
              </small>
          </div>

          <div class="mt-3">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <a href="{{ url('adminTL/temuanrekom') }}" class="btn btn-secondary">Batal</a>
          </div>
        </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>
// Global variables
let temuanCounter = 1; // Start from 1 since we already have temuan[0]
let rekomCounter = {}; // Track recommendation counter for each temuan
let subCounter = {}; // Track sub-recommendation counter

// Initialize recommendation counter for existing temuan
rekomCounter[0] = 1; // temuan[0] already has rekomendasi[0]
subCounter['0_0'] = 0; // temuan[0][rekomendasi][0] has no sub yet

// Format Rupiah function
function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return 'Rp. ' + rupiah;
}

// Function to renumber table with hierarchical numbering
function renumberTable(tbody) {
    var mainCounter = 1;
    var subCounters = {}; // Track sub-counters for each parent

    tbody.find('tr').each(function() {
        var row = $(this);
        var level = row.data('level') || 0;
        var indent = level * 20;
        var numberCell = row.find('.nomor-cell, td:first');

        if (level === 0) {
            // Main recommendation (level 0)
            numberCell.text(mainCounter);
            numberCell.css('padding-left', '8px');
            mainCounter++;

            // Reset sub-counters for this main item
            subCounters[mainCounter - 1] = [0, 0, 0]; // [level1, level2, level3]

        } else {
            // Sub-recommendation (level 1, 2, 3...)
            var parentMainIndex = mainCounter - 1;

            if (!subCounters[parentMainIndex]) {
                subCounters[parentMainIndex] = [0, 0, 0];
            }

            // Increment counter for current level
            subCounters[parentMainIndex][level - 1]++;

            // Reset counters for deeper levels
            for (var i = level; i < 3; i++) {
                subCounters[parentMainIndex][i] = 0;
            }

            // Build hierarchical number
            var hierarchicalNumber = parentMainIndex;
            for (var i = 0; i < level; i++) {
                if (subCounters[parentMainIndex][i] > 0) {
                    hierarchicalNumber += '.' + subCounters[parentMainIndex][i];
                }
            }

            // Add visual indicator for sub-items
            var prefix = '↳ ';
            numberCell.html(prefix + hierarchicalNumber);
            numberCell.css('padding-left', (8 + indent) + 'px');
        }
    });
}

$(document).ready(function() {

    // Add new temuan handler
    $('#addTemuanBtn').on('click', function() {
        var temuanIndex = temuanCounter;

        var html = '';
        html += '<div class="temuan-section" data-temuan-index="' + temuanIndex + '">';
        html += '<div class="card mb-4 border-success">';
        html += '<div class="card-header bg-success text-white d-flex justify-content-between align-items-center">';
        html += '<h6 class="mb-0"><i class="fas fa-plus"></i> Temuan Baru #' + (temuanIndex + 1) + '</h6>';
        html += '<button type="button" class="btn btn-sm btn-outline-light remove-temuan-btn" data-temuan-index="' + temuanIndex + '">';
        html += '<i class="fas fa-times"></i> Hapus Temuan';
        html += '</button>';
        html += '</div>';
        html += '<div class="card-body">';

        // Table for kode and nama temuan
        html += '<table class="table table-bordered mb-3">';
        html += '<thead class="table-light">';
        html += '<tr>';
        html += '<th scope="col">KODE TEMUAN <span class="text-danger">*</span></th>';
        html += '<th scope="col">NAMA TEMUAN <span class="text-danger">*</span></th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        html += '<tr>';
        html += '<td><input type="text" name="temuan[' + temuanIndex + '][kode_temuan]" class="form-control" placeholder="Contoh: 3, 4, 5..." required></td>';
        html += '<td><input type="text" name="temuan[' + temuanIndex + '][nama_temuan]" class="form-control" placeholder="Nama temuan baru..." required></td>';
        html += '</tr>';
        html += '</tbody>';
        html += '</table>';

        // Table for rekomendasi
        html += '<table class="table table-bordered">';
        html += '<thead class="table-light">';
        html += '<tr>';
        html += '<th scope="col">Nomor</th>';
        html += '<th scope="col">NAMA REKOMENDASI <span class="text-danger">*</span></th>';
        html += '<th scope="col">KETERANGAN REKOMENDASI</th>';
        html += '<th scope="col">PENGEMBALIAN KEUANGAN</th>';
        html += '<th>Aksi</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody class="body" id="parenttemuan_' + temuanIndex + '">';
        html += '<tr class="sub' + temuanIndex + '" data-temuan-index="' + temuanIndex + '" data-rekom-index="0" data-level="0">';
        html += '<td class="nomor-cell">1</td>';
        html += '<td><textarea class="form-control" name="temuan[' + temuanIndex + '][rekomendasi][0][rekomendasi]" placeholder="Rekomendasi untuk temuan ini..." required></textarea></td>';
        html += '<td><textarea class="form-control" name="temuan[' + temuanIndex + '][rekomendasi][0][keterangan]" placeholder="Keterangan rekomendasi..."></textarea></td>';
        html += '<td><input type="text" class="form-control tanparupiah" name="temuan[' + temuanIndex + '][rekomendasi][0][pengembalian]" placeholder="Rp. 0"></td>';
        html += '<td>';
        html += '<button type="button" data-temuan-index="' + temuanIndex + '" class="btn btn-success btn-sm add_rekom_btn" title="Tambah Rekomendasi"><i class="fa-solid fa-plus"></i></button> ';
        html += '<button type="button" data-temuan-index="' + temuanIndex + '" data-rekom-index="0" data-level="1" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button>';
        html += '</td>';
        html += '</tr>';
        html += '</tbody>';
        html += '</table>';
        html += '</div>'; // card-body
        html += '</div>'; // card
        html += '</div>'; // temuan-section

        $('#temuanBaru').append(html);

        // Initialize counters for this new temuan
        rekomCounter[temuanIndex] = 1; // Already has rekomendasi[0]

        // Increment global counter for next temuan
        temuanCounter++;

        // Show success message
        $('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
          '<i class="fas fa-check-circle"></i> Temuan baru #' + temuanIndex + ' berhasil ditambahkan!' +
          '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
          '</div>').insertBefore('#temuanBaru').delay(3000).fadeOut();
    });

    // Remove temuan handler
    $(document).on('click', '.remove-temuan-btn', function() {
        var temuanIndex = $(this).data('temuan-index');

        if (confirm('Apakah Anda yakin ingin menghapus temuan #' + (temuanIndex + 1) + ' beserta semua rekomendasinya?')) {
            $('.temuan-section[data-temuan-index="' + temuanIndex + '"]').fadeOut(300, function() {
                $(this).remove();
            });

            // Clean up counters
            delete rekomCounter[temuanIndex];

            // Show success message
            $('<div class="alert alert-info alert-dismissible fade show" role="alert">' +
              '<i class="fas fa-info-circle"></i> Temuan #' + (temuanIndex + 1) + ' berhasil dihapus!' +
              '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
              '</div>').insertBefore('#temuanBaru').delay(3000).fadeOut();
        }
    });

    // Format rupiah on input
    $(document).on('keyup', '.tanparupiah', function (e) {
        let rupiah = formatRupiah($(this).val());
        $(this).val(rupiah);
    });

    // Add new recommendation row
    $(document).on('click', '.add_rekom_btn', function () {
        var temuanIndex = $(this).data('temuan-index');

        // Initialize counter if not exists
        if (!rekomCounter[temuanIndex]) {
            rekomCounter[temuanIndex] = 0;
        }

        rekomCounter[temuanIndex]++;
        var rekomIndex = rekomCounter[temuanIndex];
        var rowNumber = $(this).closest('tbody').find('tr').length + 1;

        var html = '';
        html += '<tr class="sub' + temuanIndex + '" data-temuan-index="' + temuanIndex + '" data-rekom-index="' + rekomIndex + '" data-level="0">';
        html += '<td class="nomor-cell">' + rowNumber + '</td>';
        html += '<td><textarea class="form-control" name="temuan[' + temuanIndex + '][rekomendasi][' + rekomIndex + '][rekomendasi]" required></textarea></td>';
        html += '<td><textarea class="form-control" name="temuan[' + temuanIndex + '][rekomendasi][' + rekomIndex + '][keterangan]"></textarea></td>';
        html += '<td><input type="text" class="form-control tanparupiah" name="temuan[' + temuanIndex + '][rekomendasi][' + rekomIndex + '][pengembalian]" placeholder="Rp. 0"></td>';
        html += '<td>';
        html += '<button type="button" data-temuan-index="' + temuanIndex + '" class="btn btn-success btn-sm add_rekom_btn" title="Tambah Rekomendasi"><i class="fa-solid fa-plus"></i></button> ';
        html += '<button type="button" data-temuan-index="' + temuanIndex + '" data-rekom-index="' + rekomIndex + '" data-level="1" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button> ';
        html += '<button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button>';
        html += '</td>';
        html += '</tr>';

        $(this).closest('tbody').append(html);

        // Renumber the entire table after adding
        renumberTable($(this).closest('tbody'));
    });

    // Remove recommendation row
    $(document).on('click', '.remove_rekom_btn', function () {
        var tbody = $(this).closest('tbody');
        var rowToRemove = $(this).closest('tr');
        var parentLevel = rowToRemove.data('level') || 0;

        // Remove the row and all its nested sub-rows
        var nextRow = rowToRemove.next();
        rowToRemove.remove();

        // Remove all nested sub-rows that belong to this row
        while (nextRow.length > 0 && nextRow.data('level') > parentLevel) {
            var currentRow = nextRow;
            nextRow = nextRow.next();
            currentRow.remove();
        }

        // Renumber all rows in the table
        renumberTable(tbody);
    });

    // Add sub-recommendation (nested)
    $(document).on('click', '.add_sub_btn', function () {
        var temuanIndex = $(this).data('temuan-index');
        var parentRekomIndex = $(this).data('rekom-index');
        var level = $(this).data('level');
        var parentPath = $(this).data('parent-path') || '';

        // Find the correct parent row to get the actual structure
        var parentRow = $(this).closest('tr');
        var currentNamePrefix = '';

        // Extract the name pattern from parent row to build correct nested structure
        var parentTextarea = parentRow.find('textarea[name*="[rekomendasi]"]').first();
        if (parentTextarea.length > 0) {
            var parentName = parentTextarea.attr('name');
            // Extract the base path: temuan[0][rekomendasi][0] or temuan[0][rekomendasi][0][sub][1]
            var matches = parentName.match(/^(temuan\[\d+\]\[rekomendasi\]\[\d+\](?:\[sub\](?:\[\d+\])+)*)/);
            if (matches) {
                currentNamePrefix = matches[1];
            }
        }

        // Create unique key for sub counter based on parent structure
        var subKey = temuanIndex + '_' + parentRekomIndex + '_level' + level + (parentPath ? '_' + parentPath : '');

        // Initialize counter if not exists
        if (!subCounter[subKey]) {
            subCounter[subKey] = 0;
        }

        subCounter[subKey]++;
        var subIndex = subCounter[subKey];

        // Build the correct name path for nested structure
        var namePath = currentNamePrefix + '[sub][' + subIndex + ']';

        // Debug logging
        console.log('=== SUB-RECOMMENDATION DEBUG ===');
        console.log('Parent Name:', parentTextarea.length > 0 ? parentTextarea.attr('name') : 'No parent textarea found');
        console.log('Current Name Prefix:', currentNamePrefix);
        console.log('Final Name Path:', namePath);
        console.log('Level:', level);
        console.log('Sub Index:', subIndex);
        console.log('=== END DEBUG ===');

        // Build unique path for further nesting
        var newParentPath = parentPath ? parentPath + '_' + subIndex : subIndex;

        var levelClass = 'sub-level-' + Math.min(level, 3);

        var html = '';
        html += '<tr class="' + levelClass + '" data-temuan-index="' + temuanIndex + '" data-rekom-index="' + parentRekomIndex + '" data-level="' + level + '" data-parent-path="' + newParentPath + '">';
        html += '<td class="nomor-cell"></td>'; // Will be filled by renumberTable
        html += '<td><div class="rekomendasi-text"><textarea class="form-control" name="' + namePath + '[rekomendasi]" required placeholder="Sub-rekomendasi level ' + level + '"></textarea></div></td>';
        html += '<td><textarea class="form-control" name="' + namePath + '[keterangan]" placeholder="Keterangan sub-rekomendasi"></textarea></td>';
        html += '<td><input type="text" class="form-control tanparupiah" name="' + namePath + '[pengembalian]" placeholder="Rp. 0"></td>';
        html += '<td>';

        // Add buttons based on level (limit to 3 levels)
        if (level < 3) {
            html += '<button type="button" data-temuan-index="' + temuanIndex + '" data-rekom-index="' + parentRekomIndex + '" data-level="' + (level + 1) + '" data-parent-path="' + newParentPath + '" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Level ' + (level + 1) + '"><i class="fa-solid fa-indent"></i></button> ';
        }

        html += '<button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button>';
        html += '</td>';
        html += '</tr>';

        // Insert after current row
        var insertedRow = $(html);
        $(this).closest('tr').after(insertedRow);

        // Renumber the entire table
        renumberTable($(this).closest('tbody'));
    });

    // Add new temuan card
    $('#add_card').on('click', function () {
        var temuanIndex = temuanCounter; // Will be 1, 2, 3, etc.
        rekomCounter[temuanIndex] = 0; // Initialize recommendation counter for new temuan

        console.log('=== ADD TEMUAN DEBUG ===');
        console.log('Creating temuan with index:', temuanIndex);
        console.log('Total counter will be:', temuanCounter + 1);
        console.log('=== END DEBUG ===');

        var cardHtml = '';
        cardHtml += '<div class="card mb-3 temuan-card" data-temuan-index="' + temuanIndex + '">';
        cardHtml += '<div class="card-header d-flex justify-content-between align-items-center">';
        cardHtml += 'Tambah Jenis Temuan ' + (temuanIndex + 1);
        cardHtml += '<button type="button" class="btn btn-danger btn-sm hapus_card"><i class="fa-solid fa-trash"></i></button>';
        cardHtml += '</div>';
        cardHtml += '<div class="card-body">';

        // Temuan table
        cardHtml += '<table class="table">';
        cardHtml += '<thead>';
        cardHtml += '<tr>';
        cardHtml += '<th scope="col">KODE TEMUAN <span class="text-danger">*</span></th>';
        cardHtml += '<th scope="col">NAMA TEMUAN <span class="text-danger">*</span></th>';
        cardHtml += '</tr>';
        cardHtml += '</thead>';
        cardHtml += '<tbody>';
        cardHtml += '<tr>';
        cardHtml += '<td><input type="text" name="temuan[' + temuanIndex + '][kode_temuan]" class="form-control" required></td>';
        cardHtml += '<td><input type="text" name="temuan[' + temuanIndex + '][nama_temuan]" class="form-control" required></td>';
        cardHtml += '</tr>';
        cardHtml += '</tbody>';
        cardHtml += '</table>';

        // Recommendation table
        cardHtml += '<table class="table">';
        cardHtml += '<thead>';
        cardHtml += '<tr>';
        cardHtml += '<th scope="col">Nomor</th>';
        cardHtml += '<th scope="col">NAMA REKOMENDASI <span class="text-danger">*</span></th>';
        cardHtml += '<th scope="col">KETERANGAN REKOMENDASI</th>';
        cardHtml += '<th scope="col">PENGEMBALIAN KEUANGAN</th>';
        cardHtml += '<th>Aksi</th>';
        cardHtml += '</tr>';
        cardHtml += '</thead>';
        cardHtml += '<tbody class="body" id="parenttemuan_' + temuanIndex + '">';
        cardHtml += '<tr class="sub' + temuanIndex + '" data-temuan-index="' + temuanIndex + '" data-rekom-index="0" data-level="0">';
        cardHtml += '<td class="nomor-cell">1</td>';
        cardHtml += '<td><textarea class="form-control" name="temuan[' + temuanIndex + '][rekomendasi][0][rekomendasi]" required></textarea></td>';
        cardHtml += '<td><textarea class="form-control" name="temuan[' + temuanIndex + '][rekomendasi][0][keterangan]"></textarea></td>';
        cardHtml += '<td><input type="text" class="form-control tanparupiah" name="temuan[' + temuanIndex + '][rekomendasi][0][pengembalian]" placeholder="Rp. 0"></td>';
        cardHtml += '<td>';
        cardHtml += '<button type="button" data-temuan-index="' + temuanIndex + '" class="btn btn-success btn-sm add_rekom_btn" title="Tambah Rekomendasi"><i class="fa-solid fa-plus"></i></button> ';
        cardHtml += '<button type="button" data-temuan-index="' + temuanIndex + '" data-rekom-index="0" data-level="1" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button> ';
        cardHtml += '<button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button>';
        cardHtml += '</td>';
        cardHtml += '</tr>';
        cardHtml += '</tbody>';
        cardHtml += '</table>';
        cardHtml += '</div>';
        cardHtml += '</div>';

        $("#temuanBaru").append(cardHtml);
        temuanCounter++; // Increment after creating the card
    });

    // Remove temuan card
    $(document).on('click', '.hapus_card', function () {
        $(this).closest('.temuan-card').remove();
    });

    // Form validation before submit
    $('form').on('submit', function(e) {
        // Skip validation for modal form
        if ($(this).attr('id') === 'addRecordForm') {
            return; // Let modal form handle its own validation
        }

        var hasError = false;
        var errorMessages = [];

        // Debug: Check all form inputs
        console.log('=== FORM STRUCTURE DEBUG ===');
        var allInputs = $(this).find('input, textarea, select');
        console.log('Total form inputs found:', allInputs.length);

        var temuanInputs = $(this).find('input[name*="temuan"], textarea[name*="temuan"]');
        console.log('Total temuan-related inputs:', temuanInputs.length);

        // Check what's inside vs outside form
        var outsideInputs = $('input[name*="temuan"], textarea[name*="temuan"]').not($(this).find('input, textarea'));
        if (outsideInputs.length > 0) {
            console.log('⚠️ WARNING: Found inputs OUTSIDE form:', outsideInputs.length);
            outsideInputs.each(function() {
                console.log('Outside form input:', $(this).attr('name'));
            });
        }

        // Debug: Log form data before submission
        var formData = new FormData(this);
        console.log('=== FORM DATA DEBUG ===');
        console.log('Total form entries:', Array.from(formData.entries()).length);

        // Group by temuan index
        var temuanData = {};
        for (var pair of formData.entries()) {
            if (pair[0].includes('temuan[')) {
                var temuanMatch = pair[0].match(/temuan\[(\d+)\]/);
                if (temuanMatch) {
                    var temuanIndex = temuanMatch[1];
                    if (!temuanData[temuanIndex]) {
                        temuanData[temuanIndex] = [];
                    }
                    temuanData[temuanIndex].push(pair[0] + ': ' + pair[1]);
                }
            }
        }

        // Display grouped data
        Object.keys(temuanData).sort().forEach(function(temuanIndex) {
            console.log('--- TEMUAN[' + temuanIndex + '] ---');
            temuanData[temuanIndex].forEach(function(entry) {
                console.log(entry);
            });
        });
        console.log('=== END DEBUG ===');        // Check if at least one temuan exists
        var temuanExists = false;
        $('input[name*="nama_temuan"]').each(function() {
            if ($(this).val().trim() !== '') {
                temuanExists = true;
                return false;
            }
        });

        if (!temuanExists) {
            errorMessages.push('Minimal harus ada satu temuan yang diisi');
            hasError = true;
        }

        // Check if each temuan has at least one recommendation
        $('input[name*="nama_temuan"]').each(function() {
            if ($(this).val().trim() !== '') {
                var temuanIndex = $(this).attr('name').match(/temuan\[(\d+)\]/)[1];
                var hasRekom = false;

                $('textarea[name*="temuan[' + temuanIndex + '][rekomendasi]"][name*="[rekomendasi]"]').each(function() {
                    if ($(this).val().trim() !== '') {
                        hasRekom = true;
                        return false;
                    }
                });

                if (!hasRekom) {
                    errorMessages.push('Temuan ' + (parseInt(temuanIndex) + 1) + ' harus memiliki minimal satu rekomendasi');
                    hasError = true;
                }
            }
        });

        if (hasError) {
            e.preventDefault();
            alert('Error:\n' + errorMessages.join('\n'));
        }
    });

    // Modal form validation
    $('#addRecordForm').on('submit', function(e) {
        var hasError = false;
        var errorMessages = [];

        console.log('=== MODAL FORM SUBMISSION DEBUG ===');

        // Log form data
        var formData = new FormData(this);
        console.log('Modal form entries:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        // Check if at least one record has rekomendasi filled
        var hasValidRecord = false;
        var recordCount = 0;
        $(this).find('textarea[name*="records"][name*="[rekomendasi]"]').each(function() {
            recordCount++;
            console.log('Checking record ' + recordCount + ':', $(this).val().trim());
            if ($(this).val().trim() !== '') {
                hasValidRecord = true;
                console.log('Found valid record!');
            }
        });

        console.log('Total records found:', recordCount);
        console.log('Has valid record:', hasValidRecord);

        if (!hasValidRecord) {
            errorMessages.push('Minimal harus ada satu rekomendasi yang diisi');
            hasError = true;
        }

        console.log('Has error:', hasError);
        console.log('=== END MODAL DEBUG ===');

        if (hasError) {
            e.preventDefault();
            alert('Error:\n' + errorMessages.join('\n'));
        }
    });

    // Edit recommendation functionality
    $(document).on('click', '.edit-rekom-btn', function() {
        var id = $(this).data('id');
        var kodeRekomendasi = $(this).data('kode-rekomendasi');
        var rekomendasi = $(this).data('rekomendasi');
        var keterangan = $(this).data('keterangan');
        var pengembalian = $(this).data('pengembalian');
        var kodeTemuan = $(this).data('kode-temuan');
        var namaTemuan = $(this).data('nama-temuan');

        // Populate modal with data
        $('#edit-id').val(id);
        $('#edit-kode-rekomendasi').val(kodeRekomendasi);
        $('#edit-rekomendasi').val(rekomendasi);
        $('#edit-keterangan').val(keterangan);
        $('#edit-pengembalian').val(pengembalian > 0 ? formatRupiah(pengembalian.toString()) : '');
        $('#edit-kode-temuan').text(kodeTemuan);
        $('#edit-nama-temuan').text(namaTemuan);

        // Show modal
        $('#editModal').modal('show');
    });

    // Delete recommendation functionality
    $(document).on('click', '.delete-rekom-btn', function() {
        var id = $(this).data('id');
        var kodeTemuan = $(this).data('kode-temuan');
        var namaTemuan = $(this).data('nama-temuan');
        var rekomendasi = $(this).data('rekomendasi');

        console.log('Delete button clicked for ID:', id);

        // Create detailed confirmation message
        var confirmMessage = 'Apakah Anda yakin ingin menghapus rekomendasi ini?\n\n';
        confirmMessage += 'Kode Temuan: ' + kodeTemuan + '\n';
        confirmMessage += 'Nama Temuan: ' + namaTemuan + '\n';
        confirmMessage += 'Rekomendasi: ' + (rekomendasi.length > 100 ? rekomendasi.substring(0, 100) + '...' : rekomendasi);

        if (confirm(confirmMessage)) {
            console.log('Delete confirmed, sending AJAX request...');

            // Send delete request
            $.ajax({
                url: '/adminTL/rekomendasi/' + id,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    console.log('Sending DELETE request to:', '/adminTL/rekomendasi/' + id);
                },
                success: function(response) {
                    console.log('Delete response:', response);

                    if (response.success) {
                        alert(response.message || 'Rekomendasi berhasil dihapus!');
                        location.reload();
                    } else {
                        alert(response.message || 'Terjadi kesalahan saat menghapus data!');
                    }
                },
                error: function(xhr) {
                    console.error('Delete error:', xhr);
                    console.error('Status:', xhr.status);
                    console.error('Response Text:', xhr.responseText);

                    var errorMessage = 'Terjadi kesalahan saat menghapus data!';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }
                    }

                    alert(errorMessage);
                }
            });
        }
    });

    // Submit edit form
    $('#editForm').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            id: $('#edit-id').val(),
            kode_rekomendasi: $('#edit-kode-rekomendasi').val(),
            rekomendasi: $('#edit-rekomendasi').val(),
            keterangan: $('#edit-keterangan').val(),
            pengembalian: $('#edit-pengembalian').val().replace(/[^0-9]/g, ''), // Remove formatting
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        $.ajax({
            url: '/adminTL/rekomendasi/update',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert(response.message || 'Rekomendasi berhasil diperbarui!');
                    $('#editModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Terjadi kesalahan saat memperbarui data!');
                }
            },
            error: function(xhr) {
                console.error('Update error:', xhr);

                var errorMessage = 'Terjadi kesalahan saat memperbarui data!';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.message) {
                            errorMessage = response.message;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                    }
                }

                alert(errorMessage);
            }
        });
    });

    // Delete entire temuan functionality
    $(document).on('click', '.delete-temuan-btn', function() {
        var kodeTemuan = $(this).data('kode-temuan');
        var namaTemuan = $(this).data('nama-temuan');
        var temuanId = $(this).data('temuan-id');

        console.log('Delete temuan button clicked for:', kodeTemuan, namaTemuan);

        // Create detailed confirmation message
        var confirmMessage = '⚠️ PERINGATAN: Anda akan menghapus SELURUH TEMUAN!\n\n';
        confirmMessage += 'Kode Temuan: ' + kodeTemuan + '\n';
        confirmMessage += 'Nama Temuan: ' + namaTemuan + '\n\n';
        confirmMessage += 'Tindakan ini akan menghapus:\n';
        confirmMessage += '• Temuan utama\n';
        confirmMessage += '• SEMUA rekomendasi\n';
        confirmMessage += '• SEMUA sub-rekomendasi\n';
        confirmMessage += '• SEMUA nested sub-rekomendasi\n\n';
        confirmMessage += 'Apakah Anda yakin ingin melanjutkan?\n';
        confirmMessage += '(Data yang terhapus TIDAK DAPAT dikembalikan!)';

        if (confirm(confirmMessage)) {
            console.log('Delete temuan confirmed, sending AJAX request...');

            // Send delete request
            $.ajax({
                url: '/adminTL/temuan/' + kodeTemuan + '/delete-all',
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    console.log('Sending DELETE temuan request to:', '/adminTL/temuan/' + kodeTemuan + '/delete-all');
                },
                success: function(response) {
                    console.log('Delete temuan response:', response);
                    if (response.success) {
                        alert('✅ ' + (response.message || 'Temuan dan semua rekomendasi berhasil dihapus!'));
                        location.reload();
                    } else {
                        alert('❌ ' + (response.message || 'Terjadi kesalahan saat menghapus temuan!'));
                    }
                },
                error: function(xhr) {
                    console.error('Delete temuan error:', xhr);
                    console.error('Status:', xhr.status);
                    console.error('Response Text:', xhr.responseText);

                    var errorMessage = 'Terjadi kesalahan saat menghapus temuan!';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMessage = response.message;
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
                        }
                    }

                    alert('❌ ' + errorMessage);
                }
            });
        }
    });

    // Add New Record Modal Handler
    let recordCounter = 1;
    let subRecordCounters = {};

    $(document).on('click', '.add-new-record-btn', function() {
        var kodeTemuan = $(this).data('kode-temuan');
        var namaTemuan = $(this).data('nama-temuan');
        var temuanId = $(this).data('temuan-id');

        console.log('=== MODAL OPENING DEBUG ===');
        console.log('Kode Temuan:', kodeTemuan);
        console.log('Nama Temuan:', namaTemuan);

        // Set modal data
        $('#add-temuan-kode').val(kodeTemuan);
        $('#add-display-kode').text(kodeTemuan);
        $('#add-display-nama').text(namaTemuan);

        // Reset containers and counters BEFORE resetting form
        $('#recordsContainer').html('');
        recordCounter = 1;
        subRecordCounters = {};

        // Add first record
        addNewRecord();

        // Now set hidden values after adding record
        $('#add-temuan-kode').val(kodeTemuan);

        console.log('Modal setup complete, kode_temuan set to:', $('#add-temuan-kode').val());
        console.log('=== END MODAL OPENING DEBUG ===');

        // Show modal
        $('#addRecordModal').modal('show');
    });

    // Add More Record Button
    $('#addMoreRecordBtn').on('click', function() {
        addNewRecord();
    });

    // Function to add new record
    function addNewRecord() {
        var recordIndex = recordCounter - 1;
        subRecordCounters[recordIndex] = 0;

        var html = '';
        html += '<div class="record-group" data-record-index="' + recordIndex + '">';
        html += '<div class="card mb-3 border-success">';
        html += '<div class="card-header bg-light d-flex justify-content-between align-items-center">';
        html += '<h6 class="mb-0 text-success">';
        html += '<i class="fas fa-file-alt"></i> Record #<span class="record-number">' + recordCounter + '</span>';
        html += '</h6>';

        if (recordCounter > 1) {
            html += '<button type="button" class="btn btn-sm btn-outline-danger remove-record-btn" data-record-index="' + recordIndex + '">';
            html += '<i class="fas fa-times"></i> Hapus Record';
            html += '</button>';
        }

        html += '</div>';
        html += '<div class="card-body">';
        html += '<div class="row mb-3">';
        html += '<div class="col-md-12">';
        html += '<label class="form-label">Rekomendasi <span class="text-danger">*</span></label>';
        html += '<textarea class="form-control" name="records[' + recordIndex + '][rekomendasi]" rows="3" placeholder="Masukkan rekomendasi..." required></textarea>';
        html += '</div>';
        html += '</div>';
        html += '<div class="row mb-3">';
        html += '<div class="col-md-6">';
        html += '<label class="form-label">Keterangan</label>';
        html += '<textarea class="form-control" name="records[' + recordIndex + '][keterangan]" rows="2" placeholder="Keterangan rekomendasi..."></textarea>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<label class="form-label">Pengembalian Keuangan</label>';
        html += '<input type="text" class="form-control tanparupiah" name="records[' + recordIndex + '][pengembalian]" placeholder="Rp. 0">';
        html += '</div>';
        html += '</div>';

        // Sub Records Container
        html += '<div class="sub-records-container" data-parent-record="' + recordIndex + '">';
        html += '<h6 class="text-muted mb-2">';
        html += '<i class="fas fa-indent"></i> Sub-Rekomendasi';
        html += '<button type="button" class="btn btn-sm btn-outline-info add-sub-record-btn ms-2" data-parent="' + recordIndex + '">';
        html += '<i class="fas fa-plus"></i> Tambah Sub';
        html += '</button>';
        html += '</h6>';
        html += '<div class="sub-records-list"></div>';
        html += '</div>';

        html += '</div>'; // card-body
        html += '</div>'; // card
        html += '</div>'; // record-group

        $('#recordsContainer').append(html);
        recordCounter++;

        // Renumber records
        renumberRecords();
    }

    // Remove Record
    $(document).on('click', '.remove-record-btn', function() {
        var recordIndex = $(this).data('record-index');
        if (confirm('Hapus record ini beserta semua sub-rekomendasinya?')) {
            $('.record-group[data-record-index="' + recordIndex + '"]').remove();
            delete subRecordCounters[recordIndex];
            renumberRecords();
        }
    });

    // Add Sub Record
    $(document).on('click', '.add-sub-record-btn', function() {
        var parentIndex = $(this).data('parent');
        var subIndex = ++subRecordCounters[parentIndex];

        var html = '';
        html += '<div class="sub-record-item mb-2 p-3 border rounded" data-sub-index="' + subIndex + '">';
        html += '<div class="d-flex justify-content-between align-items-center mb-2">';
        html += '<h6 class="mb-0 text-info">';
        html += '<i class="fas fa-arrow-right"></i> Sub-Rekomendasi ' + subIndex;
        html += '</h6>';
        html += '<button type="button" class="btn btn-sm btn-outline-danger remove-sub-btn">';
        html += '<i class="fas fa-times"></i>';
        html += '</button>';
        html += '</div>';

        html += '<div class="row mb-2">';
        html += '<div class="col-md-12">';
        html += '<label class="form-label">Sub-Rekomendasi <span class="text-danger">*</span></label>';
        html += '<textarea class="form-control form-control-sm" name="records[' + parentIndex + '][sub][' + subIndex + '][rekomendasi]" rows="2" placeholder="Masukkan sub-rekomendasi..." required></textarea>';
        html += '</div>';
        html += '</div>';

        html += '<div class="row">';
        html += '<div class="col-md-6">';
        html += '<label class="form-label">Keterangan</label>';
        html += '<textarea class="form-control form-control-sm" name="records[' + parentIndex + '][sub][' + subIndex + '][keterangan]" rows="1" placeholder="Keterangan..."></textarea>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<label class="form-label">Pengembalian</label>';
        html += '<input type="text" class="form-control form-control-sm tanparupiah" name="records[' + parentIndex + '][sub][' + subIndex + '][pengembalian]" placeholder="Rp. 0">';
        html += '</div>';
        html += '</div>';

        // Nested sub-sub option
        html += '<div class="mt-2">';
        html += '<button type="button" class="btn btn-sm btn-outline-secondary add-subsub-btn" data-parent="' + parentIndex + '" data-sub="' + subIndex + '">';
        html += '<i class="fas fa-plus"></i> Tambah Sub-Sub';
        html += '</button>';
        html += '<div class="subsub-container mt-2"></div>';
        html += '</div>';

        html += '</div>';

        $('.sub-records-container[data-parent-record="' + parentIndex + '"] .sub-records-list').append(html);
    });

    // Remove Sub Record
    $(document).on('click', '.remove-sub-btn', function() {
        if (confirm('Hapus sub-rekomendasi ini?')) {
            $(this).closest('.sub-record-item').remove();
        }
    });

    // Add Sub-Sub Record
    $(document).on('click', '.add-subsub-btn', function() {
        var parentIndex = $(this).data('parent');
        var subIndex = $(this).data('sub');
        var subsubContainer = $(this).siblings('.subsub-container');
        var subsubCount = subsubContainer.find('.subsub-item').length + 1;

        var html = '';
        html += '<div class="subsub-item mt-2 p-2 bg-light border rounded" data-subsub-index="' + subsubCount + '">';
        html += '<div class="d-flex justify-content-between align-items-center mb-2">';
        html += '<small class="text-muted fw-bold">';
        html += '<i class="fas fa-arrow-right"></i><i class="fas fa-arrow-right"></i> Sub-Sub ' + subsubCount;
        html += '</small>';
        html += '<button type="button" class="btn btn-sm btn-outline-danger remove-subsub-btn">';
        html += '<i class="fas fa-times"></i>';
        html += '</button>';
        html += '</div>';

        html += '<div class="row">';
        html += '<div class="col-md-12 mb-2">';
        html += '<textarea class="form-control form-control-sm" name="records[' + parentIndex + '][sub][' + subIndex + '][subsub][' + subsubCount + '][rekomendasi]" rows="1" placeholder="Sub-sub rekomendasi..." required></textarea>';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<input type="text" class="form-control form-control-sm" name="records[' + parentIndex + '][sub][' + subIndex + '][subsub][' + subsubCount + '][keterangan]" placeholder="Keterangan...">';
        html += '</div>';
        html += '<div class="col-md-6">';
        html += '<input type="text" class="form-control form-control-sm tanparupiah" name="records[' + parentIndex + '][sub][' + subIndex + '][subsub][' + subsubCount + '][pengembalian]" placeholder="Rp. 0">';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        subsubContainer.append(html);
    });

    // Remove Sub-Sub Record
    $(document).on('click', '.remove-subsub-btn', function() {
        if (confirm('Hapus sub-sub rekomendasi ini?')) {
            $(this).closest('.subsub-item').remove();
        }
    });

    // Renumber Records Function
    function renumberRecords() {
        $('#recordsContainer .record-group').each(function(index) {
            $(this).find('.record-number').text(index + 1);
        });
    }
});
</script>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Rekomendasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="edit-id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Kode Temuan:</strong></label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                <span id="edit-kode-temuan"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Nama Temuan:</strong></label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                <span id="edit-nama-temuan"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit-kode-rekomendasi" class="form-label">Kode Rekomendasi</label>
                        <input type="text" class="form-control" id="edit-kode-rekomendasi" placeholder="Contoh: REC-001">
                    </div>

                    <div class="mb-3">
                        <label for="edit-rekomendasi" class="form-label">Rekomendasi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit-rekomendasi" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="edit-keterangan" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="edit-pengembalian" class="form-label">Pengembalian Keuangan</label>
                        <input type="text" class="form-control tanparupiah" id="edit-pengembalian" placeholder="Rp. 0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add New Record Modal -->
<div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addRecordModalLabel">
                    <i class="fas fa-plus-circle"></i> Tambah Record Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addRecordForm" action="{{ url('adminTL/temuan/') }}" method="post">
                @csrf
                <input type="hidden" name="add_new_records" value="1">
                <div class="modal-body">
                    <input type="hidden" id="add-temuan-kode" name="kode_temuan">
                    <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
                    <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">

                    <!-- Info Temuan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label"><strong>Kode Temuan:</strong></label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                <span class="badge bg-primary" id="add-display-kode"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><strong>Nama Temuan:</strong></label>
                            <div class="form-control-plaintext bg-light p-2 rounded">
                                <span id="add-display-nama" class="fw-bold text-primary"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Records Container -->
                    <div id="recordsContainer">
                        <div class="record-group" data-record-index="0">
                            <div class="card mb-3 border-success">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-success">
                                        <i class="fas fa-file-alt"></i> Record #<span class="record-number">1</span>
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-record-btn" style="display: none;">
                                        <i class="fas fa-times"></i> Hapus Record
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label class="form-label">Rekomendasi <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="records[0][rekomendasi]" rows="3" placeholder="Masukkan rekomendasi..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Keterangan</label>
                                            <textarea class="form-control" name="records[0][keterangan]" rows="2" placeholder="Keterangan rekomendasi..."></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Pengembalian Keuangan</label>
                                            <input type="text" class="form-control tanparupiah" name="records[0][pengembalian]" placeholder="Rp. 0">
                                        </div>
                                    </div>

                                    <!-- Sub Records Container -->
                                    <div class="sub-records-container" data-parent-record="0">
                                        <h6 class="text-muted mb-2">
                                            <i class="fas fa-indent"></i> Sub-Rekomendasi
                                            <button type="button" class="btn btn-sm btn-outline-info add-sub-record-btn ms-2" data-parent="0">
                                                <i class="fas fa-plus"></i> Tambah Sub
                                            </button>
                                        </h6>
                                        <div class="sub-records-list"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add More Records Button -->
                    <div class="text-center mb-3">
                        <button type="button" class="btn btn-outline-success" id="addMoreRecordBtn">
                            <i class="fas fa-plus-circle"></i> Tambah Record Lagi
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Semua Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
