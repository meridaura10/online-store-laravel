<?php

namespace App\Http\Livewire\Product;

use App\Models\OptionValue;
use App\Models\Sku;
use App\Models\SkuReview;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Show extends Component
{
    public $properties;
    public ?Sku $sku;
    public Collection $skus;
    public Collection $reviews;
    public $quantityOptions;
    public $options;
    public $selectValues = [];
    public $continuation;
    protected $listeners  = ['save-new-review' => 'saveReview'];
    public function mount(Sku $sku)
    {
        $this->sku = $sku->load(['product.attributesValues.attribute.translations','product.attributesValues.translations','product.attributesValues.attribute.property.translations']);
        $this->skus = $sku->product->skus()->with('values.option', 'variations')->get();
        $this->reviews = $this->sku->reviews;
        $this->options = $this->mapSkuToOptionsValues($this->skus);
        $this->quantityOptions = count($this->sku->values);
        $this->setOptionsSku();
        $this->filter(null);
        $this->properties = $sku->product->attributesValues->mapToGroups(function($item) {
            return [$item->attribute->property->title => $item];
        })->toArray();
    }
    public function saveReview(SkuReview $skuReview)
    {
        $this->reviews->push($skuReview);
    }
    public function addBasket()
    {
        basket()->createItem($this->sku);
    }
    private function setOptionsSku()
    {
        foreach ($this->sku->values as $value) {
            $this->selectValues[$value->option->id] = $value->id;
        }
    }
    public function mapSkuToOptionsValues($skus, $reletion = null)
    {
        return $skus->flatMap(function ($sku) {
            return $sku->values;
        })
            ->unique('id')
            ->mapToGroups(function ($value) use ($reletion) {
                return [$value->option->title => $reletion ? $value->{$reletion} : $value];
            })->toArray();
    }
    public function selected(OptionValue $optionValue)
    {
        $this->selectValues[$optionValue->option->id] = $optionValue->id;
        $this->filter($optionValue);
    }

    public function filter(OptionValue|null $optionValue)
    {
        $continuation = collect();
        $skus = [];
        $sku = null;
        foreach ($this->skus as $skuItem) {
            $isSet = false;
            $coincidence  = 0;
            foreach ($skuItem->values as $value) {
                if ($optionValue && $optionValue->id === $value->id) {
                    $isSet = true;
                }
                if ($value->id == $this->selectValues[$value->option->id]) {
                    $coincidence++;
                }
            }
            if ($coincidence === $this->quantityOptions - 1) {
                $continuation->push($skuItem);
            }
            if ($coincidence === $this->quantityOptions) {
                $sku = $skuItem;
            }
            if ($isSet) {
                $skus[$coincidence] = $skuItem;
            }
        }

        if (!$sku) {
            ksort($skus);
            $sku = end($skus);
            $this->sku = $sku;
            $this->setOptionsSku();
            return $this->filter(null);
        };
        $this->sku = $sku;
        $this->continuation = $this->mapSkuToOptionsValues($continuation, 'id');
    }

    public function render()
    {
        return view('livewire.product.show');
    }
}
