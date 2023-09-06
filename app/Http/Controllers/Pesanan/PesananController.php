<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Customer\Customer;
use App\Models\Keranjang;
use App\Models\Pesanan\DetailPesanan;
use App\Models\Pesanan\Pesanan;

use Illuminate\Support\Str;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class PesananController extends Controller
{


    public function pesanan_fo()
    {
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
            ->get()
            ->map(function ($jenisKain) {
                $jenisKain->tipe_kain->each(function ($tipeKain) {
                    $slug = Str::slug($tipeKain->nama);
                    $tipeKain->slug = $slug;
                });
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });

            $tipe ="Fresh Order";
        return view('pesanan.add-fo', compact(
            'data','tipe'

        ));
    }

    public function store_fo(Request $request){
        // $validatedData = $request->validate([
        //     'tipe_kain' => 'required|max:255',
        //     'jenis_kain' => 'required|max:255',
        //     'warna' => 'required|max:255',
        //     'gramasi' => 'required|max:255',
        //     'lebar' => 'required|max:255',
        //     'qty_pesanan' => 'required|integer',
        //     'keterangan' => 'nullable|string',
        //     'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        // ]);
    }


    public function drat_so($id)
    {
        $customer_id = auth()->user()->customer_id;
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
            ->get()
            ->map(function ($jenisKain) {
                $jenisKain->tipe_kain->each(function ($tipeKain) {
                    $slug = Str::slug($tipeKain->nama);
                    $tipeKain->slug = $slug;
                });
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });
            $pesanan = Pesanan::with([
                'customer',
                'sales_man',
                'status',
                'details'
            ])->where([
                ['id', $id],
                ['created_by', auth()->user()->id]
            ])->firstOrFail();

        $status_pesanan_id = $pesanan['status_pesanan_id'];
        // echo json_encode($pesanan, JSON_PRETTY_PRINT);
        return view('pesanan.draft-so',compact('data','pesanan'));
    }

    public function detail_so($id){

        $customer_id = auth()->user()->customer_id;
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
            ->get()
            ->map(function ($jenisKain) {
                $jenisKain->tipe_kain->each(function ($tipeKain) {
                    $slug = Str::slug($tipeKain->nama);
                    $tipeKain->slug = $slug;
                });
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });
        $pesanan = pesanan::with([
            'customer',
            'sales_man',
            'status',
            'details'
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        $delivery = DB::table('deliveries')->where('pesanan_id', $id)->first();
        // echo json_encode($no_pesanan, JSON_PRETTY_PRINT);
        return view('pesanan.detail-so',compact([
            'data',
            'pesanan',
            'delivery'
        ]));
    }

    public function pesanan_done($id){

        $customer_id = auth()->user()->customer_id;
        Pesanan::where([['id', $id], ['customer_id', $customer_id]])->update(
            [
                'status_pesanan_id' => 5,
                'status_kode'       => 'Done'
            ]
        );
        return redirect()->route('dashboard')->with('success', 'Berhasil disimpan');
        // return redirect()->route('pesanan.rating', $id)->with('success', 'Berhasil disimpan');
    }

    public function pesanan_batal(Request $request){
        $id_so = $request->input('id_so');

        Pesanan::where('id', $id_so)->update([
            'status_pesanan_id' => 6,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
