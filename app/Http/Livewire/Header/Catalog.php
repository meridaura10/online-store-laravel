<?php

namespace App\Http\Livewire\Header;

use App\Models\Category;
use Livewire\Component;

class Catalog extends Component
{
    public function mount(){

    }
    public function render()
    {
        return view('livewire.header.catalog');
    }
}
