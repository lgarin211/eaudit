
 <div class="modal-dialog modal-xl">
    <div class="modal-content" style="background-color: white">
        <div class="modal-header" style="background-color: white">
            <h1 class="modal-title fs-5" id="exampleModalLabel" style="color: #000">Pilih Penugasan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color: white">
            <form action="{{ url('adminTL/arsip/cari') }}" method="post" id="formCari">
                @csrf
                <div class="row">
                    <div class="col-3 mt-3">
                        <label for="" style="color: black">Obrik</label>
                        <input type="text" class="form-control" name="nama_obrik" style="color: white">
                    </div>
                    <div class="col-3 mt-3">
                        <label for="" style="color: black">Jenis Pengawasan</label>
                        <input type="text" name="nama_jenispengawasan" class="form-control" id="search" style="color: white">
                    </div>
                    <div class="col-3 mt-3">
                        <label for="" style="color: black">Bulan</label>
                        <select name="tanggalAwalPenugasan" id="bulan" class="form-control filter" style="color: white">
                            <option value="">Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="col-3 mt-3">
                        <label for="" style="color: black">Tahun</label>
                        <select name="tanggalAwalPenugasan_tahun" id="filtertahun" class="form-control" style="color: white">
                            <option value="">PILIH TAHUN</option>
                            @for ($i = 2022; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <button class="btn btn-info mt-3" type="submit">SUBMIT</button>
            </form>
        </div>

        <table id="mytable" class="mt-2" style="width: 100%; background-color: white ">
            <thead>
                <tr>
                    <th>Nomor Surat</th>
                    <th>Obrik</th>
                    <th>Jenis Pengawasan</th>
                    <th>Bulan Penugasan</th>
                    <th>Tahun Penugasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0" id="tbody" style="color: #000">
                <?php $no = 1; ?>
                @foreach ($data['data'] as $index => $v)
                    <tr>
                        <td>{{ '700.1.1/' . $v['noSurat'] . '/03' . '/' . date('Y') }}</td>
                        <td>{{ $v['nama_obrik'] }}</td>
                        <td>{{ $v['nama_jenispengawasan'] }}</td>
                        <td class="kolom">{{ Carbon\Carbon::parse($v['tanggalAwalPenugasan'])->translatedFormat('F') }} </td>
                        <td class="kolom">{{ Carbon\Carbon::parse($v['tanggalAwalPenugasan'])->translatedFormat('Y') }}</td>
                        <td>
                            <a href="{{ url('adminTL/pkpt_tambah/' . $v['id']) }}" class="btn btn-outline-primary">Pilih</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="modal-footer" style="background-color: white">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formCari");
    const tbody = document.getElementById("tbody");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch("{{ url('adminTL/arsip/cari') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": formData.get("_token"),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(res => {
            tbody.innerHTML = "";
            if (res.data.data && res.data.data.length > 0) {
                res.data.data.forEach(v => {
                    const bulan = new Date(v.tanggalAwalPenugasan)
                                    .toLocaleString('id-ID', { month: 'long' });
                    const tahun = new Date(v.tanggalAwalPenugasan).getFullYear();
                    tbody.innerHTML += `
                        <tr>
                            <td>700.1.1/${v.noSurat}/03/${tahun}</td>
                            <td>${v.nama_obrik}</td>
                            <td>${v.nama_jenispengawasan}</td>
                            <td>${bulan}</td>
                            <td>${tahun}</td>
                            <td>
                                <a href="{{ url('adminTL/pkpt_tambah') }}/${v.id}" class="btn btn-outline-primary">Pilih</a>
                            </td>
                        </tr>`;

                });
            } else {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                    </tr>`;
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-danger">Terjadi error</td>
                </tr>`;
        });
    });
});
</script>
