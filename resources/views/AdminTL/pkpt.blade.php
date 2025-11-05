@extends('template')
@section('content')
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
    </style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Tambah Penugasan
  </button>

            <table id="mytable" class="table-light mt-2" style="width: 100%">
                <thead>
                    <tr>
                        <tr>
                            <th>#</th>
                            <th>Penugasan</th>
                            <th>Tipe Rekomendasi</th>
                            <th>Tipe Pemeriksaan</th>
                            <th>Wilayah Pemeriksaan</th>
                            <th>Tim Pemeriksaan</th>
                            <th>Aksi</th>
                        </tr>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0" style="background-color: white">
                      <?php $no = 1; ?>
                    @foreach ($datanew as $index => $v)
                    <tr style="color: black">
                        <td>{{ $no++ }}</td>
                        <td>{{ $v['nama_jenispengawasan'].' Ke '.$v['nama_obrik'] }}</td>
                        <td>{{ $v['tipe'] }}</td>
                        <td>{{ $v['jenis'] }}</td>
                        <td>{{ $v['wilayah'] }}</td>
                        <td>{{ $v['pemeriksa'] }}</td>
                        <td>
                            <a href="{{ url('adminTL/pkpt_edit/' . $v['id'] . '/edit') }}" class="btn btn-info">Edit</a>
                            <a href="" class="btn btn-success" style="margin-top: 10px">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                @include('AdminTL.modal.modal1')
            </div>




@endsection
