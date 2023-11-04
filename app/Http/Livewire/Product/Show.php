<?php

namespace App\Http\Livewire\Product;

use App\Actions\AlsoGet;
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
    public SkuReview $review;
    public $openModalReview = false;
    public $quantityOptions;
    public $options;
    public $selectValues = [];
    public $continuation;
    public $also = [];
    public function rules()
    {
        return [
            'review.rating' => ['required'],
            'review.sku_id' => ['required'],
            'review.user_id' => ['required'],
            'review.comment' => ['required'],
        ];
    }
    public function mount(Sku $sku)
    {
        $this->also = AlsoGet::handle($sku->id);

        if (auth()->check()) {
            $this->review = SkuReview::make([
                'rating' => 5,
                'sku_id' => $this->sku->id,
                'user_id' => auth()->user()->id,
            ]);
        }

        $this->sku = $sku->load(
            'reviews.user',
            'product.propertiesValues.translations',
            'product.propertiesValues.property.parent.translations',
            'product.propertiesValues.property.translations',
            'product.skus.values.translations',
            'product.skus.values.option.translations',
        );

        $this->skus = $sku->product->skus;

        $this->reviews = $this->sku->reviews;

        $this->options = $this->mapSkuToOptionsValues($this->skus);


        $this->quantityOptions = count($this->sku->values);

        $this->setOptionsSku();

        $this->filter(null, false);

        $this->properties = $sku->product->propertiesValues->mapToGroups(function ($item) {

            return [$item->property->parent->title => $item];
        })->toArray();

        session()->put("also." . $sku->product->id, $sku->id);
    }
    public function saveReview(SkuReview $skuReview)
    {
        $this->reviews->push($skuReview);
    }
    public function openModalReview()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $this->openModalReview = true;
    }
    public function hidenModalReview()
    {
        $this->openModalReview = false;
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
        $this->filter($optionValue, true);
    }
    public function createReview()
    {
        $this->validate();

        $this->review->save();
        $this->hidenModalReview();
        $this->reviews = $this->sku->reviews()->with('user')->get();
    }
    public function filter(OptionValue|null $optionValue, $isRedirect)
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
            return $this->filter(null, true);
        };

        $this->sku = $sku;
        
        if ($isRedirect) {
            return redirect()->route('product.show', $this->sku);
        }

        $this->continuation = $this->mapSkuToOptionsValues($continuation, 'id');
    }

    public function render()
    {
        return view('livewire.product.show');
    }
}
