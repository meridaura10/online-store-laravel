<div class="p-4 w-full">
    <form wire:submit.prevent='updateOrCreate' class="w-full">
        <div class="card shadow-lg bg-base-100 mb-4">
            <div class="card-body">

                @include('ui.form.translations', ['fields' => [['name' => 'name', 'type' => 'input']]])

                @include('ui.form.checkbox', [
                    'id' => 'status',
                    'label' => trans('base.status'),
                    'model' => 'category.status',
                ])
                @include('ui.form.select',[
                    'id' => 'category',
                    'label' => 'parent category',
                    'options' => $categories,
                    'keyName' => 'id',
                    'valueName' => 'name',
                    'default' => 'виберіть батьківську категорію(не обов`язково)',
                    'model' => 'category.parent_id',
                ])
                <div>
                    <button class='btn btn-accent'>
                        {{ trans('base.save') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
