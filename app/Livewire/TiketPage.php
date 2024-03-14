<?php

namespace App\Livewire;

use App\Models\Rute;
use App\Models\Tiket;
use App\Models\Tipebus;
use Livewire\Component;

class TiketPage extends Component
{
    public $start = [];
    public $end = [];
    public $category = [];

    public function mount()
    {
        $ruteAwal = Rute::orderBy('start')->get()->groupBy('start');
        foreach ($ruteAwal as $key => $value) {
            $this->start[] = $key;
        }

        $ruteAkhir = Rute::orderBy('end')->get()->groupBy('end');
        foreach ($ruteAkhir as $key => $value) {
            $this->end[] = $key;
        }

        $this->category = Tipebus::orderBy('name')->pluck('name');
    }

    public function render()
    {
        return view('livewire.tiket-page', [
            'tiket' => Tiket::all(),
            'tipebus' => Tipebus::all(),
        ]);
    }
}
