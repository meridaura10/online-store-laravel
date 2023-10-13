<div>
    <form wire:submit.prevent='createOrUpdate'>
        @component('ui.layouts.card')
            {{-- <p class="card-title">{{ $seo_template->key->label() }}</p> --}}
            <div>
                <p>{{ trans('base.parameters') }}</p>
                <div class="my-2">
                    <p>{url} - {{ trans('admin.seo.url') }};</p>
                    <p>{name} - {{ trans('admin.seo.name_parameter') }};</p>
                    <p>{description} - {{ trans('admin.seo.description_parameter') }};</p>
                </div>
            </div>
            @include('ui.form.input',[
                'model' => 'seo.url',
                'label' => 'url'
            ])
            @include('ui.form.translations', ['fields' => [
                ['name' => 'title', 'type' => 'input', 'label' => trans('base.form.seo_title')],
                ['name' => 'description', 'type' => 'input', 'label' => trans('base.form.seo_description')]
            ]])
            @include('ui.form.button')
        @endcomponent
    </form>
</div>
