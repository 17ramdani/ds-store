<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Pesanan\CustomerPoint;
use App\Models\Penjualan\InvoiceJual;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Penjualan\Penjualan;
use App\Models\Pesanan\DetailPesanan;
use App\Models\Pesanan\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
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
        $data['data'] = JenisKain::orderBy('nama', 'asc')->get();
        return view('dashboard', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function pesanan_index()
    {
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
        // $data['data'] = JenisKain::orderBy('nama', 'asc')->get();
        $data['data'] = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });

        $data['pesanan'] = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc');
                    }
                ]);
            }
        ])->where([
            ['customer_id', $customer_id],
            ['created_by', auth()->user()->id]
        ])->get();        

        $data['cards'] = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', 1],
            ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
        ])
        ->distinct()
        ->get();
        return view('dashboard-new',$data);
        // return response()->json($data['pesanan'], 200, [], JSON_PRETTY_PRINT);
    }

    public function getUserPoints(){
        $customer_id = auth()->user()->customer_id;
        $user = CustomerPoint::where('customer_id', $customer_id)->sum('point_total');
        
        return $user;
    }

    public function getUserOrders(){
        $customer_id = auth()->user()->customer_id;
        $jml_orders = Pesanan::where('customer_id', $customer_id)->count();
        
        return $jml_orders;
    }

}
