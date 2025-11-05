<?php

namespace App\Http\Controllers\Pemeriksa\Api;

use App\Models\Pengawasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardPemeriksa extends Controller
{
     public function arsip()
    {
    $penugasan = DB::table('v_demo3')->orderBy('tanggalAwalPenugasan','DESC')->orderBy('noSurat','DESC')->get();
    return response()->json([
                'status'     => true,
                'message'    => 'data di temukan',
                'data'       => $penugasan
            ],200);
    }

    public function arsipobrik(Request $request)
    {
        $query = DB::table('v_demo3');
        foreach ($request->all() as $key => $value) {
            if (!in_array($key, ['token']) && !empty($value)) {
                $query->where($key, 'LIKE', '%' . $value . '%');
            }
        }

        $penugasan = $query->orderBy('tanggalAwalPenugasan', 'DESC')
                        ->orderBy('noSurat', 'DESC')
                        ->get();
        return response()->json([
            'status'  => true,
            'message' => 'data ditemukan',
            'data'    => $penugasan
    ],200);
    }

public function editPenugasan(Request $request,$id)
    {
    $penugasan = DB::table('v_demo3')->where('id', $id)->first();
    return response()->json([
       'status' => true,
       'message' => 'Data  ditemukan',
       'data' => $penugasan
       ]);
    }

    public function store(Request $request)
    {
        $dataPengawasan = new Pengawasan;

        $dataPengawasan->id_penugasan = $request->id_penugasan;
        $dataPengawasan->tglkeluar = $request->tglkeluar;
        $dataPengawasan->tipe = $request->tipe;
        $dataPengawasan->jenis = $request->jenis;
        $dataPengawasan->wilayah = $request->wilayah;
        $dataPengawasan->pemeriksa = $request->pemeriksa;
        $dataPengawasan->status_LHP = 'Belum Jadi';

        $pegawai = $dataPengawasan->save();

        return response()->json([
            'status'  => true,
            'message' => 'Sukses Memasukkan data'
        ]);
    }

    public function index()
    {
        $pengawasan = DB::table('v_tl1')->get();

        return response()->json([
            'status'     => true,
            'message'    => 'data di temukan',
            'data'       => $pengawasan
        ],200);
    }

    public function editPengawasan(Request $request,$id)
    {
    $pengawasan = DB::table('v_tl1')->where('id', $id)->first();
    return response()->json([
       'status' => true,
       'message' => 'Data  ditemukan',
       'data' => $pengawasan
       ]);
    }

    public function update(Request $request,$id)
    {
        $dataPengawasan = Pengawasan::find($id);
        if (empty($dataPengawasan)) {
            # code...
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan'
            ],404);
        }

        $dataPengawasan->tglkeluar = $request->tglkeluar;
        $dataPengawasan->tipe = $request->tipe;
        $dataPengawasan->jenis = $request->jenis;
        $dataPengawasan->wilayah = $request->wilayah;
        $dataPengawasan->pemeriksa = $request->pemeriksa;

        $eselon = $dataPengawasan->save();

        return response()->json([
            'status'  => true,
            'message' => 'Sukses Melakukan Update data'
        ]);
    }

public function rekom(Request $request)
{

    // return response()->json(['message' => 'pot.','data'=>'aa','pit'=>$request->all()], 200);
    try {
        try {
            DB::table('jenis_temuans')
                ->where('id_pengawasan', $request->id_pengawasan)
                ->delete();
        } catch (\Exception $e) {}

        $tipeAData = $request->input('tipeA') ?? $request->input('ubahTipeA');

        foreach ($tipeAData as $item) {
            $id_parent = DB::table('jenis_temuans')->insertGetId([
                'rekomendasi'   => $item['rekomendasi'],
                'keterangan'    => $item['keterangan'],
                'id_pengawasan' => $request->id_pengawasan,
                'id_penugasan'  => $request->id_penugasan,
                'pengembalian'  => str_replace('.', '', $item['pengembalian']),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            DB::table('jenis_temuans')
                ->where('id', $id_parent)
                ->update(['id_parent' => $id_parent]);

            if (!empty($item['sub']) && is_array($item['sub'])) {
                foreach ($item['sub'] as $subItem) {
                    $id_child = DB::table('jenis_temuans')->insertGetId([
                        'id_parent'     => $id_parent,
                        'rekomendasi'   => $subItem['rekomendasi'],
                        'keterangan'    => $subItem['keterangan'],
                        'id_pengawasan' => $request->id_pengawasan,
                        'id_penugasan'  => $request->id_penugasan,
                        'pengembalian'  => str_replace('.', '', $subItem['pengembalian']),
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ]);

                    if (!empty($subItem['sub']) && is_array($subItem['sub'])) {
                        foreach ($subItem['sub'] as $nestedSubItem) {
                            DB::table('jenis_temuans')->insert([
                                'id_parent'     => $id_child,
                                'rekomendasi'   => $nestedSubItem['rekomendasi'],
                                'keterangan'    => $nestedSubItem['keterangan'],
                                'id_pengawasan' => $request->id_pengawasan,
                                'id_penugasan'  => $request->id_penugasan,
                                'pengembalian'  => str_replace('.', '', $nestedSubItem['pengembalian']),
                                'created_at'    => now(),
                                'updated_at'    => now(),
                            ]);
                        }
                    }
                }
            }
        }

        return response()->json(['message' => 'Data berhasil disimpan.'], 200);
    } catch (\Exception $e1) {
        return response()->json(['message' => 'Data gagal disimpan.'], 400);
    }

        return response()->json(['message' => 'undivine proses.'], 200);
}

    public function indexRekom()
    {
        $pengawasan = DB::table('v_tl1')->where('tipe', '=', 'Rekomendasi')->get();

        return response()->json([
            'status'     => true,
            'message'    => 'data di temukan',
            'data'       => $pengawasan
        ],200);

    }

    public function indexTemuan()
    {
        $pengawasan = DB::table('v_tl1')->where('tipe', '=', 'TemuandanRekomendasi')->get();

        return response()->json([
            'status'     => true,
            'message'    => 'data di temukan',
            'data'       => $pengawasan
        ],200);
    }
}
