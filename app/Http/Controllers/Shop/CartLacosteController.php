<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartLacosteController extends Controller
{
    function storeToCookie(Request $request)
    {
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
        $idacs   = $request->input('idacs');
        $hargaacs   = $request->input('hargaacs');
        $qtyacs   = $request->input('qtyacs');
        $kgaccs   = $request->input('kgaccs');

        if (auth()->user() && auth()->user()->customer_id) {
            $customer_id = auth()->user()->customer_id;
            $cart = Keranjang::where([
                ['tipe_kain_id', $id_body],
                ['customer_id', $customer_id],
                ['checkout', 0]
            ])->first();
            $qty = $cart->qty ?? 0;
            if ($bagian == "body") {
                Keranjang::updateOrCreate([
                    'tipe_kain_id' => $id_body,
                    'customer_id' => $customer_id,
                    'checkout' => 0
                ], [
                    'bagian'       => 'body',
                    'warna_id' => 0,
                    'qty' => $qty_body + $qty,
                    'accesories_id' => $id_accessories ?? 0,
                    'satuan' => $satuan_body,
                    'warna_id'  => $warna_id
                ]);
            }
            foreach ($qtyacs as $i => $qtyac) {
                $cartAcc = Keranjang::where([
                    ['tipe_kain_id', $idacs[$i]],
                    ['customer_id', $customer_id],
                    ['checkout', 0]
                ])->first();
                $qtyAcc = $cartAcc->qty ?? 0;
                $qty_accesories = $cartAcc->qty_accesories ?? 0;
                Keranjang::updateOrCreate([
                    'tipe_kain_id' => $idacs[$i],
                    'customer_id' => $customer_id,
                    'checkout' => 0
                ], [
                    'bagian'       => 'accessories',
                    'warna_id' => 0,
                    'qty' => $kgaccs[$i] + $qtyAcc,
                    'qty_accesories' => $qtyacs[$i] + $qty_accesories,
                    'accesories_id' => $idacs[$i] ?? 0,
                    'satuan' => "KG",
                    'warna_id'  => $warna_id
                ]);
            }
        } else {
            $grp = Str::random(3);
            $body = [[
                'grp' => $grp,
                'tipe_kain_id' => $id_body,
                'harga' => $harga_body,
                'qty' => $qty_body,
                'pcs' => 0,
                'satuan' => $satuan_body,
                'harga_body' => $harga_body,
                'harga_asc' => $harga_accessories ?? 0,
                'bagian' => 'body',
                'parent_id' => 0,
                'qty_roll' => $qty_roll,
                'warna_id'  => $warna_id,
                'id_accessories' => 0
            ]];
            $itemAcs = [];
            foreach ($qtyacs as $key => $qtyacItem) {
                if (isset($qtyacItem)) {
                    $accs = [
                        'grp' => $grp,
                        'tipe_kain_id' => $idacs[$key],
                        'harga' => $harga_body,
                        'qty' => $kgaccs[$key] ?? 0,
                        'pcs' => $qtyacItem,
                        'satuan' => 'KG',
                        'harga_body' => $harga_body,
                        'harga_asc' => $hargaacs[$key],
                        'bagian' => 'accessories',
                        'parent_id' => 0,
                        'qty_roll' => $qty_roll,
                        'warna_id'  => $warna_id,
                        'id_accessories' => $idacs[$key]
                    ];
                    array_push($itemAcs, $accs);
                }
            }
            $data = array_merge($body, $itemAcs);
            $cartData = $this->getCartDataFromCookie();

            if ($cartData) {
                $updatedCartData = [];
                foreach ($data as $item) {
                    $found = false;

                    foreach ($cartData as $index => $cartItem) {
                        if ($cartItem['tipe_kain_id'] == $item['tipe_kain_id'] && $cartItem['satuan'] == $item['satuan']) {

                            if ($cartItem['bagian'] === 'accessories') {
                                $cartData[$index]['qty'] += $item['qty'];
                                $cartData[$index]['pcs'] += $item['pcs'];
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
                $cartData = $data;
            }
            $this->setCartDataToCookie($cartData);
        }
        // return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        return response()->json(['message' => 'sukses']);
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
