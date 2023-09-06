<?php

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Customer\CustomerCategory;

class ProfilController extends Controller
{

    public function account_detail()
    {
        $customer_id = auth()->user()->customer_id;
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
            ->get()
            ->map(function ($jenisKain) {
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });

        $customer = Customer::with('customer_category')
            ->where('id', $customer_id)
            ->first();
        // echo json_encode($customer, JSON_PRETTY_PRINT);
        return view('account-detail', compact('data', 'customer'));
    }

    public function index()
    {
        $customer = Customer::with('customer_category')
            ->where('id', auth()->user()->customer_id)
            ->first();
        return view('profil', compact('customer'));
    }
}
