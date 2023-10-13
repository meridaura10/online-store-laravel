@extends('layouts.admin.app')

@section('content')
    <div class=" p-6">
        @component('ui.components.card')
            <h1 class="text-2xl font-semibold">Продукт №{{ $product->id }}</h1>
        @endcomponent
        <div class="mt-4">
            @component('ui.components.card')
                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>Status:</strong> {{ $product->status ? 'Active' : 'Inactive' }}</p>
                <p><strong>Category:</strong> {{ $product->category->name }}</p>
                <p><strong>Brand:</strong> {{ $product->brand->name }}</p>
            @endcomponent

        </div>

        <div class="mt-4">
            @component('ui.components.card')
                <div class="flex justify-between">
                    <h2 class="text-2xl font-semibold">SKUs</h2>
                    <h2 class="text-2xl font-semibold">Images</h2>
                </div>
                <ul class="mt-4">
                    @foreach ($product->skus as $sku)
                        <li class="flex justify-between border-b-2 pb-6">
                            <div>
                                <h3 class="text-sm"><span class="text-lg font-bold">name</span>: {{ $sku->name }}</h3>
                                <p><strong>Price:</strong> ${{ number_format($sku->price, 2) }}</p>
                                <p><strong>Status:</strong> {{ $sku->status ? 'Active' : 'Inactive' }}</p>
                                <p><strong>Stock:</strong> {{ $sku->quantity }}</p>
                                @if (count($sku->values) > 0)
                                    <h4 class="mt-2 text-xl font-bold">Values</h4>
                                    <ul class="mt-2">
                                        @foreach ($sku->values as $value)
                                            <li>
                                                <p><strong>{{ $value->option->title }}</strong> {{ $value->value }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div>
                                @if (count($sku->images) > 0)
                                    <ul class="flex flex-wrap justify-end mt-2">
                                        @foreach ($sku->images as $image)
                                            <li>
                                                <img src="{{ asset('storage/' . $image->path) }}" alt="Image"
                                                    class="w-36 h-36 object-cover rounded-lg">
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>


                        </li>
                    @endforeach
                </ul>
            @endcomponent

        </div>
    </div>
@endsection
