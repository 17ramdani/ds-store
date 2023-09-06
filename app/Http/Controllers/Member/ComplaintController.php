<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Complaint\Complaint;
use Illuminate\Http\Request;
use App\Models\Pesanan\Pesanan;


class ComplaintController extends Controller
{
    public function index()
    {
        $customer_id = auth()->user()->customer_id;
        $data['total_pesanan']  = Pesanan::where('customer_id', $customer_id)->count();
        $data['total_prosess']  = Complaint::where([['customer_id', $customer_id], ['status', '2']])->count();
        $data['total_selesai']  = Complaint::where([['customer_id', $customer_id], ['status', '3']])->count();
        $data['complaint'] = Complaint::get()->where('customer_id', $customer_id);
        return view('complaint.index', $data);
    }

    public function add()
    {
        $customer_id = auth()->user()->customer_id;
        $data['pesanan'] = Pesanan::with('status', 'details')->where('customer_id', $customer_id)->get();
        return view('complaint.add', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function add_detail($id)
    {
        $data['pesanan'] = Pesanan::with('status')->where('id', $id)->get();
        return view('complaint.add-detail', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function store(Request $request)
    {
        // $validate_data = $request->validate([
        //     'name'         => 'required|max:255',
        // ]);
        $nomor = "KL." . date("Ymdhis");
        $data_inst  = [
            'nomor'                 => $nomor,
            'jenis_keluhan'         => $request->jenis_keluhan,
            'customer_id'           => $request->customer_id,
            'customer_category_id'  => $request->cat_customer,
            'customer_service_id'   => 0,
            'no_pesanan'            => $request->no_pesanan,
            'tanggal'               => date('Y-m-d H:i:s'),
            'status_pesanan'        => $request->status_pesanan,
            'status'                => 1,
            'desc_keluhan'          => $request->desc_keluhan,
        ];
        Complaint::create($data_inst);
        return redirect('/complaint')->with('success', 'Komplain berhasil ajukan!');
        // return response()->json($data_inst, 200, [], JSON_PRETTY_PRINT);
    }
}
