{{-- <img src="{{ $column->value($item) ?? null }}" alt="{{ $column->value($item) }}" class="img-thumbnail object-fit-contain"> --}}


<div>
    <div class="w-14 h-14">
      <img lazy="loading"  class="w-full h-full object-contain" src="{{ $column->value($item)->url ??  asset('img/default-product-image.png') }}" alt="table img" />
    </div>
</div>
