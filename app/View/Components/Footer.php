<?php

namespace App\View\Components;

use App\Models\Barang\JenisKain;
use App\Models\Customer\Customer;
use App\Models\Pesanan\Pesanan;
use App\Models\Pesanan\PesananDev;
use Illuminate\View\Component;

class Footer extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $jenis = JenisKain::select('id', 'nama')->orderBy('nama', 'asc')->get();

        $customer_id = auth()->user()->customer_id ?? 0;

        $customer = Customer::find($customer_id);
        $custData['name'] = $customer->nama ?? '-';
        $custData['status'] = $customer->customer_category->nama ?? '-';

        $orderCount['retailOrderCount'] = Pesanan::where('customer_id', $customer_id)->count();
        $orderCount['foCount'] = PesananDev::where('customer_id', $customer_id)->count();

        return view('components.footer', [
            'jenis' => $jenis,
            'custData' => $custData,
            'orderCount' => $orderCount
        ]);
    }
}
