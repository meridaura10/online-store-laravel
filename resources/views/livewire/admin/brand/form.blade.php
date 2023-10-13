<div class="p-4 w-full">
    <form wire:submit.prevent='updateOrCreate' class="w-full">
        <div class="card shadow-lg bg-base-100 mb-4">
            <div class="card-body">
                @include('ui.form.input', [
                    'model' => 'brand.name',
                    'label' => 'Brand name',
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
