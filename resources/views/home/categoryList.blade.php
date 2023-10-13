<div class="pt-5  w-[100%] lg:max-w-[300px]">
    <ul class="grid lg:grid-cols-1 grid-cols-3 gap-3">
        @foreach ($categories as $category)
            <a href="{{route('categories.show',$category)}}">
                <li class="flex hover:underline items-center text-[#3e77aa] text-lg cursor-pointer transition-all hover:text-[#f84147]">
                    <img src="{{ $category->image->url }}"  class="h-7 w-7 opacity-40" alt="">
                    {{-- <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 15h12l3-15H3zm3 0l2-3h6l2 3M9 12h6"></path>
                      </svg> --}}
                    <span class="ml-2 text-[15px] ">{{ $category->name }}</span>
                </li>
            </a>
        @endforeach
    </ul>
</div>