<?php

namespace App\Http\Livewire\Admin\Property;

use App\Models\Property;
use Livewire\Component;

class Form extends Component
{
    public Property $property;
    public $parentProperties;
    public $translations = [];
    public $propertiesValues = [];
    public $translationValues = [];

    public function rules()
    {
        $rules = [
            'property.parent_id' => ['nullable'],
            'property.id' => ['nullable'],
        ];
        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];

            if ($this->property->parent_id && $this->property->parent_id !== 'null') {
                $rules["propertiesValues"] = ['required'];

                foreach ($this->propertiesValues as $key => $value) {
                    $rules["propertiesValues.$key.id"] = ['nullable'];
                    $rules["translationValues.$key.$lang.value"] = [$defaultRule, 'string', 'max:190'];
                }
            }
        }
        return $rules;
    }

    public function mount(Property $property)
    {
        $this->property = $property;
        if (!$property->id) {
            $this->property->parent_id = null;
        }
        foreach ($property->values as $key => $value) {
            $this->propertiesValues[$key] = [
                'id' => $value->id
            ];
            $this->translationValues[$key] = $value->getTranslationsArray();
        }
        $this->parentProperties = Property::query()->whereNull('parent_id')->where('id', '!=', $property->id)->with('translations')->get()->toArray();
        $this->translations = $property->getTranslationsArray();
    }
    public function addValue()
    {
        array_push($this->propertiesValues, [
            'id' => null,
        ]);
    }
    public function removeValue($key)
    {
        unset($this->propertiesValues[$key]);
        unset($this->translationValues[$key]);
    }
    public function save()
    {
        $data = $this->validate();

        if ($data['property']['id']) {
            $property = Property::query()->find($data['property']['id']);

            $property->update([
                ...$data['translations'],
                'parent_id' => $data['property']['parent_id'] === 'null' ? null : $data['property']['parent_id'],
            ]);
        } else {
            $property = Property::create([
                ...$data['translations'],
                ...$data['property'],
            ]);
        }
        if ($property->parent_id) {
            $valuesToNotDelete = array_map(function ($value, $key) use ($property, $data) {
                if ($value['id']) {

                    $value = $property->values()->find($value['id']);
                } else {

                    $value = $property->values()->create([]);
                }

                $value->update($data['translationValues'][$key]);

                return $value->id;
            }, $data['propertiesValues'], array_keys($data['propertiesValues']));

            $property->values()->whereNotIn('id', $valuesToNotDelete)->delete();
        }

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);

        return redirect()->route('admin.properties.index');
    }
    public function render()
    {
        return view('livewire.admin.property.form');
    }
}
