<?php

namespace App\Http\Controllers;

use App\Models\Pesanan\Pesanan;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    function upload_bt(Request $request, $id)
    {
        $request->validate([
            'image_bt' => 'required|image|mimes:png,jpg|max:15000'
        ]);
        // return response()->json(['data' => $request->project_document], 200);

        $jenis_bukti = $request->jenis_bukti;

        $cust_id = auth()->user()->customer_id;
        $order = Pesanan::where([
            ['customer_id', $cust_id], ['id', $id]
        ])->first();
        $orderNumber = $order->nomor ?? uniqid();

        if($jenis_bukti == "dp"){
            if ($request->hasFile('image_bt')) {
                $file = $request->file('image_bt');
                $fileExt = $file->getClientOriginalExtension();
                $filename = $orderNumber . '.' . $fileExt;
                $file->storeAs('public/bt/', $filename);

                Pesanan::where([
                    ['customer_id', $cust_id], ['id', $id]
                ])->update([
                    'bukti_transfer' => url('/storage/bt/' . $filename)
                ]);
                
                // $status_pesanan = "3";
                // $status_kode    = "Approved";
                // Pesanan::where('id', $id)->update([
                //     'status_pesanan_id' => $status_pesanan,
                //     'status_kode' => $status_kode,
                // ]);
            }
        }else{
            if ($request->hasFile('image_bt')) {
                $file = $request->file('image_bt');
                $fileExt = $file->getClientOriginalExtension();
                $filename = $orderNumber . '-PELUNASAN.' . $fileExt;
                $file->storeAs('public/bt/', $filename);

                Pesanan::where([
                    ['customer_id', $cust_id], ['id', $id]
                ])->update([
                    'bukti_pelunasan' => url('/storage/bt/' . $filename)
                ]);

                // $status_pesanan = "3";
                // $status_kode    = "Approved";
                // Pesanan::where('id', $id)->update([
                //     'status_pesanan_id' => $status_pesanan,
                //     'status_kode' => $status_kode,
                // ]);
                
            }
        }
        return redirect('/dashboard')->with('success', 'Success');
    }
}
