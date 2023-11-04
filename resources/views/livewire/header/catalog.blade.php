<div x-data="{ selectedCategory: {{ $categories->first()->id }}, open: false }">
    <button @click="open = true"
        class="ml-4 px-6 py-2 rounded-lg bg-[#fff3] transition-all hover:bg-[#ffffff46] hover:text-white">Каталог</button>
    <div x-show="open" x-bind:class="open ? 'overlay' : ''">
        <div class="main"></div>
    </div>
    <div x-show="open" @click.away="open = false" class="top-full  z-50 w-full max-w-[1400px] absolute">
        <div class="bg-white text-black p-4 rounded-b-lg shadow-xl flex gap-3">
            <div class="w-[300px]">
                <ul class="gap-3 grid">
                    @foreach ($categories as $category)
                        <li @mouseover="selectedCategory = {{ $category->id }}"
                            class=" text-[#3e77aa] text-lg cursor-pointer transition-all hover:text-[#f84147]">
                            <a class="flex hover:underline items-center justify-between pr-2"
                                href="{{ route('categories.show', $category) }}">
                                <div class="flex items-center">
                                    <img src="{{ $category->image->url }}" class="h-7 w-7 opacity-40" alt="">
                                    <span class="ml-2 text-[15px] ">{{ $category->name }}</span>
                                </div>
                                <svg class="w-4 h-4 fill-blue-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M13.1714 12.0007L8.22168 7.05093L9.63589 5.63672L15.9999 12.0007L9.63589 18.3646L8.22168 16.9504L13.1714 12.0007Z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="text-[#3e77aa]">
                <ul class="h-full" x-show="selectedCategory !== null" class="flex flex-wrap">
                    @foreach ($categories as $category)
                        <li class="p-4" x-show="selectedCategory === {{ $category->id }}">
                            <div>
                                <ul class="grid grid-cols-4 ">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li class="transition-colors mb-1 cursor-pointer ">
                                            <a href="{{ route('categories.show', $subcategory) }}">
                                                <h3 class="hover:text-red-500 hover:underline text-lg">
                                                    {{ $subcategory->name }}
                                                </h3>
                                            </a>
                                        </li>
                                        @foreach ($subcategory->subcategories as $subcat)
                                            <li
                                                class="text-sm text-gray-800 hover:text-red-500 transition-all hover:underline">
                                               <a href="{{ route('categories.show', $subcategory) }}">
                                                {{ $subcat->name }}
                                               </a>
                                            </li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                            <div class="flex mt-2 items-center gap-3">
                                @foreach ($category->brands as $brand)
                                    <a href="{{ route('brands.show',$brand) }}">
                                        <img class="h-16 w-16 object-contain opacity-80 transition-opacity hover:opacity-100" src="{{ $brand->image->url }}"
                                            alt="">
                                    </a>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
