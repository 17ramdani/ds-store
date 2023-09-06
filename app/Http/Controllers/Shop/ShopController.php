<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Barang\TipeKainAccessories;
use App\Models\Barang\TipeKainPrices;
use App\Models\Customer\Customer;
use App\Models\Kain\Accessories;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $id                 = Auth::user()->customer_id;
            $customer           = Customer::with('customer_category')->where('id', $id)->first();
            $customerCategoryID = $customer->customer_category_id;
        } else {
            $customerCategoryID = 1;
        }
        $data = JenisKain::select('id', 'nama')->orderBy('nama')->get();
        $latestDate = TipeKainPrices::max('periode');
        $produk_active = TipeKain::with([
            'lebar',
            'gramasi',
            'warna',
            'satuan',
            'prices' => function ($query) use ($customerCategoryID, $latestDate) {
                $query->select('id', 'tipe_kain_id', 'customer_category_id', 'periode', 'tipe', 'harga')->where([
                    ['tipe', 'ECER'],
                    ['customer_category_id', $customerCategoryID],
                ])->orderBy('periode', 'DESC')->with('customer:id,nama');
            }
        ])
            ->selectRaw('id,kode,jenis_kain_id,kategori_warna_id,warna_id,barang_lebar_id,barang_gramasi_id,
        barang_satuan_id,nama,qty_roll,gambar')
            ->where('status', 'A')
            ->orderByRaw('RAND()')
            ->distinct()
            ->simplePaginate(12);
        // return response()->json($produk_active, 200, [], JSON_PRETTY_PRINT);
        return view('shop.shop', [
            'data'          => $data,
            'porduk_active' => $produk_active,
            'jenis_id'      => '',
            'category_kain' => ''
        ]);
    }

    public function store(Request $request)
    {
        if (auth()->user() && auth()->user()->customer_id) {
            $customer_id = auth()->user()->customer_id;
            $id_body = $request->input('id_body');
            $harga_body = $request->input('harga_body');
            $qty_body = $request->input('qty_body');
            $satuan_body = $request->input('satuan_body');
            $id_accessories = $request->input('id_accessories');
            $harga_accessories = $request->input('harga_accessories');
            $qty_accessories = $request->input('qty_accessories');
            $qty_roll = $request->input('qty_roll');
            $bagian = $request->input('bagian');
            $warna_id   = $request->input('warna_id');
            $paket   = $request->input('paket');

            if ($paket == 1) {
                if (empty($qty_accessories)) {
                    return response()->json(['message' => 'error_paket']);
                }
            } else {
                // CEK QTY ACCESSORIES DULU
                if ($id_accessories !== null && $id_accessories !== '') {
                    $dacs       = TipeKainAccessories::with('accessories')->where('id', $id_accessories)->first();
                    $asc        = substr($dacs['accessories']['name'], 0, 3);
                    if ($satuan_body == "ROLL") {
                        $qty_bdy = $qty_body * 25; // 1 roll = 25 kg
                    } else {
                        $qty_bdy = $qty_body;
                    }
                    $qty_max = 0;
                    if ($asc == "KER") {
                        $qty_max = 0;
                    } elseif ($asc == "MAN") {
                        $qty_max = 0;
                    } elseif ($asc == "RIB") {
                        $percent = 5 / 100;
                        $qty_max = $qty_bdy * $percent;
                        $qty_max = number_format($qty_max, 2);
                    } elseif ($asc == "BUR") {
                        $percent = 20 / 100;
                        $qty_max = $qty_bdy * $percent;
                        $qty_max = number_format($qty_max, 2);
                    }

                    if ($qty_accessories > $qty_max) {
                        return response()->json(['message' => 'error_max']);
                    } else {
                        $keranjangBody = Keranjang::where([
                            ['tipe_kain_id', $id_body], ['customer_id', $customer_id], ['checkout', 0],
                            ['warna_id', $warna_id], ['satuan', $satuan_body]
                        ])->first();

                        if (!isset($keranjangBody)) {
                            Keranjang::create([
                                'tipe_kain_id' => $id_body,
                                'bagian'       => $bagian,
                                'warna_id' => 0,
                                'customer_id' => $customer_id,
                                'qty' => $qty_body,
                                'accesories_id' => $id_accessories ?? 0,
                                'checkout' => 0,
                                'satuan' => $satuan_body,
                                'warna_id'  => $warna_id
                            ]);
                        } else {
                            Keranjang::where([
                                ['tipe_kain_id', $id_body], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id], ['satuan', $satuan_body]
                            ])->update([
                                'qty' => $keranjangBody->qty + $qty_body,
                            ]);
                        }

                        if ($id_accessories !== null && $id_accessories !== '') {
                            $keranjangAccessories = Keranjang::where([
                                ['tipe_kain_id', $id_accessories], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id]
                            ])->first();

                            if (!isset($keranjangAccessories)) {
                                Keranjang::create([
                                    'tipe_kain_id' => $id_accessories,
                                    'bagian'        => 'accessories',
                                    'warna_id' => 0,
                                    'customer_id' => $customer_id,
                                    'qty' => $qty_accessories,
                                    'accesories_id' => 0,
                                    'checkout' => 0,

                                    'satuan' => $satuan_body,

                                    'warna_id'  => $warna_id
                                ]);
                            } else {
                                Keranjang::where([
                                    ['tipe_kain_id', $id_accessories], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id]
                                ])->update([
                                    'qty' => $keranjangAccessories->qty + $qty_accessories,
                                ]);
                            }
                        }

                        return response()->json(['message' => 'sukses']);
                    }
                } else {
                    $keranjangBody = Keranjang::where([
                        ['tipe_kain_id', $id_body], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id], ['satuan', $satuan_body]
                    ])->first();

                    if (!isset($keranjangBody)) {
                        Keranjang::create([
                            'tipe_kain_id'  => $id_body,
                            'bagian'        => $bagian,
                            'warna_id'      => 0,
                            'customer_id'   => $customer_id,
                            'qty'           => $qty_body,
                            'accesories_id' => $id_accessories ?? 0,
                            'checkout'      => 0,
                            'satuan'        => $satuan_body,
                            'warna_id'      => $warna_id
                        ]);
                    } else {
                        Keranjang::where([
                            ['tipe_kain_id', $id_body], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id], ['satuan', $satuan_body]
                        ])->update([
                            'qty' => $keranjangBody->qty + $qty_body,
                        ]);
                    }

                    if ($id_accessories !== null && $id_accessories !== '') {
                        $keranjangAccessories = Keranjang::where([
                            ['tipe_kain_id', $id_accessories], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id]
                        ])->first();

                        if (!isset($keranjangAccessories)) {
                            Keranjang::create([
                                'tipe_kain_id' => $id_accessories,
                                'bagian'        => 'accessories',
                                'warna_id' => 0,
                                'customer_id' => $customer_id,
                                'qty' => $qty_accessories,
                                'accesories_id' => 0,
                                'checkout' => 0,

                                'satuan' => $satuan_body,

                                'warna_id'  => $warna_id
                            ]);
                        } else {
                            Keranjang::where([
                                ['tipe_kain_id', $id_accessories], ['customer_id', $customer_id], ['checkout', 0], ['warna_id', $warna_id]
                            ])->update([
                                'qty' => $keranjangAccessories->qty + $qty_accessories,
                            ]);
                        }
                    }

                    return response()->json(['message' => 'sukses']);
                }
            }
        } else {
            $id_body = $request->input('id_body');
            $harga_body = $request->input('harga_body');
            $qty_body = $request->input('qty_body');
            $satuan_body = $request->input('satuan_body');
            $id_accessories = $request->input('id_accessories');
            $harga_accessories = $request->input('harga_accessories');
            $qty_accessories = $request->input('qty_accessories');
            $qty_roll = $request->input('qty_roll');
            $bagian = $request->input('bagian');
            $warna_id   = $request->input('warna_id');
            $grp = 0;

            // CEK QTY ACCESSORIES
            if (!empty($id_accessories)) {
                $dacs       = TipeKainAccessories::with('accessories')->where('id', $id_accessories)->first();
                $asc        = substr($dacs['accessories']['name'], 0, 3);

                if ($satuan_body == "ROLL") {
                    $qty_bdy = $qty_body * 25; // 1 roll = 25 kg
                } else {
                    $qty_bdy = $qty_body;
                }
                $qty_max = 0;
                if ($asc == "KER") {
                    $qty_max = 0;
                } elseif ($asc == "MAN") {
                    $qty_max = 0;
                } elseif ($asc == "RIB") {
                    $percent = 5 / 100;
                    $qty_max = $qty_bdy * $percent;
                    $qty_max = number_format($qty_max, 2);
                } elseif ($asc == "BUR") {
                    $percent = 20 / 100;
                    $qty_max = $qty_bdy * $percent;
                    $qty_max = number_format($qty_max, 2);
                }

                $grp = Str::random(3);
                if ($qty_accessories > $qty_max) {
                    return response()->json(['message' => 'error_max']);
                } else {
                    $body = [
                        [
                            'grp' => $grp,
                            'id_product' => $id_body,
                            'harga' => $harga_body,
                            'qty' => $qty_body,
                            'satuan' => $satuan_body,
                            'harga_body' => $harga_body,
                            'harga_asc' => $harga_accessories,
                            'bagian' => 'body',
                            'parent_id' => 0,
                            'qty_roll' => $qty_roll,
                            'warna_id'  => $warna_id,
                            'id_accessories' => 0
                        ],
                    ];
                    $accessories = [];
                    if (!empty($id_accessories)) {
                        $accessories = [
                            [
                                'grp' => $grp,
                                'id_product' => $id_accessories,
                                'harga' => $harga_accessories,
                                'qty' => $qty_accessories,
                                'satuan' => $satuan_body,
                                'harga_body' => $harga_body,
                                'harga_asc' => $harga_accessories,
                                'bagian' => 'accessories',
                                'parent_id' => $id_body,
                                'qty_roll' => $qty_roll,
                                'warna_id'  => $warna_id,
                                'id_accessories' => 0
                            ],
                        ];
                    }

                    $combinedArray = array_merge($body, $accessories);
                    $body_details = array();
                    foreach ($combinedArray as $key => $item) {
                        $satuan = $item['satuan'];

                        if ($satuan == "KG") {
                            $body_details[] = [
                                'grp' => $grp,
                                'tipe_kain_id' => $item['id_product'],
                                'qty' => $item['qty'],
                                'satuan' => $item['satuan'],
                                'bagian' => $item['bagian'],
                                'harga_body' => $item['harga_body'],
                                'harga_asc' => $item['harga_asc'],
                                'parent_id' => $item['parent_id'],
                                'qty_roll' => $item['qty_roll'],
                                'warna_id'  => $item['warna_id'],
                                'id_accessories' => $item['id_accessories']
                            ];
                        } else {
                            $body_details[] = [
                                'grp' => $grp,
                                'tipe_kain_id' => $item['id_product'],
                                'qty' => $item['qty'],
                                'satuan' => $item['satuan'],
                                'bagian' => $item['bagian'],
                                'harga_body' => $item['harga_body'],
                                'harga_asc' => $item['harga_asc'],
                                'parent_id' => $item['parent_id'],
                                'qty_roll' => $item['qty_roll'],
                                'warna_id'  => $item['warna_id'],
                                'id_accessories' => $item['id_accessories']
                            ];
                        }
                    }
                    // CEK DATA KERANJANG
                    $cartData = $this->getCartDataFromCookie();

                    if ($cartData) {
                        $updatedCartData = [];
                        foreach ($body_details as $item) {
                            $found = false;

                            foreach ($cartData as $index => $cartItem) {
                                if ($cartItem['tipe_kain_id'] == $item['tipe_kain_id'] && $cartItem['satuan'] == $item['satuan']) {

                                    if ($cartItem['bagian'] === 'accessories' && $cartItem['parent_id'] == $id_body) {
                                        $cartData[$index]['qty'] += $item['qty'];
                                        $found = true;
                                        break;
                                    }
                                    if ($cartItem['bagian'] === 'body') {
                                        $cartData[$index]['qty'] += $item['qty'];
                                        $found = true;
                                        break;
                                    }
                                }
                            }
                            if (!$found) {
                                $updatedCartData[] = $item;
                            }
                        }
                        $cartData = array_merge($cartData, $updatedCartData);
                    } else {
                        $cartData = $body_details;
                    }
                    $this->setCartDataToCookie($cartData);
                    // return response()->json(['datas' => $cartData]);
                    return response()->json(['message' => 'sukses']);
                    // return response()->json(['message' => 'Item berhasil ditambahkan!']);
                }
            } else {
                $grp = Str::random(3);
                $body = [
                    [
                        'grp' => $grp,
                        'id_product' => $id_body,
                        'harga' => $harga_body,
                        'qty' => $qty_body,
                        'satuan' => $satuan_body,
                        'harga_body' => $harga_body,
                        'harga_asc' => $harga_accessories,
                        'bagian' => 'body',
                        'parent_id' => 0,
                        'qty_roll' => $qty_roll,
                        'warna_id'  => $warna_id,
                        'id_accessories' => $id_accessories
                    ],
                ];
                $accessories = [];
                if (!empty($id_accessories)) {
                    $accessories = [
                        [
                            'grp' => $grp,
                            'id_product' => $id_accessories,
                            'harga' => $harga_accessories,
                            'qty' => $qty_accessories,
                            'satuan' => $satuan_body,
                            'harga_body' => $harga_body,
                            'harga_asc' => $harga_accessories,
                            'bagian' => 'accessories',
                            'parent_id' => $id_body,
                            'qty_roll' => $qty_roll,
                            'warna_id'  => $warna_id,
                            'id_accessories' => 0
                        ],
                    ];
                }

                $combinedArray = array_merge($body, $accessories);
                $body_details = array();
                foreach ($combinedArray as $key => $item) {
                    $satuan = $item['satuan'];
                    if ($satuan == "KG") {
                        $body_details[] = [
                            'grp' => $grp,
                            'tipe_kain_id' => $item['id_product'],
                            'qty' => $item['qty'],
                            'satuan' => $item['satuan'],
                            'bagian' => $item['bagian'],
                            'harga_body' => $item['harga_body'],
                            'harga_asc' => $item['harga_asc'],
                            'parent_id' => $item['parent_id'],
                            'qty_roll' => $item['qty_roll'],
                            'warna_id'  => $item['warna_id'],
                            'id_accessories' => $item['id_accessories']
                        ];
                    } else {
                        $body_details[] = [
                            'grp' => $grp,
                            'tipe_kain_id' => $item['id_product'],
                            'qty' => $item['qty'],
                            'satuan' => $item['satuan'],
                            'bagian' => $item['bagian'],
                            'harga_body' => $item['harga_body'],
                            'harga_asc' => $item['harga_asc'],
                            'parent_id' => $item['parent_id'],
                            'qty_roll' => $item['qty_roll'],
                            'warna_id'  => $item['warna_id'],
                            'id_accessories' => $item['id_accessories']
                        ];
                    }
                }
                // CEK DATA KERANJANG
                $cartData = $this->getCartDataFromCookie();

                if ($cartData) {
                    $updatedCartData = [];
                    foreach ($body_details as $item) {
                        $found = false;

                        foreach ($cartData as $index => $cartItem) {
                            if ($cartItem['tipe_kain_id'] == $item['tipe_kain_id'] && $cartItem['satuan'] == $item['satuan']) {

                                if ($cartItem['bagian'] === 'accessories' && $cartItem['parent_id'] == $id_body) {
                                    $cartData[$index]['qty'] += $item['qty'];
                                    $found = true;
                                    break;
                                }

                                if ($cartItem['bagian'] === 'body') {
                                    $cartData[$index]['qty'] += $item['qty'];
                                    $found = true;
                                    break;
                                }
                            }
                        }
                        if (!$found) {
                            $updatedCartData[] = $item;
                        }
                    }
                    $cartData = array_merge($cartData, $updatedCartData);
                } else {
                    $cartData = $body_details;
                }
                $this->setCartDataToCookie($cartData);
                // return response()->json(['datas' => $cartData]);
                return response()->json(['message' => 'sukses']);
                // return response()->json(['message' => 'Item berhasil ditambahkan!']);
            }
        }
    }

    public function usemaxacs(Request $request)
    {
        $id_body        = $request->id_bdy;
        $satuan_bdy     = $request->satuan_bdy;
        $id_acs         = $request->id_acs;
        $qty_bdy        = $request->qty_bdy;

        $dbody      = TipeKain::where('id', $id_body)->first();
        $qty_roll   = $dbody->qty_roll;
        $dacs       = TipeKainAccessories::with([
            'accessories'
        ])->where('id', $id_acs)->first();

        $asc     = substr($dacs['accessories']['name'], 0, 3);
        // $asc ="";
        if ($satuan_bdy == "ROLL") {
            $qty_bdy = $qty_bdy * 25; // 1 roll = 25 kg
        }
        $qty_max = 0;
        if ($asc == "RIB") {
            $percent = 5 / 100;
            $qty_max = $qty_bdy * $percent;
            $qty_max = number_format($qty_max, 2);
        } elseif ($asc == "BUR") {
            $percent = 20 / 100;
            $qty_max = $qty_bdy * $percent;
            $qty_max = number_format($qty_max, 2);
        } else {
            // $percent = 22 / 100;
            // $qty_max = $qty_bdy * $percent;
            $qty_max = 0;
        }

        $data = [
            'callback'  => $qty_max,
            // 'hasil'     => $result
        ];

        return $data;
    }

    private function getCartDataFromCookie()
    {
        $cartData = Cookie::get('cart');
        return $cartData ? json_decode($cartData, true) : [];
    }

    private function setCartDataToCookie($cartData)
    {
        Cookie::queue('cart', json_encode($cartData), 43200);
    }
}
