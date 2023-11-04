<section class="p-6 w-full">
    @if (!$hasOrders)
        <div class="text-center pt-5">
            <img class="mx-auto" _ngcontent-rz-client-c1691351868="" alt="" loading="lazy" width="300px"
                src="https://xl-static.rozetka.com.ua/assets/img/design/cabinet/cabinet-orders-dummy.svg">
            <h2 class="font-bold text-xl">Список замовлень пустий</h2>
            <p class="text-gray-500 mb-4">Ви ще нічого не замовляли</p>
            <a class="py-3 px-4  bg-green-600 rounded-lg hover:bg-green-500 text-white transition-colors"
                href="{{ route('home') }}">
                перейти на головну
            </a>
        </div>
    @else
        <div class="my-4 px-6 shadow-lg pb-3">
            <h1 class="text-2xl  text-black font-bold">Мої замовлення</h1>
            <div class="font-bold my-3 flex flex-wrap gap-4 items-center">
                <button class="btn" wire:click="setSortParams(null,'created_at')">
                    сортувати за датой: @if ($sortKey === 'created_at')
                        @if ($sortDirection)
                            <i class="ri-arrow-up-line"></i>
                        @else
                            <i class="ri-arrow-down-line"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line"></i>
                    @endif
                </button>
                <button class="btn" wire:click="setSortParams(null,'amount')">
                    сортувати за ціною: @if ($sortKey === 'amount')
                        @if ($sortDirection)
                            <i class="ri-arrow-up-line"></i>
                        @else
                            <i class="ri-arrow-down-line"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line"></i>
                    @endif
                </button>
                <button @if (!$this->hasFilter()) disabled @endIf class="btn"
                    wire:click="clearFilter">{{ trans('base.table.drop_filter') }}

                </button>
            </div>

            <div class="py-2 mb-3 flex flex-wrap gap-2 ">
                @foreach (App\Enums\Order\OrderStatusEnum::cases() as $status)
                    <button wire:click="setFilterParams('status','{{ $status->value }}')" type="button"
                        class="@if (array_key_exists('status', $filters) && $status->value === $filters['status']) text-white bg-blue-500
                    @else
                    bg-blue-100 text-blue-500 @endif    py-3 px-4 inline-flex justify-center items-center gap-2   border border-transparent font-semibold  hover:text-white hover:bg-blue-500 focus:outline-none  transition-all rounded-2xl text-sm">
                        {{ $status->value }}
                    </button>
                @endforeach
            </div>
            <div>
                <div class="form-control w-full  max-w-xs">
                    <input wire:model="filters.date" type="date" placeholder="Type here"
                        class="input input-sm input-bordered w-full max-w-xs" />
                </div>
            </div>
        </div>

        <div class="w-full mt-2">
            @if ($orders->isEmpty())
                <div class="text-center">
                    <p  class="text-gray-500 text-xl font-semibold pt-4">за вибраними фільтрами не знайдено ні одного замовлення </p>
                </div>
            @else
                <ul class="grid gap-4 ">
                    @foreach ($orders as $order)
                        <li wire:key='{{ $order->id }}' class="bg-white shadow-lg rounded-lg p-6 relative">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold mb-2">Замовлення #{{ $order->id }}</h2>
                                </div>
                                <div>
                                    <p class="text-gray-700">Дата створення: <span
                                            class="font-bold">{{ $order->created_at->format('d.m.Y H:i') }}</span></p>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700">Статус: <span class="font-bold">{{ $order->status }}</span></p>
                                <p class="text-gray-700">Статус оплати: <span
                                        class="font-bold">{{ $order->payments[0]->status }}</span></p>
                            </div>
                            <div class="mt-4 ">
                                <div>
                                    <h5 class="font-bold text-lg mb-2">Products</h5>
                                </div>
                                <ul class="grid grid-cols-2 justify-between gap-3">
                                    @foreach ($order->products as $product)
                                        <li class="flex items-center w-full max-w-[500px] space-x-4">
                                            <img src="{{ $product->sku->bannerImage->url }}" alt="{{ $product->name }}"
                                                class="w-16 h-16 object-cover rounded-md">
                                            <div>
                                                <p class="font-semibold">{{ $product->name }}</p>
                                                <p class="text-gray-700">{{ $product->price }} грн</p>
                                                <p class="text-gray-700">{{ $product->quantity }} одн.</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                @if (
                                    $order->payments[0]->type === App\Enums\Payment\PaymentTypeEnum::Card->value &&
                                        $order->payments[0]->status === App\Enums\Payment\PaymentStatusEnum::Waiting->value &&
                                        $order->payments[0]->payment_expired_time > now())
                                    <div>
                                        <button wire:click='pay({{ $order->payments[0] }})' class="btn">
                                            оплатити
                                        </button>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-lg font-semibold text-blue-500">Загальна сума: {{ $order->amount }}
                                        грн
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

</section>
