<div x-data="{ selected: 1,open: false }" >
    <button @click="open = true"
        class="ml-4 px-6 py-2 rounded-lg bg-[#fff3] transition-all hover:bg-[#ffffff46] hover:text-white">Каталог</button>
    <div x-show="open" x-bind:class="open ? 'overlay' : ''">
        <div class="main"></div>
    </div>
    {{-- <div x-show="open" @click.away="open = false" class="top-full z-50 w-[1200px]  absolute">
        <div class="bg-white text-black p-4 flex  gap-3">
            <div class="w-[300px]">
                <ul class="gap-3 grid">
                    @foreach ($categories as $category)
                        <li @mouseover="selected = {{ $category->id }}"
                            class="flex hover:underline items-center text-[#3e77aa] text-lg cursor-pointer transition-all hover:text-[#f84147]">
                            <img src="{{ $category->image->url }}" class="h-7 w-7 opacity-40" alt="">
                            <span class="ml-2 text-[15px] ">{{ $category->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="text-[#3e77aa]">
                @foreach ($categories as $category)
                    <ul x-show="selected === {{ $category->id }}" class="grid grid-cols-3 text-left gap-3">
                        <div>
                            <h2 class="text-lg font-semibold">
                                Популярні категорії
                            </h2>
                            @foreach ($category->subCategories as $category)
                                <li>
                                    {{ $category->name }}
                                </li>
                            @endforeach
                        </div>
                    </ul>
                @endforeach
            </div>
        </div>
    </div> --}}

</div>
