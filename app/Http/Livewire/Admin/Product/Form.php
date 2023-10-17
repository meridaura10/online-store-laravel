<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\Property;
use App\Models\Sku;
use App\Models\SkuImage;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    public Product $product;
    public $properties;
    public $selectedPropertiesValue;
    public $selectedCategories = [];
    public array $translations = [];
    public $categories;
    public $brands;
    public Collection $skus;
    public $options = [];
    public $data = [];
    public $selectedOptionsValues = [];
    public $isSaved = false;

    protected $listeners = [
        'responseSku',
        'removeSku',
    ];

    public function mount(Product $product)
    {
        $this->product = $product->load([
            'propertiesValues.property.parent.translations',
            'propertiesValues.property.values.translations',
            'propertiesValues.property.translations'
        ]);

        $this->selectedCategories = $product->categories->pluck('id')->toArray();

        $this->selectedPropertiesValue = $product->propertiesValues
            ->pluck('id', 'property.id')
            ->toArray();
        $this->properties = $product->propertiesValues
            ->mapToGroups(function ($value) {
                return [$value->property->parent->title => $value->property];
            })
            ->toArray();

        $this->translations = $product->getTranslationsArray();
        $this->brands = Brand::all();
        $this->categories = Category::query()
            ->with(
                'image',
                'translations',
                'subcategories.translations',
                'subcategories.image'
            )
            ->whereNull('parent_id')->get();

        $this->options = Option::query()->with('translations', 'values.translations')->get()->toArray();
        $this->skus = $product->skus()->with(
            'values.option.values',
            'images',
        )->get();

        if (!$product->id) {
            return $this->addSku();
        }

        foreach ($this->skus[0]->values as $value) {
            $this->selectedOptionsValues[$value->option->id] = $value->option->values;
        }
    }
    public function rules()
    {
        $rules = [
            'product.status' => ['boolean'],
            'product.brand_id' => ['required', 'exists:brands,id'],
            'skus' => ['required', 'array'],
            'selectedPropertiesValue' => ['required'],
            'selectedCategories' => ['required'],
        ];

        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.name"] = [$defaultRule, 'string', 'max:190'];
        }
        return $rules;
    }

    public function addSku()
    {
        $this->skus->push(
            Sku::make([
                'status' => 1,
            ])
        );
    }
    public function removeSku($key)
    {
        unset($this->skus[$key]);
    }
    public function updatedSelectedCategories($selectedCategoriesIds)
    {
        $this->selectedPropertiesValue = [];

        $categoryIds = array_map('intval', $selectedCategoriesIds);

        $properties =  Property::query()
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->with(['parent.translations', 'values.translations', 'translations'])
            ->get();


        $this->properties = $properties->mapToGroups(function ($property) {

            $hasProperty= $this->product
                ->propertiesValues()
                ->whereHas('property', function ($query) use ($property) {
                    return $query->where('property_id', $property->id);
                })
                ->first();

            $this->selectedPropertiesValue[$property->id] = $hasProperty?->id;

            return [$property->parent->title => $property];
        })->toArray();
    }

    public function responseSku($data)
    {
        $this->data['skus'][] = $data;

        if ($this->skus->count() === count($this->data['skus'])) {
            $this->updateOrCreate();
        }
    }
    private function updateOrCreate()
    {
        $this->product->save();

        $this->product->categories()->sync($this->data['data']['selectedCategories']);

        $this->product->propertiesValues()->sync($this->data['data']['selectedPropertiesValue']);

        $this->product->update($this->data['data']['translations']);

        $skuToNotDelete = [];

        foreach ($this->data['skus'] as $skuData) {

            if ($skuData['sku']['id']) {

                $sku = $this->product->skus()->find($skuData['sku']['id']);

                $sku->update($skuData['sku']);
            } else {
                $sku = $this->product->skus()->create($skuData['sku']);
            }
            $skuToNotDelete[] = $sku['id'];

            $this->emit("saveImagesSku." . $skuData['skuKey'], $sku);

            $sku->values()->sync($skuData['skuOptionsValues']);
        }
        $this->product->skus()->whereNotIn('id', $skuToNotDelete)->delete();

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        $this->isSaved = false;
    }
    public function save()
    {
        $this->isSaved = true;

        $this->data = [];

        alert()->setData([
            'message' => 'зачекайте йде процес збереження данних будь ласка не закривайте сторінку',
            'type' => 'info',
            'dellay' => false,
        ]);

        alert()->open($this);

        $this->data['data'] = $this->validate();

        $this->emit('validateSku');

        // return redirect()->route('admin.products.show', $this->product);
    }
    public function selectOption(Option $option, $flag)
    {
        if ($flag) {
            $this->selectedOptionsValues[$option->id] = $option->values;
        } else {
            unset($this->selectedOptionsValues[$option->id]);
        }
        $this->emit('updateSelectedOptions', $this->selectedOptionsValues);
    }
    public function render()
    {
        return view('livewire.admin.product.form');
    }
}
