<div class="w-225">
    <div class="p-2">
        <img class="w-full h-64 object-contain" src="{{$sku->bannerImage->url}}" alt="{{$sku->name}}">
    </div>
    <div class="p-3 border-r border-b">
        <h6 class="pb-2">
            <a href="{{route('product.show',$sku)}}" class="text-black hover:underline hover:text-black">
                {{$sku->name}}
            </a>
        </h6>
        <div>
            <span class="text-[#f84147] text-[18px] font-bold">{{$sku->price}}</span> <span class="text-lg">$</span>
        </div>
    </div>
</div>
