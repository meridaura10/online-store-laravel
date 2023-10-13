<?php

namespace App\Http\Livewire\Util;

use App\Models\Sku;
use App\Models\SkuReview;
use Livewire\Component;

class FormSkuReview extends Component
{
    public $open = false;
    public SkuReview $skuReview;
    public Sku $sku;
    protected $listeners  = ['open-modal-form-sku-review' => 'open'];
    public function mount(Sku $sku)
    {
        $this->sku = $sku;
    }
    public function rules()
    {
        return [
            'skuReview.rating' => ['required'],
            'skuReview.comment' => ['required'],
            'skuReview.sku_id' => ['required'],
            'skuReview.user_id' => ['required'],
        ];
    }
    public function open()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $this->skuReview = new SkuReview;
        $this->skuReview->sku_id = $this->sku->id;
        $this->skuReview->rating = '5';
        $this->skuReview->user_id = auth()->user()->id;
        $this->open = true;
    }
    public function submit()
    {
        $this->validate();
        $this->skuReview->save();
        $this->emit('save-new-review',$this->skuReview);
        $this->open = false;
    }
    public function render()
    {
        return view('livewire.util.form-sku-review');
    }
}
