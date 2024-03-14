<?php

namespace App\Livewire\Forms;

use App\Models\Tiket;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TiketForm extends Form
{
    public ?Tiket $tiket;
    public $id;


    public function setTiket(Tiket $tiket){
        $this->tiket = $tiket;

        $this->id = $tiket->id;

    }
    public function setUser(): array
    {
        return User::pluck('name', 'id')->all();
    }

    public function store()
    {
        $this->validate();

        Order::create([
            'user_id' => $this->user,
            'tiket_id' => $this->tiket,])
    }
}
