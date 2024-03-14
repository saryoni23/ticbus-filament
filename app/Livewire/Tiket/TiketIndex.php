<?php

namespace App\Livewire\Tiket;

use Illuminate\View\View;
use Livewire\Component;
use Livewire\Attributes\Title;

class TiketIndex extends Component
{
    #[Title('Berita')]
    public function render():View
    {

        return view('livewire.tiket.tiket-index');
    }
}
