<?php

namespace App\Http\Livewire\Admin\Category;

use App\Models\Category;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;
    public Category $category;
    public $parent;
    public $categories;
    public $translations;
    public $searchCategory;
    public $image;
    public function mount(Category $category)
    {
        $this->category = $category;

        if ($this->category->status === null) {
            $this->category->status = true;
        }

        $this->parent = $category->parent()->with('translations')->first()?->toArray();

        $this->categories = collect();

        $this->image = $category->image;


        $this->translations = $this->category->getTranslationsArray();
    }
    public function rules()
    {
        $rules = [
            'category.status' => ['boolean'],
            'parent' => ['nullable'],
        ];

        $rules['image'] = $this->image instanceof Model ? ['required'] : ['required', 'image', 'max:2048'];
        $rules['image.id'] = $this->image instanceof Model ? ['exists:images,id'] : ['nullable'];

        foreach (localization()->getSupportedLocalesKeys() as $lang) {
            $defaultRule = $lang == localization()->getDefaultLocale()  ? 'required' : 'nullable';

            $rules["translations.$lang"] = [$defaultRule, 'array'];
            $rules["translations.$lang.name"] = [$defaultRule, 'string', 'max:190'];
        }

        return $rules;
    }
    private function makeQuery()
    {
        return Category::query()->whereNot('id',$this->category->id)->with('translations')->take(20);
    }
    public function updatedSearchCategory($value)
    {
        $this->categories = $this->makeQuery()->search($value)->get();
    }
    public function updateOrCreate()
    {
        $data = $this->validate();

        $this->category->parent_id = $data['parent'] ? $data['parent']['id'] : null;

        $this->category->save();

        $this->category->update($data['translations']);

        if (!$this->image instanceof Model) {
            $path = $data['image']->store("categories/" . $this->category->id);

            $this->category->image()->delete();

            $this->category->image()->create([
                'order' => 0,
                'path' => $path,
                'disk' => 'local',
            ]);
        }

        alert()->setData([
            'message' => 'данні успішно збережені',
            'type' => 'success',
            'dellay' => 3000,
        ]);

        alert()->open($this);
    }
    public function render()
    {
        return view('livewire.admin.category.form');
    }
}
