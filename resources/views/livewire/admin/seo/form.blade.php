<div class="p-6">
    <form wire:submit.prevent='createOrUpdate'>
        @component('ui.layouts.card')
            <div class="mb-2">
                <p class="text-xl font-bold"> форма seo для статичних сторінок\шаблона</p>
            </div>
            <div>
                <p>{{ trans('base.parameters') }}</p>
                <div class="my-2">
                    <p>{url} - {{ trans('admin.seo.url') }};</p>
                    <p>{name} - {{ trans('admin.seo.name_parameter') }};</p>
                    <p>{description} - {{ trans('admin.seo.description_parameter') }};</p>
                </div>
            </div>
        @endcomponent
        @component('ui.layouts.card')
            @include('ui.form.input', [
                'model' => 'seo.url',
                'label' => 'url',
            ])
        @endcomponent
        @component('ui.layouts.card')
            @include('ui.form.translations', [
                'fields' => [
                    ['name' => 'title', 'type' => 'input', 'label' => trans('base.form.seo_title')],
                    ['name' => 'description', 'type' => 'input', 'label' => trans('base.form.seo_description')],
                ],
            ])
        @endcomponent
        @component('ui.layouts.card')
            @include('ui.form.button',[
                'type' => 'submit',
            ])
        @endcomponent
    </form>
</div>
