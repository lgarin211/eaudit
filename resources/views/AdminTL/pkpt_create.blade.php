@extends('template')
@section('content')

<div class="card mb-4" style="width: 100%;">
    <div class="card-header">Data Penugasan</div>
    <div class="card-body">
        <form action="{{ url('/jabatan_baru'.$penugasan['id']) }}" method="post" enctype="multipart/form-data">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="">Nomor Surat </label>
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ "700.1.1/".$penugasan['noSurat']."/03/2023" }}</textarea>
                </div>
                <div class="col-8 mb-3">
                    <label for="">Jenis Pengawasan </label>
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $penugasan['nama_jenispengawasan'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-8 mb-3">
                    <label for="">Obrik Pengawasan </label>
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $penugasan['nama_obrik'] }}</textarea>
                </div>
                <div class="col-4 mb-3">
                    <label for="">Tanggal Awal </label>
                    <textarea name="nama" style="color: black; background-color:white" class="form-control" readonly>{{ $penugasan['tanggalAwalPenugasan'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="">Tanggal Akhir </label>
                    <input type="text" name="nama" readonly style="color: black; background-color:white" class="form-control" value="{{ $penugasan['tanggalAkhirPenugasan'] }}" >
                </div>
                <div class="col-6 mb-3">
                    <label for="">Status LHP </label>
                    <input type="text" name="nama" readonly  style="color: black; background-color:white" class="form-control" value="Belum Jadi">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4" style="width: 100%;">
    <div class="card-header"></div>
    <div class="card-body">
        <form action="{{ url('adminTL/pkpt_baru/'.$penugasan['id']) }}" method="post" enctype="multipart/form-data">
            @method('post')
            @csrf
            <input type="hidden" name="id_penugasan" value="{{ $penugasan['id'] }}">
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="">Tanggal Surat Keluar </label>
                    <input type="date" name="tglkeluar" style="color: black; background-color:white" class="form-control" >
                </div>
                 <div class="col-4 mb-3">
                    <label for="">Tipe Rekomendasi </label>
                    <select name="tipe" id="" class="form-control" style="color: black; background-color:white">
                        <option value="Rekomendasi">Rekomendasi</option>
                        <option value="TemuandanRekomendasi">Temuan dan Rekomendasi</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label for="">Jenis Pemeriksaan </label>
                     <select name="jenis" id="" class="form-control" style="color: black; background-color:white">
                        <option value="pdtt">PDTT</option>
                        <option value="nspk">NSPK</option>
                     </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="">Wilayah </label>
                     <select name="wilayah" id="" class="form-control" style="color: black; background-color:white">
                        <option value="wilayah1">Wilayah 1</option>
                        <option value="wilayah2">Wilayah 2</option>
                     </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="">Pemeriksa </label>
                     <select name="pemeriksa" id="" class="form-control" style="color: black; background-color:white">
                        <option value="auditor">Auditor</option>
                        <option value="ppupd">PPUPD</option>
                     </select>
                </div>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <button class="btn btn-success">Batal</button>

    </div>
</div>

@endsection
