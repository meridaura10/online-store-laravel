<?php

namespace App\Http\Livewire\Admin\Product;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\Property;
use App\Models\Sku;
use Illuminate\Support\Collection;
use Livewire\Component;

class Form extends Component
{
    public Product $product;
    public $properties;
    public $selectedCategories = [];
    public array $translations = [];
    public array $selectedPropertiesValue = [];
    public $brands;    
    public $searchCategories;
    public $categories;
    protected $listeners = [
        'responseSku',
        'removeSku',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
  
        $this->selectedCategories = $product->categories->pluck('id')->toArray();
        
        $this->updatedSelectedCategories($this->selectedCategories);

        $this->translations = $product->getTranslationsArray();

        $this->brands = Brand::all();
    }
    public function rules()
    {
        $rules = [
            'product.status' => ['boolean'],
            'product.brand_id' => ['required', 'exists:brands,id'],
            'selectedPropertiesValue' => ['array'],
            'selectedCategories' => ['required'],
        ];

        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.name"] = [$defaultRule, 'string', 'max:190'];
        }
        return $rules;
    }
    public function updatedSelectedCategories($selectedCategoriesIds)
    {
        $this->selectedPropertiesValue = [];

        $categoryIds = array_map('intval', $selectedCategoriesIds);

        $properties =  Property::query()
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->with('parent.translations', 'values.translations', 'translations')
            ->get();


        $this->properties = $properties->mapToGroups(function ($property) {

            $hasProperty = $this->product
                ->propertiesValues
                ->where('property_id', $property->id)
                ->first();

            $this->selectedPropertiesValue[$property->id] = $hasProperty?->id;

            return [$property->parent->title => $property];
        })->toArray();
    }

    public function save()
    {
        $data = $this->validate();

        $this->product->save();

        foreach ($data['selectedPropertiesValue'] as $key => $propertyId) {
            if ($propertyId === 'null' || !$propertyId) {
                unset($data['selectedPropertiesValue'][$key]);
            }
        }

        $this->product->categories()->sync($data['selectedCategories']);

        $this->product->propertiesValues()->sync($data['selectedPropertiesValue']);

        $this->product->update($data['translations']);

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        return redirect()->route('admin.products.skus.form', $this->product);
    }
    public function render()
    {
        return view('livewire.admin.product.form');
    }
}
