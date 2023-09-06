<?php

namespace App\Http\Controllers\Pesanan;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Pesanan\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
    function create(Request $request, $pesanan_id)
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
        $retur = DB::table('returs')->where('pesanan_id', $pesanan_id)->first();
        $photos = $retur->photos ?? "-";
        $photos_exploded = explode(",", $photos);
        return view('pesanan.retur.create', [
            'data' => $data,
            'pesanan_id' => $pesanan_id,
            'jenis_retur' => $retur->jenis_retur ?? "",
            'alasan_retur' => $retur->alasan_retur ?? "",
            'deskripsi' => $retur->deskripsi ?? "",
            'files' => $photos_exploded,
        ]);
    }
    function store(Request $request, $pesanan_id)
    {
        $request->validate([
            'follow_up' => ['required', 'string', 'max:255'],
            'alasan_retur' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'files.*' => ['required', 'file', 'mimes:png,jpg', 'max:10240']
        ]);
        $arr_photo = [];
        $files = "";
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            for ($i = 0; $i < count($files); $i++) {
                $name = $files[$i]->hashName(); // Generate a unique, random name...
                // $extension = $files[$i]->extension(); // Determine the file's extension based on the file's MIME type...

                $files[$i]->storeAs('public/retur', $name);
                $photos = url('storage/retur') . '/' . $name;
                array_push($arr_photo, $photos);
            }
            $files = implode(",", $arr_photo);
        }
        Retur::updateOrCreate([
            'pesanan_id' => $pesanan_id
        ], [
            'tanggal' => Date('Y-m-d H:i:s'),
            'jenis_retur' => $request->follow_up,
            'alasan_retur' => $request->alasan_retur,
            'deskripsi' => $request->deskripsi,
            'photos' => $files
        ]);
        return back()->with('success', 'Retur berhasil diajukan.');
    }
}
