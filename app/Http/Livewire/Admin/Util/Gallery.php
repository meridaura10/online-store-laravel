<?php

namespace App\Http\Livewire\Admin\Util;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithFileUploads;

class Gallery extends Component
{
    use WithFileUploads;
    public Model $model;
    public $images;
    public $newImages = [];
    public function rules()
    {
        $rules = [];
        
        $rules['images.*.id'] = ['required'];
        $rules['images.*.order'] = ['required'];


        return $rules;
    }
    public function mount(Model $model)
    {
        $this->model = $model;
        $this->images = $model->images;
    }
    public function render()
    {
        return view('livewire.admin.util.gallery');
    }
}
