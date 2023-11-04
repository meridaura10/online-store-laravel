<?php

namespace App\Http\Livewire\Admin\Seo;

use App\Models\Seo;
use Livewire\Component;

class Form extends Component
{
    public $translations;
    public $seo;
    public function mount(Seo $seo){
        $this->seo = $seo;
        $this->translations = $seo->getTranslationsArray();
    }
    public function rules() {
        $rules['seo.url'] = ['required'];
        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translations.$lang.description"] = ['nullable','string', 'max:190'];
        }
        return $rules;
    }
       
    public function createOrUpdate(){
        $data = $this->validate();

        $this->seo->save();

        $this->seo->update($data['translations']);

        cache()->forget($this->seo->url);

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        redirect()->route('admin.seos.index');
    }
    public function render()
    {
        return view('livewire.admin.seo.form');
    }
}
