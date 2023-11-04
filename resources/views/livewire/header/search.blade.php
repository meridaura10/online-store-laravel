<div class="w-[50%]">
    <div class="relative w-full ">
        <input wire:click="open" wire:model.debounce.500ms='value' type="text"
            class="@if ($open) rounded-t-md  border-gray-100 border-1 @else rounded-md @endIf bg-wgite relative z-10 w-full text-black px-4 py-2 transition-all  focus:outline-0"
            placeholder="Пошук">
        @if ($open)
            <div class="absolute z-10 border-t text-black  bg-white w-full py-2 rounded-b-lg shadow-2xl">

                @if ($categories->count())
                    <ul class="border-b">
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category) }}"
                                    class="block px-4 py-2 hover:opacity-100 transition-all underline-search-text-sku  hover:bg-gray-100">
                                    <div class="flex gap-3 items-center">
                                        <div>
                                            @if ($category->parent_id)
                                                <img class="h-16 w-16 object-contain" src="{{ $category->image->url }}"
                                                    alt="">
                                            @else
                                                <img class="h-16 w-16 opacity-50 transition-opacity"
                                                    src="{{ $category->image->url }}" alt="">
                                            @endIf
                                        </div>
                                        <div class="flex w-full justify-between items-center">
                                            <p class="text-gray-600 ">{{ $category->name }}</p>
                                            <span class="no-underline">категорія</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <ul>
                    @foreach ($skus as $sku)
                        <li>
                            <a href="{{ route('product.show', $sku) }}"
                                class="block px-4 py-2 transition-all underline-search-text-sku  hover:bg-gray-100">
                                <div class="flex gap-3 items-center">
                                    <div>
                                        <img class="w-16 h-16" src="{{ $sku->bannerImage->url }}" alt="">
                                    </div>
                                    <div class="flex w-full justify-between items-center">
                                        <p class="text-sky-600 ">{{ $sku->name }}</p>
                                        <span class="no-underline">{{ $sku->price }}$</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>

            </div>
        @endif
    </div>
    <div wire:click="hidden" class="@if ($open) overlay @endif">
        <div class="main"></div>
    </div>
</div>
