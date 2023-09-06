<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use Illuminate\Http\Request;
use App\Models\Pesanan\Komplain;
use App\Models\Pesanan\Pesanan;

class KomplainController extends Controller
{
    function create($pesanan_id)
    {
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
            ->get()
            ->map(function ($jenisKain) {
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });
        // $komplain = Komplain::with('pesanan:id,nomor')->where('pesanan_id', $pesanan_id)->first();
        $pesanan = Pesanan::with('komplain')->select('id', 'nomor')->where('id', $pesanan_id)->firstOrFail();
        // return response()->json(['data' => $pesanan], 200, [], JSON_PRETTY_PRINT);
        return view('pesanan.komplain.create', [
            'data' => $data,
            'pesanan' => $pesanan
        ]);
    }

    function store(Request $request, $pesanan_id)
    {
        $request->validate([
            'deskripsi' => ['required', 'string', 'max:255'],
            'file' => ['required', 'file', 'mimes:png,jpg', 'max:10240']
        ]);
        $photos = "";
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = $file->hashName();
            $file->storeAs('public/komplain', $name);
            $photos = url('storage/komplain') . '/' . $name;
        }
        Komplain::updateOrCreate([
            'pesanan_id' => $pesanan_id
        ], [
            'customer_id' => auth()->user()->customer_id,
            'tanggal' => Date('Y-m-d'),
            'keterangan' => $request->deskripsi,
            'photos' => $photos
        ]);
        return back()->with('success', 'Komplain berhasil diajukan.');
    }
}
