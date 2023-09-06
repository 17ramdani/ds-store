<?php

namespace App\View\Components;

use App\Models\Barang\JenisKain;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class SideMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
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

        return view('components.side-menu', [
            'data' => $data
        ]);
    }
}
