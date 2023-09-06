<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Barang\TipeKainAccessories;
use App\Models\Barang\TipeKainPrices;
use App\Models\Customer\Customer;
use App\Models\CustomerUser;
use App\Models\Kain\Accessories;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ProductController extends Controller
{

    public function fetch_product(Request $request)
    {
        $jenis  = $request->input('id');
        $tipe   = $request->input('jenis');

        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
            ->where([
                ['jenis_kain_id', $jenis],
                ['nama', 'like', '%' . $tipe . '%']
            ])
            ->distinct()
            ->get();
        return view('product.product-card', [
            'cards' => $cards
        ]);
    }

    public function product_by_cat(Request $request, $id)
    {
        if (Auth::check()) {
            $idx                = Auth::user()->customer_id;
            $customer           = Customer::with('customer_category')->where('id', $idx)->first();
            $customerCategoryID = $customer->customer_category_id;
        } else {
            $customerCategoryID = 1;
        }
        $categoryId = $request->query('category-kain');

        $data = JenisKain::select('id', 'nama')->orderBy('nama')->get();

        $cards = TipeKain::with([
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
                $slug = Str::slug($jenisKain->nama);
                $jenisKain->slug = $slug;
                return $jenisKain;
            })
            ->filter(function ($jenisKain) use ($categoryId) {
                return $jenisKain->slug === Str::slug($categoryId) || $jenisKain->nama === $categoryId;
            });

        $paginatedCards = new LengthAwarePaginator(
            $filteredCards->forPage(Paginator::resolveCurrentPage(), 12),
            $filteredCards->count(),
            12,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
        $tKain = TipeKain::where('jenis_kain_id', $id)->select('nama')->distinct()->get()
            ->map(function ($jenisKain) {
                $slug = Str::slug($jenisKain['nama']);
                $jenisKain->slug = $slug;
                return $jenisKain;
            })
            ->filter(function ($jenisKain) use ($categoryId) {
                return $jenisKain->slug === Str::slug($categoryId) || $jenisKain['nama'] === $categoryId;
            });
        $tNama = $tKain[0]['nama'] ?? '';
        // return response()->json($tKain, 200, [], JSON_PRETTY_PRINT);
        return view('product.product-card', [
            'data'          => $data,
            'cards'         => $paginatedCards,
            'jenis_id'      => $id,
            't_nama' => $tNama
        ]);
    }

    public function detail(Request $request, $id)
    {
        if (Auth::check()) {
            $customerCategoryID = CustomerUser::find(auth()->user()->id)->customer()->first()->customer_category_id ?? 1;
        } else {
            $customerCategoryID = 1;
        }
        $detail = TipeKain::with([
            'lebar',
            'gramasi',
            'warna',
            'satuan',
            'prices' => function ($query) use ($customerCategoryID) {
                $query->where([
                    ['tipe', 'ECER'],
                    ['customer_category_id', $customerCategoryID]
                ])->orderBy('periode', 'DESC');
            }
        ])
            ->where('id', $id)
            ->first();

        $rekomendasi_produk = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
            ->where(
                [
                    ['jenis_kain_id', $detail['jenis_kain_id']],
                    ['bagian', 'body']
                ]
            )
            ->distinct()
            ->get()
            ->random(4);
        // return response()->json($detail, 200, [], JSON_PRETTY_PRINT);
        return view('product.detail-product', [
            'detail'    => $detail,
            'rekom'     => $rekomendasi_produk
        ]);
    }

    public function getPrice(Request $request)
    {
        $id     = $request->id;
        $satuan = $request->satuan;
        $customer_cid = 1;
        if (auth()->user()) {
            $customer_cid = CustomerUser::find(auth()->user()->id)->customer()->first()->customer_category_id ?? 1;
        }
        $price = TipeKainPrices::where(
            [
                'tipe_kain_id' => $id,
                'tipe' => $satuan,
                'customer_category_id' => $customer_cid
            ]
        )->orderBy('periode', 'DESC')->first();
        // echo json_encode($price, JSON_PRETTY_PRINT);
        if ($price) {
            return response()->json(['price' => $price->harga]);
        }
        return response()->json(['price' => 0]);
    }

    public function getproductmodal(Request $request)
    {
        $id_produk = $request->input('id');
        $kain = TipeKain::with('jenis_kain', 'lebar', 'gramasi', 'satuan', 'warna')
            ->where('id', $id_produk)
            ->first();
        $jenis_kain_id  = $kain['jenis_kain_id'];
        $nama_produk    = $kain['nama'];

        // $satuan = TipeKain::whereHas('satuan', function ($query) {
        //     $query->select('id', 'keterangan');
        // })->with('satuan')
        //     ->where([
        //         ['jenis_kain_id', $jenis_kain_id], ['nama', 'like', '%' . $nama_produk . '%']
        //     ])->select('barang_satuan_id')->distinct()
        //     ->get();
        $satuan = TipeKain::with('satuan:id,keterangan')
            ->select('barang_satuan_id')->where('jenis_kain_id', $jenis_kain_id)->distinct()->get();

        // $asc = TipeKain::whereIn('id',array($basic_id,$spandek_id))->select('id', 'nama')->get();
        $asc    = TipeKainAccessories::with('accessories')
            ->where('tipe_kain_id', $id_produk)
            ->get();

        return response()->json([
            'datas'     => $kain,
            'asc'       => $asc,
            'satuan'    => $satuan,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function gethargabody(Request $request)
    {
        $id_produk  = $request->input('id_product');
        $satuan     = $request->input('satuan_body');
        if (Auth::check()) {
            $customerCategoryID = CustomerUser::find(auth()->user()->id)->customer()->first()->customer_category_id ?? 1;
        } else {
            $customerCategoryID = 1;
        }
        $price = TipeKainPrices::where([
            ['tipe_kain_id', $id_produk],
            ['tipe', $satuan],
            ['customer_category_id', $customerCategoryID]
        ])->orderBy('periode', 'DESC')->firstOrFail();

        $tipe_kain = TipeKain::with('satuan')
            ->where('id', $id_produk)->firstOrFail();

        return response()->json([
            'prices'    => $price,
            'tipe_kain' => $tipe_kain
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function gethargaaccessories(Request $request)
    {
        $id_asc   = $request->input('id_asc');
        $datas    = TipeKainAccessories::with(
            ['accessories']
        )->where([
            ['id', $id_asc]
        ])->firstOrFail();

        return response()->json([
            'datas'     => $datas,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function get_subkategori($jenis_id)
    {
        $data = TipeKain::where([['jenis_kain_id', $jenis_id], ['bagian', '!=', 'accessories']])->select('nama')->distinct()
            ->orderBy('nama', 'asc')
            ->get();

        return response()->json($data);
    }
}
