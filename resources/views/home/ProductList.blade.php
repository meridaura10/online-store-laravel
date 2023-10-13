<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
    @foreach ($skus as $sku)
    @include('product.cart')
    @endforeach
</div>