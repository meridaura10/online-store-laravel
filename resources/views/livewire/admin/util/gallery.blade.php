<div>
    <div class="flex mt-4 flex-wrap gap-5">
        @foreach ($images as $key => $image)
            <div class="w-48 relative border" wire:key="{{ $image->id }}">
                <div class="h-48 flex justify-center">
                    <img class="object-contain max-h-48" src="{{ $image->url }}" alt="">
                </div>
                <button type="button" wire:click="removeImage({{ $key }},true)"
                    class="absolute bg-gray-300 hover:bg-gray-400 top-0 pl-2 pr-1 pb-2 rounded-bl-full border-t border-r border-gray-300  transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                    <i class="ri-delete-bin-line"></i>
                </button>
                <div class="p-2">
                    <label for="image-{{ $key }}" class="block text-sm font-medium text-gray-900">Image
                        {{ $key + 1 }}</label>
                    <input wire:model.defer='images.{{ $key }}.order' type="number" min='0'
                        id="image-{{ $key }}" placeholder="Enter image number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </div>
            </div>
        @endforeach
    </div>


    <div>
        @if (count($newImages))
            <div class="flex flex-wrap gap-3 py-4">
                @foreach ($newImages['images'] as $key => $image)
                    <div wire:key="newImages.images.{{ $key }}" class="relative w-40 border">
                        <div class="w-40 h-40 object-contain">
                            <img class="w-40 h-40 object-contain" src="{{ $image->temporaryUrl() }}" alt="">
                        </div>
                        <button type="button" wire:click="removeImage({{ $key }},false)"
                        class="absolute bg-gray-300 hover:bg-gray-400 top-0 pl-2 pr-1 pb-2 rounded-bl-full border-t border-r border-gray-300  transition-all right-0 text-red-500 hover:text-red-700 cursor-pointer">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                        <div class="p-2">
                            <label for="newImages-{{ $key }}"
                                class="block text-sm font-medium text-gray-900">Image
                                {{ $key + 1 }}</label>
                            <input min="0" type="number"
                                wire:model.defer='newImages.orders.{{ $key }}'
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
    <div class="mt-3">
        @include('ui.form.file', [
            'model' => 'newImages.images',
            'multiply' => true,
        ])
    </div>
</div>
