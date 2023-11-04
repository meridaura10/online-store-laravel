<?php

namespace App\Http\Livewire\Admin\Seo;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class DynamicForm extends Component
{
    public Model $model;
    public array $translations = [];
    public $seo;
    public function mount(Model $model)
    {
        $this->model = $model;
        $this->seo = $model->seo;
        $this->translations = $this->seo?->getTranslationsArray() ?? [];
    }
    public function rules()
    {
        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translations.$lang.description"] = ['string', 'max:190'];
        }

        return $rules;
    }
    public function save()
    {
        $data = $this->validate();

        $this->model->seo()->updateOrCreate(
            [
                'id' => $this->seo?->id,
            ],
            [
                ...$data['translations'],
            ]
        );

       
        cache()->forget('seo_' + $this->model->id);

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        return redirect()->route('admin.seos.index');
    }
    public function deleteSeo()
    {
        $this->seo->delete();

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        return redirect()->route('admin.seos.index');
    }
    public function render()
    {
        return view('livewire.admin.seo.dynamic-form');
    }
}
