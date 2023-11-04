<div class="max-w-[300px] {{ $styles ?? '' }}">
    <div class="p-2">
        <img class="w-full h-64 object-contain" src="{{ $sku->bannerImage->url }}"
            alt="{{ $sku->name }}">
    </div>
    <div class="p-3 ">
        <h6 class="h-[45px] text-clip">
            <a href="{{ route('product.show', $sku) }}"
                class="text-black hover:underline hover:text-black">
                {{ $sku->name }}
            </a>
        </h6>
        <div class="mt-1">
            <span class="text-[#f84147] text-[18px] font-bold">{{ $sku->price }}</span> <span
                class="text-lg">$</span>
        </div>
        <div>
           <span class="text-gray-600">сер.оцінка: <span class="text-black">{{ $sku->averageRating }}</span></span>
        </div>
    </div>
</div>