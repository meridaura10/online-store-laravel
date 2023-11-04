<ul
    class="border-t-2 border-r-2 @if ($down === 0) grid-cols-3 grid @endif border-transparent transition-all py-2 rounded-lg">
    @foreach ($categories as $category)
        @if (count($category->subcategories) > 0)
            <li x-data="{ open: false }" class="hover:bg-blue-200 hover:border-blue-300">
                <div class="flex gap-2 mb-2 items-center cursor-pointer" @click="open = !open">
                    <i x-bind:class="open ? 'ri-arrow-right-s-line' : 'ri-arrow-down-s-line'" class="text-xl"></i>
                    <span class="font-semibold pl-2 text-lg">{{ $category->name }}</span>
                    <div class="w-5 h-5">
                        <img class="w-full h-full" src="{{ $category->image->url }}" alt="">
                    </div>
                </div>
                <ul class="border-l-4 border-b-[3px] border-white pl-4" x-show="open">
                    @include('category.tree', [
                        'categories' => $category->subcategories,
                        'down' => $down + 1,
                    ])
                </ul>
            </li>
        @else
            <li>
                <div class="flex items-center gap-3">
                    <div class="w-12 items-center h-12">
                        <img class="w-full h-full object-contain" src="{{ $category->image->url }}" alt="">
                    </div>
                    <div>
                        {{ $category->name }}
                    </div>
                    <div>
                        <div class="form-control">
                            <input wire:loading.attr="disabled" type="checkbox" wire:model='selectedCategories'
                                value="{{ $category->id }}" checked="checked" class="checkbox checkbox-accent" />
                        </div>
                    </div>
                </div>
            </li>
        @endif
    @endforeach
</ul>
