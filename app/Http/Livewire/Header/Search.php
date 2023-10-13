<?php

namespace App\Http\Livewire\Header;

use Livewire\Component;

class Search extends Component
{
    public $value = '';
    public $showDropdown = false;
    public function show()
    {
        $this->showDropdown = true;
    }
    public function hidden()
    {
        $this->showDropdown = false;
    }
    public function render()
    {
        
        return view('livewire.header.search');
    }
}
