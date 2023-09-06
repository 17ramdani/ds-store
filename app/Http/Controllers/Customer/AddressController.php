<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer\CustomerAdress;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $custId = auth()->user()->customer_id;

        $datas = CustomerAdress::where('customer_id', $custId)->select('id', 'name', 'category', 'full_address')
            ->orderBy('primary', 'DESC')->get();
        return response()->json(['datas' => $datas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => ['required'],
            'nama_penerima' => ['required', 'string', 'max:255'],
            'kategori_alamat' => ['required', 'string', 'max:50'],
            'alamat_lengkap' => ['required', 'string', 'max:255'],
        ]);
        CustomerAdress::create([
            'customer_id' => $request->customer_id,
            'name' => $request->nama_penerima,
            'category' => $request->kategori_alamat,
            'full_address' => $request->alamat_lengkap,
        ]);
        return response()->json(['message' => 'Alamat berhasil ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = CustomerAdress::where('id', $id)->select('id', 'name', 'full_address', 'category')->firstOrFail();
        return response()->json(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => ['required'],
            'nama_penerima' => ['required', 'string', 'max:255'],
            'kategori_alamat' => ['required', 'string', 'max:50'],
            'alamat_lengkap' => ['required', 'string', 'max:255'],
        ]);
        CustomerAdress::where('id', $id)->update([
            'name' => $request->nama_penerima,
            'category' => $request->kategori_alamat,
            'full_address' => $request->alamat_lengkap,
        ]);
        return response()->json(['message' => 'Alamat berhasil diperbaharui']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CustomerAdress::find($id);
        $penerima = $data->name;
        $primary = $data->primary;
        if ($primary == 1) {
            return response()->json(['message' => 'Alamat utama tidak dapat dihapus'], 400);
        }
        $data->delete();

        return response()->json(['message' => 'Alamat ' . $penerima . ' berhasil dihapus']);
    }
}
