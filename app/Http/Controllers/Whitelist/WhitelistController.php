<?php

namespace App\Http\Controllers\Whitelist;

use App\Http\Controllers\Controller;
use App\Models\Whitelist\Whitelist;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use App\Models\Barang\JenisKain;
use App\Models\Barang\TipeKain;
use Illuminate\Support\Facades\Cookie;

class WhitelistController extends Controller
{

    public function wht_index(Request $request){
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
        }])
        ->get()
        ->map(function ($jenisKain) {
            $jenisKain->tipe_kain = $jenisKain->tipe_kain->unique('nama')->values();
            return $jenisKain;
        });

        $cartData = $request->cookie('whitelist');
        $cartArray = json_decode($cartData, true);

        if (auth()->check() && auth()->user()->customer_id) {
            if (empty($cartArray)) {
                $cartArray = [];
                $ids = [];
            }
            
            foreach ($cartArray as $item) {
                $id = isset($item['id']) ? $item['id'] : null;
                $item['source'] = 'cookie';
                if ($id) {
                    $ids[] = $id;
                }
            }
            
            $cartArray = TipeKain::with(['lebar', 'gramasi', 'kategoriwarna', 'warna', 'satuan', 'jenis_kain'])
            ->whereIn('id', $ids)
            ->get();
            $cartArray = $cartArray->toArray();
        }else{
            if (empty($cartArray)) {
                $cartArray = [];
                $ids = [];
            }
            
            foreach ($cartArray as $item) {
                $id = isset($item['id']) ? $item['id'] : null;
                $item['source'] = 'cookie';
                if ($id) {
                    $ids[] = $id;
                }
            }
            
            $cartArray = TipeKain::with(['lebar', 'gramasi', 'kategoriwarna', 'warna', 'satuan', 'jenis_kain'])
            ->whereIn('id', $ids)
            ->get();
            $cartArray = $cartArray->toArray();
            
            // $cartArray = array_filter($cartArray, function ($item) {
            //     return isset($item['source']);
            // });
            
            // echo json_encode($cartArray, JSON_PRETTY_PRINT);
        }

        // echo json_encode($cartArray, JSON_PRETTY_PRINT);
        return view('whitelist.index-whitelist',compact('data','cartArray','cards'));
    }

    public function store_wht(Request $request){

        // Proses data dari permintaan Ajax
        $id = $request->input('itemId');
        $icon = $request->input('icon');
        $iconStatus = $request->input('iconStatus');
        
        // Simpan data ke dalam cookie
        $cookieData = [
            'id'            => $id,
            'icon'          => $icon,
            'iconStatus'    => $iconStatus
        ];
        
        if ($iconStatus === 'add') {
            $whitelistCookie = $request->cookie('whitelist');
            $whitelistData = $whitelistCookie ? json_decode($whitelistCookie, true) : [];

            $itemExists = false;
            foreach ($whitelistData as $item) {
                if ($item['id'] === $id) {
                    $itemExists = true;
                    break;
                }
            }
            if (!$itemExists) {
                if (count($whitelistData) < 5) {
                    $whitelistData[] = $cookieData;
                    $cookie = cookie('whitelist', json_encode($whitelistData), 720);
        
                    return response()->json([
                        'success' => true,
                        'message' => 'Item added to whitelist successfully'
                    ])->withCookie($cookie);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum item limit reached'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item already exists in whitelist'
                ]);
            }
        }elseif ($iconStatus === 'remove'){
            $whitelistCookie = $request->cookie('whitelist');
            $whitelistData = $whitelistCookie ? json_decode($whitelistCookie, true) : [];

            $itemIndex = -1;
            foreach ($whitelistData as $index => $item) {
                if ($item['id'] === $id) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== -1) {
                unset($whitelistData[$itemIndex]);
                $whitelistData = array_values($whitelistData); // Urutkan ulang array

                if (empty($whitelistData)) {
                    $cookie = cookie('whitelist', null, -1); // Hapus cookie whitelist jika data kosong
                } else {
                    $cookie = cookie('whitelist', json_encode($whitelistData), 720);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from whitelist successfully'
                ])->withCookie($cookie);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in whitelist'
                ]);
            }

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid icon status'
            ]);
        }
    }

    public function getWishlist(){
        $whitelistCookie = json_decode(request()->cookie('whitelist'), true);
        return $whitelistCookie ?? [];
    }

    public function getIconsWhitelist(Request $request){
        if(auth()->user() && auth()->user()->customer_id){
            $customer_id = auth()->user()->customer_id;
            $id = $request->input('itemId');
            $whitelistCookie = json_decode($request->cookie('whitelist'), true);
            $exists = false;
            
            if ($whitelistCookie && is_array($whitelistCookie)) {
                foreach ($whitelistCookie as $item) {
                    if (isset($item['id']) && $item['id'] == $id) {
                        $exists = true;
                        break;
                    }
                }
            }
            
            // Tanggapi permintaan Ajax
            return response()->json([
                'datas'  => $whitelistCookie,
                'exists' => $exists
            ]);
        }else{

            $id = $request->input('itemId');
            $whitelistCookie = json_decode($request->cookie('whitelist'), true);
            $exists = false;
            
            if ($whitelistCookie && is_array($whitelistCookie)) {
                foreach ($whitelistCookie as $item) {
                    if (isset($item['id']) && $item['id'] == $id) {
                        $exists = true;
                        break;
                    }
                }
            }
            
            // Tanggapi permintaan Ajax
            return response()->json([
                'datas'  => $whitelistCookie,
                'exists' => $exists
            ]);
        }
    }

    public function destroy_wht(Request $request, $id){
        if(auth()->user() && auth()->user()->customer_id){
            $whitelistCookie = $request->cookie('whitelist');
            $whitelistData = $whitelistCookie ? json_decode($whitelistCookie, true) : [];

            $itemIndex = -1;
            foreach ($whitelistData as $index => $item) {
                if ($item['id'] === $id) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== -1) {
                unset($whitelistData[$itemIndex]);
                $whitelistData = array_values($whitelistData); // Urutkan ulang array

                if (empty($whitelistData)) {
                    $cookie = cookie('whitelist', null, -1); // Hapus cookie whitelist jika data kosong
                } else {
                    $cookie = cookie('whitelist', json_encode($whitelistData), 720);
                }

                $request->session()->flash('success', 'Item removed from whitelist successfully!');
                return redirect('/index-whitelist')->withCookie($cookie);
            } else {
                $request->session()->flash('warning', 'Item not found in whitelist');
                return redirect('/index-whitelist');
            }
        }else{
            $whitelistCookie = $request->cookie('whitelist');
            $whitelistData = $whitelistCookie ? json_decode($whitelistCookie, true) : [];

            $itemIndex = -1;
            foreach ($whitelistData as $index => $item) {
                if ($item['id'] === $id) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== -1) {
                unset($whitelistData[$itemIndex]);
                $whitelistData = array_values($whitelistData); // Urutkan ulang array

                if (empty($whitelistData)) {
                    $cookie = cookie('whitelist', null, -1); // Hapus cookie whitelist jika data kosong
                } else {
                    $cookie = cookie('whitelist', json_encode($whitelistData), 720);
                }

                $request->session()->flash('success', 'Item removed from whitelist successfully!');
                return redirect('/index-whitelist')->withCookie($cookie);
            } else {
                $request->session()->flash('warning', 'Item not found in whitelist');
                return redirect('/index-whitelist');
            }
        }
    }

    public function store_wht_cart(Request $request){
        $id = $request->input('itemId');
        $icon = $request->input('icon');
        $iconStatus = $request->input('iconStatus');

        $cookieData = [
            'id'            => $id,
            'icon'          => $icon,
            'iconStatus'    => $iconStatus
        ];

        if ($iconStatus === 'add') {
            $whitelistCookie = $request->cookie('whitelist');
            $whitelistData = $whitelistCookie ? json_decode($whitelistCookie, true) : [];

            $itemExists = false;
            foreach ($whitelistData as $item) {
                if ($item['id'] === $id) {
                    $itemExists = true;
                    break;
                }
            }
            if (!$itemExists) {
                if (count($whitelistData) < 5) {
                    $whitelistData[] = $cookieData;
                    $cookie = cookie('whitelist', json_encode($whitelistData), 720);
        
                    return response()->json([
                        'success' => true,
                        'message' => 'Item added to whitelist successfully'
                    ])->withCookie($cookie);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Maximum item limit reached'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item already exists in whitelist'
                ]);
            }
        }elseif ($iconStatus === 'remove'){
            $whitelistCookie = $request->cookie('whitelist');
            $whitelistData = $whitelistCookie ? json_decode($whitelistCookie, true) : [];

            $itemIndex = -1;
            foreach ($whitelistData as $index => $item) {
                if ($item['id'] === $id) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== -1) {
                unset($whitelistData[$itemIndex]);
                $whitelistData = array_values($whitelistData); // Urutkan ulang array

                if (empty($whitelistData)) {
                    $cookie = cookie('whitelist', null, -1); // Hapus cookie whitelist jika data kosong
                } else {
                    $cookie = cookie('whitelist', json_encode($whitelistData), 720);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from whitelist successfully'
                ])->withCookie($cookie);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found in whitelist'
                ]);
            }

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid icon status'
            ]);
        }
    }

    public function getIconsWhitelistCart(Request $request){
        if(auth()->user() && auth()->user()->customer_id){
            $customer_id = auth()->user()->customer_id;
            $id = $request->input('itemId');
            $whitelistCookie = json_decode($request->cookie('whitelist'), true);

            if (is_array($whitelistCookie) || is_object($whitelistCookie)) {
                $exists = false;

                foreach ($whitelistCookie as $item) {
                    if (isset($item['id']) && $item['id'] == $id) {
                        $exists = true;
                        break;
                    }
                }

                // Tanggapi permintaan Ajax
                return response()->json([
                    'datas'  => $whitelistCookie,
                    'exists' => $exists
                ]);
            } else {
                // Tanggapi dengan data kosong dan tidak ada
                return response()->json([
                    'datas'  => [],
                    'exists' => false
                ]);
            }
        }else{

            $id = $request->input('itemId');
            $whitelistCookie = json_decode($request->cookie('whitelist'), true);

            if (is_array($whitelistCookie) || is_object($whitelistCookie)) {
                $exists = false;

                foreach ($whitelistCookie as $item) {
                    if (isset($item['id']) && $item['id'] == $id) {
                        $exists = true;
                        break;
                    }
                }

                // Tanggapi permintaan Ajax
                return response()->json([
                    'datas'  => $whitelistCookie,
                    'exists' => $exists
                ]);
            } else {
                // Tanggapi dengan data kosong dan tidak ada
                return response()->json([
                    'datas'  => [],
                    'exists' => false
                ]);
            }

        }
    }

    public function index(){
        $customer_id = auth()->user()->customer_id;
        $datas = Whitelist::with([
            'tipe_kain' => [
                "lebar", "gramasi", "warna", "satuan"
            ]
        ])->where([
            ['customer_id', $customer_id], ['checkout', 0]
        ])->get();
        return response()->json([
            'datas' => $datas
        ], 200, [], JSON_PRETTY_PRINT);
    }

    function store(Request $request, $tipe_kain_id)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1',
        ]);
        $customer_id = auth()->user()->customer_id;
        $whitelist = Whitelist::where([
            ['tipe_kain_id', $tipe_kain_id], ['customer_id', $customer_id], ['checkout', 0]
        ])->first();
        if (!isset($whitelist)) {
            Whitelist::create([
                'tipe_kain_id'  => $tipe_kain_id,
                'customer_id'   => $customer_id,
                'qty'           => $request->qty,
                'checkout'      => 0,
                'created_by'    => auth()->user()->id
            ]);
        } else {
            Whitelist::where([
                ['tipe_kain_id', $tipe_kain_id], ['customer_id', $customer_id], ['checkout', 0]
            ])->update([
                'qty' => $whitelist->qty + $request->qty
            ]);
        }
        return response()->json([
            'message' => $request->all()
        ]);
    }

    public function destroy($id){
        Whitelist::where('id', $id)->delete();
        return response()->json([
            'message' => 'Barang dihapus dari whitelist.'
        ]);
    }

}