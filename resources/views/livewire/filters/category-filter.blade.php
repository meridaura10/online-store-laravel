<div>
    <ul class="grid gap-4">
        @foreach ($filter->values as $key => $categories)
            <li x-data="{ open: false }">
                <div class="w-full hover:text-red-400  text-blue-600 ">
                    <div  class="flex justify-between items-center cursor-pointer">
                        <h2 wire:click="$set('f.{{ $filter->key }}.{{ str()->slug($categories[0]['parentName']) }}','{{ $key }}')"
                            class="py-1 transition-colors">
                            {{ $categories[0]['parentName'] }}
                            <span
                                class="text-gray-400 text-sm pl-1">{{ count($categories) > 0 ? count($categories) : '' }}</span>
                        </h2>
                        <i x-on:click="open = ! open" x-bind:class="open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"
                            class="text-2xl text-gray-500"></i>
                    </div>
                </div>
                <ul x-show="open">
                    @foreach ($categories as $key => $category)
                        @foreach ($category['category'] as $key => $name)
                            <li
                                class="hover:text-red-400 cursor-pointer pl-2 text-sm transition-colors mt-2  text-sky-700">
                                <a href="{{ route('categories.show', $key) }}">{{ $name }}</a>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
