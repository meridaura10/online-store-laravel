<div class="p-4 w-full">
    <form wire:submit.prevent='updateOrCreate' class="w-full">
        <div class="card shadow-lg bg-base-100 mb-4">
            <div class="card-body">

                @include('ui.form.translations', ['fields' => [['name' => 'name', 'type' => 'input']]])


                @include('ui.form.selectSearch', [
                    'valueName' => 'name',
                    'label' => 'parent category',
                    'model' => 'parent',
                    'default' => 'this category is parent',
                    'value' => $parent['name'] ?? 'виберіть батьківську категорію ( не обов`язково ) або категорія буде батьківська ',
                    'options' => $categories,
                    'searchModel' => 'searchCategory',
                ])

                <div class="my-6">
                    <div class="h-24 flex justify-between items-end">
                        @if ($image)
                            <div class="h-full">
                                <img class="h-full w-full object-contain"
                                    src="{{ $image->url ?? $image->temporaryUrl() }}" alt="">
                            </div>
                        @endif
                        <div>
                            @include('ui.form.file', [
                                'model' => 'image',
                                'label' => 'new image',
                                'multiple' => false,
                            ])
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button class='btn btn-accent'>
                        {{ trans('base.save') }}
                    </button>
                    <div class="mr-8">
                        @include('ui.form.checkbox', [
                            'id' => 'status',
                            'label' => trans('base.status'),
                            'model' => 'category.status',
                        ])
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
