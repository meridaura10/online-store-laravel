<div class="p-4 w-full">
    <form wire:submit.prevent='updateOrCreate' class="w-full">

        @component('ui.layouts.card')
            @include('ui.form.input', [
                'model' => 'brand.name',
                'label' => 'Brand name',
            ])
            <div class="my-6">
                <div class="h-24 flex justify-between items-end">
                    @if ($image)
                        <div class="h-full">
                            <img class="h-full w-full object-contain" src="{{ $image->url ?? $image->temporaryUrl() }}"
                                alt="">
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
        @endcomponent

        @component('ui.layouts.card')
            @include('ui.form.button', [
                'type' => 'submit',
            ])
        @endcomponent

    </form>
</div>
