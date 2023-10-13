<?php

namespace App\Http\Livewire\Admin\Sku;

use Livewire\Component;

class Gallery extends component
{
    // public function model(): string{
    //     return Sku::class;
    // }
    public $id;
    public function render()
    {
        return view('livewire.admin.form.gallery',[
            'skuId' => $this->id,
        ]);
    }
}
