<div class="grid gap-4 p-3">
    <div class="justify-between items-center flex">
        <div>
            @include('ui.form.input', [
                'id' => 'sku.price',
                'model' => 'sku.quantity',
                'label' => 'count',
            ])
        </div>
        <div>
            <h2 class="font-bold text-lg">Sku №{{ $skuKey + 1 }}</h2>
        </div>
        <div>
            @include('ui.form.input', [
                'id' => 'sku.status',
                'model' => 'sku.price',
                'label' => 'price',
            ])
        </div>
    </div>
    <div class="grid gap-3">
        @foreach ($selectedOptionsValues as $key => $values)
            <div>
                <label for="skuOptionsValues.{{ $key }}"
                    class="block pl-2 mb-1 text-sm font-medium text-gray-900 :text-white">Select an
                    {{ $options[array_search($key, array_column($options, 'id'))]['title'] }}</label>
                <select wire:model="skuOptionsValues.{{ $key }}" id="skuOptionsValues.{{ $key }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-700 :border-gray-600 :placeholder-gray-400 :text-white :focus:ring-blue-500 :focus:border-blue-500">
                    <option selected value={{ null }}>select option
                        {{ $options[array_search($key, array_column($options, 'id'))]['title'] }}
                    </option>
                    @foreach ($values as $value)
                        <option wire:key='{{ $value['id'] }}' class="option" value="{{ $value['id'] }}">
                            {{ $value['value'] }}
                        </option>
                    @endforeach
                </select>
                @error("skusOptionsValues.$key")
                    <label class="label">
                        <span class="text-xs text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>
        @endforeach
    </div>




    <div class="">
        <div x-data="{ open: false }">

            <div>
                @if ($sku->id && count($images))
                    <button type="button" @click="open = !open" class="bg-blue-500 text-white p-2 rounded-md">
                        <span x-text="open ? 'Hide Images' : 'Show Images'"></span>
                    </button>
                    <div x-show="open" x-transition class="flex mt-4 flex-wrap gap-5">
                        @foreach ($images as $key => $image)
                            <div class="w-48 relative" wire:key="{{ $image->id }}" class="relative">
                                <div class="h-48 flex justify-center">
                                    <img class="object-contain max-h-48" src="{{ $image->url }}" alt="">
                                </div>
                                <button type="button"
                                    wire:click="removeImage({{ $key }},true)"
                                    class="absolute top-0 bg-white pl-2 pb-2 rounded-bl-full border-t border-r hover:bg-slate-100 transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                                <div class="mt-2">
                                    <label for="image-{{ $key }}"
                                        class="block text-sm font-medium text-gray-900">Image
                                        {{ $key + 1 }}</label>
                                    <input wire:model.defer='images.{{ $key }}.order' type="number"
                                        min='0' id="image-{{ $key }}" placeholder="Enter image number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            @if (count($newImages))
                <div class="flex flex-wrap gap-3">
                    @foreach ($newImages['images'] as $key => $image)
                        <div wire:key="newImages.images.{{ $key }}" class="relative w-28">
                            <img class="w-28 h-28" src="{{ $image->temporaryUrl() }}" alt="">
                            <button type="button"
                                wire:click="removeImage({{ $key }},false)"
                                class="absolute top-2 right-2 text-red-500 hover:text-red-700 cursor-pointer">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                            <div class="mt-2">
                                <label for="newImages-{{ $key }}"
                                    class="block text-sm font-medium text-gray-900">Image
                                    {{ $key + 1 }}</label>
                                <input min="0" type="number" wire:model.defer='newImages.orders.{{ $key }}'
                                    id="newImages-{{ $key }}" placeholder="order"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                @error('newImages.orders.{{ $key }}')
                                    <label class="label">
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    </label>
                                @endError
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>



    <div class="flex justify-between">
        <div>
            <button type="button" wire:click='removeSku({{ $skuKey }})' class="btn-error btn">
                delete
            </button>
        </div>
        <div>
            @error('newImages')
                <label class="label">
                    <span class="text-xs text-error">{{ $message }}</span>
                </label>
            @endError
            @error('newImages.orders')
            <label class="label">
                <span class="text-xs text-error">{{ $message }}</span>
            </label>
        @endError
            @include('ui.form.file', [
                'model' => 'newImages.images',
                'multiply' => true,
            ])
            @error('newImages.images')
                <label class="label">
                    <span class="text-xs text-error">{{ $message }}</span>
                </label>
            @endError

        </div>
        <div>
            @include('ui.form.checkbox', [
                'id' => 'sku.status',
                'label' => 'status',
                'model' => 'sku.status',
            ])
        </div>
    </div>
</div>
