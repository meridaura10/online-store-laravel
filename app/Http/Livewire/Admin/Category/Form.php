<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Livewire\Component;

class Form extends Component
{
    public Category $category;
    public $categories;
    public $translations;
    public function mount(Category $category){
        $this->category = $category;

        if ( $this->category->status === null ) {
            $this->category->status = true;
        }
        $this->categories = Category::query()->whereNot('id',$category->id)->get();
        $this->translations = $this->category->getTranslationsArray();

    }
    public function rules()
    {
        $rules = [
            'category.status' => ['boolean']
        ];

        foreach(localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';

            $rules["translations.$lang"] = [$defaultRule, 'array'];
            $rules["category.parent_id"] = ['nullable'];
            $rules["translations.$lang.name"] = [$defaultRule, 'string', 'max:190'];
        }

        return $rules;
    }

    public function addSubCategory($key){
        $this->subCategories[$key] = [];
    }
    
    public function updateOrCreate(){
       $data = $this->validate();
        
       $this->category->save();
       $this->category->update($data['translations']);
    }
    public function render()
    {
        return view('livewire.admin.category.form');
    }
}
