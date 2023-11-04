<div class='w-full p-4'>
    <form x-data="{ open: false }" wire:submit.prevent='save' class="w-full">
        @component('ui.layouts.card')
            <h2 class="font-bold text-xl">
                Форма {{ $product->id ? "редагування продукта: $product->name" : 'редагування продукта' }}
            </h2>
        @endComponent

        @component('ui.layouts.card')
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

                    @component('ui.components.accordion', [
                        'title' => 'select categories'
                        ])
                        @include('category.tree', [
                            'categories' => $categories,
                            'down' => 0,
                        ])
                    @endcomponent



                    @if (count($properties))
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


        @component('ui.layouts.card')
            <div>
                <button type="submit" class="btn mt-2">
                    submit
                </button>
            </div>
        @endComponent




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
