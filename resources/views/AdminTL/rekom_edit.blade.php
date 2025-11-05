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
        margin-left: 20px;
    }
    table #baris .kolom{
        margin-left: 20px;
    }
    table #baris2 .kolom2{
        margin-left: 40px;
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

    /* Styling untuk rekomendasi section */
    .rekomendasi-section {
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .border-success {
        border-color: #198754 !important;
    }

    #add_btn {
        transition: all 0.3s ease;
        border-radius: 25px;
        padding: 12px 30px;
        font-weight: 600;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #add_btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .remove-rekom-btn {
        transition: all 0.2s ease;
    }

    .remove-rekom-btn:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }

    /* Enhanced table styling */
    .table-bordered {
        border: 2px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-light {
        background-color: #f8f9fa;
    }

    /* Button styling improvements */
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }

    .btn-success {
        background-color: #198754;
        border-color: #198754;
    }

    .btn-success:hover {
        background-color: #146c43;
        border-color: #13653f;
    }

    .btn-info {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
    }

    .btn-info:hover {
        background-color: #31d2f2;
        border-color: #25cff2;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
        border-color: #b02a37;
    }

    /* Form control improvements */
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Card improvements */
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-header {
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        font-weight: 600;
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
<div class="card-header"> Jenis Rekomendasi</div>
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
        @if(isset($data) && count($data) > 0)
        <div class="card mb-4" style="display: none;">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-list"></i> Data Rekomendasi yang Sudah Ada</h5>
            </div>
            <div class="card-body">
                @foreach($data as $parentIndex => $parent)
                <div class="mb-4 border rounded p-3">
                    <div class="row mb-3 bg-light p-2 rounded">
                        <div class="col-md-9">
                            <strong>Rekomendasi Utama #{{ $parentIndex + 1 }}:</strong><br>
                            <span class="text-primary fw-bold">{{ $parent->rekomendasi ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 text-end">
                            <strong>Aksi Rekomendasi:</strong><br>
                            <button type="button" class="btn btn-success btn-sm add-new-record-btn"
                                    data-parent-id="{{ $parent->id }}"
                                    data-main-number="{{ $parentIndex + 1 }}"
                                    title="Tambah Record Baru ke Rekomendasi Ini">
                                <i class="fas fa-plus"></i> Add New Record
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-rekom-btn ms-1"
                                    data-id="{{ $parent->id }}"
                                    data-rekomendasi="{{ htmlspecialchars($parent->rekomendasi ?? '') }}"
                                    title="Hapus Seluruh Rekomendasi">
                                <i class="fas fa-trash"></i> Hapus Rekomendasi
                            </button>
                        </div>
                    </div>

                    {{-- Display recommendations hierarchically --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="table-dark">
                                <tr>
                                    <th width="8%">No</th>
                                    <th width="40%">Rekomendasi</th>
                                    <th width="27%">Keterangan</th>
                                    <th width="15%">Pengembalian</th>
                                    <th width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Display main parent recommendation --}}
                                @php
                                    $mainNumber = $parentIndex + 1;
                                @endphp
                                <tr>
                                    <td><strong>{{ $mainNumber }}</strong></td>
                                    <td><strong>{{ $parent->rekomendasi ?? '-' }}</strong></td>
                                    <td>{{ $parent->keterangan ?? '-' }}</td>
                                    <td>
                                        @if($parent->pengembalian && $parent->pengembalian > 0)
                                            <span class="text-success fw-bold">Rp {{ number_format($parent->pengembalian, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm edit-rekom-btn"
                                                data-id="{{ $parent->id }}"
                                                data-rekomendasi="{{ htmlspecialchars($parent->rekomendasi ?? '') }}"
                                                data-keterangan="{{ htmlspecialchars($parent->keterangan ?? '') }}"
                                                data-pengembalian="{{ $parent->pengembalian ?? 0 }}"
                                                title="Edit Rekomendasi">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm delete-rekom-btn"
                                                data-id="{{ $parent->id }}"
                                                data-rekomendasi="{{ htmlspecialchars($parent->rekomendasi ?? '') }}"
                                                title="Hapus Rekomendasi">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                {{-- Display sub-recommendations (level 1) --}}
                                {{-- Debug info --}}
                                @if(isset($parent->sub))
                                    <!-- DEBUG: Sub exists, type: {{ gettype($parent->sub) }}, count: {{ is_countable($parent->sub) ? count($parent->sub) : 'not countable' }} -->
                                @endif

                                @if(isset($parent->sub) && (is_array($parent->sub) || is_object($parent->sub)) && count($parent->sub) > 0)
                                    @foreach($parent->sub as $subIndex => $subRekom)
                                        @php
                                            $subNumber = $mainNumber . '.' . ($subIndex + 1);
                                        @endphp
                                        <tr class="sub-level-1">
                                            <td>{{ $subNumber }}</td>
                                            <td><span style="margin-left: 20px; font-style: italic;">{{ $subRekom->rekomendasi ?? '-' }}</span></td>
                                            <td>{{ $subRekom->keterangan ?? '-' }}</td>
                                            <td>
                                                @if($subRekom->pengembalian && $subRekom->pengembalian > 0)
                                                    <span class="text-success fw-bold">Rp {{ number_format($subRekom->pengembalian, 0, ',', '.') }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-sm edit-rekom-btn"
                                                        data-id="{{ $subRekom->id }}"
                                                        data-rekomendasi="{{ htmlspecialchars($subRekom->rekomendasi ?? '') }}"
                                                        data-keterangan="{{ htmlspecialchars($subRekom->keterangan ?? '') }}"
                                                        data-pengembalian="{{ $subRekom->pengembalian ?? 0 }}"
                                                        title="Edit Rekomendasi">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-rekom-btn"
                                                        data-id="{{ $subRekom->id }}"
                                                        data-rekomendasi="{{ htmlspecialchars($subRekom->rekomendasi ?? '') }}"
                                                        title="Hapus Rekomendasi">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        {{-- Display sub-sub-recommendations (level 2) --}}
                                        @if(isset($subRekom->sub))
                                            <!-- DEBUG SUB-SUB: type: {{ gettype($subRekom->sub) }}, count: {{ is_countable($subRekom->sub) ? count($subRekom->sub) : 'not countable' }} -->
                                        @endif

                                        @if(isset($subRekom->sub) && (is_array($subRekom->sub) || is_object($subRekom->sub)) && count($subRekom->sub) > 0)
                                            @foreach($subRekom->sub as $subSubIndex => $subSubRekom)
                                                @php
                                                    $subSubNumber = $subNumber . '.' . ($subSubIndex + 1);
                                                @endphp
                                                <tr class="sub-level-2">
                                                    <td>{{ $subSubNumber }}</td>
                                                    <td><span style="margin-left: 40px; font-style: italic; font-size: 0.9em;">{{ $subSubRekom->rekomendasi ?? '-' }}</span></td>
                                                    <td>{{ $subSubRekom->keterangan ?? '-' }}</td>
                                                    <td>
                                                        @if($subSubRekom->pengembalian && $subSubRekom->pengembalian > 0)
                                                            <span class="text-success fw-bold">Rp {{ number_format($subSubRekom->pengembalian, 0, ',', '.') }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm edit-rekom-btn"
                                                                data-id="{{ $subSubRekom->id }}"
                                                                data-rekomendasi="{{ htmlspecialchars($subSubRekom->rekomendasi ?? '') }}"
                                                                data-keterangan="{{ htmlspecialchars($subSubRekom->keterangan ?? '') }}"
                                                                data-pengembalian="{{ $subSubRekom->pengembalian ?? 0 }}"
                                                                title="Edit Rekomendasi">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm delete-rekom-btn"
                                                                data-id="{{ $subSubRekom->id }}"
                                                                data-rekomendasi="{{ htmlspecialchars($subSubRekom->rekomendasi ?? '') }}"
                                                                title="Hapus Rekomendasi">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Include Rekomendasi Hierarchy Component --}}
        @include('AdminTL.datadukungkom_tambahrekomendasi_componponen', ['existingData' => isset($data) ? $data : [], 'pengawasan' => $pengawasan])

        {{-- Form for adding new data --}}
        {{-- <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-plus"></i> Tambah Rekomendasi Baru (Mode Lama)</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i>
                    <strong>Petunjuk:</strong> Silakan isi kolom rekomendasi yang tersedia kosong di bawah ini.
                    Anda dapat menambah rekomendasi baru dengan menekan tombol <strong>"Tambah Rekomendasi Lain"</strong>
                    dan menambah sub-rekomendasi dengan tombol <strong>"Sub"</strong>.
                </div>
        <form action="{{ url('adminTL/rekom/') }}" method="post" enctype="multipart/form-data" id="legacyRekomForm">
           @method('POST')
           @csrf
           <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
           <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">

           <div class="d-flex justify-content-between align-items-center mb-3">
               <h6 class="mb-0 text-muted">Form Input Rekomendasi</h6>
               <button type="button" class="btn btn-success btn-sm" id="add_btn">
                   <i class="fa-solid fa-plus"></i> Tambah Rekomendasi Lain
               </button>
           </div>

           <table class="table table-bordered">
            <thead class="table-light">
              <tr>
                <th scope="col" style="width: 8%">Nomor</th>
                <th scope="col" style="width: 35%">NAMA REKOMENDASI <span class="text-danger">*</span></th>
                <th scope="col" style="width: 25%">KETERANGAN REKOMENDASI</th>
                <th scope="col" style="width: 20%">PENGEMBALIAN KEUANGAN</th>
                <th style="width: 12%">Aksi</th>
              </tr>
            </thead>
            <tbody class="body">
                <tr class="sub0" data-level="0" data-rekom-index="0">
                    <td class="nomor-cell">1</td>
                    <td><textarea class="form-control" name="tipeA[0][rekomendasi]" rows="3" required placeholder="Masukkan rekomendasi..."></textarea></td>
                    <td><textarea class="form-control" name="tipeA[0][keterangan]" rows="2" placeholder="Keterangan rekomendasi..."></textarea></td>
                    <td><input type="text" class="form-control tanparupiah" name="tipeA[0][pengembalian]" placeholder="Rp. 0"></td>
                    <td>
                        <button type="button" data-level1="0" class="btn btn-success btn-sm add_rekom_btn" title="Tambah Rekomendasi"><i class="fa-solid fa-plus"></i></button>
                        <button type="button" data-level1="0" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button>
                    </td>
                </tr>
            </tbody>
          </table>

          <div class="mt-3">
              <button type="submit" class="btn btn-primary btn-lg">
                  <i class="fas fa-save"></i> Simpan Rekomendasi
              </button>
              <a href="{{ url('adminTL/rekom') }}" class="btn btn-secondary btn-lg ms-2">
                  <i class="fas fa-arrow-left"></i> Kembali
              </a>
          </div>
        </form>
            </div>
        </div> --}}
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>


<script>
// Global variables
let rekomCounter = {{ count($data) > 0 ? count($data) : 1 }};
let subCounter = {};

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
    var currentMainNumber = 0;
    var subCounters = {}; // Track sub-counters for each parent
    var subSubCounters = {}; // Track sub-sub-counters

    tbody.find('tr').each(function() {
        var row = $(this);
        var level = row.data('level') || 0;
        var numberCell = row.find('.nomor-cell, td:first');

        if (level === 0) {
            // Main recommendation: 1, 2, 3, etc.
            currentMainNumber = mainCounter;
            numberCell.text(mainCounter);
            mainCounter++;
            // Reset sub counters for this main item
            subCounters[currentMainNumber] = 0;
            subSubCounters[currentMainNumber] = {};
        } else if (level === 1) {
            // Sub-recommendation: 1.1, 1.2, 2.1, 2.2, etc.
            if (!subCounters[currentMainNumber]) subCounters[currentMainNumber] = 0;
            subCounters[currentMainNumber]++;
            var subNumber = subCounters[currentMainNumber];
            numberCell.text(currentMainNumber + '.' + subNumber);
            // Reset sub-sub counter for this sub item
            subSubCounters[currentMainNumber][subNumber] = 0;
        } else if (level === 2) {
            // Sub-sub-recommendation: 1.1.1, 1.1.2, 1.2.1, etc.
            var currentSubNumber = subCounters[currentMainNumber] || 1;
            if (!subSubCounters[currentMainNumber]) subSubCounters[currentMainNumber] = {};
            if (!subSubCounters[currentMainNumber][currentSubNumber]) subSubCounters[currentMainNumber][currentSubNumber] = 0;
            subSubCounters[currentMainNumber][currentSubNumber]++;
            var subSubNumber = subSubCounters[currentMainNumber][currentSubNumber];
            numberCell.text(currentMainNumber + '.' + currentSubNumber + '.' + subSubNumber);
        }
    });
}

$(document).ready(function () {
    let index = 1; // Start with 1 since we already have tipeA[0]
    let indexEdit = 0;
    let indexEdit1 = 0;



    // Format rupiah on input
    $(document).on('keyup', '.tanparupiah', function (e) {
        let rupiah = formatRupiah($(this).val());
        $(this).val(rupiah);
    });

    // Add sub-sub recommendation (level 2)
    $(document).on('click', '.add_subsub_btn, #add_btnEdit1', function () {
        indexEdit1++;
        var html = '';
        var level1 = $(this).data('level1');
        var level2 = $(this).data('level2');
        var parentId = $(this).data('parentid');

        html += '<tr class="sub-level-2" data-level="2" data-rekom-index="' + indexEdit1 + '" data-parent="' + level1 + '_' + level2 + '">';
        html += '<input type="hidden" name="tipeA[' + level1 + '][sub][' + level2 + '][sub][' + indexEdit1 + '][parentid]" value="' + parentId + '">';
        html += '<td class="nomor-cell"></td>';
        html += '<td><div class="rekomendasi-text"><textarea class="form-control kolom2" name="tipeA[' + level1 + '][sub][' + level2 + '][sub][' + indexEdit1 + '][rekomendasi]" required placeholder="Sub-sub rekomendasi..."></textarea></div></td>';
        html += '<td><textarea class="form-control kolom2" name="tipeA[' + level1 + '][sub][' + level2 + '][sub][' + indexEdit1 + '][keterangan]" placeholder="Keterangan..."></textarea></td>';
        html += '<td><input type="text" class="form-control kolom2 tanparupiah" name="tipeA[' + level1 + '][sub][' + level2 + '][sub][' + indexEdit1 + '][pengembalian]" placeholder="Rp. 0"></td>';
        html += '<td><button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button></td>';
        html += '</tr>';

        $(this).closest('tr').after(html);
        renumberTable($(this).closest('tbody'));
    });



    // Add sub recommendation (level 1)
    $(document).on('click', '.add_sub_btn, #add_btnEdit', function () {
        indexEdit++;
        var html = '';
        var level1 = $(this).data('level1');
        var parentId = $(this).data('parentid');

        html += '<tr class="sub-level-1" data-level="1" data-rekom-index="' + indexEdit + '" data-parent="' + level1 + '">';
        html += '<input type="hidden" name="tipeA[' + level1 + '][sub][' + indexEdit + '][parentid]" value="' + parentId + '">';
        html += '<td class="nomor-cell"></td>';
        html += '<td><div class="rekomendasi-text"><textarea class="form-control kolom1" name="tipeA[' + level1 + '][sub][' + indexEdit + '][rekomendasi]" required placeholder="Sub rekomendasi..."></textarea></div></td>';
        html += '<td><textarea class="form-control kolom1" name="tipeA[' + level1 + '][sub][' + indexEdit + '][keterangan]" placeholder="Keterangan..."></textarea></td>';
        html += '<td><input type="text" class="form-control kolom1 tanparupiah" name="tipeA[' + level1 + '][sub][' + indexEdit + '][pengembalian]" placeholder="Rp. 0"></td>';
        html += '<td>';
        html += '<button type="button" data-level1="' + level1 + '" data-level2="' + indexEdit + '" class="btn btn-info btn-sm add_subsub_btn" title="Tambah Sub-Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button> ';
        html += '<button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button>';
        html += '</td>';
        html += '</tr>';

        $(this).closest('tr').after(html);
        renumberTable($(this).closest('tbody'));
    });

    // Legacy support for add_btn1 (sub recommendation) - updated for simpler form
    $(document).on('click', '#add_btn1', function () {
        // This is now handled by the generic add_sub_btn handler
        $(this).trigger('click');
    });
    // Add new recommendation row
    $(document).on('click', '.add_rekom_btn', function () {
        var tbody = $(this).closest('tbody');
        var rowNumber = tbody.find('tr[data-level="0"]').length + 1;

        var html = '';
        html += '<tr class="sub' + index + '" data-level="0" data-rekom-index="' + index + '">';
        html += '<td class="nomor-cell">' + rowNumber + '</td>';
        html += '<td><textarea class="form-control" name="tipeA[' + index + '][rekomendasi]" rows="3" required placeholder="Masukkan rekomendasi..."></textarea></td>';
        html += '<td><textarea class="form-control" name="tipeA[' + index + '][keterangan]" rows="2" placeholder="Keterangan rekomendasi..."></textarea></td>';
        html += '<td><input type="text" class="form-control tanparupiah" name="tipeA[' + index + '][pengembalian]" placeholder="Rp. 0"></td>';
        html += '<td>';
        html += '<button type="button" data-level1="' + index + '" class="btn btn-success btn-sm add_rekom_btn" title="Tambah Rekomendasi"><i class="fa-solid fa-plus"></i></button> ';
        html += '<button type="button" data-level1="' + index + '" class="btn btn-info btn-sm add_sub_btn" title="Tambah Sub Rekomendasi"><i class="fa-solid fa-indent"></i></button> ';
        html += '<button type="button" class="btn btn-danger btn-sm remove_rekom_btn" title="Hapus"><i class="fa-solid fa-minus"></i></button>';
        html += '</td>';
        html += '</tr>';

        tbody.append(html);
        index++;
        renumberTable(tbody);
    });

    // Legacy support for main add button - find the first add_rekom_btn in the form
    $('#add_btn').on('click', function () {
        $('.add_rekom_btn').first().click();
    });




    // Remove recommendation row
    $(document).on('click', '.remove_rekom_btn', function () {
        var tbody = $(this).closest('tbody');
        var rowToRemove = $(this).closest('tr');
        var parentLevel = rowToRemove.data('level') || 0;

        // Check if this is the only main recommendation
        var mainRows = tbody.find('tr[data-level="0"]');
        if (mainRows.length <= 1 && parentLevel === 0) {
            alert('Minimal harus ada satu rekomendasi utama!');
            return;
        }

        // Confirm deletion
        if (confirm('Apakah Anda yakin ingin menghapus rekomendasi ini beserta sub-rekomendasinya?')) {
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
        }
    });

    // Legacy support for add_btn2 (sub-sub recommendation) - handled by add_subsub_btn
    $(document).on('click', '#add_btn2', function () {
        // This is now handled by the generic add_subsub_btn handler
    });

    // Form validation and data cleaning before submit - ONLY for legacy form (NOT hierarchy component)
    $('#legacyRekomForm').on('submit', function(e) {
        var hasError = false;
        var errorMessages = [];

        // Clean rupiah formatting from all pengembalian fields before submit
        $(this).find('input[name*="[pengembalian]"]').each(function() {
            var cleanValue = $(this).val().replace(/[^0-9]/g, '');
            $(this).val(cleanValue);
        });

        // Check if at least one recommendation exists
        var rekomExists = false;
        $(this).find('textarea[name*="[rekomendasi]"]').each(function() {
            if ($(this).val().trim() !== '') {
                rekomExists = true;
                return false; // Break loop
            }
        });

        if (!rekomExists) {
            hasError = true;
            errorMessages.push('Minimal harus ada satu rekomendasi yang diisi!');
        }

        if (hasError) {
            e.preventDefault();
            alert(errorMessages.join('\n'));
            return false;
        }
    });

    // Initialize numbering on page load
    renumberTable($('tbody.body'));

    // Edit recommendation functionality
    $(document).on('click', '.edit-rekom-btn', function() {
        var id = $(this).data('id');
        var rekomendasi = $(this).data('rekomendasi');
        var keterangan = $(this).data('keterangan');
        var pengembalian = $(this).data('pengembalian');

        // Populate modal with data
        $('#edit-id').val(id);
        $('#edit-rekomendasi').val(rekomendasi);
        $('#edit-keterangan').val(keterangan);
        $('#edit-pengembalian').val(pengembalian > 0 ? formatRupiah(pengembalian.toString()) : '');

        // Show modal
        $('#editModal').modal('show');
    });

    // Delete recommendation functionality
    $(document).on('click', '.delete-rekom-btn', function() {
        var id = $(this).data('id');
        var rekomendasi = $(this).data('rekomendasi');

        console.log('Delete button clicked for ID:', id);

        // Create detailed confirmation message
        var confirmMessage = 'Apakah Anda yakin ingin menghapus rekomendasi ini?\n\n';
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

    // Add New Record Modal Handler for sub recommendations
    $(document).on('click', '.add-new-record-btn', function() {
        var parentId = $(this).data('parent-id');
        var mainNumber = $(this).data('main-number');

        console.log('=== SUB MODAL OPENING DEBUG ===');
        console.log('Parent ID:', parentId);
        console.log('Main Number:', mainNumber);

        // Set modal data
        $('#add-parent-id').val(parentId);
        $('#add-display-number').text(mainNumber);

        // Reset form
        $('#addSubRecordForm')[0].reset();
        $('#add-parent-id').val(parentId);

        console.log('Modal setup complete, parent_id set to:', $('#add-parent-id').val());
        console.log('=== END SUB MODAL OPENING DEBUG ===');

        // Show modal
        $('#addSubRecordModal').modal('show');
    });

    // Submit add sub record form
    $('#addSubRecordForm').on('submit', function(e) {
        e.preventDefault();

        var formData = {
            parent_id: $('#add-parent-id').val(),
            rekomendasi: $('#add-sub-rekomendasi').val(),
            keterangan: $('#add-sub-keterangan').val(),
            pengembalian: $('#add-sub-pengembalian').val().replace(/[^0-9]/g, ''), // Remove formatting
            id_pengawasan: '{{ $pengawasan["id"] }}',
            id_penugasan: '{{ $pengawasan["id_penugasan"] }}',
            _token: $('meta[name="csrf-token"]').attr('content')
        };

        console.log('=== SUBMITTING SUB RECORD ===');
        console.log('Form Data:', formData);

        $.ajax({
            url: '/adminTL/rekomendasi/add-sub',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('Add sub response:', response);
                if (response.success) {
                    alert(response.message || 'Sub rekomendasi berhasil ditambahkan!');
                    $('#addSubRecordModal').modal('hide');
                    location.reload();
                } else {
                    alert(response.message || 'Terjadi kesalahan saat menambahkan sub rekomendasi!');
                }
            },
            error: function(xhr) {
                console.error('Add sub error:', xhr);

                var errorMessage = 'Terjadi kesalahan saat menambahkan sub rekomendasi!';

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

<!-- Add Sub Record Modal -->
<div class="modal fade" id="addSubRecordModal" tabindex="-1" aria-labelledby="addSubRecordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addSubRecordModalLabel">
                    <i class="fas fa-plus-circle"></i> Tambah Sub Rekomendasi untuk #<span id="add-display-number"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addSubRecordForm">
                <div class="modal-body">
                    <input type="hidden" id="add-parent-id" name="parent_id">

                    <div class="mb-3">
                        <label for="add-sub-rekomendasi" class="form-label">Sub Rekomendasi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="add-sub-rekomendasi" name="rekomendasi" rows="3" placeholder="Masukkan sub rekomendasi..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="add-sub-keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="add-sub-keterangan" name="keterangan" rows="2" placeholder="Keterangan sub rekomendasi..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="add-sub-pengembalian" class="form-label">Pengembalian Keuangan</label>
                        <input type="text" class="form-control tanparupiah" id="add-sub-pengembalian" name="pengembalian" placeholder="Rp. 0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan Sub Rekomendasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
