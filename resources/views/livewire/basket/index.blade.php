<div class="my-container  p-8">
    <div class="p-8 bg-white">
        @if (basket()->isEmpty())
            <div class="text-center">
                <div>
                    <img class="w-[240px] h-[240px] mr-auto ml-auto" loading="lazy"
                        src="https://xl-static.rozetka.com.ua/assets/img/design/modal-cart-dummy.svg">

                    <h4 wire:click='alert' class="">{{ trans('base.basket_empty') }}</h4>
                    <p class="">{{ trans('base.but_never_too_late_fix') }} :)</p>
                </div>
            </div>
        @else
            <div class="">
                <div class="flex justify-between items-center border-b pb-6">
                    <h1 class="font-semibold text-2xl">{{ trans('base.shopping_cart') }}</h1>
                    <div>
                        <a class="inline-block w-full px-6 py-4 mt-4 text-lg font-medium leading-6 tracking-tighter text-center text-white bg-orange-500 lg:w-auto hover:bg-orange-600 focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50 rounded-xl"
                            href="{{ route('orders.checkout') }}">{{ trans('base.place_order_amount') }}: <span
                                class="text-sm">${{ basket()->sum() }}</span></a>
                    </div>
                    <h2 class="font-semibold text-2xl">{{ basket()->quantity() }} {{ trans('base.items') }}</h2>
                </div>
            </div>
            <div class="pt-6">
                @foreach (basket()->getItems() as $item)
                    <div class="md:flex relative mb-4 border-b-2 pb-2" wire:key='{{ $item->id }}'>
                        <div class="w-full mb-4 md:mb-0 h-96 md:h-44 md:w-56">
                            <img src="{{ $item->sku->bannerImage->url }}" alt=""
                                class="object-cover w-full h-full">
                        </div>
                        <div class="flex flex-col w-full md:pl-4 py-3 justify-between">
                            <div class="md:flex justify-between w-full ">
                                <div class="pt-2">
                                    <p class="font-semibold">{{ $item->sku->name }}</p>
                                </div>

                                <div wire:click='removeProduct({{ $item }})'
                                    class="md:relative top-0 right-0 absolute pt-12 pr-12 bg-gray-100 rounded-bl-full">
                                    <div class="absolute top-2 right-2">
                                        <button class=" text-gray-400  hover:text-gray-600 ">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="w-6 h-6 bi bi-x-circle" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                                                </path>
                                                <path
                                                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="flex pt-3 justify-between w-full">

                                <p class="text-gray-500 mt-2">{{ trans('base.price') }}: ${{ $item->sku->price }}</p>
                                <p class="text-gray-500 mt-2">{{ trans('base.total') }}: ${{ $item->sum }}</p>
                                <div class="flex items-center">
                                    <div class="pr-4"
                                        wire:click='update({{ $item }},{{ $item->quantity - 1 }})'>
                                        <button class="text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <input  wire:change.debounce.500ms='update({{ $item }},$event.target.value)'
                                        min="1" value="{{ $item->quantity }}"
                                        class="w-16 px-2 py-1  text-center border border-gray-300 rounded-md bg-gray-50 text-gray-400 md:text-right"
                                         min="1" type="number" max="{{ $item->sku->quantity }}">
                                    <div class="pl-4"
                                        wire:click='update({{ $item }},{{ $item->quantity + 1 }})'>
                                        <button class="text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path
                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
