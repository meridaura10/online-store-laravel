<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use Livewire\Component;

class Form extends Component
{
    public Brand $brand;
    public function mount(Brand $brand)
    {
        $this->brand = $brand;
    }
    protected $rules = [
        'brand.name' => ['required']
    ];
    public function updateOrCreate()
    {
        $this->validate();
        $this->brand->save();

        return redirect()->route('admin.brands.index');
    }
    public function render()
    {
        return view('livewire.admin.brand.form');
    }
}
