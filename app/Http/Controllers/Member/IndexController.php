<?php

namespace App\Http\Controllers\Member;

use App\Console\Kernel;
use App\Http\Controllers\Member\Auth;
use App\Http\Controllers\Controller;
use App\Mail\Email;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
    {
        $data = JenisKain::orderBy('nama', 'asc')->get();
        // echo json_encode($data, JSON_PRETTY_PRINT);
        return view('index-new', compact('data'));
    }

    public function index_old(){
        $data = JenisKain::orderBy('nama', 'asc')->get();

        return view('index', compact('data'));
    }

    public function fetch_data_pagin(Request $request)
    {
        if($request->ajax())
        {
        $porduk_active = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
            ->distinct()
            ->simplePaginate(10);
            return view('pagination_data', compact('porduk_active'))->render();
        }
    }

    public function product(){
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });

        $porduk_active = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->distinct()
        ->latest()
        ->simplePaginate(10);

        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', 1],
            ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
        ])
        ->distinct()
        ->simplePaginate(10);

        // return json_encode($porduk_active, JSON_PRETTY_PRINT);
        return view('product', compact('data','porduk_active','cards'));
    }

    public function detail($id){
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });
        $detail = TipeKain::with('lebar', 'gramasi', 'kategoriwarna', 'warna', 'satuan', 'jenis_kain')
                ->where('id', $id)
                ->first();

        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where([
                    ['jenis_kain_id', 1],
                    ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                ])
                ->distinct()
                ->get();
        $jkain = $detail['jenis_kain_id'];
        $rekomendasi_produk = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where('jenis_kain_id', $jkain)
                ->distinct()
                ->get()
                ->random(4);

        // echo json_encode($detail, JSON_PRETTY_PRINT);
        return view('product-detail', compact('data','detail','cards','rekomendasi_produk'));
    }

    public function product_detail(Request $request)
    {
        $id_produk = $request->input('id_prd');
        $id_jenisk = $request->input('jenis_kain_id');
        $nama_produk = $request->input('nama_produk');

        $kain = TipeKain::with('lebar', 'gramasi', 'satuan', 'warna')
               ->where('id', $id_produk)
               ->where('jenis_kain_id', $id_jenisk)
               ->where('nama', 'like', '%' . $nama_produk . '%')
               ->first();

        $satuan = TipeKain::whereHas('satuan', function ($query) {
            $query->select('id', 'keterangan');
        })->with('satuan')
            ->where([
                ['jenis_kain_id', $id_jenisk], ['nama', 'like', '%' . $nama_produk . '%']
            ])->select('barang_satuan_id')->distinct()
            ->get();
        $asc = TipeKain::where([
            ['jenis_kain_id', $id_jenisk],
            ['bagian', 'accessories']
        ])->select('id', 'nama')->distinct()->get()->unique('nama')->values();    
        
        return response()->json([
            'datas'     => $kain,
            'asc'       => $asc,
            'satuan'    => $satuan,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function product_harga_body(Request $request){
        $jenis_id   = $request->input('jenis_kain_id');
        $id_produk  = $request->input('id_prd');
        $datas = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', $jenis_id],
            ['id',$id_produk]
        ])->firstOrFail();
        return response()->json([
            'datas'     => $datas,
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function product_harga_asc(Request $request)
    {
        $jenis_id   = $request->input('jenis_kain_id');
        $id_produk  = $request->input('id_prdasc');
        $datas = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', $jenis_id],
            ['id',$id_produk]
        ])->firstOrFail();
        return response()->json([
            'datas'     => $datas,
        ], 200, [], JSON_PRETTY_PRINT);
    }


    public function fetch_cards(Request $request){
        // $id = $request->input('tipeKainId');
        // $pecah = explode("-",$id);
        // $jenis  = $pecah[0];
        // $tipe   = $pecah[1];

        $jenis  = $request->input('id');
        $tipe   = $request->input('jenis');

        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', $jenis],
            ['nama', 'like', '%' . $tipe . '%']
        ])
        ->distinct()
        ->get();

        // return response()->json($cards);
        return view('cards', compact('cards'));
    }

    public function get_subkategori($jenis_id){
        $data = TipeKain::where([['jenis_kain_id', $jenis_id], ['bagian', '!=', 'accessories']])->select('nama')->distinct()
            ->orderBy('nama', 'asc')
            ->get();

        return response()->json($data);
    }

    public function get_produk(Request $request, $kategori){
        $subKategoriId = $request->subKategoriId;
        $produk = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', $kategori],
            ['nama', 'like', '%' . $subKategoriId . '%']
        ])
        ->distinct()
        ->get();

        return response()->json($produk);
    }

    public function tipe_by_jenis_public($jenis_id){
            $datas = TipeKain::where([['jenis_kain_id', $jenis_id], ['bagian', '!=', 'accessories']])->select('nama')->distinct()
            ->orderBy('nama', 'asc')
            ->get();

            return response()->json($datas);
    }

    public function addtocartsmt(Request $request){

        if(auth()->user() && auth()->user()->customer_id){
            // $hasil = "Save to db";
            $id_produk  = $request->input('id_produk');
            $jenis_kain_id  = $request->input('jenis_kain_id');

            $customer_id = auth()->user()->customer_id;
            $keranjang = Keranjang::where([
                ['tipe_kain_id', $id_produk], ['customer_id', $customer_id], ['checkout', 0]
            ])->first();

            if($request->qtyAscModal == null){
                $qty_asc = 0;
            }else{
                $qty_asc = $request->qtyAscModal;
            }

            if($request->id_prdasc == "899"){
                $id_accessories = "0";
            }else{
                $id_accessories = $request->id_prdasc;
            }

            if (!isset($keranjang)) {
                // $echo = 1;
                Keranjang::create([
                    'tipe_kain_id'      => $id_produk,
                    'customer_id'       => $customer_id,
                    'checkout'          => 0,
                    'qty'               => $request->qtyBodyModal,
                    'qty_accesories'    => $qty_asc,
                    'warna_id'          => $request->warnaModal,
                    'accesories_id'     => $id_accessories,
                    'satuan'            => $request->satuaBodyModal,
                    'created_by'        => auth()->user()->id    
                ]);
            }else{
                // $echo = 2;
                Keranjang::where([
                    ['tipe_kain_id', $id_produk], ['customer_id', $customer_id], ['checkout', 0]
                ])->update([
                    'qty'               => $keranjang->qty + $request->qtyBodyModal,
                    'qty_accesories'    => $keranjang->qty_acessories + $request->qtyAscModal,
                    'warna_id'          => $request->warnaModal,
                    'accesories_id'     => $id_accessories,
                    'satuan'            => $request->satuaBodyModal,
                ]);
            }

        } else {
            $id_produk      = $request->input('id_produk');
            $id_prdasc      = $request->input('id_prdasc');
            $jenis_kain_id  = $request->input('jenis_kain_id');
            $nama_produk    = $request->input('nama_produk');
            $qtyAscModal    = $request->input('qtyAscModal');
            $qtyBodyModal   = $request->input('qtyBodyModal');
            $satuaBodyModal = $request->input('satuaBodyModal');
            $totalHarga     = $request->input('totalHarga');
            $bagian         = $request->input('bagian');
            $harga          = $request->input('harga');
            $harga_body     = $request->input('harga_pil');
            $namaWarna      = $request->input('namaWarna');
            $lebarModal     = $request->input('lebarModal');
            $gramasiModal   = $request->input('gramasiModal');
            $warnaModalId   = $request->input('warnaModal');

            if ($id_prdasc) {
                $datacs = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                    ->where([
                        ['jenis_kain_id', $jenis_kain_id],
                        ['id', $id_prdasc]
                    ])->firstOrFail();

                if (!empty($qtyBodyModal)) {
                    $hargana = $harga_body;
                } else {
                    $hargana = $harga;
                }

                $cartData = $request->cookie('cartData');
                $cartArray = json_decode($cartData, true) ?? [];
                $result = [];

                $itemBody = [
                    'item_id' => uniqid(),
                    'tipekain_id' => $id_produk,
                    'jenis_kain_id' => $jenis_kain_id,
                    'nama' => $nama_produk,
                    'harga' => $hargana,
                    'qty' => $qtyBodyModal,
                    'satuan' => $satuaBodyModal,
                    'warna_id' => $warnaModalId,
                    'barang_lebar_id' => $lebarModal,
                    'barang_gramasi_id' => $gramasiModal,
                    'bagian' => 'body',
                    'harga_body' => $hargana,
                    'harga_asc'  => $datacs['harga_ecer'],
                ];

                // Cari item dengan tipe_kain_id yang sama pada bagian body
                $existingItem = null;
                foreach ($cartArray as $index => $item) {
                    if ($item['tipekain_id'] == $id_produk && $item['bagian'] == 'body') {
                        $existingItem = $index;
                        break;
                    }
                }

                if ($existingItem !== null) {
                    // Jika item dengan tipe_kain_id yang sama ditemukan, jumlahkan qty-nya
                    $cartArray[$existingItem]['qty'] += $qtyBodyModal;
                } else {
                    // Jika tidak ditemukan, tambahkan item baru ke dalam keranjang
                    $result[] = $itemBody;
                }

                $itemAccessories = [
                    'item_id' => uniqid(),
                    'tipekain_id' => $id_prdasc,
                    'jenis_kain_id' => $jenis_kain_id,
                    'nama' => $datacs['nama'],
                    'harga' => $datacs['harga_ecer'],
                    'qty' => $qtyAscModal,
                    'satuan' => $satuaBodyModal,
                    'warna_id' => $warnaModalId,
                    'barang_lebar_id' => null,
                    'barang_gramasi_id' => null,
                    'bagian' => 'accessories',
                    'harga_body' => $hargana,
                    'harga_asc'  => $datacs['harga_ecer'],
                ];
                $result[] = $itemAccessories;

                $result1 = $cartData ? array_merge($cartArray, $result) : $result;

                $cookieValue = json_encode($result1);
                $expiration = Carbon::now()->addDays(30);
                $cookie = Cookie::forever('cartData', $cookieValue, $expiration);
                return response()->json(['cookie' => $cookieValue])->withCookie($cookie);
            } else {
                if (!empty($qtyBodyModal)) {
                    $hargana = $harga_body;
                } else {
                    $hargana = $harga;
                }

                $cartData = $request->cookie('cartData');
                $cartArray = json_decode($cartData, true) ?? [];
                $result = [];

                $itemBody = [
                    'item_id' => uniqid(),
                    'tipekain_id' => $id_prdasc,
                    'jenis_kain_id' => $jenis_kain_id,
                    'nama' => $nama_produk,
                    'harga' => $hargana,
                    'qty' => $qtyBodyModal,
                    'satuan' => $satuaBodyModal,
                    'warna_id' => $warnaModalId,
                    'barang_lebar_id' => $lebarModal,
                    'barang_gramasi_id' => $gramasiModal,
                    'bagian' => 'body',
                    'harga_body' => $hargana,
                    'harga_asc'  => 0,
                ];

                // Cari item dengan tipe_kain_id yang sama pada bagian body
                $existingItem = null;
                foreach ($cartArray as $index => $item) {
                    if ($item['tipekain_id'] == $id_prdasc && $item['bagian'] == 'body') {
                        $existingItem = $index;
                        break;
                    }
                }

                if ($existingItem !== null) {
                    // Jika item dengan tipe_kain_id yang sama ditemukan, jumlahkan qty-nya
                    $cartArray[$existingItem]['qty'] += $qtyBodyModal;
                } else {
                    // Jika tidak ditemukan, tambahkan item baru ke dalam keranjang
                    $result[] = $itemBody;
                }

                $result1 = $cartData ? array_merge($cartArray, $result) : $result;

                $cookieValue = json_encode($result1);
                $expiration = Carbon::now()->addDays(30);
                $cookie = Cookie::forever('cartData', $cookieValue, $expiration);
                return response()->json(['cookie' => $cookieValue])->withCookie($cookie);
            }

            // return response()->json($datacs);
        }

        
        return response()->json([
            'message' => $id_produk
        ]);

    }

    public function cart(Request $request)
    {
        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where([
                    ['jenis_kain_id', 1],
                    ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                ])
                ->distinct()
                ->get();
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])->get()->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });
        
        $cartData = $request->cookie('cartData');
        $cartArray = json_decode($cartData, true);
        
        if (auth()->check() && auth()->user()->customer_id) {
            $customer_id = auth()->user()->customer_id;
            $cartDataCookie = $request->cookie('cartData');
            $cartArrayCookie = json_decode($cartDataCookie, true) ?? [];
        
            if ($cartArrayCookie) {
                $cartArrayDB = Keranjang::with('tipe_kain', 'accesories')
                    ->where([
                        ['customer_id', $customer_id],
                        ['checkout', 0]
                    ])->get();
        
                $cartArray = [];

                foreach ($cartArrayCookie as $item) {
                    $item['source'] = 'cookie';
                    $cartArray[] = $item;
                }
        
                foreach ($cartArrayDB as $item) {

                    $satuan = $item['satuan'];

                    if ($item['tipe_kain']['bagian'] === 'body') {
                        $hargaBody = $satuan === 'ROLL' ? $item['tipe_kain']['harga_roll'] : $item['tipe_kain']['harga_ecer'];
                    }

                    $cartArray[] = [
                        'id_keranjang'      => $item['id'],
                        'tipekain_id'       => $item['tipe_kain']['id'],
                        'jenis_kain_id'     => $item['tipe_kain']['jenis_kain_id'],
                        'nama'              => $item['tipe_kain']['nama'],
                        'harga'             => $item['tipe_kain']['harga_ecer'],
                        'qty'               => $item['qty'],
                        'satuan'            => $item['satuan'],
                        'warna_id'          => $item['tipe_kain']['warna_id'],
                        'barang_lebar_id'   => $item['tipe_kain']['barang_lebar_id'],
                        'barang_gramasi_id' => $item['tipe_kain']['barang_gramasi_id'],
                        'bagian'            => $item['tipe_kain']['bagian'],
                        'source'            => 'database',
                        'harga_body'        => $hargaBody,
                        'harga_asc'         => $item['accesories']['harga_ecer'],
                    ];
                    if (isset($item['accesories'])) {
                        $cartArray[] = [
                            'id_keranjang'      => $item['id'],
                            'tipekain_id'       => $item['accesories']['id'],
                            'jenis_kain_id'     => $item['accesories']['jenis_kain_id'],
                            'nama'              => $item['accesories']['nama'],
                            'harga'             => $item['accesories']['harga_ecer'],
                            'qty'               => $item['qty_accesories'],
                            'satuan'            => $item['satuan'],
                            'warna_id'          => $item['tipe_kain']['warna_id'],
                            'barang_lebar_id'   => $item['accesories']['barang_lebar_id'],
                            'barang_gramasi_id' => $item['accesories']['barang_gramasi_id'],
                            'bagian'            => $item['accesories']['bagian'],
                            'source'            => 'database',
                            'harga_body'        => $hargaBody,
                            'harga_asc'         => $item['accesories']['harga_ecer'],
                        ];
                    }
                }
            } else {
                $cartArray = Keranjang::with('tipe_kain', 'accesories')
                    ->where([
                        ['customer_id', $customer_id],
                        ['checkout', 0]
                    ])->get()->flatMap(function ($item) {
                        $bodyItem = [
                            'id_keranjang'      => $item->id,
                            'tipekain_id'       => $item->tipe_kain->id,
                            'jenis_kain_id'     => $item->tipe_kain->jenis_kain_id,
                            'nama'              => $item->tipe_kain->nama,
                            'harga'             => $item->tipe_kain->harga_ecer,
                            'qty'               => $item->qty,
                            'satuan'            => $item->satuan,
                            'warna_id'          => $item->tipe_kain->warna_id,
                            'barang_lebar_id'   => $item->tipe_kain->barang_lebar_id,
                            'barang_gramasi_id' => $item->tipe_kain->barang_gramasi_id,
                            'harga_body'        => $item->tipe_kain->harga_ecer,
                            'harga_asc'         => $item->accesories->harga_ecer,
                            'bagian'            => 'body',
                            'source'            => 'database'
                        ];

                        $accessoriesItem = [];
                        if ($item->accesories) {
                            $accessoriesItem = [
                                'id_keranjang'      => $item->id,
                                'tipekain_id'       => $item->accesories->id,
                                'jenis_kain_id'     => $item->accesories->jenis_kain_id,
                                'nama'              => $item->accesories->nama,
                                'harga'             => $item->accesories->harga_ecer,
                                'qty'               => $item->qty_accesories,
                                'satuan'            => $item->satuan,
                                'warna_id'          => $item->accesories->warna_id,
                                'barang_lebar_id'   => $item->accesories->barang_lebar_id,
                                'barang_gramasi_id' => $item->accesories->barang_gramasi_id,
                                'harga_body'        => $item->tipe_kain->harga_ecer,
                                'harga_asc'         => $item->accesories->harga_asc,
                                'bagian'            => 'acessories',
                                'source'            => 'database'
                            ];
                        }

                        return [$bodyItem, $accessoriesItem];
                    })->filter()->values()->toArray();
            }

            $newCartArray = [];
            foreach ($cartArray as $item) {
                $item['source'] = 'cookie';
                $newCartArray[] = $item;
            }

            $cartArray = [];

            foreach ($newCartArray as $key => $item) {
                if ($item['satuan'] == "ROLL") {
                    $cartArray[] = [
                        'tipekain_id' => $item['tipekain_id'],
                        'jenis_kain_id' => $item['jenis_kain_id'],
                        'nama' => $item['nama'],
                        'harga' => $item['harga'],
                        'barang_lebar_id' => $item['barang_lebar_id'],
                        'barang_gramasi_id' => $item['barang_gramasi_id'],
                        'bagian' => $item['bagian'],
                        'harga_body' => $item['harga_body'],
                        'harga_asc' => $item['harga_asc'],
                        'source' => $item['source'],
                        'qty' => $item['qty'],
                        'satuan' => $item['satuan'],
                    ];
                } else if ($item['satuan'] == "KG") {
                    $satuan = "KG";
                    $qtykg = $item['qty'];
                    $bagian = intval($qtykg / 25);
                    $sisa = $qtykg % 25;
                    $splitData = array();
                    for ($i = 0; $i < $bagian; $i++) {
                        $splitData[] = array(
                            'value' => 1,
                            'satuan' => 'ROLL'
                        );
                    }
                    if ($sisa > 0) {
                        $splitData[] = array(
                            'value' => $sisa,
                            'satuan' => 'KG'
                        );
                    }
                    foreach ($splitData as $data) {
                        $cartArray[] = [
                            'tipekain_id' => $item['tipekain_id'],
                            'jenis_kain_id' => $item['jenis_kain_id'],
                            'nama' => $item['nama'],
                            'harga' => $item['harga'],
                            'barang_lebar_id' => $item['barang_lebar_id'],
                            'barang_gramasi_id' => $item['barang_gramasi_id'],
                            'bagian' => $item['bagian'],
                            'harga_body' => $item['harga_body'],
                            'harga_asc' => $item['harga_asc'],
                            'source' => $item['source'],
                            'qty' => $data['value'],
                            'satuan' => $data['satuan'],
                        ];
                    }
                } else {
                    $cartArray[] = [
                        'tipekain_id' => $item['tipekain_id'],
                        'jenis_kain_id' => $item['jenis_kain_id'],
                        'nama' => $item['nama'],
                        'harga' => $item['harga'],
                        'barang_lebar_id' => $item['barang_lebar_id'],
                        'barang_gramasi_id' => $item['barang_gramasi_id'],
                        'bagian' => $item['bagian'],
                        'harga_body' => $item['harga_body'],
                        'harga_asc' => $item['harga_asc'],
                        'source' => $item['source'],
                        'qty' => $item['qty'],
                        'satuan' => $item['satuan'],
                    ];
                }
            }

            $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                    ->where([
                        ['jenis_kain_id', 1],
                        ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                    ])
                    ->distinct()
                    ->get();
            $data = JenisKain::with(['tipe_kain' => function ($query) {
                $query->where('bagian', '!=', 'accessories')
                    ->orderBy('nama', 'asc');
            }])->get()->map(function ($jenisKain) {
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });

            return view('cart',compact('data','cartArray','cards'));
            // echo json_encode($cartArray, JSON_PRETTY_PRINT);
        } else {
            if (empty($cartArray)) {
                $cartArray = [];
            }
            
            $newCartArray = [];
            
            foreach ($cartArray as $item) {
                $item['source'] = 'cookie';
                $newCartArray[] = $item;
            }
            
            $newCartArray = array_filter($newCartArray, function ($item) {
                return isset($item['source']);
            });
            
            $cartArray = [];
            
            foreach ($newCartArray as $key => $item) {
                if ($item['satuan'] == "ROLL") {
                    // $satuan = "ROLL";
                    $cartArray[] = [
                        'tipekain_id' => $item['tipekain_id'],
                        'jenis_kain_id' => $item['jenis_kain_id'],
                        'nama' => $item['nama'],
                        'harga' => $item['harga'],
                        'barang_lebar_id' => $item['barang_lebar_id'],
                        'barang_gramasi_id' => $item['barang_gramasi_id'],
                        'bagian' => $item['bagian'],
                        'harga_body' => $item['harga_body'],
                        'harga_asc' => $item['harga_asc'],
                        'source' => $item['source'],
                        'qty' => $item['qty'],
                        'satuan' => $item['satuan'],
                    ];

                } else if ($item['satuan'] == "KG") {
                    $satuan = "KG";
                    $qtykg = $item['qty'];
                    $bagian = intval($qtykg / 25);
                    $sisa = $qtykg % 25;
                    $splitData = array();
                    for ($i = 0; $i < $bagian; $i++) {
                        $splitData[] = array(
                            'value' => 1,
                            'satuan' => 'ROLL'
                        );
                    }
                    if ($sisa > 0) {
                        $splitData[] = array(
                            'value' => $sisa,
                            'satuan' => 'KG'
                        );
                    }
                    foreach ($splitData as $data) {
                        $cartArray[] = [
                            'tipekain_id' => $item['tipekain_id'],
                            'jenis_kain_id' => $item['jenis_kain_id'],
                            'nama' => $item['nama'],
                            'harga' => $item['harga'],
                            'barang_lebar_id' => $item['barang_lebar_id'],
                            'barang_gramasi_id' => $item['barang_gramasi_id'],
                            'bagian' => $item['bagian'],
                            'harga_body' => $item['harga_body'],
                            'harga_asc' => $item['harga_asc'],
                            'source' => $item['source'],
                            'qty' => $data['value'],
                            'satuan' => $data['satuan'],
                        ];
                    }
                } else {
                    $cartArray[] = [
                        'tipekain_id' => $item['tipekain_id'],
                        'jenis_kain_id' => $item['jenis_kain_id'],
                        'nama' => $item['nama'],
                        'harga' => $item['harga'],
                        'barang_lebar_id' => $item['barang_lebar_id'],
                        'barang_gramasi_id' => $item['barang_gramasi_id'],
                        'bagian' => $item['bagian'],
                        'harga_body' => $item['harga_body'],
                        'harga_asc' => $item['harga_asc'],
                        'source' => $item['source'],
                        'qty' => $item['qty'],
                        'satuan' => $item['satuan'],
                    ];
                }
            }
            $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                    ->where([
                        ['jenis_kain_id', 1],
                        ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                    ])
                    ->distinct()
                    ->get();
            $data = JenisKain::with(['tipe_kain' => function ($query) {
                $query->where('bagian', '!=', 'accessories')
                    ->orderBy('nama', 'asc');
            }])->get()->map(function ($jenisKain) {
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });
            
            // echo json_encode($cartArray, JSON_PRETTY_PRINT);
            return view('cart', compact('data', 'cartArray','cards'));
        }
        
    }

    public function destroy_cart(Request $request)
    {
        $item_id    = $request->input('item_id');
        $source     = $request->input('source');
        $bagian     = $request->input('bagian');
        $idxidx     = $request->input('idxidx');

        if($source == "cookie"){
            $cartData = $request->cookie('cartData');
            $cartArray = json_decode($cartData, true) ?? [];

            // Cek apakah item dengan tipekain_id ada di dalam cartArray
            $itemKey = array_search($item_id, array_column($cartArray, 'tipekain_id'));
            if ($itemKey !== false) {
                // Hapus item dari cartArray berdasarkan key
                unset($cartArray[$itemKey]);

                // Konversi kembali ke JSON
                $cartDataUpdated = json_encode(array_values($cartArray));

                // Update cookie dengan data yang baru
                $expiration = Carbon::now()->addDays(30);
                $cookie = Cookie::forever('cartData', $cartDataUpdated, $expiration);
                return response()->json(['message' => 'Item removed from cart.'])->withCookie($cookie);
            }

            return response()->json(['message' => 'Item not found in cart.']);
        }else{
            if($bagian == "body"){
                $item = Keranjang::where('id', $idxidx)->first();
                // return response()->json($item);
                if ($item) {
                    $item->delete();

                    return response()->json(['message' => 'Item successfully deleted from database']);
                } else {
                    return response()->json(['error' => 'Item not found in database'], 404);
                }
            }else{
                $item = Keranjang::where('id',$idxidx)->first();
                // return response()->json($item);
                if ($item) {
                    $item->accesories_id = 0;
                    $item->save();
        
                    return response()->json(['message' => 'Item successfully updated in database']);
                } else {
                    return response()->json(['error' => 'Item not found in database'], 404);
                }
            }
        }
    }

    public function getNotificationBadge()
    {
        if(auth()->user() && auth()->user()->customer_id){
            $customer_id = auth()->user()->customer_id;
            $totalQty = 0;
            $totalHarga = 0;

            // Mengambil data dari database
            $datas = Keranjang::with([
                'tipe_kain' => [
                    "lebar", "gramasi", "warna", "satuan"
                ],
                'accesories'
            ])->where([
                ['customer_id', $customer_id], ['checkout', 0]
            ])->get();

            // Mengambil data dari cookie
            $notificationBadgeFromCookie = json_decode(Cookie::get('cartData'), true);

            // Menggabungkan data dari cookie dan database
            $notificationBadge = $notificationBadgeFromCookie ? count($notificationBadgeFromCookie) + $datas->count() : $datas->count();

            // Menghitung totalQty dan totalHarga
            foreach ($datas as $data) {
                $qty = $data->qty + $data->qty_accesories;

                if ($data->tipe_kain !== null) {
                    $hargaKain = $data->satuan === 'KG' ? $data->tipe_kain->harga_ecer : $data->tipe_kain->harga_roll;
                } else {
                    $hargaKain = 0;
                }
                
                if ($data->accesories !== null) {
                    $hargaAksesoris = $data->accesories->harga_ecer;
                } else {
                    $hargaAksesoris = 0;
                }

                $totalQty += $qty;
                $totalHarga += ($data->qty * $hargaKain) + ($data->qty_accesories * $hargaAksesoris);
            }

            // Menggabungkan totalQty dan totalHarga
            if ($notificationBadgeFromCookie) {
                foreach ($notificationBadgeFromCookie as $item) {
                    $harga = intval($item['harga']);
                    $qty = intval($item['qty']);
                    $totalQty += $qty;
                    $totalHarga += ($harga * $qty);
                }
            }

            $response = [
                'notifbadge' => $notificationBadge,
                'total_qty' => $totalQty,
                'total_harga' => $totalHarga
            ];

            return $response;
        }else{
            $notificationBadgeFromCookie = json_decode(Cookie::get('cartData'), true);
            $totalQty   = 0;
            $totalHarga = 0;
            if ($notificationBadgeFromCookie) {
                foreach ($notificationBadgeFromCookie as $item) {
                    $harga = intval($item['harga']);
                    $qty = intval($item['qty']);
                    $totalQty += $qty;
                    $totalHarga += ($harga * $qty);
                }
            }
            
            $notificationBadge = $notificationBadgeFromCookie ? count($notificationBadgeFromCookie) : 0;
            $response = [
                'notifbadge'    => $notificationBadge,
                'total_qty'     => $totalQty,
                'total_harga'   => $totalHarga
            ];
            return $response;
        }
    }    

    public function accessories_index()
    {
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });

        $product_active =  TipeKain::with(['lebar', 'gramasi', 'warna', 'satuan'])
        ->where('bagian', '!=', 'body')
        ->get();

        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', 1],
            ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
        ])
        ->distinct()
        ->paginate(10);
        // echo json_encode($produc_active, JSON_PRETTY_PRINT);
        return view('accessories-index',compact('data','product_active','cards'));
    }

    public function getCartMobile(Request $request)
    {
        $cartData = $request->cookie('cartData');
        $cartArray = json_decode($cartData, true);

        if (auth()->check() && auth()->user()->customer_id) {
            $customer_id = auth()->user()->customer_id;
            $cartDataCookie = $request->cookie('cartData');
            $cartArrayCookie = json_decode($cartDataCookie, true) ?? [];
        
            if ($cartArrayCookie) {
                $cartArrayDB = Keranjang::with('tipe_kain', 'accesories')
                    ->where([
                        ['customer_id', $customer_id],
                        ['checkout', 0]
                    ])->get();
        
                $cartArray = [];

                foreach ($cartArrayCookie as $item) {
                    $item['source'] = 'cookie';
                    $cartArray[] = $item;
                }
        
                foreach ($cartArrayDB as $item) {
                    $cartArray[] = [
                        'id_keranjang'      => $item['id'],
                        'tipekain_id'       => $item['tipe_kain']['id'],
                        'jenis_kain_id'      => $item['tipe_kain']['jenis_kain_id'],
                        'nama'              => $item['tipe_kain']['nama'],
                        'harga'             => $item['tipe_kain']['harga_ecer'],
                        'qty'               => $item['qty'],
                        'satuan'            => $item['satuan'],
                        'warna_id'          => $item['tipe_kain']['warna_id'],
                        'barang_lebar_id'   => $item['tipe_kain']['barang_lebar_id'],
                        'barang_gramasi_id' => $item['tipe_kain']['barang_gramasi_id'],
                        'bagian'            => $item['tipe_kain']['bagian'],
                        'source'            => 'database'
                    ];
                    $cartArray[] = [
                        'id_keranjang'      => $item['id'],
                        'tipekain_id'       => $item['accesories']['id'],
                        'jenis_kain_id'      => $item['accesories']['jenis_kain_id'],
                        'nama'              => $item['accesories']['nama'],
                        'harga'             => $item['accesories']['harga_ecer'],
                        'qty'               => $item['qty_accesories'],
                        'satuan'            => $item['satuan'],
                        'warna_id'          => $item['tipe_kain']['warna_id'],
                        'barang_lebar_id'   => $item['accesories']['barang_lebar_id'],
                        'barang_gramasi_id' => $item['accesories']['barang_gramasi_id'],
                        'bagian'            => $item['accesories']['bagian'],
                        'source'            => 'database'
                    ];
                }

                // $cartArray = array_merge($cartArrayCookie, $cartArray);
            } else {
                $cartArray = Keranjang::with('tipe_kain', 'accesories')
                    ->where([
                        ['customer_id', $customer_id],
                        ['checkout', 0]
                    ])->get()->flatMap(function ($item) {
                        $bodyItem = [
                            'id_keranjang'      => $item->id,
                            'tipekain_id'       => $item->tipe_kain->id,
                            'jenis_kain_id'      => $item->tipe_kain->jenis_kain_id,
                            'nama'              => $item->tipe_kain->nama,
                            'harga'             => $item->tipe_kain->harga_ecer,
                            'qty'               => $item->qty,
                            'satuan'            => $item->satuan,
                            'warna_id'          => $item->tipe_kain->warna_id,
                            'barang_lebar_id'   => $item->tipe_kain->barang_lebar_id,
                            'barang_gramasi_id' => $item->tipe_kain->barang_gramasi_id,
                            'bagian'            => 'body',
                            'source'            => 'database'
                        ];

                        $accessoriesItem = [];
                        if ($item->accesories) {
                            $accessoriesItem = [
                                'id_keranjang'      => $item->id,
                                'tipekain_id'       => $item->accesories->id,
                                'jenis_kain_id'      => $item->accesories->jenis_kain_id,
                                'nama'              => $item->accesories->nama,
                                'harga'             => $item->accesories->harga_ecer,
                                'qty'               => $item->qty_accesories,
                                'satuan'            => $item->satuan,
                                'warna_id'          => $item->accesories->warna_id,
                                'barang_lebar_id'   => $item->accesories->barang_lebar_id,
                                'barang_gramasi_id' => $item->accesories->barang_gramasi_id,
                                'bagian'            => 'acessories',
                                'source'            => 'database'
                            ];
                        }

                        return [$bodyItem, $accessoriesItem];
                    })->filter()->values()->toArray();
            }
        }else{
            if (empty($cartArray)) {
                $cartArray = [];
            }
            
            $newCartArray = [];
            
            foreach ($cartArray as $item) {
                $item['source'] = 'cookie';
                $newCartArray[] = $item;
            }
            
            $newCartArray = array_filter($newCartArray, function ($item) {
                return isset($item['source']);
            });
            
            $cartArray = [];
            
            foreach ($newCartArray as $key => $item) {
                if ($item['satuan'] == "ROLL") {
                    $satuan = "ROLL";
                } else if ($item['satuan'] == "KG") {
                    $satuan = "KG";
                    $qtykg = $item['qty'];
                    $bagian = intval($qtykg / 25);
                    $sisa = $qtykg % 25;
                    $splitData = array();
                    for ($i = 0; $i < $bagian; $i++) {
                        $splitData[] = array(
                            'value' => 1,
                            'satuan' => 'ROLL'
                        );
                    }
                    if ($sisa > 0) {
                        $splitData[] = array(
                            'value' => $sisa,
                            'satuan' => 'KG'
                        );
                    }
                    foreach ($splitData as $data) {
                        $cartArray[] = [
                            'tipekain_id' => $item['tipekain_id'],
                            'jenis_kain_id' => $item['jenis_kain_id'],
                            'nama' => $item['nama'],
                            'harga' => $item['harga'],
                            'barang_lebar_id' => $item['barang_lebar_id'],
                            'barang_gramasi_id' => $item['barang_gramasi_id'],
                            'bagian' => $item['bagian'],
                            'harga_body' => $item['harga_body'],
                            'harga_asc' => $item['harga_asc'],
                            'source' => $item['harga_asc'],
                            'qty' => $data['value'],
                            'satuan' => $data['satuan'],
                        ];
                    }
                } else {
                    // Jika kondisi lainnya
                }
            }
            $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                    ->where([
                        ['jenis_kain_id', 1],
                        ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                    ])
                    ->distinct()
                    ->get();
            $data = JenisKain::with(['tipe_kain' => function ($query) {
                $query->where('bagian', '!=', 'accessories')
                    ->orderBy('nama', 'asc');
            }])->get()->map(function ($jenisKain) {
                $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
                return $jenisKain;
            });
        }

        return $cartArray;
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
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
