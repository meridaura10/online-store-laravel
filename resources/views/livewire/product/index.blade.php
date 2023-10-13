<div class="pt-6">
    <ul class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @foreach ($skus as $sku)
            @include('product.cart')
        @endforeach
    </ul>

    {{ $skus->links() }}
</div>
