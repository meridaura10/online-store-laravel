<div class="pt-5 w-full lg:max-w-[300px]">
    <ul class="grid lg:grid-cols-1 grid-cols-3 gap-3">
        @foreach ($categories as $category)
            <a href="{{route('categories.show',$category)}}">
                <li class="flex hover:underline items-center text-[#3e77aa] text-lg cursor-pointer transition-all hover:text-[#f84147]">
                    <img src="{{ $category->image->url }}"  class="h-7 w-7 opacity-40" alt="">
                    <span class="ml-2 text-[15px] ">{{ $category->name }}</span>
                </li>
            </a>
        @endforeach
    </ul>
</div>