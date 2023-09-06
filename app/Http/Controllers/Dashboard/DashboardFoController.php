<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan\PesananDev;
use Illuminate\Support\Str;

class DashboardFoController extends Controller
{
    function leftnav()
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

    function index()
    {
        $customer_id = auth()->user()->customer_id;
        $data['data'] = $this->leftnav();

        $data['count'] = DB::select('SELECT
            COUNT(*) AS sts_0,
            COUNT(case when `status`="Draft" then 1 end ) AS sts_1,
            COUNT(case when `status`="Approved" then 1 end ) AS sts_2,
            COUNT(case when `status`="Invoicing" then 1 end ) AS sts_3,
            COUNT(case when `status`="Delivery" then 1 end ) AS sts_4,
            COUNT(case when `status`="Done" then 1 end ) AS sts_5
            FROM pesanan_devs
            WHERE customer_id=' . $customer_id . ' AND deleted_at IS NULL')[0];
        $data['pesanans'] = PesananDev::with('accs:id,pesanan_dev_id,accessories')
            ->select('id', 'inq_number', 'nomor', 'tanggal', 'keterangan', 'status', 'grand_total', 'tanggal_kirim')
            ->where('customer_id', $customer_id)->latest()->get();

        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        return view('dashboard.dashboard-fo-new', $data);
    }
}
