<form wire:submit.prevent='save' class="overflow-x-auto p-6" x-data="{ openModal: false }">
    <dialog id="modal" class="modal modal-vertical" x-bind:open="!openModal ? false : true">
        <div class="w-screen h-screen relative  bg-base-content opacity-40">

        </div>


        <div class="modal-box absolute top-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
            <div class=" border-b">
                <h2 class="pb-2 font-bold text-xl">select options</h2>
            </div>
            <div class="my-2">
                @foreach ($options as $key => $option)
                    <div class="flex gap-2" wire:key='select.{{ $option->id }}.option.modal'>
                        <div class="w-full">

                            <label class="label flex justify-between cursor-pointer">
                                <span class="font-bold">{{ $option->title }}</span>
                                <input type="checkbox" wire:loading.attr="disabled"
                                    wire:model="selectedOptions.{{ $option->id }}" class="toggle" />
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between pt-2 border-t items-center">
                <div class="mt-1">
                    <button type="button" @click="openModal = false" class="btn">{{ trans('base.close') }}</button>
                </div>
            </div>
        </div>

    </dialog>
    @component('ui.layouts.card')
        <div class="flex items-center justify-between">
            <div class="flex gap-2 items-center">
                <h2 class="text-xl font-bold">форма створення\редагування skus продукта: {{ $product->name }}</h2>
                <a class="opacity-80 hover:opacity-100 transition-opacity" href="{{ route('admin.products.edit',$product) }}">
                    <i class="ri-edit-2-line text-2xl"></i>
                </a>
            </div>
            <div class="flex gap-2">
                <div>
                    <button type="button" wire:click='addSku' class="btn btn-accent">
                        <i class="ri-add-line"></i>
                    </button>
                </div>
                <div @click="openModal = true">
                    @include('ui.form.button', [
                        'name' => 'вибрати опції',
                    ])
                </div>
            </div>
        </div>
    @endcomponent
    @component('ui.layouts.card')
        <table class="table">
            <thead>
                <tr class="select-none">
                    <th>price</th>
                    <th>quantity</th>
                    @foreach ($selectedOptions as $optionId => $flag)
                        <th wire:key='{{ $optionId }}.option.th'> {{ $options->where('id', $optionId)->first()->title }}
                        </th>
                    @endforeach
                    <th>status</th>
                    <th>images</th>
                </tr>
            </thead>
            <tbody x-data="{ select: [] }">
                @foreach ($skus as $skuKey => $sku)
                    <div wire:key="skus.{{ $skuKey }}.table.item">
                        <tr x-bind:class="select.includes({{ $skuKey }}) ? 'bg-blue-100' : ''" class="hover">
                            <td>
                                @include('ui.form.input', [
                                    'model' => "skus.$skuKey.price",
                                ])
                            </td>
                            <td>
                                @include('ui.form.input', [
                                    'model' => "skus.$skuKey.quantity",
                                ])
                            </td>

                            @foreach ($optionsValues as $optionId => $values)
                                <th wire:key="{{ $optionId }}.option.values.select.sku.{{ $skuKey }}">
                                    @include('ui.form.select', [
                                        'default' => 'select' . ' ' . $options->where('id', $optionId)->first()->title,
                                        'defaultDisabled' => true,
                                        'model' => "skusOptionsValues.$skuKey.$optionId",
                                        'simple' => true,
                                        'options' => $values,
                                    ])
                                </th>
                            @endforeach

                            <td>
                                @include('ui.form.checkbox', [
                                    'model' => "skus.$skuKey.status",
                                ])
                            </td>

                            <td
                                @click="select.includes({{ $skuKey }}) ? select = select.filter(item => item !== {{ $skuKey }}) : select.push({{ $skuKey }})">
                                <i x-bind:class="select.includes({{ $skuKey }}) ? 'ri-arrow-down-s-fill' : 'ri-arrow-up-s-fill'"
                                    class="text-xl"></i>
                            </td>
                        </tr>
                        <tr x-bind:class="select.includes({{ $skuKey }}) ? 'bg-blue-100' : ''" class="hover"
                            x-show="select.includes({{ $skuKey }})" x-transition>
                            <td class="h-32" colspan="{{ 4 + count($selectedOptions) }}">
                                <div class="">
                                    <div class="flex mt-4 flex-wrap gap-5">
                                        @if (isset($sku->id))
                                            @foreach ($images[$skuKey] as $key => $image)
                                                <div wire:key='{{ $image['id'] }}.image.{{ $skuKey }}'
                                                    class="w-48 relative">
                                                    <div class="h-48 flex justify-center">
                                                        <img class="object-contain max-h-48" src="{{ $image['url'] }}"
                                                            alt="">
                                                    </div>
                                                    <button type="button"
                                                        wire:click="removeImage({{ $skuKey }}, {{ $key }}, true)"
                                                        class="absolute top-0 bg-white pl-2 pb-2 rounded-bl-full border-t border-r hover:bg-gray-300 transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                    <div class="mt-2">
                                                        <input
                                                            wire:model.defer='images.{{ $skuKey }}.{{ $key }}.order'
                                                            type="number" min='0' placeholder="order"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                        @if (array_key_exists($skuKey, $newImages))
                                            @foreach ($newImages[$skuKey]['images'] as $key => $image)
                                                <div class="w-48 relative"
                                                    wire:key="{{ $key }}.newImages.{{ $key }}"
                                                    class="relative">
                                                    <div class="h-48 flex justify-center">
                                                        <img class="object-contain max-h-48"
                                                            src="{{ $image->temporaryUrl() }}" alt="">
                                                    </div>
                                                    <button type="button"
                                                        wire:click="removeImage({{ $skuKey }},{{ $key }},false)"
                                                        class="absolute top-0 bg-white pl-2 pb-2 rounded-bl-full border-t border-r hover:bg-gray-300 transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                    <div class="mt-2">
                                                        <input
                                                            wire:model.defer='newImages.{{ $skuKey }}.orders.{{ $key }}'
                                                            type="number" min='0' placeholder="order"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif


                                    </div>
                                    <div class="mt-2">
                                        @include('ui.form.file', [
                                            'model' => "newImages.$skuKey.images",
                                            'multiply' => true,
                                        ])
                                    </div>
                                </div>




                            </td>
                        </tr>
                    </div>
                @endforeach
            </tbody>
        </table>
    @endcomponent

    @component('ui.layouts.card')
        <div class="flex items-center gap-2 justify-between">
            <div>
                @include('ui.form.button', [
                    'type' => 'submit',
                ])
            </div>
            @if ($errors->any())
                <div class="p-2">
                    @foreach ($errors->all() as $error)
                        <span class="text-xs text-error">{{ $error }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    @endcomponent
</form>
