@extends('template')
@section('content')

<style>
    #mytable {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #mytable td,
    #mytable th {
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

    #mytable1 td,
    #mytable th {
        border: 2px solid #000;
        padding: 8px;
    }



    #mytable1 th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #32CD32;
        color: white;
    }

    table #baris1 .kolom1 {
        margin-left: 10px;
    }

    table #baris .kolom {
        margin-left: 20px;
    }

    table #baris2 .kolom2 {
        margin-left: 30px;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ "700.1.1" }}</textarea>
                </div>
                <div class="col-3 mb-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ $pengawasan['noSurat'] }}</textarea>
                </div>
                <div class="col-3 mb-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{"03/2025" }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-2">
                    Jenis Pengawasan
                </div>
                <div class="col-9">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ $pengawasan['nama_jenispengawasan'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-3">
                    Obrik Pengawasan
                </div>
                <div class="col-9 mt-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ $pengawasan['nama_obrik'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-3">
                    Tanggal Pelaksanaan
                </div>
                <div class="col-3 mt-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ $pengawasan['tanggalAwalPenugasan'] }}</textarea>
                </div>
                <div class="col-3 mt-3">
                    s/d
                </div>
                <div class="col-3 mt-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ $pengawasan['tanggalAkhirPenugasan'] }}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-3 mt-3">
                    <label for="">Status LHP </label>
                </div>
                <div class="col-9 mt-3">
                    <textarea name="nama" style="color: black; background-color:white" class="form-control"
                        readonly>{{ 'Belum Jadi' }}</textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4" style="width: 100%;">
    <div class="card-header">Data Pengawasan</div>
    <div class="card-body">
        {{-- <form action="{{ url('/jabatan_baru'.$penugasan['id']) }}" method="post" enctype="multipart/form-data">
            --}}
            @method('post')
            @csrf
            <div class="row">
                <div class="col-4 mb-3">
                    <label for="">Tanggal Surat Keluar </label>
                    <input type="date" name="tglkeluar" style="color: black; background-color:white"
                        class="form-control" value="{{ $pengawasan['tglkeluar'] }}">
                </div>
                <div class="col-4 mb-3">
                    <label for="">Tipe Rekomendasi </label>
                    <select name="tipe" id="" class="form-control" style="color: black; background-color:white">
                        <option value="Rekomendasi" @if ($pengawasan['tipe']=='Rekomendasi' )selected='selected' @endif>
                            Rekomendasi</option>
                        <option value="TemuandanRekomendasi" @if ($pengawasan['tipe']=='TemuandanRekomendasi'
                            )selected='selected' @endif>Temuan dan Rekomendasi</option>
                    </select>
                </div>
                <div class="col-4 mb-3">
                    <label for="">Jenis Pemeriksaan </label>
                    <select name="jenis" id="" class="form-control" style="color: black; background-color:white">
                        <option value="pdtt" @if ($pengawasan['jenis']=='pdtt' )selected='selected' @endif>PDTT</option>
                        <option value="nspk" @if ($pengawasan['jenis']=='nspk' )selected='selected' @endif>NSPK</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                    <label for="">Wilayah </label>
                    <select name="wilayah" id="" class="form-control" style="color: black; background-color:white">
                        <option value="wilayah1" @if ($pengawasan['wilayah']=='wilayah1' )selected='selected' @endif>
                            Wilayah 1</option>
                        <option value="wilayah2" @if ($pengawasan['wilayah']=='wilayah2' )selected='selected' @endif>
                            Wilayah 2</option>
                    </select>
                </div>
                <div class="col-6 mb-3">
                    <label for="">Pemeriksa </label>
                    <select name="pemeriksa" id="" class="form-control" style="color: black; background-color:white">
                        <option value="auditor" @if ($pengawasan['pemeriksa']=='auditor' )selected='selected' @endif>
                            Auditor</option>
                        <option value="ppupd" @if ($pengawasan['pemeriksa']=='ppupd' )selected='selected' @endif>PPUPD
                        </option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4" style="width: 100%;">
    <div class="card-header"> Jenis Temuan dan Rekomendasi</div>
    <div class="d-flex justify-content-end" style="background-color:bisque"><button type="button"
            class="btn btn-primary btn-sm" id="add_card"><i class="fa-solid fa-plus"></i></button></div>
    <div class="card-body">
        <form action="{{ url('adminTL/temuan/') }}" method="post" enctype="multipart/form-data">
            @method('POST')
            @csrf
            <input type="hidden" name="id_pengawasan" value="{{ $pengawasan['id'] }}">
            <input type="hidden" name="id_penugasan" value="{{ $pengawasan['id_penugasan'] }}">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">KODE TEMUAN</th>
                        <th scope="col">NAMA TEMUAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="temuan[0][kode_temuan]" class="form-control"></td>
                        <td><input type="text" name="temuan[0][nama_temuan]" class="form-control"></td>
                    </tr>
                </tbody>
            </table>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nomor</th>
                        <th scope="col">KODE REKOMENDASI</th>
                        <th scope="col">NAMA REKOMENDASI</th>
                        <th scope="col">KETERANGAN REKOMENDASI</th>
                        <th scope="col">PENGEMBALIAN KEUANGAN</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="body" id="parenttemuan_0">
                    <tr class="sub0">
                        <td>1</td>
                        <td><textarea type="text" class="form-control"
                                name="temuan[0][rekomendasi][0][rekomendasi]"></textarea></td>
                        <td><textarea type="text" class="form-control"
                                name="temuan[0][rekomendasi][0][keterangan]"></textarea></td>
                        <td><textarea type="text" class="form-control"
                                name="temuan[0][rekomendasi][0][pengembalian]"></textarea></td>
                        <td><textarea type="text" class="form-control tanparupiah "
                                name="temuan[0][rekomendasi][0][pengembalian]"></textarea></td>
                        <td><button type="button" data-level1="0" data-indextemuan=0 class="btn btn-success"
                                id="add_btn1"><i class="fa-solid fa-plus"></i></button></td>
                        <td><button type="button" data-nomorterakhir=1 data-indextemuan=0 class="btn btn-primary"
                                id="add_btn"><i class="fa-solid fa-plus"></i></button></td>
                </tbody>
            </table>
    </div>
    <div id="temuanBaru" class="mt-2"></div>
    <button class="btn btn-primary">Simpan</button>
    <button class="btn btn-success">Batal</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>

<script>

    let tanparupiah = document.querySelector('.tanparupiah');

    $(document).on('keyup', '.tanparupiah', function (e) {
        let rupiah = formatRupiah($(this).val());
        console.log(rupiah);
        $(this).val(rupiah);
    })
    $('#add_btn').on('click', function () {
        var html = '';
        html += '<tr>';
        html += '<td></td>';
        html += '<td><textarea class="form-control" name="tipeA[rekomendasi]"></textarea></td>';
        html += '<td><textarea class="form-control" name="tipeA[rekomendasi]"></textarea></td>';
        html += '<td><textarea class="form-control" name="tipeA[keterangan]"></textarea></td>';
        html += '<td><input type="text" class="form-control tanparupiah" name="tipeA[pengembalian]"></td>';
        html += '<td><button  type="button" class="btn btn-success" id="add_btn1"><i class="fa-solid fa-plus"></i></button></td>';
        html += '<td><button type="button" class="btn btn-danger" id="remove"><i class="fa-solid fa-minus"></i></button></td>';
        html += '</tr>';
        $('tbody.body').append(html);
        // $(this).closest('tr').after(html);
    })


    // $(document).on('click','#add_btnEdit1',function () {
    //             indexEdit1++;
    //             var html='';
    //             var level1=$(this).data('level1');
    //             var level2=$(this).data('level2');
    //             var parentId = $(this).data('parentid');
    //             html+='<tr id="baris2">';
    //             html+='<input type="hidden" name="tipeA['+level1+'][sub]['+level2+'][sub]['+indexEdit1+'][parentid]" value="'+parentId+'">';
    //             html+='<td></td>';
    //             html+='<td><input type="text" class="form-control kolom2"  name="tipeA['+level1+'][sub]['+level2+'][sub]['+indexEdit1+'][rekomendasi]"></td>';
    //             html+='<td><input type="text" class="form-control kolom2" name="tipeA['+level1+'][sub]['+level2+'][sub]['+indexEdit1+'][keterangan]"></td>';
    //             html+='<td><input type="text" class="form-control kolom2 tanparupiah"  name="tipeA['+level1+'][sub]['+level2+'][sub]['+indexEdit1+'][pengembalian]"></td>';
    //             html+='<td><button type="button" class="btn btn-danger" id="remove"><i class="fa-solid fa-minus"></i></button></td>';
    //         //sesuaikan idnya button
    //             html+='</tr>';
    //             $(this).closest('tr').after(html);

    //         })



    //         $(document).on('click','#add_btnEdit',function () {
    //             alert('tes');
    //             var html='';
    //             indexEdit++;
    //             var level1=$(this).data('level1');
    //             var parentId = $(this).data('parentid');
    //             html+='<tr id="baris1">';
    //             html+='<td></td>';
    //             html+='<input type="hidden" name="tipeA['+level1+'][sub]['+indexEdit+'][parentid]" value="'+parentId+'">';
    //             html+='<td><input type="text" class="form-control kolom1" name="tipeA['+level1+'][sub]['+indexEdit+'][rekomendasi]"></td>';
    //             html+='<td><input type="text" class="form-control kolom1" name="tipeA['+level1+'][sub]['+indexEdit+'][keterangan]"></td>';
    //             html+='<td><input type="text" class="form-control kolom1 tanparupiah" name="tipeA['+level1+'][sub]['+indexEdit+'][pengembalian]"></td>';
    //             html+='<td><button type="button" class="btn btn-danger" id="remove"><i class="fa-solid fa-minus"></i></button></td>';
    //             //sesuaikan idnya button
    //             html+='<td><button data-level2="'+index1+'" data-level1="'+level1+'" type="button" class="btn btn-success" id="add_btn2"><i class="fa-solid fa-plus"></i></button></td>';
    //             html+='</tr>';
    //             $(this).closest('tr').after(html);
    //         })

    // $('#add_btn').on('click',function () {
    //     index++;
    //     var html='';
    //     html+='<tr class="sub'+index+'">';
    //     html+='<td>'+rowCount.toString()+'</td>';
    //     html+='<td><textarea class="form-control" name="tipeA['+index+'][rekomendasi]"></textarea></td>';
    //     html+='<td><textarea class="form-control" name="tipeA['+index+'][keterangan]"></textarea></td>';
    //     html+='<td><input type="text" class="form-control tanparupiah" name="tipeA['+index+'][pengembalian]"></td>';
    //     html+='<td><button data-level1="'+index+'"  type="button" class="btn btn-success" id="add_btn1"><i class="fa-solid fa-plus"></i></button></td>';
    //     html+='<td><button type="button" class="btn btn-danger" id="remove"><i class="fa-solid fa-minus"></i></button></td>';
    //     html+='</tr>';
    //     $('tbody.body').append(html);
    //     // $(this).closest('tr').after(html);
    //     rowCount++;
    // })

    // $(document).on('click','#add_btn1',function () {
    //     console.log('click');
    //     var html='';
    //     index1++;
    //     var level1=$(this).data('level1');
    //     html+='<tr id="baris1">';
    //     html+='<td></td>';
    //     html+='<td><textarea class="form-control kolom1" name="tipeA['+level1+'][sub]['+index1+'][rekomendasi]"></textarea></td>';
    //     html+='<td><textarea class="form-control kolom1" name="tipeA['+level1+'][sub]['+index1+'][keterangan]"></textarea></td>';
    //     html+='<td><input type="text" class="form-control kolom1 tanparupiah" name="tipeA['+level1+'][sub]['+index1+'][pengembalian]"></td>';
    //     html+='<td><button data-level2="'+index1+'" data-level1="'+level1+'" type="button" class="btn btn-success" id="add_btn2"><i class="fa-solid fa-plus"></i></button></td>';
    //     html+='<td><button type="button" class="btn btn-danger" id="remove"><i class="fa-solid fa-minus"></i></button></td>';
    //     html+='</tr>';
    //     $(this).closest('tr.sub'+level1).after(html);
    // })

    $('#add_card').on('click', function () {
        $("#temuanBaru").append("<div class='card-header' id='tambahtemuan'>Tambah Jenis Temuan <button type='button' id='hapus_card' class='btn btn-danger btn-sm' style='margin-left: 650px'><i class='fa-solid fa-trash' ></i></button>  </div> <div class='card-body'><table class='table'><thead><tr><th scope='col'>KODE TEMUAN</th><th scope='col'>NAMA TEMUAN</th></tr></thead> <tbody><tr><td><textarea name='temuan[kode_temuan]'  class='form-control'></textarea></td><td><textarea name='temuan[nama_temuan]'  class='form-control' ></textarea></td></tr></tbody></table> <table class='table'><thead><tr><th scope='col'>NOMOR</th><th scope='col'>NAMA REKOMENDASI</th><th scope='col'>KETERANGAN REKOMENDASI</th><th scope='col'>PENGEMBALIAN KEUANGAN</th><th>Aksi</th></tr></thead>  <tbody class='body'><tr><td>1</td><td><textarea name='temuan[rekomendasi][rekomendasi]' id='' class='form-control'></textarea></td><td><textarea name='temuan[rekomendasi][keterangan]' id='' class='form-control'></textarea></td><td><textarea name='temuan[rekomendasi][pengembalian]' id='' class='form-control tanparupiah'></textarea></td><td><button type='button'   class='btn btn-success' id='add_btn1'><i class='fa-solid fa-plus'></i></button><td><button type='button' class='btn btn-primary' id='add_btn'><i class='fa-solid fa-plus'></i></button></td></tr></tbody></table></div>");
    })


    // $('#add_card').on('click',function () {
    //     countertemuan++;
    //     indexrekomendasi++;
    //     $("#temuanBaru").append("<div class='card-header' id='tambahtemuan'>Tambah Jenis Temuan "+countertemuan+" <button type='button' id='hapus_card' class='btn btn-danger btn-sm' style='margin-left: 650px'><i class='fa-solid fa-trash' ></i></button>  </div> <div class='card-body'><table class='table'><thead><tr><th scope='col'>KODE TEMUAN</th><th scope='col'>NAMA TEMUAN</th></tr></thead> <tbody><tr><td><textarea name='temuan["+countertemuan+"][kode_temuan]'  class='form-control'></textarea></td><td><textarea name='temuan["+countertemuan+"][nama_temuan]'  class='form-control' ></textarea></td></tr></tbody></table> <table class='table'><thead><tr><th scope='col'>NOMOR</th><th scope='col'>NAMA REKOMENDASI</th><th scope='col'>KETERANGAN REKOMENDASI</th><th scope='col'>PENGEMBALIAN KEUANGAN</th><th>Aksi</th></tr></thead>  <tbody class='body'><tr><td>1</td><td><textarea name='temuan["+countertemuan+"][rekomendasi]["+indexrekomendasi+"][rekomendasi]' id='' class='form-control'></textarea></td><td><textarea name='temuan["+countertemuan+"][rekomendasi]["+indexrekomendasi+"][keterangan]' id='' class='form-control'></textarea></td><td><textarea name='temuan["+countertemuan+"][rekomendasi]["+indexrekomendasi+"][pengembalian]' id='' class='form-control tanparupiah'></textarea></td><td><button type='button' data-level1="+indexrekomendasi+" data-indextemuan="+countertemuan+" class='btn btn-success' id='add_btn1'><i class='fa-solid fa-plus'></i></button><td><button type='button' data-nomorterakhir="+indexrekomendasi+" data-indextemuan="+countertemuan+" class='btn btn-primary' id='add_btn'><i class='fa-solid fa-plus'></i></button></td></tr></tbody></table></div>");
    // })

    $(document).on('click', '#remove', function () {
        $(this).closest('tr').remove();
    })

    $(document).on('click', '#hapus_card', function () {
        $(this).closest('#tambahtemuan').remove();
    })

    // $(document).on('click','#hapus_btn1',function () {
    //     $(this).closest('tr').remove();
    // })

    // $(document).on('click','#hapus_btn2',function () {
    //     $(this).closest('tr').remove();
    // })

    // $(document).on('click','#hapus_btn',function () {
    //     $(this).closest('tr').remove();
    // })

    // $(document).on('click','#add_btn2',function () {
    //     index2++;
    //     var html='';
    //     var level1=$(this).data('level1');
    //     var level2=$(this).data('level2');
    //     html+='<tr id="baris2">';
    //     html+='<td></td>';
    //     html+='<td><textarea class="form-control kolom2" name="tipeA['+level1+'][sub]['+level2+'][sub]['+index2+'][rekomendasi]"></textarea></td>';
    //     html+='<td><textarea class="form-control kolom2" name="tipeA['+level1+'][sub]['+level2+'][sub]['+index2+'][keterangan]"></textarea></td>';
    //     html+='<td><input type="text" class="form-control kolom2 tanparupiah" name="tipeA['+level1+'][sub]['+level2+'][sub]['+index2+'][pengembalian]"></td>';
    //     html+='<td><button type="button" class="btn btn-primary kolom2" id="remove"><i class="fa-solid fa-minus"></i></button></td>';
    //     html+='</tr>';
    //     $(this).closest('tr').after(html);
    // })




</script>
@endsection