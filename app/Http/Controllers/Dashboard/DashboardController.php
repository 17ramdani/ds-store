<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Customer\Customer;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Pesanan\CustomerPoint;
use App\Models\Pesanan\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function pesanan_index(){
        $customer_id = auth()->user()->customer_id;
        $data['count'] = DB::select('SELECT
            COUNT(*) AS sts_0,
            COUNT(case when status_pesanan.keterangan="Tunggu Konfirmasi" then 1 end ) AS sts_1,
            COUNT(case when status_pesanan.keterangan="Tunggu Pembayaran" then 1 end ) AS sts_2,
            COUNT(case when status_pesanan.keterangan="Pesanan Diproses" then 1 end ) AS sts_3,
            COUNT(case when status_pesanan.keterangan="Pesanan Diantar" then 1 end ) AS sts_4,
            COUNT(case when status_pesanan.keterangan="Pesanan Selesai" then 1 end ) AS sts_5
            FROM pesanan
            JOIN status_pesanan ON pesanan.status_pesanan_id=status_pesanan.id
            WHERE pesanan.customer_id=' . $customer_id . ' AND pesanan.deleted_at IS NULL')[0];
        $data['customer'] = Customer::find($customer_id)->customer_category()->first();
        $data['point'] = CustomerPoint::where('customer_id', $customer_id)->sum('point_total');
        $data['total_byr'] = Pesanan::where('customer_id', $customer_id)->sum('total');
        $data['inv_byr'] = InvoiceJual::get()->sum('grand_total');
        $data['data'] = JenisKain::with(['tipe_kain' => function ($query) {
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

        $data['pesanan'] = pesanan::with([
            'customer',
            'sales_man',
            'status',
            'details'
        ])->where([
            ['customer_id', $customer_id],
            ['created_by', auth()->user()->id]
        ])->get();   

        // echo json_encode([
        //     'data'      => $data['pesanan'],
        // ], JSON_PRETTY_PRINT);     
        return view('dashboard.dashboard',$data);
    }

    function fresh_order(){
        $customer_id = auth()->user()->customer_id;
        $data['count'] = DB::select('SELECT
            COUNT(*) AS sts_0,
            COUNT(case when status_pesanan.keterangan="Tunggu Konfirmasi" then 1 end ) AS sts_1,
            COUNT(case when status_pesanan.keterangan="Tunggu Pembayaran" then 1 end ) AS sts_2,
            COUNT(case when status_pesanan.keterangan="Pesanan Diproses" then 1 end ) AS sts_3,
            COUNT(case when status_pesanan.keterangan="Pesanan Diantar" then 1 end ) AS sts_4,
            COUNT(case when status_pesanan.keterangan="Pesanan Selesai" then 1 end ) AS sts_5
            FROM pesanan
            JOIN status_pesanan ON pesanan.status_pesanan_id=status_pesanan.id
            WHERE pesanan.customer_id=' . $customer_id . ' AND pesanan.deleted_at IS NULL')[0];
        $data['customer'] = Customer::find($customer_id)->customer_category()->first();
        $data['point'] = CustomerPoint::where('customer_id', $customer_id)->sum('point_total');
        $data['total_byr'] = Pesanan::where('customer_id', $customer_id)->sum('total');
        $data['inv_byr'] = InvoiceJual::get()->sum('grand_total');
        $data['data'] = JenisKain::with(['tipe_kain' => function ($query) {
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

        $data['pesanan'] = pesanan::with([
            'customer',
            'sales_man',
            'status',
            'details'
        ])->where([
            ['customer_id', $customer_id],
            ['created_by', auth()->user()->id]
        ])->get();   

        // echo json_encode([
        //     'data'      => $data['pesanan'],
        // ], JSON_PRETTY_PRINT);     
        return view('dashboard.dashboard-fo',$data);
    }
}
