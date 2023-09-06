<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    function store(Request $request, $tipe_kain_id)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);
        $customer_id = auth()->user()->customer_id;
        $keranjang = Keranjang::where([
            ['tipe_kain_id', $tipe_kain_id], ['customer_id', $customer_id], ['checkout', 0]
        ])->first();

        if (!isset($keranjang)) {
            Keranjang::create([
                'tipe_kain_id' => $tipe_kain_id,
                'customer_id' => $customer_id,
                'checkout' => 0,
                'qty' => $request->qty,
                'qty_accesories'    => 0,
                'warna_id'    => $request->warna,
                // 'accesories_id' => $request->id_assesoris,
                'accesories_id' => 0,
                'satuan'    => $request->satuans,
                'created_by' => auth()->user()->id
            ]);
        } else {
            Keranjang::where([
                ['tipe_kain_id', $tipe_kain_id], ['customer_id', $customer_id], ['checkout', 0]
            ])->update([
                'qty' => $keranjang->qty + $request->qty,
                'qty_accesories'    => 0,
                'warna_id'    => $request->warna,
                // 'accesories_id' => $request->id_assesoris,
                'accesories_id' => 0,
                'satuan'    => $request->satuans,
            ]);
        }

        return response()->json([
            'message' => 'Barang ditambahkan ke keranjang.'
        ]);
    }

    function index()
    {
        $customer_id = auth()->user()->customer_id;
        $datas = Keranjang::with([
            'tipe_kain' => [
                "lebar", "gramasi", "warna", "satuan"
            ]
        ])->where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();
        return response()->json([
            'datas' => $datas
        ], 200, [], JSON_PRETTY_PRINT);
    }

    function destroy($id)
    {
        Keranjang::where('id', $id)->delete();
        return response()->json([
            'message' => 'Barang dihapus dari keranjang.'
        ]);
    }
}
