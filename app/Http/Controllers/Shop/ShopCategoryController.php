<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopCategoryController extends Controller
{
    function index(Request $request, $id)
    {
        if (Auth::check()) {
            $idx                = Auth::user()->customer_id;
            $customer           = Customer::with('customer_category')->where('id', $idx)->first();
            $customerCategoryID = $customer->customer_category_id;
        } else {
            $customerCategoryID = 1;
        }
        $categoryId = $request->query('category-kain');

        $data = JenisKain::with(['tipe_kain' => function ($query) {
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

        $cards = TipeKain::with([
            'jenis_kain:id,nama',
            'lebar',
            'gramasi',
            'warna',
            'satuan',
            'prices' => function ($query) use ($customerCategoryID) {
                $query->where([
                    ['tipe', 'ECER'],
                    ['customer_category_id', $customerCategoryID]
                ])->orderBy('periode', 'DESC')->with('customer');
            }
        ])
            ->where('jenis_kain_id', $id)
            ->distinct();

        $filteredCards = $cards->get()
            ->map(function ($jenisKain) {
                $slug = Str::slug($jenisKain->jenis_kain->nama);
                $jenisKain->slug = $slug;
                return $jenisKain;
            })
            ->filter(function ($jenisKain) use ($categoryId) {
                return $jenisKain->slug === Str::slug($categoryId) || $jenisKain->jenis_kain->nama === $categoryId;
            });

        $paginatedCards = new LengthAwarePaginator(
            $filteredCards->forPage(Paginator::resolveCurrentPage(), 12),
            $filteredCards->count(),
            12,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        // return response()->json($filteredCards, 200, [], JSON_PRETTY_PRINT);
        return view('product.product-card', [
            'data'          => $data,
            'cards'         => $paginatedCards,
            'jenis_id'      => '',
            't_nama' => ''
        ]);
    }
}
