<div class="p-6">
    <form wire:submit.prevent='save'>
        @component('ui.layouts.card')
            <div>
                <div class="mb-2">
                    <h2 class="text-xl font-bold">
                        @if ($seo)
                            Форма редагування seo
                        @else
                            Форма створення seo
                        @endif
                    </h2>
                </div>
                <p>{{ trans('base.parameters') }}</p>
                <div class="my-2">
                    <p>{name} - {{ trans('admin.seo.name_parameter') }};</p>
                    <p>{description} - {{ trans('admin.seo.description_parameter') }};</p>
                </div>
            </div>
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
            <div class="flex justify-between items-center">
                @include('ui.form.button', [
                    'type' => 'submit',
                ])
                @if ($seo)
                  <div wire:click='deleteSeo'>
                    @include('ui.form.button', [
                        'name' => 'delete',
                        'style' => 'btn-error',
                    ])
                  </div>
                @endif
            </div>
        @endcomponent

        @if ($errors->any())
            <div class="card shadow-lg bg-base-100 mb-4">
                <div class="card-body">
                    <div class="p-2">
                        @foreach ($errors->all() as $error)
                            <span class="text-xs text-error">{{ $error }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </form>
</div>
