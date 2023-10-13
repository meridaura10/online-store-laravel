<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\Product;
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
    public $selectedAttributesValue;
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
            'attributesValues.attribute.property.translations',
            'attributesValues.attribute.values.translations',
            'attributesValues.attribute.translations'
        ]);

        $this->selectedCategories = $product->categories->pluck('id')->toArray();

        $this->selectedAttributesValue = $product->attributesValues
            ->pluck('id', 'attribute.id')
            ->toArray();

        $this->properties = $product->attributesValues
            ->mapToGroups(function ($value) {
                return [$value->attribute->property->title => $value->attribute];
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

        $this->options = Option::query()->get()->toArray();
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
            'selectedAttributesValue' => ['required'],
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
        $this->selectedAttributesValue = [];

        $categoryIds = array_map('intval', $selectedCategoriesIds);

        $attributes =  Attribute::query()
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->with(['property.translations', 'values.translations', 'translations'])
            ->get();


        $this->properties = $attributes->mapToGroups(function ($attribute) {

            $hasAttribute = $this->product
                ->attributesValues()
                ->whereHas('attribute', function ($query) use ($attribute) {
                    return $query->where('attribute_id', $attribute->id);
                })
                ->first();

            $this->selectedAttributesValue[$attribute->id] = $hasAttribute?->id;

            return [$attribute->property->title => $attribute];
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

        $this->product->attributesValues()->sync($this->data['data']['selectedAttributesValue']);

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
