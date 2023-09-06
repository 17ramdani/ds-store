<?php

namespace App\Http\Controllers;

use App\Models\Barang\JenisKain;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data = JenisKain::orderBy('nama', 'asc')->get();
        return view('home',[
            'data' => $data
        ]);
    }
}
