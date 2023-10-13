<?php

namespace App\Http\Livewire\Admin\Sku;

use App\Models\Option;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public $sku;
    public $skuKey;
    public $selectedOptionsValues;
    public $skuOptionsValues = [];
    public $options;
    public $newImages = [];
    public $images;
    public function mount(Sku $sku)
    {
        $this->images = $sku->images ?? collect();

        foreach ($sku->values as $value) {
            $this->skuOptionsValues[$value->option_id] = $value->id;
        }
    }
    public function rules()
    {
        $rules = [
            'sku.price' => ['required', 'numeric', 'min:0'],
            'sku.status' => ['nullable', 'boolean'],
            'sku.quantity' => ['required', 'numeric', 'min:0'],
            'skuOptionsValues' => ['array'],
            'sku.id' => ['nullable'],
            'skuKey' => ['required'],
        ];
        if (count($this->images)) {
            $rules['images'] = ['required'];
            $rules['images.*.order'] = ['required', 'numeric', 'min:0'];
            $rules['newImages.orders'] = ['nullable'];
            $rules['newImages'] = ['nullable', 'array'];
            $rules['newImages.images.*'] = ['nullable', 'image'];
            $rules['newImages.orders.*'] = ['nullable'];
        } else {
            $rules['newImages.orders'] = ['required'];
            $rules['newImages'] = ['required'];
            $rules['newImages.images.*'] = ['required'];
            $rules['newImages.orders.*'] = ['required'];
        }

        return $rules;
    }

    protected function getListeners()
    {
        return [
            'updateSelectedOptions' => 'updateSelectedOptions',
            "saveImagesSku.$this->skuKey" => 'saveImagesSku',
            'validateSku' => 'validated',
        ];
    }
    public function removeImage($key, $flag)
    {
        if ($flag) {
            unset($this->images[$key]);
        } else {
            unset($this->newImages['images'][$key]);
            unset($this->newImages['orders'][$key]);
        }
    }
    public function validated()
    {
        $data = $this->validate();
 
        $this->emitUp('responseSku', $data);
    }
    public function saveImagesSku($skuData)
    {
        $sku = Sku::find($skuData['id']);

        $imagesToNotDelete = array_map(function ($item) use ($sku) {

            $imageToUpdate = $sku->images()->find($item['id']);

            $imageToUpdate->update($item);

            return $item['id'];
        }, $this->images->toArray());

        $sku->images()->whereNotIn('id', $imagesToNotDelete)->delete();

        if (!count($this->newImages)) {
            return;
        }

        foreach ($this->newImages['images'] as $key => $image) {

            $path = $image->store("skus/$sku->id");

            $sku->images()->create([
                'order' => (int) $this->newImages['orders'][$key],
                'path' => $path,
                'disk' => 'local',
            ]);
        }
    }
    public function updateSelectedOptions($selectedOptionsValues)
    {
        $this->selectedOptionsValues = $selectedOptionsValues;

        if (!count($this->selectedOptionsValues)) {
            return $this->skuOptionsValues = [];
        }

        foreach ($this->skuOptionsValues as $key => $value) {

            if (!array_key_exists($key, $this->selectedOptionsValues)) {

                unset($this->skuOptionsValues[$key]);
            }
        }
    }
    public function removeSku()
    {
        $this->emit('removeSku', $this->skuKey);
    }
    public function render()
    {
        return view('livewire.admin.sku.form');
    }
}
