<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Financing\Financing;

use App\Models\Pesanan\Pesanan;

use Illuminate\Http\Request;


class FinanceController extends Controller
{

    public function financing_checkout ($id)
    {
        $pesanan    = Pesanan::findOrFail($id);
        $customer   = Customer::where('id', auth()->user()->id)->first();
        
        // return response()->json($pesanan, 200, [], JSON_PRETTY_PRINT);

        return view('financing', [
            'pesanan'   => $pesanan,
            'customer'  => $customer
        ]);
    }

    public function store(Request $request)
    {
       Financing::create([
            'customer_id' => auth()->user()->id,
            'pesanan_id' => $request->pesanan_id,
            'tgl_pengajuan' => date('Y-m-d'),
            'nominal' => $request->kebutuhan_nominal,
            'status' => 2 // PENDING
       ]);
       return redirect()->route('pesanan.payment', $request->pesanan_id);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function add()
    {
        $customer = Customer::where('id', auth()->user()->id)->first();

        return view('financing', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => '', 'string', 'max:255',
            'pesanan_id' => '', 'string', 'max:255',
            'tgl_pengajuan' => '', 'string', 'max:255',
            'nominal' => '', 'string', 'max:255',
            'status' => 'required', 'required', 'string', 'max:255',
        ]);

        Financing::where('id', $id)->store([
            'customer_id' => $request->id,
            'pesanan_id' => $request->pesanan_id,
            'tgl_pengajuan' => date('Y-m-d H:i:s'),
            'nama_perusahaan' => $request->nama_perusahaan,
            'nominal' => $request->nominal,
            'status' => $request->status
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Berhasil Daftar Buyer Financing');
    }
}
