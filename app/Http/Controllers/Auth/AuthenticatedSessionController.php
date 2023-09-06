<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Keranjang;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user();
        $userId = $user->customer_id;
        $request->session()->regenerate();

        // Cek apakah cookie "cart" ada pada request
        if ($request->hasCookie('cart')) {
            $cartData   = json_decode($request->cookie('cart'), true);

            foreach ($cartData as $index => $data) {
                $keranjang = Keranjang::where([
                    'tipe_kain_id'  => $data['tipe_kain_id'],
                    'bagian'        => $data['bagian'],
                    'satuan'        => $data['satuan'],
                    'checkout'      => 0,
                    'customer_id'   => $userId,
                    'warna_id'      => $data['warna_id']
                ])->first();
                if ($keranjang) {
                    // Jika data sudah ada, update qty
                    $keranjang->qty += $data['qty'];
                    $keranjang->save();

                    unset($cartData[$index]);
                } else {
                    // Jika data belum ada, insert data baru ke keranjang
                    Keranjang::create([
                        'tipe_kain_id' => $data['tipe_kain_id'],
                        'bagian'       => $data['bagian'],
                        'warna_id' => $data['warna_id'],
                        'customer_id' => $userId,
                        'qty' => $data['qty'],
                        'accesories_id' => $data['id_accessories'] ?? 0,
                        'checkout' => 0,
                        'satuan' => $data['satuan'],
                    ]);
                    unset($cartData[$index]);
                }
            }
            // Hapus cookie jika tidak ada data lagi dalam cart
            if (empty($cartData)) {
                $response = new RedirectResponse(RouteServiceProvider::HOME);
                $response->withCookie(Cookie::forget('cart'));
                return $response;
            }

            $response = new RedirectResponse(RouteServiceProvider::HOME);
            $response->withCookie(Cookie::make('cart', json_encode(array_values($cartData)), 43200));
            return $response;
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        // Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
