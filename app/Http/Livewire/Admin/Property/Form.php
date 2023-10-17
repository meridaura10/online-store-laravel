<?php

namespace App\Http\Livewire\Admin\Property;

use App\Models\Property;
use Livewire\Component;

class Form extends Component
{
    public Property $property;
    public $parentProperties;
    public $subProperties;
    public $translations = [];
    public $propertiesValues = [];
    public $translationsSubProperties = [];
    public $translationsPropertyValues = [];

    public function rules()
    {
        $rules = [
            'property.parent_id' => ['nullable'],
            'property.id' => ['nullable'],
            'translationsSubProperties' => ['required'],
            'translationsPropertyValues' => ['required'],
        ];
        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';
            $rules["translations.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translationsSubProperties.*.$lang.title"] = [$defaultRule, 'string', 'max:190'];
            $rules["translationsPropertyValues.*.*.$lang.value"] = [$defaultRule, 'string', 'max:190'];
        }
        return $rules;
    }

    public function mount(Property $property)
    {
        $this->property = $property;
        $this->parentProperties = Property::query()->whereNull('parent_id')->where('id', '!=', $property->id)->with('translations')->get()->toArray();
        $this->translations = $property->getTranslationsArray();

        $subProperties = $property->subproperties()->with('translations', 'values.translations')->get();
        if ($subProperties->empty()) {
            $this->propertiesValues = $property->values->toArray();
        } else {
            foreach ($subProperties as $keyProperty => $property) {

                $this->translationsSubProperties[$keyProperty] = $property->getTranslationsArray();

                foreach ($property->values as $key => $value) {
                    $this->propertiesValues[$keyProperty][$key] = $value;
                    $this->translationsPropertyValues[$keyProperty][$key] = $value->getTranslationsArray();
                }
            }
        }



        $this->subProperties = $subProperties->toArray();
    }
    public function addSubProperty()
    {
        array_push($this->subProperties, ['id' => null,]);
        array_push($this->propertiesValues, ['id' => null]);
        array_push($this->translationsSubProperties, []);
    }
    public function removeSubProperty($key)
    {
        unset($this->subProperties[$key]);
        unset($this->translationsSubProperties[$key]);
    }
    public function addValueProperty()
    {
        array_push($this->propertiesValues, []);
    }
    public function removeSubPropertyValue($key, $keyValue)
    {
        unset($this->propertiesValues[$key][$keyValue]);
        unset($this->translationsPropertyValues[$key][$keyValue]);
    }
    public function save()
    {
        $data = $this->validate();

        $propertyData = $data['property'];

        $property = Property::query()->find($propertyData['id']);

        $property->update([
            'parent_id' => $propertyData['parent_id'] === 'null' ? null : $propertyData['parent_id'],
        ]);

        // if ($property->parent_id) {
        //     $property->subproperties()->delete();

        // }

        // if ($) {
        //     dd('app');
        // }else{


        //     dd($property);
        // }


        dd($data);
    }
    public function addValueToSubProperty($key)
    {
        array_push($this->subProperties[$key]['values'], [
            'id' => null,
        ]);
        array_push($this->translationsPropertyValues[$key], []);
    }

    public function render()
    {
        return view('livewire.admin.property.form');
    }
}
