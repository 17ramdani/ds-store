<?php

namespace App\Http\Controllers\Barang;

use App\Http\Controllers\Controller;
use App\Models\Barang\BarangSatuan;
use App\Models\Barang\TipeKain;
use App\Models\Barang\Warna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipeKainController extends Controller
{
    function tipe_by_jenis($jenis_id)
    {

        // $datas = TipeKain::where('jenis_kain_id', $jenis_id)->select('id', 'nama')->distinct()->get();
        $datas = TipeKain::where([['jenis_kain_id', $jenis_id], ['bagian', '!=', 'accessories']])->select('nama')->distinct()
            ->orderBy('nama', 'asc')
            ->get();

        return response()->json([
            'datas' => $datas
        ], 200, [], JSON_PRETTY_PRINT);
    }

    function kain_by_tipe(Request $request, $jenis)
    {
        $tipe_name = $request->tipe_name;
        $barangs = TipeKain::with(["kategoriwarna" => function ($query) {
            $query->select('id', 'nama')->distinct();
        }])
            ->where([
                ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
            ])->select('kategori_warna_id')->distinct()
            ->get();
        return response()->json([
            'datas'     => $barangs,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function gambar_by_tipe(Request $request, $jenis)
    {
        $tipe_name = $request->tipe_name;
        $barangs = TipeKain::where([
            ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
        ])
            ->first();
        return response()->json([
            'datas' => $barangs
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function search_by_tipe(Request $request, $jenis)
    {
        $keyword = $request->keyword;
        $tipe_name = $request->tipe_name;
        $barangs = TipeKain::whereHas('warna', function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        })->with('warna', 'lebar', 'gramasi', 'satuan')
            ->where([
                ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
            ])
            ->get();
        $asesoris   = TipeKain::with(["lebar", "gramasi", "warna", "satuan"])
            ->where([
                ['jenis_kain_id', $jenis], ['bagian', '!=', 'body']
            ])
            ->firstOrFail();
        $warna = TipeKain::whereHas('warna', function ($query) {
            $query->select('id', 'nama');
        })->with('warna')
            ->where([
                ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
            ])->select('warna_id')->distinct()
            ->get();
        $satuan = BarangSatuan::all();
        return response()->json([
            'datas'     => $barangs,
            'acesoris'  => $asesoris,
            'satuan'    => $satuan,
            'warnas'    => $warna,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    // public function warna_by_tipe(Request $request){
    //     $cwarna = $request->id_warna;
    //     $warna = DB::select('SELECT DISTINCT
    //     warna.id,warna.nama,tipe_kain.warna_id
    //     FROM tipe_kain
    //     JOIN warna ON tipe_kain.warna_id=warna.parent_id
    //     WHERE
    //     warna.parent_id= '.$cwarna.'');
    //     return response()->json([
    //         'callback'     => $warna,
    //     ], 200, [], JSON_PRETTY_PRINT);
    // }

    public function warna_by_tipe(Request $request, $jenis)
    {
        $kategori_warna = $request->kategori_warna;
        $tipe_name      = $request->tipe_name;

        $barangs = TipeKain::whereHas('warna', function ($query) use ($kategori_warna) {
            $query->where('parent_id', '=', $kategori_warna);
        })->with('kategoriwarna', 'warna', 'lebar', 'gramasi', 'satuan')
            ->where([
                ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
            ])
            ->get();

        // $asesoris   = TipeKain::with(["lebar", "gramasi", "warna", "satuan"])
        //     ->where([
        //         ['jenis_kain_id', $jenis], ['bagian', '!=', 'body']
        //     ])
        //     ->firstOrFail();
        // $warna += Warna::where('kategori_warna','like','%'.$cwarna.'%')->get();
        $cwarna = "";
        $warna = TipeKain::whereHas('warna', function ($query) use ($cwarna) {
            $query->where('parent_id', '!=', '0')->select('id', 'nama');
        })->with('warna')
            ->where([
                ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
            ])->select('warna_id')->distinct()
            ->get();

        $satuan = TipeKain::whereHas('satuan', function ($query) {
            $query->select('id', 'keterangan');
        })->with('satuan')
            ->where([
                ['jenis_kain_id', $jenis], ['nama', 'like', '%' . $tipe_name . '%']
            ])->select('barang_satuan_id')->distinct()
            ->get();

        return response()->json([
            'datas'     => $barangs,
            // 'acesoris'  => $asesoris,
            'satuan'    => $satuan,
            // 'warnas'    => $warna,
        ], 200, [], JSON_PRETTY_PRINT);
    }
}
