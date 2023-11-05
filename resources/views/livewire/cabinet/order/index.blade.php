<section class="p-6 w-full">
    @if (!$hasOrders)
        <div class="text-center pt-5">
            <img class="mx-auto" _ngcontent-rz-client-c1691351868="" alt="" loading="lazy" width="300px"
                src="https://xl-static.rozetka.com.ua/assets/img/design/cabinet/cabinet-orders-dummy.svg">
            <h2 class="font-bold text-xl">{{ trans('base.the_list_orders_empty') }}</h2>
            <p class="text-gray-500 mb-4">{{ trans('base.you_haven`t_ordered_anything_yet') }}</p>
            <a class="py-3 px-4  bg-green-600 rounded-lg hover:bg-green-500 text-white transition-colors"
                href="{{ route('home') }}">
                {{ trans('base.go_main_page') }}
            </a>
        </div>
    @else
        <div class="my-4 px-6 shadow-lg pb-3">
            <h1 class="text-2xl  text-black font-bold">{{ trans('base.my_orders') }}</h1>
            <div class="font-bold my-3 flex flex-wrap gap-4 items-center">
                <button class="btn" wire:click="setSortParams(null,'created_at')">
                    {{ trans('base.sort_date') }}: @if ($sortKey === 'created_at')
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
                   {{ trans('base.sort_price') }}: @if ($sortKey === 'amount')
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
                    wire:click="clearFilter">{{ trans('base.drop_filters') }}

                </button>
            </div>

            <div class="py-2 mb-3 flex flex-wrap gap-2 ">
                @foreach (App\Enums\Order\OrderStatusEnum::cases() as $status)
                    <button wire:click="setFilterParams('status','{{ $status->value }}')" type="button"
                        class="@if (array_key_exists('status', $filters) && $status->value === $filters['status']) text-white bg-blue-500
                    @else
                    bg-blue-100 text-blue-500 @endif    py-3 px-4 inline-flex justify-center items-center gap-2   border border-transparent font-semibold  hover:text-white hover:bg-blue-500 focus:outline-none  transition-all rounded-2xl text-sm">
                        {{ trans('statuses.' . $status->value) }}
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
                    <p  class="text-gray-500 text-xl font-semibold pt-4">{{ trans('base.no_orders_were_found_for_the_selected_filters') }} </p>
                </div>
            @else
                <ul class="grid gap-4 ">
                    @foreach ($orders as $order)
                        <li wire:key='{{ $order->id }}' class="bg-white shadow-lg rounded-lg p-6 relative">
                            <div class="flex justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold mb-2">{{ trans('base.order') }} #{{ $order->id }}</h2>
                                </div>
                                <div>
                                    <p class="text-gray-700">{{ trans('base.date_creation') }}: <span
                                            class="font-bold">{{ $order->created_at->format('d.m.Y H:i') }}</span></p>
                                </div>
                            </div>
                            <div>
                                <p class="text-gray-700">{{ trans('statuses.status') }}: <span class="font-bold"> {{ trans('statuses.' . $order->status) }}  </span></p>
                                <p class="text-gray-700">{{ trans('statuses.status_payment') }}: <span
                                        class="font-bold">{{ trans('statuses.' . $order->payments[0]->status) }}</span></p>
                            </div>
                            <div class="mt-4 ">
                                <div>
                                    <h5 class="font-bold text-lg mb-2">{{ trans('base.products') }}</h5>
                                </div>
                                <ul class="grid grid-cols-2 justify-between gap-3">
                                    @foreach ($order->products as $product)
                                        <li class="flex items-center w-full max-w-[500px] space-x-4">
                                            <img src="{{ $product->sku->bannerImage->url }}" alt="{{ $product->name }}"
                                                class="w-16 h-16 object-cover rounded-md">
                                            <div>
                                                <p class="font-semibold">{{ $product->name }}</p>
                                                <p class="text-gray-700">{{ $product->price }} {{ trans('base.uah') }}</p>
                                                <p class="text-gray-700">{{ $product->quantity }} {{ trans('base.item') }}.</p>
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
                                            {{ trans('base.pay') }}
                                        </button>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-lg font-semibold text-blue-500">{{ trans('base.total_price') }}: {{ $order->amount }}
                                        {{ trans('base.uah') }}
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
