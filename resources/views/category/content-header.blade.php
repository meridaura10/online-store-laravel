<div>
    <div class="mb-4">
        <h2 class="text-3xl font-bold">
            {{ $category->name }}
        </h2>
    </div>
    @if (count($category->subcategories))
    <ul class="flex gap-3">
        @foreach ($category->subcategories as $category)
            <li class=" mb-2">
                <div class="flex items-center">
                    <a class="p-4 hover:text-[#f84147] border-r text-center text-[#3e77aa] hover:underline"
                        href="{{ route('categories.show', $category) }}">
                        <img class="w-[125px] h-[125px] object-contain mb-4" src="{{ $category->image->url }}"
                            alt="">
                        <div class="text-ellipsis ">
                            <p class="text-sm w-full cursor-pointer overflow-ellipsis  mt-4 transition-all">
                                {{ $category->name }}
                            </p>
                        </div>
                    </a>
                </div>
            </li>
        @endforeach
        </ul>
    @endif
</div>
