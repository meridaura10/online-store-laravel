<div class='w-full p-4'>
    <div class="modal z-10" @if ($isSaved) open @endif>

    </div>
    <form x-data="{ open: false }" wire:submit.prevent='save' class="w-full">
        @component('ui.components.card')
            <h2 class="font-bold text-xl">
                Product
            </h2>
        @endComponent

        @component('ui.components.card')
            @include('ui.form.translations', ['fields' => [['name' => 'name', 'type' => 'input']]])
            <div>
                <div>
                    @include('ui.form.select', [
                        'label' => 'brand',
                        'options' => $brands,
                        'model' => 'product.brand_id',
                        'default' => 'select brand',
                        'keyName' => 'id',
                        'valueName' => 'name',
                    ])


                    @component('ui.components.accordion', ['title' => 'select categories'])
                        <ul class="grid justify-between gap-3 grid-cols-3">
                            @foreach ($categories as $category)
                                <li
                                    class="hover:bg-blue-200 hover:border-blue-300 border-t-2 border-r-2 border-transparent transition-all pt-2 rounded-lg">
                                    <div class="flex gap-2 mb-2 items-center">
                                        <span class="font-semibold pl-2 text-lg"> {{ $category->name }}</span>
                                        <div class="w-5 h-5">
                                            <img class="w-full h-full" src="{{ $category->image->url }}" alt="">
                                        </div>
                                    </div>
                                    <ul class="border-l-4 border-b-[3px] border-white pl-3">
                                        @foreach ($category->subcategories as $subCategory)
                                            <li class="flex items-center gap-3">
                                                <div class="w-12 items-center h-12">
                                                    <img class="w-full h-full object-contain"
                                                        src="{{ $subCategory->image->url }}" alt="">
                                                </div>
                                                <div>
                                                    {{ $subCategory->name }}
                                                </div>
                                                <div>
                                                    <div class="form-control">
                                                        <input wire:loading.attr="disabled" type="checkbox"
                                                            wire:model='selectedCategories' value="{{ $subCategory->id }}"
                                                            checked="checked" class="checkbox checkbox-accent" />
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @endcomponent


                    @if (count($selectedCategories))
                        @component('ui.components.accordion', ['title' => 'properties product'])
                            <ul class="p-4 grid gap-4 pt-0">
                                @foreach ($properties as $key => $subProperties)
                                    <li>
                                        <div class="text-xl font-bold">
                                            {{ $key }}
                                        </div>
                                        <ul class="grid gap-2">
                                            @foreach ($subProperties as $subProperty)
                                                <li class="flex justify-between items-center">
                                                    <span
                                                        class="w-full before:w-full gap-3 whitespace-nowrap before:h-[1px] before:block before:mb-1 flex flex-row-reverse items-end before:bg-gray-400">{{ $subProperty['title'] }}</span>
                                                    <div class="pl-3 w-full">
                                                        @include('ui.form.select', [
                                                            'label' => null,
                                                            'model' => "selectedPropertiesValue.{$subProperty['id']}",
                                                            'options' => $subProperty['values'],
                                                            'isArray' => true,
                                                            'default' => 'пусто',
                                                            'defaultDisabled' => false,
                                                            'keyName' => 'id',
                                                            'styleSelect' => 'bg-sky-100',
                                                            'valueName' => 'value',
                                                        ])
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        @endcomponent
                    @endif

                    @if ($product->category_id)
                        <div class="mt-3">
                            <button wire:click='$emit("modal-product-properties-open")' type="button" class="btn">
                                select properties
                            </button>
                        </div>
                    @endif
                    <div class="mt-1">
                        @include('ui.form.checkbox', [
                            'id' => 'status',
                            'label' => 'status',
                            'model' => 'product.status',
                        ])
                    </div>
                </div>
            </div>
        @endComponent


        <dialog id="modal" class="modal modal-vertical" x-bind:open="!open ? false : true">
            <div class="w-screen h-screen relative  bg-base-content opacity-40">

            </div>


            <div class="modal-box absolute top-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
                <div class=" border-b">
                    <h2 class="pb-2 font-bold text-xl">select options</h2>
                </div>
                <div class="my-2">
                    @foreach ($options as $option)
                        <div class="flex gap-2" wire:key='select.{{ $option['id'] }}'>
                            <div class="w-full">
                                <label class="label flex justify-between cursor-pointer">
                                    <span class="font-bold">{{ $option['title'] }}</span>
                                    <input type="checkbox" @if (array_key_exists($option['id'], $selectedOptionsValues)) checked @endif
                                        wire:change="selectOption({{ $option['id'] }}, $event.target.checked)"
                                        class="toggle" />
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between pt-2 border-t items-center">
                    <div class="mt-1">
                        <button type="button" @click="open = false" class="btn">{{ trans('base.close') }}</button>
                    </div>
                </div>
            </div>

        </dialog>

        <div>
            @component('ui.components.card')
                <div class="flex justify-between items-center px-4 py-2">
                    <h2 class="font-bold my-4 text-xl">
                        skus
                    </h2>
                    <div class="flex items-center gap-4">
                        <button @click="open = true" type="button" class="btn">
                            select option
                        </button>
                        <div>
                            <button wire:click='addSku' type="button" class="btn btn-accent rounded-3xl">
                                <i class="ri-add-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endComponent

            <div class="grid gap-4">
                @foreach ($skus as $skuKey => $sku)
                    @component('ui.components.card')
                        @livewire(
                            'admin.sku.form',
                            [
                                'sku' => $sku,
                                'skuKey' => $skuKey,
                                'selectedOptionsValues' => $selectedOptionsValues,
                                'options' => $options,
                            ],
                            key($skuKey)
                        )
                    @endComponent
                @endforeach
                <button type="submit" class="btn mt-2">
                    submit
                </button>
            </div>
        </div>



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
