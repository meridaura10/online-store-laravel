<?php

namespace App\Http\Livewire\Admin\Product\Sku;

use App\Models\Option;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public Product $product;
    public $options;
    public $selectedOptions = [];
    public $optionsValues = [];
    public $skusOptionsValues = [];
    public $newImages = [];

    public $images = [];
    public $skus;
    public function rules()
    {
        $rules = [
            'skus.*.id' => 'nullable    ',
            'skus.*.price' => 'required',
            'skus.*.status' => 'required',
            'skus.*.quantity' => 'required',
        ];

        foreach ($this->skus as $skuKey => $sku) {
            $rules["images.$skuKey"] = ['array'];

            $rules["images.$skuKey.*.order"] = ['required'];
            $rules["images.$skuKey.*.id"] = ['required'];
            $rules["images.$skuKey.*.url"] = ['required'];
            $rules["newImages.$skuKey.images.*"] = ['required'];
            $rules["newImages.$skuKey.orders.*"] = ['required'];
            $rules["skusOptionsValues"] = ['array'];
            if (count($this->selectedOptions)) {
                foreach ($this->selectedOptions as $key => $value) {
                    if ($value) {
                        $rules["skusOptionsValues.$skuKey.$key"] = ['required'];
                    } else {
                        $rules["skusOptionsValues.$skuKey"] = ['array'];
                    }
                }
            }

            if ($sku->id && count($this->images[$skuKey])) {
                $rules["newImages.$skuKey"] = ['nullable', 'array'];
            } else {
                $rules["newImages.$skuKey.images"] = ['required', 'array'];
            }

            if (array_key_exists($skuKey, $this->newImages) && array_key_exists('images', $this->newImages[$skuKey]) && is_array($this->newImages[$skuKey]['images'])) {
                foreach ($this->newImages[$skuKey]['images'] as $key => $img) {
                    $rules["newImages.$skuKey.orders"] = ['required', 'array'];
                    $rules["newImages.$skuKey.orders.$key"] = ['required'];
                    $rules["newImages.$skuKey.images.$key"] = ['required'];
                    $rules["newImages.$skuKey.images"] = ['required', 'array'];
                }
            }
        }

        return $rules;
    }

    public function mount(Product $product)
    {
        $this->skus = $product->skus->load('values.option', 'images');
        $this->options = Option::query()->with('translations', 'values.translations')->get();
        $this->product = $product;

        foreach ($this->skus as $skuKey => $sku) {

            foreach ($sku->images as $key => $image) {
                $this->images[$skuKey][$key] = [
                    'id' => $image->id,
                    'url' => $image->url,
                    'order' => $image->order,
                ];
            }

            foreach ($sku->values as $value) {
                if ($skuKey === 0) {
                    $this->selectedOptions[$value->option->id] = true;
                    $this->optionsValues[$value->option->id] = $this->options
                        ->where('id', $value->option->id)
                        ->first()
                        ->values
                        ->pluck('value', 'id')
                        ->toArray();
                }
                $this->skusOptionsValues[$skuKey][$value->option->id] = $value->id;
            }
        }
    }
    public function updatedSelectedOptions($flag, $key)
    {
        if ($flag) {
            foreach ($this->skus as $skuKey => $sku) {
                $this->skusOptionsValues[$skuKey][$key] = $sku->values->where('option_id', $key)->first()?->id;
            }
            return $this->optionsValues[$key] = $this->options->where('id', $key)
                ->first()
                ->values
                ->pluck('value', 'id')
                ->toArray();
        }

        foreach ($this->skus as $skuKey => $sku) {
            unset($this->skusOptionsValues[$skuKey][$key]);
        }

        unset($this->optionsValues[$key]);
        unset($this->selectedOptions[$key]);
    }
    public function removeImage($skuKey, $imageKey, $flag)
    {
        if ($flag) {

            unset($this->images[$skuKey][$imageKey]);
        } else {

            unset($this->newImages[$skuKey]['images'][$imageKey]);
            unset($this->newImages[$skuKey]['orders'][$imageKey]);
        }
    }
    public function addSku()
    {
        $this->skus->push(Sku::make([
            'status' => 1,
        ]));

        $this->images[] = [];

        $this->skusOptionsValues[] = array_map(function ($i) {
            return null;
        }, $this->selectedOptions);
    }
    public function save()
    {
        $data = $this->validate();

        foreach ($data['skus'] as $skuKey => $skuData) {
            if ($skuData['id']) {
                $sku = $this->product->skus()->find(intval($skuData['id']));

                $sku->update($skuData);
            } else {
                $sku = $this->product->skus()->create($skuData);
            }

    
            if (array_key_exists($skuKey, $data['skusOptionsValues'])) {
                $sku->values()->sync($data['skusOptionsValues'][$skuKey]);
            }

            $sku->update([
                'slug' => $sku->name
            ]);

            $imagesToNotDelete = array_map(function ($item) use ($sku) {

                $imageToUpdate = $sku->images()->find($item['id']);

                $imageToUpdate->update($item);

                return $item['id'];
            }, $data['images'][$skuKey]);

            $sku->images()->whereNotIn('id', $imagesToNotDelete)->delete();

            if (array_key_exists($skuKey, $this->newImages) && array_key_exists('images', $this->newImages[$skuKey])) {
                foreach ($this->newImages[$skuKey]['images'] as $key => $image) {
                    $path = $image->store("skus/$sku->id");

                    $sku->images()->create([
                        'order' => (int) $this->newImages[$skuKey]['orders'][$key],
                        'path' => $path,
                        'disk' => 'local',
                    ]);
                }
            }
        }

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        return redirect()->route('admin.products.skus.index', [
            'product' => $this->product,
        ]);
    }
    public function render()
    {
        return view('livewire.admin.product.sku.form');
    }
}
