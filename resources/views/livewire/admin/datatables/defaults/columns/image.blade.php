{{-- <img src="{{ $column->value($item) ?? null }}" alt="{{ $column->value($item) }}" class="img-thumbnail object-fit-contain"> --}}


<div class="avatar">
    <div class="mask mask-squircle w-12 h-12">
      <img lazy="loading" src="{{ $column->value($item) ??  asset('img/default-product-image.png') }}" alt="table img" />
    </div>
</div>
