<?php

namespace App\Http\Livewire\Admin\Option;

use App\Models\Option;
use App\Models\OptionValue;
use Livewire\Component;

class Form extends Component
{
    public Option $option;
    public $translations = [];
    public $translationsValues = [];
    public $values;
    public function rules()
    {
        $rules = [
            'values' => ['required'],
            'values.*.id' => ['nullable'],
            'translationsValues' => ['required']
        ];
        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translationsValues.*.$lang.value"] = [$defaultRule, 'string', 'max:190'];
        }
        return $rules;
    }
    public function addValue()
    {
        array_push($this->values, [
            'id' => null,
        ]);
    }
    public function removeValue($key)
    {
        unset($this->values[$key]);
        unset($this->translationsValues[$key]);
    }
    public function save()
    {
        $data =  $this->validate();

        $this->option->save();

        $this->option->update($data['translations']);

        $valuesNotDelete = [];

        foreach ($data['values'] as $key => $valueData) {
            if ($valueData['id']) {
                $value = OptionValue::query()->find($valueData['id']);
            }else{
                $value = $this->option->values()->create($valueData);
            }
            $valuesNotDelete[] = $value->id;
            $value->update($data['translationsValues'][$key]);
        }

        $this->option->values()->whereNotIn('id',$valuesNotDelete)->delete();

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);
    }
    public function mount(Option $option)
    {
        $option->load(['translations', 'values.translations']);
        $values = $option->values;
        $this->translations = $option->getTranslationsArray();

        foreach ($values as $key => $value) {
            $this->translationsValues[] = $value->getTranslationsArray();
        }
        $this->values = $values->toArray();
        $this->option = $option;
    }
    public function render()
    {
        return view('livewire.admin.option.form');
    }
}
