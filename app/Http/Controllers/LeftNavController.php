<?php

namespace App\Http\Controllers;

use App\Models\Barang\JenisKain;
// use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LeftNavController extends Controller
{
    static function leftnav()
    {
        return JenisKain::with(['tipe_kain' => function ($query) {
            $query->selectRaw('id,jenis_kain_id,nama')->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])->selectRaw('id,nama')
            ->get()
            ->map(function ($jenisKain) {
                $jenisKain->tipe_kain->each(function ($tipeKain) {
                    $slug = Str::slug($tipeKain->nama);
                    $tipeKain->slug = $slug;
                });
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });
    }
}
