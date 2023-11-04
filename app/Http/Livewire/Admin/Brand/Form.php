<?php

namespace App\Http\Livewire\Admin\Brand;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public Brand $brand;
    public $image;
    public function mount(Brand $brand)
    {
        $this->brand = $brand;
        $this->image = $brand->image;
    }
    public function rules() { 
        $rules = [
            'brand.name' => ['required'],
            'brand.id' => ['nullable'],
        ];

        $rules['image'] = $this->image instanceof Model ? ['required'] : ['required', 'image', 'max:2048'];
        $rules['image.id'] = $this->image instanceof Model ? ['exists:images,id'] : ['nullable'];

        return $rules;
        
    }
    public function updateOrCreate()
    {
        $data = $this->validate();

        $this->brand->save();
        $this->brand->update([
            'slug' => str()->slug($this->brand->name),
        ]);

        if (!$this->image instanceof Model) {
            $path = $data['image']->store("brands/" . $this->brand->id);

            $this->brand->image()->delete();

            $this->brand->image()->create([
                'order' => 0,
                'path' => $path,
                'disk' => 'local',
            ]);
        }

        return redirect()->route('admin.brands.index');
    }
    public function render()
    {
        return view('livewire.admin.brand.form');
    }
}
