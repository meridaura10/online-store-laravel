@extends('layouts.app')
@section('content')
    <div class="flex flex-col lg:flex-row my-container">
        <div class="border-r w-[300px]">
            @include('home.category-list')
        </div>
        <div>
            @if (!basket()->isEmpty())
                <div class="my-5 p-4 border rounded-lg mx-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i class="ri-shopping-cart-2-line text-green-600 text-3xl"></i>
                            <p>У кошику <strong>{{ basket()->quantity() }}</strong> товари на суму
                                <strong>{{ basket()->sum() }}₴</strong>
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('basket.index') }}" class="text-blue-600 font-bold">перейти до кошика</a>
                            <a href="{{ route('orders.checkout') }}">
                                @include('ui.form.button', [
                                    'styles' => 'bg-green-600 hover:bg-green-500 text-white',
                                    'name' => 'оформити замовлення ',
                                ])
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            @if (count($also))
                <h2 class="text-2xl mx-3 mb-4 font-bold">
                    Останні переглянуті товари
                </h2>

                <div class="grid grid-cols-2 border-b px-2 pb-1  md:grid-cols-3 xl:grid-cols-5">
                    @foreach ($also as $sku)
                        @include('ui.components.sku-card', [])
                    @endforeach
                </div>
            @endif
            <div class="border-b py-6 border-r">
                <h2 class="text-2xl px-3 font-bold">
                    більше товарів для вибору
                </h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($skus as $sku)
                    @include('ui.components.sku-card', [
                        'styles' => 'border-r border-b',
                    ])
                @endforeach
            </div>
            <div class="px-2 py-8">
                {{ $skus->links() }}
            </div>
        </div>
    </div>
@endsection
