<div x-data="{ isOpen: false }" class="w-full max-w-[1232px] mx-auto">
    <div class="py-5">
        <h1 class="font-bold text-[32px] text-black">
            Оформлення замовлення
        </h1>
    </div>
    <div x-show="isOpen"
        class="fixed top-0 left-0 right-0 bottom-0 z-50 overflow-hidden  bg-gray-800 bg-opacity-50 flex justify-center items-center">
        <!-- Modal container -->
        <div class="bg-white rounded-lg shadow-md w-full max-w-lg p-4">
            <!-- Modal header -->
            <div class="flex items-start justify-between border-b pb-2">
                <h3 class="text-lg font-semibold text-gray-900">Виберіть своє місто</h3>
                <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M14.293 5.293a1 1 0 011.414 0l.001.001c.39.391.39 1.023 0 1.414L11.414 10l4.294 4.293a1 1 0 11-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414 1 1 0 011.414 0L10 8.586l4.293-4.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <div class="py-4">
                @include('ui.form.selectSearch', [
                    'valueName' => 'name',
                    'label' => 'Область',
                    'model' => 'area',
                    'value' => $area['name'] ?? null,
                    'options' => $areas,
                    'searchModel' => 'searchArea',
                ])
                @if (isset($area))
                    @include('ui.form.selectSearch', [
                        'valueName' => 'name',
                        'label' => 'Місто',
                        'model' => 'city',
                        'value' => $city['name'] ?? null,
                        'options' => $cities,
                        'searchModel' => 'searchCity',
                    ])
                @endif
                @if (isset($city) && !empty($city))
                    @include('ui.form.selectSearch', [
                        'valueName' => 'address',
                        'label' => 'Відділення',
                        'model' => 'warehouse',
                        'value' => $warehouse['address'] ?? null,
                        'options' => $warehouses,
                        'searchModel' => 'searchWarehouse',
                    ])
                @endif
            </div>
        </div>
    </div>

    <div class="pb-4">
        <div>
            <h2 class="font-bold  text-xl">Отримувач замовлення</h2>
        </div>
        <div class="grid grid-cols-2 gap-4">
            @include('ui.form.input', [
                'model' => 'orderCustomer.last_name',
                'label' => 'прізвище',
                'styleLabelText' => 'text-[12px] text-[#797878]',
            ])
            @include('ui.form.input', [
                'model' => 'orderCustomer.first_name',
                'label' => 'Iм`я',
                'styleLabelText' => 'text-[12px] text-[#797878]',
            ])
            @include('ui.form.input', [
                'model' => 'orderCustomer.patronymics',
                'label' => 'По батькові',
                'styleLabelText' => 'text-[12px] text-[#797878]',
            ])
            @include('ui.form.input', [
                'model' => 'orderCustomer.phone',
                'label' => 'Мобільний телефон',
                'type' => 'tel',
                'styleLabelText' => 'text-[12px] text-[#797878]',
            ])
        </div>
        <div class="p-4 mt-4 bg-[rgba(255,169,0,.1)]  border border-[#ffa900] rounded-md">
            Зверніть увагу, отримання замовлення за паспортом. Введіть прізвище, ім'я, по батькові як зазначено у
            документі та мобільний номер телефону отримувача замовлення
        </div>
    </div>
    <div class="py-4">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold  text-xl">Товари </h2>
            </div>
            @include('ui.form.buttonEdit', [
                'click' => 'redirectBasket',
            ])
        </div>
        <ul>
            @foreach (basket()->getItems() as $basketItem)
                <li class="flex p-3 gap-2 items-center border-b">
                    <div class="h-[70px] w-[70px]">
                        <img class="h-full object-cover" src="{{ $basketItem->sku->bannerImage->url }}"
                            alt="">
                    </div>
                    <div class="flex justify-between items-center  w-full">
                        <div>
                            {{ $basketItem->sku->name }}
                        </div>
                        <div class="font-mono">
                            {{ $basketItem->sku->price }} $ x {{ $basketItem->quantity }} од.
                        </div>
                        <div class="font-bold text-base">
                            {{ $basketItem->sum }} $
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="py-4">
        <div class="flex justify-between items-center">
            <h2 class="font-bold  text-xl">Оплата </h2>
            <div>
                @error('orderPayment.payment_type')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
                @error('orderPayment.payment_system')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <ul x-data="{ show: false }">
            <li x-on:click="show = false" wire:click='selectCashPayment' class="flex p-2 items-center">
                @include('ui.form.radio', [
                    'model' => 'paymentType',
                    'label' => 'Оплата під час отримання товару',
                    'value' => 'cash',
                ])
            </li>
            <li class=" p-2" x-bind:class="show ? 'border border-green-600 rounded-lg' : ''">
                <div class="flex items-center">
                    <label wire:click='selectCartPaymant' wire:model='paymentType' class="label gap-4 cursor-pointer">

                        <input x-bind:checked="show ? true : false" value="card" x-on:click="show = true"
                            type="radio" class="radio  checked:bg-red-500" />
                        <span class="label-text mr-2">Оплатити зараз</span>
                    </label>
                </div>
                <div x-show="show">
                    <ul class="pl-4">
                        <li class="flex p-1 items-center">
                            <label class="label gap-4 cursor-pointer">

                                <input wire:model='paymentSystem' value="liqPay" type="radio"
                                    class="radio checked:bg-red-500" />
                                <span class="label-text mr-2">LiqPay</span>
                            </label>

                        </li>
                        <li class="flex p-1 items-center">
                            <label class="label gap-4 cursor-pointer">
                                <input wire:model='paymentSystem' type="radio" value="fondy"
                                    class="radio checked:bg-red-500" />
                                <span class="label-text mr-2">Fondy</span>
                            </label>

                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="py-4">
        <div class="flex justify-between items-center">
            <h2 class="font-bold mb-2  text-xl">Доставка </h2>
            <div>
                @error('area')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
                @error('city')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
                @error('warehouse')
                    <span class="text-xs text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <button @click="isOpen = true"
            class="border p-4 flex justify-between items-center hover:bg-gray-100 transition-colors w-full">
            <div class="flex gap-4 items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="30" height="30">
                        <path
                            d="M12 20.8995L16.9497 15.9497C19.6834 13.2161 19.6834 8.78392 16.9497 6.05025C14.2161 3.31658 9.78392 3.31658 7.05025 6.05025C4.31658 8.78392 4.31658 13.2161 7.05025 15.9497L12 20.8995ZM12 23.7279L5.63604 17.364C2.12132 13.8492 2.12132 8.15076 5.63604 4.63604C9.15076 1.12132 14.8492 1.12132 18.364 4.63604C21.8787 8.15076 21.8787 13.8492 18.364 17.364L12 23.7279ZM12 13C13.1046 13 14 12.1046 14 11C14 9.89543 13.1046 9 12 9C10.8954 9 10 9.89543 10 11C10 12.1046 10.8954 13 12 13ZM12 15C9.79086 15 8 13.2091 8 11C8 8.79086 9.79086 7 12 7C14.2091 7 16 8.79086 16 11C16 13.2091 14.2091 15 12 15Z">
                        </path>
                    </svg>
                </div>
                <div class="text-left">
                    <h3 class="font-bold">{{ $area['name'] ?? 'Ваша область' }}</h3>
                    <span class="font-medium">{{ $city['name'] ?? 'Ваше місто' }}</span>
                    <div>
                        <span>{{ $warehouse['address'] ?? 'Адрес відділення нової пошти' }}</span>
                    </div>
                </div>
            </div>
            @include('ui.form.buttonEdit')
        </button>
    </div>
    <div class="p-5 bg-gray-100 rounded-lg">
        <div class="">
            <div class=" pb-4 border-b border-gray-300">
                <h3 class="text-2xl mb-4 font-bold text-black">Разом</h3>
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-gray-600">
                        {{ basket()->quantity() }} товарів:
                    </h2>
                    <span class="font-mono">
                        {{ basket()->sum() }} $
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <h2 class="text-gray-600">
                        доставка:
                    </h2>
                    <span class="">
                        безкоштовна
                    </span>
                </div>
                <div>

                </div>
            </div>
            <div class="flex py-4 border-b border-gray-300 mb-4 items-center justify-between">
                <h2 class="text-gray-600">
                    До сплати:
                </h2>
                <span class="font-bold text-2xl font-mono">
                    {{ basket()->sum() }} $
                </span>
            </div>
            <button wire:click='submit'
                class="focus:outline-none w-full text-white bg-green-600 hover:bg-green-500 text-lg transition-all focus:ring-4 focus:ring-green-300 font-medium rounded-lg px-5 py-2.5 mr-2 mb-2 ">
                Замовлення підтверджую
            </button>
        </div>
    </div>
</div>



{{-- <div class="w-full min-h-screen bg-neutral-content flex justify-center items-center">
        <div class="w-11/12 bg-base-100 rounded-xl p-4 m-5">
            <div class="mx-auto flex gap-10">
                <div>
                    <div>
                        @component('ui.layouts.card')
                            <p class="card-title">Замовник</p>
                            @include('ui.form.input', [
                                'model' => 'customer.full_name',
                                'label' => 'ПІБ',
                            ])
                            @include('ui.form.input', [
                                'model' => 'customer.phone',
                                'label' => 'Телефон',
                                'type' => 'number',
                            ])
                        @endcomponent
                    </div>
                    <div>
                        @component('ui.layouts.card')
                            <p class="card-title">Способи доставки</p>
                            <div class="flex gap-5">
                                @include('ui.form.radio', [
                                    'label' => 'Доставка',
                                    'model' => 'order.delivery_type',
                                    'value' => 'delivery',
                                ])
                                @include('ui.form.radio', [
                                    'label' => 'Самовивіз',
                                    'model' => 'order.delivery_type',
                                    'value' => 'self',
                                ])
                            </div>
                        @endcomponent
                    </div>
                    @component('ui.layouts.card')
                        <p class="card-title">Тип оплати</p>
                        <select class="select select-bordered w-full max-w-xs" wire:model='order.payment_type'>
                            <option selected value="liqpay">LiqPay</option>
                        </select>
                    @endcomponent
                    @component('ui.layouts.card')
                        <div>
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm  px-8 py-4    focus:outline-none ">Оплатити
                                замовлення</button>
                        </div>
                    @endcomponent
                </div>
                <div>
                    @component('ui.layouts.card')
                        <p class="card-title">Список покупок</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach (basket()->getItems() as $basketItem)
                                <div class="card bg-base-100 shadow-xl">
                                    <figure><img class="w-full h-52 object-cover"
                                            src="{{ asset($basketItem->sku->bannerImage->path) ?? asset('img/default-product-image.png') }}"
                                            alt="{{ $basketItem->sku->name }}" />
                                    </figure>
                                    <div class="card-body">
                                        <h2 class="card-title">{{ $basketItem->sku->name }}</h2>
                                        <div class="flex justify-between">
                                            <span>Кількість:</span><span>{{ $basketItem->quantity }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Ціна:</span><span>{{ $basketItem->sum }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($errors->any())
                            <div class="card shadow-lg bg-base-100 mb-4">
                                <div class="card-body ">
                                    <div class="p-2">
                                        @foreach ($errors->all() as $error)
                                            <span class="text-xs text-error">{{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endcomponent
                </div>
            </div>
        </div>
    </div> --}}
