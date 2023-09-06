<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use App\Models\Barang\WarnaKain;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerService;
use App\Models\Keranjang;
use App\Models\Pesanan\CustomerExperience;
use App\Models\Pesanan\CustomerPoint;
use Illuminate\Http\Request;
use App\Models\Pesanan\DetailPesanan;
use App\Models\Pesanan\Pesanan;
use Browser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class PesananController extends Controller
{

    public function pesanan_fo()
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

        $porduk_active = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', 1],
            ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
        ])
        ->distinct()
        ->get();
        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
        ->where([
            ['jenis_kain_id', 1],
            ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
        ])
        ->distinct()
        ->get();
        return view('pesanan.add-fo', compact(
            'data',
            'porduk_active',
            'cards'
        ));
    }

    public function co_store(Request $request)
    {
        $customer_id = auth()->user()->customer_id;
        $id_keranjang = $request->input('idx');
        $bagian = $request->input('bagian');
        $tipekain_id = $request->input('id');
        $warna_id = $request->input('warna_id');
        $satuan = $request->input('satuan');
        $sources = $request->input('source');
        $qtys = $request->input('qty');
        $hargas = $request->input('harga');

        $insertData = [];
        $updateData = [];

        $count = count($bagian);
        for ($i = 0; $i < $count; $i += 2) {
            if ($sources[$i] == 'cookie') {
                $item = [
                    'tipe_kain_id' => $tipekain_id[$i],
                    'warna_id' => $warna_id[$i],
                    'customer_id' => $customer_id,
                    'acessories_id' => isset($tipekain_id[$i + 1]) ? $tipekain_id[$i + 1] : null,
                    'qty' => $qtys[$i],
                    'qty_acessorires' => isset($qtys[$i + 1]) ? $qtys[$i + 1] : null,
                    'satuan'  => $satuan[$i]
                ];

                if ($item['qty'] == 0 || $item['qty_acessorires'] == 0) {
                    continue;
                }

                $insertData[] = $item;
            } else {
                $item = [
                    'id'                => $id_keranjang[$i + 1],
                    'qty'               => $qtys[$i],
                    'qty_acessorires'   => isset($qtys[$i + 1]) ? $qtys[$i + 1] : null,
                ];

                if ($item['qty'] == 0 || $item['qty_acessorires'] == 0) {
                    continue;
                }

                $updateData[] = $item;
            }
        }

        if (empty($insertData) && empty($updateData)) {
            $request->session()->flash('error', 'Oppss ada yang salah, sepertinya ada QTY yang kosong !.');
            return redirect()->back();
        }

        if (!empty($insertData)) {
            foreach ($insertData as $item) {
                Keranjang::create([
                    'tipe_kain_id' => $item['tipe_kain_id'],
                    'warna_id' => $item['warna_id'],
                    'customer_id' => $item['customer_id'],
                    'accesories_id' => $item['acessories_id'],
                    'qty' => $item['qty'],
                    'qty_accesories' => $item['qty_acessorires'],
                    'satuan'  => $item['satuan']
                ]);
            }
        }

        foreach ($updateData as $item) {
            $keranjang = Keranjang::where('id', $item['id'])->first();
            if ($keranjang) {
                $keranjang->update([
                    'qty' => $item['qty'],
                    'qty_accesories' => $item['qty_acessorires'],
                    // Update kolom lainnya sesuai kebutuhan
                ]);
            }
        }
        // echo json_encode($insertData, JSON_PRETTY_PRINT);
        // echo json_encode($updateData, JSON_PRETTY_PRINT);
        $request->session()->flash('success', 'Data siap di checkout.');
        return redirect('/checkout-index');
    }

    public function co_index()
    {
        $customer_id = auth()->user()->customer_id;

        $data_cust = Customer::where('id',$customer_id)->firstOrFail();

        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });
        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where([
                    ['jenis_kain_id', 1],
                    ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                ])
                ->distinct()
                ->get();

        $cartArray1 = Keranjang::with('tipe_kain','accesories')
        ->where([
            ['customer_id', $customer_id],
            ['checkout', 0]
        ])->get();

        $cartArray = [];
        foreach ($cartArray1 as $item) {
            $cartArray[] = [
                'id_keranjang'      => $item['id'],
                'tipekain_id'       => $item['tipe_kain']['id'],
                'jenis_kainid'      => $item['tipe_kain']['jenis_kain_id'],
                'nama'              => $item['tipe_kain']['nama'],
                'harga'             => $item['tipe_kain']['harga_ecer'],
                'qty'               => $item['qty'],
                'satuan'            => $item['satuan'],
                'warna_id'          => $item['tipe_kain']['warna_id'],
                'barang_lebar_id'   => $item['tipe_kain']['barang_lebar_id'],
                'barang_gramasi_id' => $item['tipe_kain']['barang_gramasi_id'],
                'bagian'            => $item['tipe_kain']['bagian'],
            ];
            if (isset($item['accesories'])) {
                $cartArray[] = [
                    'id_keranjang'      => $item['id'],
                    'tipekain_id'       => $item['accesories']['id'],
                    'jenis_kainid'      => $item['accesories']['jenis_kain_id'],
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
            // $cartArray[] = [
            //     'id_keranjang'      => $item['id'],
            //     'tipekain_id'       => $item['accesories']['id'],
            //     'jenis_kainid'      => $item['accesories']['jenis_kain_id'],
            //     'nama'              => $item['accesories']['nama'],
            //     'harga'             => $item['accesories']['harga_ecer'],
            //     'qty'               => $item['qty_accesories'],
            //     'satuan'            => $item['satuan'],
            //     'warna_id'          => $item['tipe_kain']['warna_id'],
            //     'barang_lebar_id'   => $item['accesories']['barang_lebar_id'],
            //     'barang_gramasi_id' => $item['accesories']['barang_gramasi_id'],
            //     'bagian'            => $item['accesories']['bagian'],
            // ];
        }
        // echo json_encode($cartArray, JSON_PRETTY_PRINT);
        return view('pesanan.checkout-index',compact('data','cards','cartArray','data_cust'));
    }

    public function co(Request $request)
    {
        $customer_id    = auth()->user()->customer_id;
        $target_kebutuhan  = $request->target_kebutuhan;
        $alamat_kirim  = $request->alamat_kirim;
        $catatan  = $request->catatan;
        $nomor = 'SO.' . date('Ymdhis');
        $url     = url('/pesanan');

        // $tg_pesanan = $request->target_pesanan;

        $keranjang = Keranjang::with(['accesories'])->where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();

        $details = [];

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
        foreach ($keranjang as $key => $item) {

            if ($item->satuan == "ROLL") {
                $satuan = "ROLL";
                for ($i = 1; $i <= $item->qty; $i++) {
                    $body = DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'tipe_kain_id' => $item->tipe_kain_id,
                        'warna_id'     => $item->warna_id,
                        'qty'       => $item->qty / $item->qty,
                        'satuan'    => $item->satuan,
                        'bagian'    => 'body',
                        'parent_id' => '0',
                        'created_by' => auth()->user()->id
                    ]);
                }
                $body_id = $body->id;
            } else if($item->satuan == "KG"){
                $satuan = "KG";
                $qtykg = $item->qty;
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
                $body_details = array();
                foreach ($splitData as $data) {
                    $body_details[] = [
                        'pesanan_id' => $pesanan->id,
                        'tipe_kain_id' => $item->tipe_kain_id,
                        'warna_id'     => $item->warna_id,
                        'qty'       => $data['value'],
                        'satuan'    => $data['satuan'],
                        'bagian'    => 'body',
                        'parent_id' => '0',
                        'created_by' => auth()->user()->id
                    ];
                }
                DetailPesanan::insert($body_details);
                $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');

            }else{
                $body = DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'tipe_kain_id' => $item->tipe_kain_id,
                    'warna_id'     => $item->warna_id,
                    'qty'       => $item->qty,
                    'satuan'    => $item->satuan,
                    'bagian'    => 'body',
                    'parent_id' => '0',
                    'created_by' => auth()->user()->id
                ]);
                $body_id = $body->id;
            }
            // accesories
            $qty_accessories = ceil($item->qty_accesories);
            if ($qty_accessories > 0) {

                $detail = [
                    'pesanan_id'    => $pesanan->id,
                    'tipe_kain_id'  => $item->accesories_id,
                    'warna_id'      => $item->warna_id,
                    'qty'           => $item->qty_accesories,
                    'satuan'        => $item->satuan,
                    'bagian'        => 'accessories',
                    'parent_id'     => $body_id,
                    'created_by'    => auth()->user()->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
                array_push($details, $detail);
            }
        }
        // return response()->json($details, 200, [], JSON_PRETTY_PRINT);
        if (!empty($details)) {
            DetailPesanan::insert($details);
        }

        //clear keranjang
        Keranjang::where('customer_id', $customer_id)->update(['checkout' => 1, 'updated_by' => auth()->user()->id]);

        $request->session()->flash('success', 'Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.');
        return redirect('/dashboard');
    }


    public function drat_so($id)
    {
        $customer_id = auth()->user()->customer_id;
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });
        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where([
                    ['jenis_kain_id', 1],
                    ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                ])
                ->distinct()
                ->get();
        $pesanan = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();

        $status_pesanan_id = $pesanan['status_pesanan_id'];

        $no_pesanan = Pesanan::where('customer_id', $customer_id)
                    ->where('status_pesanan_id', $status_pesanan_id)
                    ->get();
        
        // echo json_encode($pesanan, JSON_PRETTY_PRINT);
        return view('pesanan.draft-so',compact('data','cards','pesanan','no_pesanan'));
    }

    public function detail_so($id){
        $customer_id = auth()->user()->customer_id;
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });
        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where([
                    ['jenis_kain_id', 1],
                    ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                ])
                ->distinct()
                ->get();
        $pesanan = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();

        $status_pesanan_id = $pesanan['status_pesanan_id'];

        $no_pesanan = Pesanan::where('customer_id', $customer_id)
                    ->where('status_pesanan_id', $status_pesanan_id)
                    ->get();
        
        // echo json_encode($no_pesanan, JSON_PRETTY_PRINT);
        return view('pesanan.detail-so',compact('data','cards','pesanan','no_pesanan'));
    }

    public function getBodyInvoice($id)
    {
        $pesanan = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        return view('pesanan.body-invoice',compact('pesanan'));
    }

    public function index()
    {
        $customer_id = auth()->user()->customer_id;
        $data['count'] = DB::select('SELECT
            COUNT(*) AS sts_0,
            COUNT(case when status_pesanan.keterangan="Tunggu Konfirmasi" then 1 end ) AS sts_1,
            COUNT(case when status_pesanan.keterangan="Tunggu Pembayaran" then 1 end ) AS sts_2,
            COUNT(case when status_pesanan.keterangan="Pesanan Diproses" then 1 end ) AS sts_3,
            COUNT(case when status_pesanan.keterangan="Pesanan Diantar" then 1 end ) AS sts_4,
            COUNT(case when status_pesanan.keterangan="Pesanan Selesai" then 1 end ) AS sts_5
            FROM pesanan
            JOIN status_pesanan ON pesanan.status_pesanan_id=status_pesanan.id
            WHERE pesanan.customer_id=' . $customer_id . ' AND pesanan.deleted_at IS NULL')[0];
        $data['pesanans'] = Pesanan::with(['details' => function ($query) {
            $query->where('bagian', '!=', 'accessories');
        }, 'status'])->where('customer_id', $customer_id)->orderByDesc('tanggal_pesanan')->latest()->get();
        return view('pesanan.index', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    function detail($id)
    {
        // $data['pesanan'] = Pesanan::with([
        //     'customer',
        //     'sales_man',
        //     'status',
        //     'details' => [
        //         'tipe_kain' => [
        //             'lebar',
        //             'gramasi',
        //             'warna',
        //             'satuan'
        //         ],
        //         'warna_pesanan'
        //     ]
        // ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        $data['pesanan'] = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        return view('pesanan.detail', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function draft_edit($id)
    {
        $data['pesanan'] = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();

        $jenis = JenisKain::select('id', 'kode', 'nama')->orderBy('nama', 'asc')->get();
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        return view('pesanan.edit', [
            'jenis'     => $jenis,
            'pesanan'   => $data['pesanan']
        ]);
        
    }

    function add()
    {
        $jenis = JenisKain::select('id', 'kode', 'nama')->orderBy('nama', 'asc')->get();
        return view('pesanan.add', [
            'jenis' => $jenis
        ]);

        // return response()->json($warna, 200, [], JSON_PRETTY_PRINT);
    }

    public function detail_done()
    {
        return view('pesanan.detail-done');
    }

    public function detail_rating($id)
    {
        
        $customer_id = auth()->user()->customer_id;
        $data = JenisKain::with(['tipe_kain' => function ($query) {
            $query->where('bagian', '!=', 'accessories')
                ->orderBy('nama', 'asc');
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });
        $cards = TipeKain::with('lebar', 'gramasi', 'warna', 'satuan')
                ->where([
                    ['jenis_kain_id', 1],
                    ['nama', 'like', '%F.SK COTTON 30S BAMBOO%']
                ])
                ->distinct()
                ->get();
        $pesanan = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        
        $status_pesanan_id = $pesanan['status_pesanan_id'];

        $no_pesanan = Pesanan::where('customer_id', $customer_id)
                    ->where('status_pesanan_id', $status_pesanan_id)
                    ->get();
        return view('pesanan.detail-rating', compact('data','cards','pesanan','no_pesanan'));
    }
    function rating_store(Request $request, $id)
    {
        $customer_id = auth()->user()->customer_id;
        CustomerExperience::updateOrCreate(
            [
                'customer_id' => $customer_id,
                'pesanan_id' => $id
            ],
            [
                'star' => $request->star,
                'message' => $request->message,
                'date_input' => date('Y-m-d H:i:s')
            ]
        );
        return redirect()->route('pesanan.index')->with('success', 'Terimasih atas penilaian anda');
    }


    public function draft_index()
    {
        $customer_id = auth()->user()->customer_id;
        $data['pesanans'] = Pesanan::with([
            'details' => [
                'tipe_kain'
            ]
        ])
            ->where([['customer_id', $customer_id], ['status_pesanan_id', 1]])
            ->get();
        return view('pesanan.draft-index', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    public function draft_detail($id)
    {
        // $data['pesanan'] = Pesanan::with([
        //     'customer',
        //     'sales_man',
        //     'status',
        //     'details' => [
        //         'tipe_kain' => [
        //             'lebar',
        //             'gramasi',
        //             'warna',
        //             'satuan'
        //         ],
        //         'warna_pesanan'
        //     ]
        // ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        $data['pesanan'] = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();

        return view('pesanan.draft-detail', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    function draft_update(Request $request, $id)
    {
        $request->validate([
            'ttd' => ['required', 'string'],
            'nomor' => ['required', 'string']
        ]);
        $image = $request->input('ttd');
        $ttd = null;
        $no_invoice = 'INV.' . time();
        if ($image) {
            $path = storage_path('app/public/ttd/');
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $data_image = explode(";", $image)[0] ?? "data:image/png";
            $image_ext = explode("/", $data_image)[1] ?? "png";
            $fileName = $request->nomor . '.' . $image_ext;
            Image::make(file_get_contents($image))->save($path . '/' . $fileName);
            $ttd = url('/storage/ttd/' . $fileName);
        }
        Pesanan::where([['id', $id], ['created_by', auth()->user()->id]])->update([
            'status_pesanan_id' => 3,
            // 'status_kode' => 'Invoicing',
            'status_kode' => 'Approved',
            'ttd' => $ttd,
            'no_invoice' => $no_invoice,
            'approved_at' => date('Y-m-d H:i:s'),
            'approved_by' => auth()->user()->id,
            'approved_by_host' => $request->ip(),
            'approved_by_device' => Browser::browserName()
        ]);
        return redirect()->route('pesanan.checkout', $id);
        // return response()->json(['data' => $request->all()], 200, [], JSON_PRETTY_PRINT);
    }

    public function invoicing_index()
    {
        $customer_id = auth()->user()->customer_id;
        $data['pesanans'] = Pesanan::with([
            'details' => [
                'tipe_kain'
            ]
        ])
            ->where([['customer_id', $customer_id], ['status_pesanan_id', 2]])
            ->get();
        return view('pesanan.draft-index', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    function checkout($id)
    {
        // $data['pesanan'] = Pesanan::with([
        //     'details' => [
        //         'tipe_kain' => [
        //             'lebar',
        //             'gramasi',
        //             'warna',
        //             'satuan'
        //         ],
        //         'warna_pesanan'
        //     ]
        // ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        $data['pesanan'] = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();

        $status_pesanan = "3";
        $status_kode    = "Approved";
        Pesanan::where('id', $id)->update([
            'status_pesanan_id' => $status_pesanan,
            'status_kode' => $status_kode,
        ]);

        return view('pesanan.checkout', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function payment($id)
    {
        // $data['pesanan'] = Pesanan::with([
        //     'details' => [
        //         'tipe_kain' => [
        //             'jenis_kain',
        //             'lebar',
        //             'gramasi',
        //             'warna',
        //             'satuan'
        //         ],
        //         'warna_pesanan'
        //     ],
        //     'status'
        // ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();
        $data['pesanan'] = pesanan::with([
            "customer",
            'sales_man',
            'status',
            "details" => function($query) {
                $query->orderByRaw("CASE WHEN parent_id = 0 THEN id ELSE parent_id END, id")->with([
                    "tipe_kain" => function($query) {
                        $query->orderBy('id', 'asc')->with([
                            "lebar",
                            "gramasi",
                            "warna",
                        ]);
                    },
                    'warna_pesanan'
                ]);
            }
        ])->where([['id', $id], ['created_by', auth()->user()->id]])->firstOrFail();

        $data['point'] = CustomerPoint::where('customer_id', auth()->user()->customer_id)->sum('point_total');
        return view('pesanan.payment', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    function payment_update($id)
    {
        $customer_id = auth()->user()->customer_id;
        $total_pesanan = DetailPesanan::where('pesanan_id', $id)->sum('harga');
        $update = Pesanan::where([['id', $id], ['customer_id', $customer_id]])->update(
            [
                'status_pesanan_id' => 3
            ]
        );
        if ($update) {
            $this->setPoint($customer_id, $id, $total_pesanan);
        }

        return redirect()->route('pesanan.index');
    }

    public function done_index()
    {
        $customer_id = auth()->user()->customer_id;
        $data['pesanans'] = Pesanan::with([
            'details' => [
                'tipe_kain'
            ]
        ])
            ->where([['customer_id', $customer_id], ['status_pesanan_id', 5]])
            ->get();
        return view('pesanan.done-index', $data);
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    function pesanan_done($id)
    {
        $customer_id = auth()->user()->customer_id;
        Pesanan::where([['id', $id], ['customer_id', $customer_id]])->update(
            [
                'status_pesanan_id' => 5,
                'status_kode'       => 'Done'
            ]
        );
        return redirect()->route('pesanan.rating', $id)->with('success', 'Berhasil disimpan');
    }



    public function store(Request $request)
    {
        $customer_id = auth()->user()->customer_id;

        $keranjang = Keranjang::where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();
        if (count($keranjang) > 0) {
            $message = "";
            $url     = url('/accesories-add/' . $customer_id);
        } else {
            $message = "Keranjang anda masih kosong.";
            $url     = url('/pesanan-add');
        }

        return response()->json([
            'message'         => $message,
            'count_keranjang' => count($keranjang),
            'redirectUrl'     => $url
        ], 200);
    }

    function accesories_add($id)
    {
        $pesanan = Keranjang::with([
            'tipe_kain' => [
                'lebar',
                'gramasi',
                'warna',
                'satuan'
            ],
            'warna_pesanan',
            // 'accesories'
        ])->where([['customer_id', $id], ['checkout', 0]])->get();

        $basic_ids = [];
        $spandex_ids = [];

        foreach ($pesanan as $item) {
            $basic_ids[] = $item->tipe_kain->basic_id;
            $spandex_ids[] = $item->tipe_kain->spandex_id;
        }

        $ids = array_merge($basic_ids, $spandex_ids);
        // $asc = DB::select('SELECT * FROM tipe_kain WHERE id IN ('.implode(',', $ids).')');

        $asc = DB::select('SELECT t.id as id_asc,t.nama as nama_kain,w.nama as nama_warna,g.nama as nama_gram
        FROM tipe_kain t
        JOIN barang_gramasi g ON t.barang_gramasi_id = g.id
        JOIN warna w ON t.warna_id = w.id
        WHERE t.id IN ('.implode(',', $ids).')');

        // return response()->json($asc, 200, [], JSON_PRETTY_PRINT);
        return view('pesanan.add_accesories', [
            'pesanan' => $pesanan,
            'asssc'   => $asc
        ]);
    }

    public function get_asc_detail($id)
    {
        $asc = DB::select('SELECT t.id as id_asc,t.nama as nama_kain,w.nama as nama_warna,g.nama as nama_gram
        FROM tipe_kain t
        JOIN barang_gramasi g ON t.barang_gramasi_id = g.id
        JOIN warna w ON t.warna_id = w.id
        WHERE t.id = '.$id.'')[0];
        return response()->json([
            'callback' => $asc
        ], 200, [], JSON_PRETTY_PRINT);
    }

    public function accesories_store(Request $request)
    {

        $customer_id = auth()->user()->customer_id;
        $nomor = 'SO.' . date('Ymdhis');
        $url     = url('/pesanan');

        $tg_pesanan = $request->target_pesanan;

        $keranjang = Keranjang::with(['accesories'])->where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();

        $details = [];

        $pesanan = Pesanan::create([
            'nomor' => $nomor,
            'customer_id' => $customer_id,
            'sales_man_id' => 0,
            'customer_service_id' => $this->getCs(5),
            'tanggal_pesanan' => date("Y-m-d"),
            'target_pesanan'    => $tg_pesanan,
            'status_pesanan_id' => 1,
            'status_kode' => 'Draft',
            'created_by' => auth()->user()->id,
            'created_by_host' => $request->ip(),
            'created_by_device' => Browser::browserName()
        ]);
        foreach ($keranjang as $key => $item) {

            if ($item->satuan == "ROLL") {
                $satuan = "ROLL";
                for ($i = 1; $i <= $item->qty; $i++) {
                    $body = DetailPesanan::create([
                        'pesanan_id' => $pesanan->id,
                        'tipe_kain_id' => $item->tipe_kain_id,
                        'warna_id'     => $item->warna_id,
                        'qty'       => $item->qty / $item->qty,
                        'satuan'    => $item->satuan,
                        'bagian'    => 'body',
                        'parent_id' => '0',
                        'created_by' => auth()->user()->id
                    ]);
                }
                $body_id = $body->id;
            } else if($item->satuan == "KG"){
                $satuan = "KG";
                $qtykg = $item->qty;
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
                $body_details = array();
                foreach ($splitData as $data) {
                    $body_details[] = [
                        'pesanan_id' => $pesanan->id,
                        'tipe_kain_id' => $item->tipe_kain_id,
                        'warna_id'     => $item->warna_id,
                        'qty'       => $data['value'],
                        'satuan'    => $data['satuan'],
                        'bagian'    => 'body',
                        'parent_id' => '0',
                        'created_by' => auth()->user()->id
                    ];
                }
                DetailPesanan::insert($body_details);
                $body_id = DetailPesanan::orderBy('id', 'desc')->value('id');

            }else{
                $body = DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'tipe_kain_id' => $item->tipe_kain_id,
                    'warna_id'     => $item->warna_id,
                    'qty'       => $item->qty,
                    'satuan'    => $item->satuan,
                    'bagian'    => 'body',
                    'parent_id' => '0',
                    'created_by' => auth()->user()->id
                ]);
                $body_id = $body->id;
            }
            // accesories
            $qty_accessories = ceil($item->qty_accesories);
            if ($qty_accessories > 0) {

                $detail = [
                    'pesanan_id'    => $pesanan->id,
                    'tipe_kain_id'  => $item->accesories_id,
                    'warna_id'      => $item->warna_id,
                    'qty'           => $item->qty_accesories,
                    'satuan'        => $request->satuan_asc,
                    'bagian'        => 'accessories',
                    'parent_id'     => $body_id,
                    'created_by'    => auth()->user()->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
                array_push($details, $detail);

                // DetailPesanan::create([
                //     'pesanan_id'    => $pesanan->id,
                //     'tipe_kain_id'  => $item->accesories_id,
                //     'warna_id'      => $item->warna_id,
                //     'qty'           => $item->qty_accesories,
                //     'satuan'        => $request->satuan_asc,
                //     'bagian'        => 'accessories',
                //     'parent_id'     => $body_id,
                //     'created_by'    => auth()->user()->id
                // ]);
            }
        }
        // return response()->json($details, 200, [], JSON_PRETTY_PRINT);
        if (!empty($details)) {
            DetailPesanan::insert($details);
        }

        //clear keranjang
        Keranjang::where('customer_id', $customer_id)->update(['checkout' => 1, 'updated_by' => auth()->user()->id]);

        $message = 'Terimakasih. Pesanan Anda sudah terkirim. Kami akan memeriksa ketersediaan barang tersebut, dan akan menyampaikan informasi kepada Anda.';

        return response()->json([
            'message' => $message,
            'redirectUrl'     => $url,
        ], 200);
    }

    public function store_asc_qty(Request $request)
    {

        $customer_id = auth()->user()->customer_id;
        $id_keran    = $request->idkeran;
        $qty_accessories = ceil($request->qty);
        if ($qty_accessories <= 0) {
            return response()->json([
                'status' => 2,
                'pesan' => 'QTY Kosong.'
            ]);
        } else {
            $keranjang = Keranjang::where([
                ['id', $id_keran], ['customer_id', $customer_id], ['checkout', 0]
            ])->first();

            if (!isset($keranjang)) {
                Keranjang::where([
                    ['id', $id_keran], ['customer_id', $customer_id], ['checkout', 0]
                ])->update([
                    'accesories_id' => $request->id_asc,
                    'qty_accesories' => $request->qty,
                ]);
            } else {
                Keranjang::where([
                    ['id', $id_keran], ['customer_id', $customer_id], ['checkout', 0]
                ])->update([
                    'accesories_id' => $request->id_asc,
                    'qty_accesories' => $request->qty,
                ]);
            }
            return response()->json([
                'status' => 1,
                'pesan' => 'Accessories berhasil di tambahkan.'
            ]);
        }
    }

    public function destroy_asc_kosong(Request $request)
    {
        $id_asc     = $request->ids;
        if ($id_asc) {
            // $callback = "Ada yang di delete";
            DetailPesanan::whereIn('id', $id_asc)->delete();
            // $detail = DetailPesanan::whereIn('id',$id_asc)->get();
        } else {
            // $callback = "Tidak ada yang di delete";
            // $detail = "";
        }
        return response()->json([
            'message'  => "oke"
        ], 200);
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

    function getCs($limit)
    {
        $cs = CustomerService::where('order_handle', '<=', $limit)->inRandomOrder()->first();
        return $cs->id ?? 0;
    }

    function setPoint($customer_id, $pesanan_id, $total)
    {
        $poin_before = CustomerPoint::where('customer_id', $customer_id)->sum('point_total');
        $point_amount = ceil($total / 1000);
        $point_total = $poin_before + $point_amount;
        CustomerPoint::create([
            'customer_id' => $customer_id,
            'pesanan_id' => $pesanan_id,
            'transaction_total' => $total,
            'point_date' => date('Y-m-d'),
            'point_before' => $poin_before,
            'point_amount' => $point_amount,
            'point_total' => $point_total,
            'created_by' => auth()->user()->id
        ]);
    }
    public function batalkanPesananForm($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        return view('pesanan.batalkan', compact('pesanan'));
    }

    public function batalkanPesanan(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status_pesanan_id = 6;
        $pesanan->status_kode = 'LO';
        $pesanan->keterangan = $request->input('keterangan');
        $pesanan->save();

        return redirect()->route('pesanan.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
