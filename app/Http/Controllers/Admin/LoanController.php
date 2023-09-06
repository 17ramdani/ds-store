<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\LoanActivity;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    function index()
    {
        $jumlah_pending = Loan::where('status', 'Pending')->count();
        $data = Loan::with(["member", "type"])->where('status', '!=', 'Pending')->get();
        return view('admin.pinjaman.index', [
            'loans' => $data,
            'jumlah_pending' => $jumlah_pending
        ]);
    }
    function index_pending()
    {
        $data = Loan::with(["member", "type"])->where('status', 'Pending')->get();
        return view('admin.pinjaman.pending', [
            'pendings' => $data
        ]);

        // return response()->json([
        //     'pendings' => $data
        // ], 200, [], JSON_PRETTY_PRINT);
    }
    function approval_pending($id)
    {
        $data = Loan::with(["member", "type"])->where('id', $id)->firstOrFail();

        $pokok_pinjaman = $data->pokok_pinjaman == 0 ? 1 : $data->pokok_pinjaman;
        $jangka_waktu = $data->jwk == 0 ? 1 : $data->jwk;

        $angsuran_pokok = $pokok_pinjaman / $jangka_waktu;
        $angsuran_bunga = (($pokok_pinjaman * 21.60) / 100) / 12;
        $angsuran = $angsuran_pokok + $angsuran_bunga;

        return view('admin.pinjaman.pending-approval', [
            'loan' => $data,
            'angsuran' => $angsuran
        ]);
    }
    function approval_action(Request $req, $id)
    {
        $req->validate([
            'note' => 'nullable|string|max:255',
            'status' => 'required|string'
        ]);
        $loan = Loan::find($id);
        $loan->update([
            'note' => $req->note,
            'status' => $req->status,
            'approved_by' => $req->status == "Approved" ? auth()->user()->id : 0,
            'rejected_by' => $req->status == "Rejected" ? auth()->user()->id : 0,
        ]);
        // if ($req->staus == "Approved") {
        //     LoanActivity::create([
        //         'periode' => date('Y-m-d'),
        //         'no_anggota' => $loan->no_anggota,
        //         'grup' => 'DEFAULT',
        //         'tipe' => $loan->tipe,
        //         'tanggal' => $loan->tanggal,
        //         'no_pinjaman' => time(),
        //         'pokok_pinjaman' => $loan->pokok_pinjaman,
        //         'jbayar_pokok' => 0,
        //         'sisa_pokok' => $loan->pokok_pinjaman,
        //         'x_sisa' => $loan->jwk,
        //         'jwk' => $loan->jwk,
        //     ]);
        // }
        return redirect()->back()->with($req->status, 'Data berhasil disimpan');
    }
    function detail($id)
    {
        $data = Loan::with(["member", "type"])->where('id', $id)->firstOrFail();

        $pokok_pinjaman = $data->pokok_pinjaman == 0 ? 1 : $data->pokok_pinjaman;
        $jangka_waktu = $data->jwk == 0 ? 1 : $data->jwk;

        $angsuran_pokok = $pokok_pinjaman / $jangka_waktu;
        $angsuran_bunga = (($pokok_pinjaman * 21.60) / 100) / 12;
        $angsuran = $angsuran_pokok + $angsuran_bunga;

        return view('admin.pinjaman.detail', [
            'loan' => $data,
            'angsuran' => $angsuran
        ]);
    }
}
