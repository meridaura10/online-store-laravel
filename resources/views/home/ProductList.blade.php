<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
    @foreach ($products as $product)
        <div class="w-225">
            <div class="p-2">
                <img class="w-full h-64 object-contain" src="{{ $product->sku->bannerImage->url }}" alt="{{ $product->sku->name }}">
            </div>
            <div class="p-3 border-r border-b">
                <h6 class="pb-2">
                    <a href="{{ route('product.show', $product->sku) }}" class="text-black hover:underline hover:text-black">
                        {{ $product->sku->name }}
                    </a>
                </h6>
                <div>
                    <span class="text-[#f84147] text-[18px] font-bold">{{ $product->sku->price }}</span> <span
                        class="text-lg">$</span>
                </div>
            </div>
        </div>
    @endforeach
</div>
