<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LeftNavController;
use App\Models\Barang\JenisKain;
use App\Models\Pesanan\PesananDev;
use App\Models\Pesanan\PesananDevAcc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class FreshOrderController extends Controller
{
    function store(Request $request)
    {
        $request->validate([
            'jenis_kain' => ['required', 'string', 'max:255'],
            'tipe_kain' => ['required', 'string', 'max:255'],
            'gramasi' => ['required', 'string', 'max:255'],
            'warna' => ['required', 'string', 'max:255'],
            'lebar' => ['required', 'string', 'max:255'],
            'qty_pesanan' => ['required', 'numeric', 'min:0'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'gambar' => ['required', 'file', 'mimes:png,jpg', 'max:10240']
        ]);
        $data = new PesananDev;
        $data->inq_number = 'INQ.' . date('YmdHis');
        $data->tanggal = date('Y-m-d');
        $data->customer_id = auth()->user()->customer_id;
        $data->jenis_kain_id = 0;
        $data->jenis_kain = $request->jenis_kain;
        $data->tipe_kain_id = 0;
        $data->tipe_kain = $request->tipe_kain;
        $data->warna = $request->warna;
        $data->gramasi = $request->gramasi;
        $data->lebar = $request->lebar;
        $data->qty = $request->qty_pesanan;
        $data->keterangan = $request->keterangan;
        $photos = "";
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $name = $file->hashName();
            $file->storeAs('public/order-fresh', $name);
            $photos = url('storage/order-fresh') . '/' . $name;
        }
        $data->images = $photos;
        $data->tipe_pesanan = $request->tipe_pesanan;
        $data->save();
        //input accessories
        if ($request->rib > 0) {
            PesananDevAcc::create(['pesanan_dev_id' => $data->id, 'accessories_id' => 0, 'accessories' => 'RIB', 'qty' => $request->rib]);
        }
        if ($request->rib_spandex > 0) {
            PesananDevAcc::create(['pesanan_dev_id' => $data->id, 'accessories_id' => 0, 'accessories' => 'RIB SPANDEX', 'qty' => $request->rib_spandex]);
        }
        if ($request->bur > 0) {
            PesananDevAcc::create(['pesanan_dev_id' => $data->id, 'accessories_id' => 0, 'accessories' => 'BUR', 'qty' => $request->bur]);
        }
        if ($request->bur_spandex > 0) {
            PesananDevAcc::create(['pesanan_dev_id' => $data->id, 'accessories_id' => 0, 'accessories' => 'BUR SPANDEX', 'qty' => $request->bur_spandex]);
        }
        if ($request->kerah > 0) {
            PesananDevAcc::create(['pesanan_dev_id' => $data->id, 'accessories_id' => 0, 'accessories' => 'KERAH', 'qty' => $request->kerah]);
        }
        if ($request->manset > 0) {
            PesananDevAcc::create(['pesanan_dev_id' => $data->id, 'accessories_id' => 0, 'accessories' => 'MANSET', 'qty' => $request->manset]);
        }

        return redirect()->route('dashboard-fo')->with('success', $request->tipe_pesanan . ' Created.');
    }

    function pesanan_dev()
    {
        $data = LeftNavController::leftnav();
        $tipe = "Development";
        return view('pesanan.add-fo', compact(
            'data',
            'tipe'
        ));
    }

    function detail($id)
    {
        $data['data'] = LeftNavController::leftnav();
        $data['pesanan'] = PesananDev::with([
            'customer:id,nama,alamat', 'accs:id,pesanan_dev_id,accessories,qty', 'details:id,pesanan_dev_id,bagian,nama,warna,kategori_warna,qty,qty_act,harga,subtotal'
        ])->where('id', $id)->firstOrFail();

        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        return view('pesanan.fresh-order.detail', $data);
    }
}
