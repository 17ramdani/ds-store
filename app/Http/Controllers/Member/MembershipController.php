<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerCategory;
use App\Models\Membership\Membership;

class MembershipController extends Controller
{
    public function index()
    {

        //
        //$id = auth()->user()->id;
        //$qmemb = Membership::get()->where('customer_id', $id);
        //if ($qmemb->count() > 0) {
        //    return redirect('/inv-member')->with('success', 'Anda sudah melukan pendaftaran membership !');
        //} else {
        //    return view('membership.add', $qmemb);
        //}
        $customer = Customer::where('id', auth()->user()->customer_id)->first();

        return view('membership.add', compact('customer'));
    }

    public function store(Request $request)
    {
        // $validate_data = $request->validate([
        //     'nama_kartu'  => 'required|max:255',
        // ]);
        $id = auth()->user()->id;
        $inputkeun_wa = [
            'customer_id'           => auth()->user()->id,
            'customer_category_id'  => $request->paket,
            'join_at'               => date('Y-m-d H:i:s'),
            'status'                => 1,
            'created_at'            => date('Y-m-d H:i:s'),
        ];

        Membership::create($inputkeun_wa);
        Customer::where('id', $id)->update([
            'alamat'                => $request->alamat_rumah,
            'no_ktp'                => $request->no_ktp,
            'lama_berusaha'         => $request->lama_berusaha,
            'omset'                 => $request->omset,
            'nama_perusahaan'       => $request->nama_perusahaan2,
            'alamat_perusahaan'     => $request->alamat_perusahaan,
            'tlp_perusahaan'        => $request->no_tlp_perusahaan,
            'omset_perusahaan'      => $request->omset_perusahaan,
            'kebutuhan_nominal'     => $request->kebutuhan_nominal,
            'referensi'             => $request->referensi,
            'updated_at'            => date('Y-m-d H:i:s'),
        ]);
        return redirect('/inv-member')->with('success', 'Registrasi berhasil !');
    }

    public function inv_member()
    {
        $id = auth()->user()->id;
        return view('membership.inv_member', [
            'member'    => Membership::get()->where('customer_id', $id),
        ]);
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'customer_category_id' => '', 'string', 'max:255',
            'nama' => 'required',
            'email' => 'required|unique:customer,email,' . $id,
            'nama_perusahaan' => 'required', 'string', 'max:255',
            'alamat' => 'required', 'string', 'max:255',
            'kota' => '', 'string', 'max:255',
            'nohp' => 'required', 'string', 'max:255',
            'pob' => 'required', 'string', 'max:255',
            'dob' => 'required', 'date',
            'notlp' => '', 'string', 'max:255',
            'npwp' => '', 'string', 'max:255',
            'no_ktp' => 'required', 'string', 'max:255',
            'pekerjaan' => '', 'string', 'max:255',
            'omset' => 'required', 'string', 'max:255',
            'lama_berusaha' => 'required', 'string', 'max:255',
            'alamat_perusahaan' => 'required', 'string', 'max:255',
            'tlp_perusahaan' => 'required', 'string', 'max:255',
            'email_perusahaan' => 'required', 'string', 'max:255',
            'lama_perusahaan' => '', 'string', 'max:255',
            'jenis_usaha' => 'required', 'string', 'max:255',
            'omset_perusahaan' => 'required', 'string', 'max:255',
            'kebutuhan_nominal' => 'required', 'string', 'max:255',
            'referensi' => 'required', 'string', 'max:255',
        ]);

        Customer::where('id', $id)->update([
            'customer_category_id' => $request->paket,
            'nama' => $request->nama,
            'email' => $request->email,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'nohp' => $request->nohp,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'notlp' => $request->notlp,
            'pekerjaan' => $request->pekerjaan,
            'npwp' => $request->npwp,
            'no_ktp' => $request->no_ktp,
            'omset'  => $request->omset,
            'lama_berusaha' => $request->lama_berusaha,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'email_perusahaan' => $request->email_perusahaan,
            'tlp_perusahaan' => $request->tlp_perusahaan,
            'lama_perusahaan' => $request->lama_perusahaan,
            'jenis_usaha' => $request->jenis_usaha,
            'omset_perusahaan' => $request->omset_perusahaan,
            'kebutuhan_nominal' => $request->kebutuhan_nominal,
            'referensi' => $request->referensi,
        ]);

        $membershipCount = Membership::where('customer_id', $id)->count();

        if($membershipCount > 1){
            Membership::create([
                'customer_id' => $id,
                'customer_category_id' => $request->paket,
                'join_at' => date('Y-m-d H:i:s'),
                'status'  => 0,
                'status_bayar' => 0,
                'is_renewal' => 0,
            ]);
        }else{

        }

        return redirect()->route('dashboard')
            ->with('success', 'Berhasil Daftar Membership');
    }
}
