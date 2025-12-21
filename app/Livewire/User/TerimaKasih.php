<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('layouts.user')]

class TerimaKasih extends Component
{
    public function render()
    {
        return view('livewire.user.terima-kasih');
    }
}
