<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Barang\TipeKainAccessories;
use App\Models\Barang\TipeKainPrices;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerAdress;
use App\Models\Customer\CustomerService;
use App\Models\Kain\Accessories;
use App\Models\Keranjang;
use App\Models\Pesanan\DetailPesanan;
use App\Models\Pesanan\Pesanan;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Browser;

class CartController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $id                 = Auth::user()->customer_id;
            $customer           = Customer::with('customer_category')->where('id', $id)->first();
            $customerCategoryID = $customer->customer_category_id;
        } else {
            $customerCategoryID = 1;
        }
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
        if (auth()->user() && auth()->user()->customer_id) {
            $id = auth()->user()->customer_id;
            // GET KERANJANG
            $cartData = Keranjang::where([['customer_id', $id], ['checkout', 0]])->get();

            $tipekainDetails = [];
            $bodyData = null;
            $accessoriesData = null;
            foreach ($cartData as $item) {
                $tipeKainId = $item['tipe_kain_id'];
                $bagian     = $item['bagian'];
                $satuan     = $item['satuan'];


                if ($bagian === 'body') {
                    $bodyData = $item;
                } else {
                    $accessoriesData = $item;
                }

                if ($bodyData && $accessoriesData) {
                    $tipeKainId = $bodyData['tipe_kain_id'];
                    $accessoriesId = $accessoriesData['tipe_kain_id'];

                    //     // harusnya pakai ini
                    $latestDate = TipeKainPrices::max('periode');
                    $tipekain = TipeKain::with([
                        'jenis_kain', 'lebar', 'gramasi', 'satuan', 'warna',
                        'tipekainacs' => function ($query) use ($accessoriesId) {
                            $query->where('id', $accessoriesId)
                                ->with([
                                    'accessories'
                                ]);
                        },
                        'prices' => function ($query) use ($satuan, $latestDate) {
                            $query->where([
                                ['customer_category_id', 1],
                                ['tipe', $satuan],
                                ['periode', $latestDate]
                            ]);
                        }
                    ])
                        ->where('id', $tipeKainId)
                        ->first();

                    if ($tipekain) {
                        $tipekainDetails[] = $tipekain;
                    }
                }
            }
        } else {
            $cartData = $this->getCartDataFromCookie();
            $tipekainDetails = [];
            $bodyData = null;
            $accessoriesData = null;
            foreach ($cartData as $item) {
                $tipeKainId = $item['tipe_kain_id'];
                $bagian     = $item['bagian'];
                $satuan     = $item['satuan'];


                if ($bagian === 'body') {
                    $bodyData = $item;
                } else {
                    $accessoriesData = $item;
                }

                if ($bodyData && $accessoriesData) {
                    $tipeKainId = $bodyData['tipe_kain_id'];
                    $accessoriesId = $accessoriesData['tipe_kain_id'];

                    //     // harusnya pakai ini
                    $latestDate = TipeKainPrices::max('periode');
                    $tipekain = TipeKain::with([
                        'jenis_kain', 'lebar', 'gramasi', 'satuan', 'warna',
                        'tipekainacs' => function ($query) use ($accessoriesId) {
                            $query->where('id', $accessoriesId)
                                ->with([
                                    'accessories'
                                ]);
                        },
                        'prices' => function ($query) use ($satuan, $latestDate) {
                            $query->where([
                                ['customer_category_id', 1],
                                ['tipe', $satuan],
                                ['periode', $latestDate]
                            ]);
                        }
                    ])
                        ->where('id', $tipeKainId)
                        ->first();

                    if ($tipekain) {
                        $tipekainDetails[] = $tipekain;
                    }
                }
            }
        }

        // echo json_encode([
        //     'cartdata'  => $cartData,
        //     'tipekain'  => $tipekainDetails,
        // ], JSON_PRETTY_PRINT);
        return view('cart.cart-index', [
            'data'      => $data,
            'cartdata'  => $cartData,
            'tipekain'  => $tipekainDetails,
            'cust_cat'  => $customerCategoryID,
        ]);
    }

    public function updateKeranjangs(Request $request)
    {
        $customer_id    = auth()->user()->customer_id;
        $id             = $request->input('id');
        $id_keranjangs  = $request->input('id_keranjang');
        $qty            = $request->input('qty');
        foreach ($id_keranjangs as $index => $id_keranjang) {
            $newQty         = $qty[$index];
            $tipe_kain_id   = $id[$index];
            //     $id_keranjang;
            $keranjang = Keranjang::where('customer_id', $customer_id)
                ->where('id', $id_keranjang)
                ->where('tipe_kain_id', $tipe_kain_id)
                ->first();
            if ($keranjang) {
                $keranjang->update([
                    'qty' => $newQty,
                ]);
            } else {
            }
        }
        $request->session()->flash('success', 'Data siap di checkout.');
        return redirect('/checkout-index');
    }

    public function checkout_index()
    {
        $customer_id = auth()->user()->customer_id;
        $data_cust = Customer::where('id', $customer_id)->firstOrFail();

        $customerCategoryID = $data_cust['customer_category_id'];
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
        $cartData = Keranjang::where([['customer_id', $customer_id], ['checkout', 0]])->get();
        $cust_address = CustomerAdress::where('customer_id', $customer_id)->orderBy('primary', 'DESC')->get();
        $address_primary = CustomerAdress::where([
            'customer_id' => $customer_id,
            'primary' => 1
        ])->select('id', 'category', 'name', 'full_address')->first();

        // echo json_encode([
        //     'data'      => $data,
        //     'cards'     => $cards,
        //     'data_cust' => $data_cust,
        //     'cartdata'  => $cartData,
        //     'tipekain'  => $tipekainDetails
        // ], JSON_PRETTY_PRINT);
        return view('cart.checkout-index', [
            'data'      => $data,
            'data_cust' => $data_cust,
            'cartdata'  => $cartData,
            'cust_cat'  => $customerCategoryID,
            'address' => $cust_address,
            'address_primary' => $address_primary
        ]);
    }

    public function store_(Request $request)
    {
        $customer_id    = auth()->user()->customer_id;
        $target_kebutuhan  = $request->target_kebutuhan;
        $alamat_kirim  = $request->alamat_kirim;
        $catatan  = $request->catatan;
        $nomor = 'SO.' . date('Ymdhis');

        $keranjang = Keranjang::with('tipe_kain')->where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();

        $pesanan = Pesanan::create([
            'nomor' => $nomor,
            'customer_id' => $customer_id,
            'sales_man_id' => 0,
            'customer_service_id' => $this->getCs(5),
            'tanggal_pesanan' => date("Y-m-d"),
            'target_pesanan'    => $target_kebutuhan,
            'status_pesanan_id' => 1,
            'status_kode' => 'Draft',
            'alamat_kirim'  => $alamat_kirim,
            'bukti_pelunasan' => 'N/A',
            'catatan'   => $catatan,
            'created_by' => auth()->user()->id,
            'created_by_host' => $request->ip(),
            'created_by_device' => Browser::browserName()
        ]);
        $all_data = [];
        $qty_bodyy = 0;
        foreach ($keranjang as $key => $item) {
            if ($item->satuan === 'ROLL') {
                if ($item->bagian == "body") {
                    $qty_roll = $item->tipe_kain->qty_roll;
                    for ($i = 1; $i <= $item->qty; $i++) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => 1,
                            'qty_act'       => $item->tipe_kain->qty_roll,
                            'satuan'        => 'ROLL',
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        // DetailPesanan::insert($data_roll);
                        $all_data[] = $data_roll;
                    }
                } else {
                    $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
                    $data_roll = [
                        'pesanan_id'    => $pesanan->id,
                        'tipe_kain_id'  => $item->tipe_kain_id,
                        'warna_id'      => $item->warna_id,
                        'qty'           => $item->qty,
                        'qty_act'       => $item->qty,
                        'satuan'        => $item->satuan,
                        'parent_id'     => $body_id,
                        'bagian'        => $item->bagian,
                        'created_by'    => auth()->user()->id
                    ];
                    // DetailPesanan::insert($data_asc);
                    $all_data[] = $data_roll;
                }
            } else if ($item->satuan === "ECER") {
                if ($item->bagian == "body") {
                    $qty_bodyy = $item->qty;
                    $qty_roll = $item->tipe_kain->qty_roll;

                    $qtykg = $item->qty;
                    $bagian = intval($qtykg / $qty_roll);
                    $sisa = $qtykg % $qty_roll;

                    for ($i = 0; $i < $bagian; $i++) {

                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => 1,
                            'qty_act'       => $item->tipe_kain->qty_roll,
                            'satuan'        => 'ROLL',
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id

                        ];
                        // DetailPesanan::insert($data_bodyroll);
                        $all_data[] = $data_roll;
                    }
                    if ($sisa > 0) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => $sisa,
                            'qty_act'       => $sisa,
                            'satuan'        => $item->satuan,
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        // DetailPesanan::insert($data_body);
                        $all_data[] = $data_roll;
                    }

                    // DetailPesanan::insert($data_body);
                } else {
                    if ($qty_bodyy >= 25) {
                        $ssatuan = 'ROLL';
                    } else {
                        $ssatuan = $item->satuan;
                    }

                    $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
                    $data_roll = [
                        'pesanan_id'    => $pesanan->id,
                        'tipe_kain_id'  => $item->tipe_kain_id,
                        'warna_id'      => $item->warna_id,
                        'qty'           => $item->qty,
                        'qty_act'       => $item->qty,
                        'satuan'        => $ssatuan,
                        'parent_id'     => $body_id,
                        'bagian'        => $item->bagian,
                        'created_by'    => auth()->user()->id
                    ];
                    // DetailPesanan::insert($data_asc);
                    $all_data[] = $data_roll;
                }
            } else {
                if ($item->bagian == "body") {
                    $qty_bodyy  = $item->qty;
                    $qty_roll   = $item->tipe_kain->qty_roll;
                    $qtykg      = $item->qty;
                    $bagian     = intval($qtykg / $qty_roll);
                    $sisa       = $qtykg % $qty_roll;

                    for ($i = 0; $i < $bagian; $i++) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => 1,
                            'qty_act'       => $item->tipe_kain->qty_roll,
                            'satuan'        => 'ROLL',
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        // DetailPesanan::insert($data_bodyroll);

                        $all_data[] = $data_roll;
                    }
                    if ($sisa > 0) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => $sisa,
                            'qty_act'       => $sisa,
                            'satuan'        => $item->satuan,
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];

                        // DetailPesanan::insert($data_body);
                        $all_data[] = $data_roll;
                    }

                    // DetailPesanan::insert($data_body);

                } else {
                    if ($qty_bodyy >= 25) {
                        $ssatuan = 'ROLL';
                    } else {
                        $ssatuan = $item->satuan;
                    }

                    $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
                    $data_roll = [
                        'pesanan_id'    => $pesanan->id,
                        'tipe_kain_id'  => $item->tipe_kain_id,
                        'warna_id'      => $item->warna_id,
                        'qty'           => $item->qty,
                        'qty_act'       => $item->qty,
                        'satuan'        => $ssatuan,
                        'parent_id'     => $body_id,
                        'bagian'        => $item->bagian,
                        'created_by'    => auth()->user()->id
                    ];

                    // DetailPesanan::insert($data_asc);
                    $all_data[] = $data_roll;
                }

                // }else{
                if ($item->bagian == "body") {
                    $qty_bodyy  = $item->qty;
                    $qty_roll   = $item->tipe_kain->qty_roll;
                    $qtykg      = $item->qty;
                    $bagian     = intval($qtykg / $qty_roll);
                    $sisa       = $qtykg % $qty_roll;

                    for ($i = 0; $i < $bagian; $i++) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => 1,
                            'qty_act'       => $item->tipe_kain->qty_roll,
                            'satuan'        => 'ROLL',
                            'parent_id'     => 0,
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        // DetailPesanan::insert($data_roll);
                        $all_data[] = $data_roll;
                    }
                    if ($sisa > 0) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => $sisa,
                            'qty_act'       => $sisa,
                            'satuan'        => $item->satuan,
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        $all_data[] = $data_roll;
                        // DetailPesanan::insert($data_sisa);
                    }
                } else {
                    if ($qty_bodyy >= 25) {
                        $ssatuan = 'ROLL';
                    } else {
                        $ssatuan = $item->satuan;
                    }
                    $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
                    $data_roll = [
                        'pesanan_id'    => $pesanan->id,
                        'tipe_kain_id'  => $item->tipe_kain_id,
                        'warna_id'      => $item->warna_id,
                        'qty'           => $item->qty,
                        'qty_act'       => $item->qty,
                        'satuan'        => $ssatuan,
                        'parent_id'     => $body_id,
                        'bagian'        => $item->bagian,
                        'created_by'    => auth()->user()->id
                    ];

                    $all_data[] = $data_roll;
                    // DetailPesanan::insert($data_asc);
                }
            }
        }
        DetailPesanan::insert($all_data);
        // echo json_encode($all_data, JSON_PRETTY_PRINT);
        Keranjang::where('customer_id', $customer_id)->update(['checkout' => 1, 'updated_by' => auth()->user()->id]);

        $request->session()->flash('success_pesan', 'Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.');

        return redirect('/dashboard');
    }

    public function store(Request $request)
    {
        $customer_id    = auth()->user()->customer_id;
        $target_kebutuhan  = $request->target_kebutuhan;
        $alamat_kirim  = $request->alamat_kirim;
        $catatan  = $request->catatan;
        $address_id = $request->addr_id;
        $nomor = 'SO.' . date('Ymdhis');

        $keranjang = Keranjang::with('tipe_kain')->where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();

        $pesanan = Pesanan::create([
            'nomor' => $nomor,
            'customer_id' => $customer_id,
            'sales_man_id' => 0,
            'customer_service_id' => $this->getCs(5),
            'tanggal_pesanan' => date("Y-m-d"),
            'target_pesanan'    => $target_kebutuhan,
            'status_pesanan_id' => 1,
            'status_kode' => 'Draft',
            'alamat_kirim'  => $alamat_kirim,
            'penerima'  => $request->penerima,
            'bukti_pelunasan' => 'N/A',
            'catatan'   => $catatan,
            'created_by' => auth()->user()->id,
            'created_by_host' => $request->ip(),
            'created_by_device' => Browser::browserName()
        ]);
        CustomerAdress::where([['id', $address_id], ['customer_id', $customer_id]])->update([
            'primary' => 1
        ]);
        CustomerAdress::where([['id', '!=', $address_id], ['customer_id', $customer_id]])->update([
            'primary' => 0
        ]);

        $all_data = [];
        $qty_bodyy = 0;
        foreach ($keranjang as $key => $item) {
            if ($item->bagian == "body") {
                $qty_roll = $item->tipe_kain->qty_roll;
                if ($item->satuan === 'ROLL') {
                    for ($i = 1; $i <= $item->qty; $i++) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => 1,
                            'qty_act'       => $item->tipe_kain->qty_roll,
                            'satuan'        => 'ROLL',
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        // DetailPesanan::insert($data_roll);
                        $all_data[] = $data_roll;
                    }
                } else {
                    $qty_bodyy = $item->qty;
                    $qty_roll = $item->tipe_kain->qty_roll;

                    $qtykg = $item->qty;
                    $bagian = intval($qtykg / $qty_roll);
                    $sisa = $qtykg % $qty_roll;

                    for ($i = 0; $i < $bagian; $i++) {

                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => 1,
                            'qty_act'       => $item->tipe_kain->qty_roll,
                            'satuan'        => 'ROLL',
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id

                        ];
                        // DetailPesanan::insert($data_bodyroll);
                        $all_data[] = $data_roll;
                    }
                    if ($sisa > 0) {
                        $data_roll = [
                            'pesanan_id'    => $pesanan->id,
                            'tipe_kain_id'  => $item->tipe_kain_id,
                            'warna_id'      => $item->warna_id,
                            'qty'           => $sisa,
                            'qty_act'       => $sisa,
                            'satuan'        => $item->satuan,
                            'parent_id'     => '0',
                            'bagian'        => $item->bagian,
                            'created_by'    => auth()->user()->id
                        ];
                        // DetailPesanan::insert($data_body);
                        $all_data[] = $data_roll;
                    }
                }
            } else {
                $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
                $data_roll = [
                    'pesanan_id'    => $pesanan->id,
                    'tipe_kain_id'  => $item->tipe_kain_id,
                    'warna_id'      => $item->warna_id,
                    'qty'           => $item->qty,
                    'qty_act'       => $item->qty,
                    'satuan'        => $item->satuan,
                    'parent_id'     => $body_id,
                    'bagian'        => $item->bagian,
                    'created_by'    => auth()->user()->id
                ];
                // DetailPesanan::insert($data_asc);
                $all_data[] = $data_roll;
            }
            // =========== old
            // if ($item->satuan === 'ROLL') {
            //     if ($item->bagian == "body") {
            //         $qty_roll = $item->tipe_kain->qty_roll;
            //         for ($i = 1; $i <= $item->qty; $i++) {
            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => 1,
            //                 'qty_act'       => $item->tipe_kain->qty_roll,
            //                 'satuan'        => 'ROLL',
            //                 'parent_id'     => '0',
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id
            //             ];
            //             // DetailPesanan::insert($data_roll);
            //             $all_data[] = $data_roll;
            //         }
            //     } else {
            //         $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
            //         $data_roll = [
            //             'pesanan_id'    => $pesanan->id,
            //             'tipe_kain_id'  => $item->tipe_kain_id,
            //             'warna_id'      => $item->warna_id,
            //             'qty'           => $item->qty,
            //             'qty_act'       => $item->qty,
            //             'satuan'        => $item->satuan,
            //             'parent_id'     => $body_id,
            //             'bagian'        => $item->bagian,
            //             'created_by'    => auth()->user()->id
            //         ];
            //         // DetailPesanan::insert($data_asc);
            //         $all_data[] = $data_roll;
            //     }
            // } else if ($item->satuan === "ECER") {
            //     if ($item->bagian == "body") {
            //         $qty_bodyy = $item->qty;
            //         $qty_roll = $item->tipe_kain->qty_roll;

            //         $qtykg = $item->qty;
            //         $bagian = intval($qtykg / $qty_roll);
            //         $sisa = $qtykg % $qty_roll;

            //         for ($i = 0; $i < $bagian; $i++) {

            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => 1,
            //                 'qty_act'       => $item->tipe_kain->qty_roll,
            //                 'satuan'        => 'ROLL',
            //                 'parent_id'     => '0',
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id

            //             ];
            //             // DetailPesanan::insert($data_bodyroll);
            //             $all_data[] = $data_roll;
            //         }
            //         if ($sisa > 0) {
            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => $sisa,
            //                 'qty_act'       => $sisa,
            //                 'satuan'        => $item->satuan,
            //                 'parent_id'     => '0',
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id
            //             ];
            //             // DetailPesanan::insert($data_body);
            //             $all_data[] = $data_roll;
            //         }

            //         // DetailPesanan::insert($data_body);
            //     } else {
            //         if ($qty_bodyy >= 25) {
            //             $ssatuan = 'ROLL';
            //         } else {
            //             $ssatuan = $item->satuan;
            //         }

            //         $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
            //         $data_roll = [
            //             'pesanan_id'    => $pesanan->id,
            //             'tipe_kain_id'  => $item->tipe_kain_id,
            //             'warna_id'      => $item->warna_id,
            //             'qty'           => $item->qty,
            //             'qty_act'       => $item->qty,
            //             'satuan'        => $ssatuan,
            //             'parent_id'     => $body_id,
            //             'bagian'        => $item->bagian,
            //             'created_by'    => auth()->user()->id
            //         ];
            //         // DetailPesanan::insert($data_asc);
            //         $all_data[] = $data_roll;
            //     }
            // } else {
            //     if ($item->bagian == "body") {
            //         $qty_bodyy  = $item->qty;
            //         $qty_roll   = $item->tipe_kain->qty_roll;
            //         $qtykg      = $item->qty;
            //         $bagian     = intval($qtykg / $qty_roll);
            //         $sisa       = $qtykg % $qty_roll;

            //         for ($i = 0; $i < $bagian; $i++) {
            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => 1,
            //                 'qty_act'       => $item->tipe_kain->qty_roll,
            //                 'satuan'        => 'ROLL',
            //                 'parent_id'     => '0',
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id
            //             ];
            //             // DetailPesanan::insert($data_bodyroll);

            //             $all_data[] = $data_roll;
            //         }
            //         if ($sisa > 0) {
            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => $sisa,
            //                 'qty_act'       => $sisa,
            //                 'satuan'        => $item->satuan,
            //                 'parent_id'     => '0',
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id
            //             ];

            //             // DetailPesanan::insert($data_body);
            //             $all_data[] = $data_roll;
            //         }

            //         // DetailPesanan::insert($data_body);

            //     } else {
            //         if ($qty_bodyy >= 25) {
            //             $ssatuan = 'ROLL';
            //         } else {
            //             $ssatuan = $item->satuan;
            //         }

            //         $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
            //         $data_roll = [
            //             'pesanan_id'    => $pesanan->id,
            //             'tipe_kain_id'  => $item->tipe_kain_id,
            //             'warna_id'      => $item->warna_id,
            //             'qty'           => $item->qty,
            //             'qty_act'       => $item->qty,
            //             'satuan'        => $ssatuan,
            //             'parent_id'     => $body_id,
            //             'bagian'        => $item->bagian,
            //             'created_by'    => auth()->user()->id
            //         ];

            //         // DetailPesanan::insert($data_asc);
            //         $all_data[] = $data_roll;
            //     }

            //     // }else{
            //     if ($item->bagian == "body") {
            //         $qty_bodyy  = $item->qty;
            //         $qty_roll   = $item->tipe_kain->qty_roll;
            //         $qtykg      = $item->qty;
            //         $bagian     = intval($qtykg / $qty_roll);
            //         $sisa       = $qtykg % $qty_roll;

            //         for ($i = 0; $i < $bagian; $i++) {
            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => 1,
            //                 'qty_act'       => $item->tipe_kain->qty_roll,
            //                 'satuan'        => 'ROLL',
            //                 'parent_id'     => 0,
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id
            //             ];
            //             // DetailPesanan::insert($data_roll);
            //             $all_data[] = $data_roll;
            //         }
            //         if ($sisa > 0) {
            //             $data_roll = [
            //                 'pesanan_id'    => $pesanan->id,
            //                 'tipe_kain_id'  => $item->tipe_kain_id,
            //                 'warna_id'      => $item->warna_id,
            //                 'qty'           => $sisa,
            //                 'qty_act'       => $sisa,
            //                 'satuan'        => $item->satuan,
            //                 'parent_id'     => '0',
            //                 'bagian'        => $item->bagian,
            //                 'created_by'    => auth()->user()->id
            //             ];
            //             $all_data[] = $data_roll;
            //             // DetailPesanan::insert($data_sisa);
            //         }
            //     } else {
            //         if ($qty_bodyy >= 25) {
            //             $ssatuan = 'ROLL';
            //         } else {
            //             $ssatuan = $item->satuan;
            //         }
            //         $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');
            //         $data_roll = [
            //             'pesanan_id'    => $pesanan->id,
            //             'tipe_kain_id'  => $item->tipe_kain_id,
            //             'warna_id'      => $item->warna_id,
            //             'qty'           => $item->qty,
            //             'qty_act'       => $item->qty,
            //             'satuan'        => $ssatuan,
            //             'parent_id'     => $body_id,
            //             'bagian'        => $item->bagian,
            //             'created_by'    => auth()->user()->id
            //         ];

            //         $all_data[] = $data_roll;
            //         // DetailPesanan::insert($data_asc);
            //     }
            // }
        }
        DetailPesanan::insert($all_data);
        // echo json_encode($all_data, JSON_PRETTY_PRINT);
        Keranjang::where('customer_id', $customer_id)->update(['checkout' => 1, 'updated_by' => auth()->user()->id]);

        // $request->session()->flash('success_pesan', 'Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.');

        // return redirect('/dashboard');
        return redirect()->route('dashboard')->with('success_pesan', 'Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.');
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

    function getCs($limit)
    {
        $cs = CustomerService::where('order_handle', '<=', $limit)->inRandomOrder()->first();
        return $cs->id ?? 0;
    }

    public function getNotificationBadge()
    {
        if (auth()->user() && auth()->user()->customer_id) {
            $customer_id = auth()->user()->customer_id;
            $id                 = Auth::user()->customer_id;
            $customer           = Customer::with('customer_category')->where('id', $id)->first();
            $customerCategoryID = $customer->customer_category_id;
            $cartData = Keranjang::where([['customer_id', $customer_id], ['checkout', 0]])->get();

            $totalHarga = 0;
            $subtotal_harga = 0;
            $subtotal_asc = 0;
            $harga_body = 0;
            $total_harga    = 0;

            if ($cartData) {
                foreach ($cartData as $item) {
                    $tipe_kain_id   = $item->tipe_kain_id;
                    $bagian         = $item->bagian;
                    $satuan         = $item->satuan;
                    $satuan_harga   = $satuan;
                    if ($satuan != "ROLL") {
                        $satuan_harga = "ECER";
                    }
                    // Harga Body
                    if ($bagian == "body") {
                        $data       = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                            ->where('id', $tipe_kain_id)->firstOrFail();

                        $qty_roll   = $data['qty_roll'];
                        $maxperiode = DB::table("tipe_kain_prices")->where([
                            ['tipe_kain_id', $tipe_kain_id],
                            ['tipe', $satuan_harga],
                            ['customer_category_id', $customerCategoryID],
                        ])->MAX('periode');

                        $daharga = DB::table("tipe_kain_prices")->where([
                            ['tipe_kain_id', $tipe_kain_id],
                            ['tipe', $satuan_harga],
                            ['customer_category_id', $customerCategoryID],
                            ['periode', $maxperiode]
                        ])->first();
                        $harga  = $daharga->harga;
                    } else {
                        $data       = TipeKainAccessories::where('id', $tipe_kain_id)->first();
                        $idasc      = $data['tipe_kain_id'];
                        $maxperiode = DB::table("tipe_kain_prices")->where([
                            ['tipe_kain_id', $idasc],
                            ['tipe', $satuan_harga],
                            ['customer_category_id', $customerCategoryID],
                        ])->MAX('periode');

                        $data       = DB::table('tipe_kain_accessories as tka')
                            ->leftJoin('accessories as acs', 'acs.id', '=', 'tka.accessories_id')
                            ->leftJoin('tipe_kain_prices as tkp', 'tkp.tipe_kain_id', '=', 'tka.tipe_kain_id')
                            ->where([
                                ['tka.id', $tipe_kain_id],
                                ['tkp.tipe_kain_id', $idasc],
                                ['tkp.tipe', $satuan_harga],
                                ['tkp.customer_category_id', $customerCategoryID],
                                ['tkp.periode', $maxperiode]
                            ])
                            ->selectRaw('tka.id,acs.harga_roll,acs.harga_ecer,tkp.harga')
                            ->first();
                        $harga_roll  = $data->harga_roll;
                        $harga_ecer  = $data->harga_ecer;
                        $harga_bdy   = $data->harga;

                        $harga  = $harga_bdy + $harga_roll;
                        if ($satuan != "ROLL") {
                            $harga  = $harga_bdy + $harga_ecer;
                        }
                    }


                    if ($satuan == 'ROLL') {
                        if ($bagian == "body") {
                            $subtotal = $item->qty * $qty_roll * $harga;
                        } else {
                            $subtotal = $item->qty * $harga;
                        }
                        // $subtotal = $item->qty * $hargaby;
                    } else {
                        $subtotal = $item->qty * $harga;
                    }

                    $total_harga += $subtotal;
                }
            }

            // $totalHarga = $subtotal_harga + $subtotal_asc;

            $notificationBadge = $cartData ? count($cartData) : 0;
            $response = [
                'notifbadge' => $notificationBadge,
                'total_harga' => $total_harga,
            ];

            return $response;
        } else {
            $notificationBadgeFromCookie = json_decode(Cookie::get('cart'), true);
            // $totalQty   = 0;
            $totalHarga = 0;
            if ($notificationBadgeFromCookie) {
                foreach ($notificationBadgeFromCookie as $item) {
                    $bagian = $item['bagian'];
                    $satuan = $item['satuan'];
                    if ($bagian == "body") {
                        if ($satuan == "ROLL") {
                            $harga_body = intval($item['harga_body'] * intval($item['qty']));
                            $harga      = $harga_body * $item['qty_roll'];
                        } else {
                            $harga = intval($item['harga_body'] * intval($item['qty']));
                        }
                    } else {
                        $harga_asc  = intval($item['harga_body']) + intval($item['harga_asc']);
                        $harga      = $harga_asc * floatval($item['qty']);
                    }
                    $qty = intval($item['qty']);
                    // // $totalQty += $qty;
                    $totalHarga += $harga;
                }
            }

            $notificationBadge = $notificationBadgeFromCookie ? count($notificationBadgeFromCookie) : 0;
            $response = [
                'notifbadge'    => $notificationBadge,
                // 'total_qty'     => $totalQty,
                'total_harga'   => $totalHarga
            ];
            return $response;
        }
    }

    public function getCartMobile()
    {
        if (auth()->user() && auth()->user()->customer_id) {
            $id = auth()->user()->customer_id;
            // GET KERANJANG
            $cartData = Keranjang::where([['customer_id', $id], ['checkout', 0]])->get();

            $tipekainDetails = [];
            foreach ($cartData as $item) {
                $tipeKainId = $item['tipe_kain_id'];
                $tipekain = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan', 'jenis_kain')->find($tipeKainId);

                if ($tipekain) {
                    $tipekainDetails[] = $tipekain;
                }
            }
            $callback = [
                'cartdata'  => $cartData,
                'tipekain'  => $tipekainDetails
            ];

            return response()->json($callback);
        } else {
            $cartData = $this->getCartDataFromCookie();
            $tipekainDetails = [];

            foreach ($cartData as $item) {
                $tipeKainId = $item['tipe_kain_id'];
                $tipekain = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan', 'jenis_kain')->find($tipeKainId);

                if ($tipekain) {
                    $tipekainDetails[] = $tipekain;
                }
            }

            $callback = [
                'cartdata'  => $cartData,
                'tipekain'  => $tipekainDetails
            ];

            return response()->json($callback);
        }
    }

    public function destroy_cart(Request $request)
    {
        $item_id    = $request->input('item_id');
        $grp = $request->grp;
        if (auth()->user() && auth()->user()->customer_id) {
            $keranjangItems = Keranjang::where([
                ['tipe_kain_id', $item_id],
                ['customer_id', auth()->user()->customer_id], ['checkout', 0]
            ]);
            if ($keranjangItems->first()) {
                $cartAccs = Keranjang::where([
                    ['bagian', 'accessories'], ['customer_id', auth()->user()->customer_id],
                    ['checkout', 0], ['warna_id', $keranjangItems->first()->warna_id],
                    ['created_at', $keranjangItems->first()->created_at]
                ])->get();
                foreach ($cartAccs as $key => $cartAcc) {
                    $cartAcc->delete();
                }
                $keranjangItems->delete();
            }
            // return response()->json(['id' => $item_id, 'id2' => $keranjangItems->first()->accesories_id]);
        } else {
            $cartData = $this->getCartDataFromCookie();

            $newCart = [];
            foreach ($cartData as $key => $cart) {
                if ($cart['grp'] != $grp) {
                    $newCart[] = $cart;
                }
            }
            $updatedCookieValue = json_encode($newCart);
            Cookie::queue('cart', $updatedCookieValue);

            // $index = array_search($grp, array_column($cartData, 'grp'));

            // if ($index !== false) {
            //     array_splice($cartData, $index, 3);

            //     if (empty($cartData)) {
            //         $response = new Response();
            //         $response->withCookie(cookie()->forget('cart'));
            //         return $response;
            //     }

            //     $updatedCookieValue = json_encode($cartData);
            //     Cookie::queue('cart', $updatedCookieValue);
            // }

            // $cartCookie = request()->cookie('cart');
            // $cartData = json_decode($cartCookie, true);
            // $updatedCartData = $cartData;
            // foreach ($cartData as $key => $item) {
            //     if (isset($item['tipe_kain_id']) && $item['tipe_kain_id'] === $item_id) {
            // Menghapus item dengan tipe_kain_id yang sesuai dari array
            // unset($updatedCartData[$key]);
            // return $updatedCartData[$key];
            //     }
            // }
            // if (empty($updatedCartData)) {
            //     $response = new Response();
            //     $response->withCookie(cookie()->forget('cart'));
            //     return $response;
            // }

            // $response = new Response();
            // $response->withCookie(Cookie::make('cart', json_encode(array_values($updatedCartData)), 43200));
            // return response()->json(['message' => 'Item berhasil dihapus!']);
        }
        return response()->json(['message' => 'Item berhasil dihapus!']);
    }
}
