<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\CustomerUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Utils;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $request->session()->forget(['ktpData', 'filename']);
        return view('auth.register');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'fileInput' => 'required|image|mimes:jpeg,png,jpgmax:5120|max:5120',
        ]);
        // dd($request->hasFile('fileInput'));
        if ($request->hasFile('fileInput')) {
            $file = $request->file('fileInput');
            $extension = $file->getClientOriginalExtension();
            $newFileName = date('YmdHis') . '.' . $extension;
            $filePath = $file->storeAs('public/upload-ktp', $newFileName);

            $fileContents = file_get_contents(storage_path('app/public/upload-ktp/' . $newFileName));
            $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0eXBlIjoiVVNFUiIsImlkIjo1NDYsImtleSI6MjAwNDI4NjEyMywiaWF0IjoxNjg5ODM5NDg0fQ.xI14zRCA0BOxY2q98sFrJ47IUW5vpLgI9VJPYqbmvpY';

            $url = 'https://api.aksarakan.com/document/ktp';
            $client = new Client();
            $fileStream = Utils::streamFor($fileContents);
            $response = $client->request('PUT', "$url", [
                'headers'       => [
                    // 'Content-Type'  => 'multipart/form-data',
                    'Authentication' => "bearer $token",
                ],
                // 'body' => $fileStream,
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => $fileStream,
                        'filename' => $newFileName
                    ],
                ]
            ]);

            $responseStatus = $response->getStatusCode();
            $responseBody = $response->getBody()->getContents();
            if ($responseStatus === 201) {
                $result = json_decode($responseBody, true);
                $request->session()->put([
                    'filename' => $newFileName,
                    'ktpData' => $result['result']
                ]);
                return redirect('/register-dua');
            } else {
                $request->session()->flash('error', 'Terjadi kesalahan saat mengunggah foto KTP!');
                return redirect('/register');
            }
        }

        $request->session()->flash('error', 'Terjadi kesalahan saat mengunggah foto KTP !');
        return redirect('/register');
    }

    public function create_dua(Request $request)
    {
        if ($request->session()->get('filename')) {
            $filename = $request->session()->get('filename');
            $textKTP = $request->session()->get('ktpData');
            // $lines = explode("\n", $textKTP);
            // $data = array_map('trim', $lines);
            // $data = array_map(function ($item) {
            //     $item = str_replace(':', '', $item);
            //     $item = ltrim($item);
            //     $item = preg_replace('/^\s+/', '', $item);
            //     $item = preg_replace('/[^a-z A-Z0-9\/,\-]+/', '', $item);
            //     return $item;
            // }, $lines);


            // // $penanda_khusus1 = substr($data[0], 0, strpos($data[0], " "));
            // // $penanda_khusus2 = substr($data[1], 0, strpos($data[1], " "));

            // // if($penanda_khusus1 != "PROVINSI"){
            // //     return redirect('/register')->with('error', 'Terjadi kesalahan, Pastikan anda mengupload KTP! Atau pastikan KTP terbaca dengan jelas');
            // // }

            // $result = [
            //     'nik' => '',
            //     'provinsi' => '',
            //     'kabupaten' => '',
            //     'nama' => '',
            //     'tempat_lahir' => '',
            //     'tanggal_lahir' => '',
            //     'jenis_kelamin' => '',
            //     'alamat' => '',
            //     'rt' => '',
            //     'rw' => '',
            //     'desa_kelurahan' => '',
            //     'kecamatan' => '',
            //     'agama' => '',
            //     'status_perkawinan' => '',
            //     'pekerjaan' => '',
            //     'kewarganegaraan' => '',
            //     'berlaku_hingga' => ''
            // ];

            // try {
            //     $result['nik'] = isset($data[16]) ? trim($data[16]) : '';
            //     $result['provinsi'] = isset($data[14]) ? trim(str_replace("PROVINSI ", "", $data[14])) : '';
            //     $result['kabupaten'] = isset($data[15]) ? trim(str_replace("KABUPATEN ", "", $data[15])) : '';
            //     $result['nama'] = isset($data[17]) ? trim($data[17]) : '';
            //     $tempatTanggalLahir = explode(',', isset($data[18]) ? trim($data[18]) : '');
            //     $result['tempat_lahir'] = isset($tempatTanggalLahir[0]) ? trim($tempatTanggalLahir[0]) : '';
            //     $result['tanggal_lahir'] = isset($tempatTanggalLahir[1]) ? trim($tempatTanggalLahir[1]) : '';
            //     $result['jenis_kelamin'] = isset($data[4]) ? trim($data[4]) : '';
            //     $result['alamat'] = isset($data[20]) ? trim($data[20]) : '';
            //     $rtRw = explode('/', isset($data[21]) ? trim($data[21]) : '');
            //     $result['rt'] = isset($rtRw[0]) ? trim($rtRw[0]) : '';
            //     $result['rw'] = isset($rtRw[1]) ? trim($rtRw[1]) : '';
            //     $result['desa_kelurahan'] = isset($data[22]) ? trim($data[22]) : '';
            //     $result['kecamatan'] = isset($data[23]) ? trim($data[23]) : '';
            //     $result['agama'] = isset($data[24]) ? trim($data[24]) : '';
            //     $result['status_perkawinan'] = isset($data[25]) ? trim($data[25]) : '';
            //     $result['pekerjaan'] = isset($data[26]) ? trim($data[26]) : '';
            //     $result['kewarganegaraan'] = isset($data[27]) ? trim($data[27]) : '';
            //     $result['berlaku_hingga'] = isset($data[28]) ? trim($data[28]) : '';
            // } catch (Exception $e) {
            //     $result = array_fill_keys(array_keys($result), '');
            // }

            // echo json_encode($textKTP, JSON_PRETTY_PRINT);
            return view('auth.register-new-dua', [
                'ktpData' => $textKTP,
                'filename' => $filename
            ]);
        } else {
            return redirect('/register');
        }
    }

    public function store_dua(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255'],
            'agama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . CustomerUser::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = Customer::create([
            'customer_category_id'  => 1,
            'nama'                  => $request->nama,
            'no_ktp'                => $request->no_ktp,
            'pob'                   => $request->pob,
            'dob'                   => $request->dob,
            'jenis_kelamin'         => $request->jenis_kelamin,
            'alamat'                => $request->alamat,
            'agama'                 => $request->agama,
            'nohp'                  => $request->no_hp,
            'email'                 => $request->email,
            'file_ktp'              => $request->session()->get('filename')
        ]);

        $user = CustomerUser::create([
            'customer_id' => $customer->id,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'old_password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);

        // $email = $request->email;
        // $kode_verif = "12345";
        // Mail::to($email)->send(new Email($kode_verif));
        // echo json_encode($data2, JSON_PRETTY_PRINT);
        event(new Registered($user));

        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string', 'max:255'],
            'kota_perusahaan' => ['nullable', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:255'],
            'agama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'alamat' => ($request->jenis_akun == 'perusahaan') ? 'nullable' : 'required_without_all:alamat,kota',
            'kota' => ($request->jenis_akun == 'perusahaan') ? 'nullable' : 'required_without_all:kota,alamat',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . CustomerUser::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = Customer::create([
            'customer_category_id' => 1,
            'nama' => $request->nama_lengkap,
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat_perusahaan' => $request->alamat_perusahaan,
            'kota_perusahaan' => $request->kota_perusahaan,
            'agama' => $request->agama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'dob' => $request->dob,
            'alamat' => $request->alamat,
            'kota' => $request->kota,
            'nohp' => $request->no_hp,
            'email' => $request->email
        ]);
        $user = CustomerUser::create([
            'customer_id' => $customer->id,
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'old_password' => Hash::make($request->password),
            'remember_token' => Str::random(10),
        ]);
        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
