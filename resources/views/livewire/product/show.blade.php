<div class="my-container" x-data="{ activeTab: 'all' }">
    <div class="flex gap-4 mt-4 border-b mb-4">
        <div @click="activeTab = 'all'"
            x-bind:class="activeTab === 'all' ? 'text-green-600 border-b-2 border-green-500' : ''"
            class="hover:text-green-600 cursor-pointer hover:border-green-500 pb-4 hover:border-b-2 transition-color">
            {{ trans('base.all_about_product') }}
        </div>
        <div @click="activeTab = 'properties'"
            x-bind:class="activeTab === 'properties' ? 'text-green-600 border-b-2 border-green-500 ' : ''"
            class="hover:text-green-600 cursor-pointer hover:border-green-500 pb-4 hover:border-b-2 transition-color">
            {{ trans('base.properties') }}
        </div>
        <div @click="activeTab = 'review'"
            x-bind:class="activeTab === 'review' ? 'text-green-600 border-b-2 border-green-500' : ''"
            class="hover:text-green-600 cursor-pointer hover:border-green-500 pb-4  hover:border-b-2 transition-color">
            {{ trans('base.reviews') }} {{ count($sku->reviews) }}
        </div>
    </div>
    <div x-show="activeTab === 'all'">
        <div class="flex  justify-between">

            <div x-data="{ showImage: 0, max: {{ count($sku->images) - 1 }} }" class="w-full">
                <div class="relative ">
                    @foreach ($sku->images as $key => $image)
                        <div x-show="showImage === {{ $key }}" class="w-full flex justify-center"
                            wire:key='{{ $key }}.image'>
                            <img class="min-h-[400px] max-h-[600px] object-contain" src="{{ $image->url }}"
                                alt="">
                        </div>
                    @endforeach
                    @if(count($sku->images) > 1)
                    <button class="absolute top-0 bottom-0 right-5 rounded-full ">
                        <div @click='showImage === max ? showImage = 0 : showImage++'
                            class="bg-gray-200 hover:bg-gray-300 rounded-full h-[45px] w-[45px] items-center flex justify-center flex-col transition-colors">
                            <i class="ri-arrow-right-s-line text-4xl"></i>
                        </div>
                    </button>
                    <button class="absolute top-0 bottom-0 left-5 rounded-full ">
                        <div @click='showImage === 0 ? showImage = max : showImage--'
                            class="bg-gray-200 hover:bg-gray-300 rounded-full h-[45px] w-[45px] items-center flex justify-center flex-col transition-colors">
                            <i class="ri-arrow-left-s-line text-4xl"></i>
                        </div>
                    </button>
                    @endIf
                </div>
                @if(count($sku->images) > 1)
                <div class="w-full flex gap-1">
                    @foreach ($sku->images as $key => $image)
                        <div @click='showImage = {{ $key }}'
                            x-bind:class="showImage === {{ $key }} ? 'border border-orange-400' : 'border border-transparent'"
                            class="p-1.5 cursor-pointer" wire:key='{{ $key }}.image'>
                            <img class="min-h-[70px] max-h-[70px] max-w-[70px] object-contain" src="{{ $image->url }}"
                                alt="">
                        </div>
                    @endforeach
                </div>
                @endIf
            </div>

            <div class="w-full">
                <h3 class="text-2xl font-bold">
                    {{ $sku->name }}
                </h3>

                <div class="my-3">
                    @foreach ($options as $optionTitle => $optionValues)
                        <div>
                            <div>
                                <h3 class="text-xl mb-1 font-bold">{{ $optionTitle }}</h3>
                                <ul class="flex gap-3">
                                    @foreach ($optionValues as $optionValue)
                                        <li>
                                            <button wire:click="selected({{ $optionValue['id'] }})"
                                                class="btn @if ($selectValues[$optionValue['option']['id']] === $optionValue['id']) btn-secondary @elseif (isset($continuation[$optionTitle]) && in_array($optionValue['id'], $continuation[$optionTitle])) btn-error @else btn-warning @endif">
                                                {{ $optionValue['value'] }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="border flex gap-4 items-center py-4 px-3">
                    <div>
                        <span class="text-3xl font-bold">{{ $sku->price }}$</span>
                        <p>
                            @if ($sku->quantity > 0)
                                <span class="text-green-600 font-semibold">{{ trans('base.in_stock') }}</span>
                            @else
                                <span class="text-red-400 font-semibold">{{ trans('base.not_available') }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div>
                            <button wire:click=' @if (basket()->hasItem($sku->id))
                                redirectBasket
                                @else 
                                addBasket
                            @endif'
                                class="bg-green-600 btn flex items-center gap-2 hover:bg-green-500 transition-all text-white">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 24 24"
                                        width="28" height="28">
                                        <path
                                            d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z">
                                        </path>
                                    </svg>
                                </div>
                                @if (basket()->hasItem($sku->id))
                                    {{ trans('base.product_already_cart') }}
                                    @else 
                                    {{ trans('base.by') }}
                                @endif
                            </button>
                        </div>
                        {{-- <div>
                            <button class="bg-sky-600 btn hover:bg-sky-500 transition-all text-white">
                                купити в
                                кредит</button>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 fill-orange-400" viewBox="0 0 24 24">
                                <path
                                    d="M16.5 3C19.5376 3 22 5.5 22 9C22 16 14.5 20 12 21.5C9.5 20 2 16 2 9C2 5.5 4.5 3 7.5 3C9.35997 3 11 4 12 5C13 4 14.64 3 16.5 3ZM12.9339 18.6038C13.8155 18.0485 14.61 17.4955 15.3549 16.9029C18.3337 14.533 20 11.9435 20 9C20 6.64076 18.463 5 16.5 5C15.4241 5 14.2593 5.56911 13.4142 6.41421L12 7.82843L10.5858 6.41421C9.74068 5.56911 8.5759 5 7.5 5C5.55906 5 4 6.6565 4 9C4 11.9435 5.66627 14.533 8.64514 16.9029C9.39 17.4955 10.1845 18.0485 11.0661 18.6038C11.3646 18.7919 11.6611 18.9729 12 19.1752C12.3389 18.9729 12.6354 18.7919 12.9339 18.6038Z">
                                </path>
                            </svg>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="activeTab === 'properties'">
        <h1 class="text-3xl font-bold">{{ trans('base.properties') }} {{ $sku->name }}</h1>
        <div class="mt-4 mb-2">
            @foreach ($sku->values as $value)
                <li class="flex items-center"> <span
                        class="w-[40%] before:w-full gap-3 whitespace-nowrap before:h-[1px] before:block before:mb-1 flex flex-row-reverse items-end before:bg-gray-300">{{ $value->option->title }}</span>
                    <span class="pl-3">{{ $value->value }}</span>
                </li>
            @endforeach
        </div>
        <div class="my-3">
            <ul class="pb-5">
                @foreach ($properties as $key => $propertiesValues)
                    <li class="mb-4">
                        <h2 class="text-xl mb-2 font-bold">{{ $key }}</h2>
                        <ul class="grid gap-3">
                            @foreach ($propertiesValues as $propertiesValue)
                                <li class="flex items-center"> <span
                                        class="w-[40%] before:w-full gap-3 whitespace-nowrap before:h-[1px] before:block before:mb-1 flex flex-row-reverse items-end before:bg-gray-300">{{ $propertiesValue['property']['title'] }}</span>
                                    <span class="pl-3">{{ $propertiesValue['value'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div x-show="activeTab === 'review'">
        <div>
            <h1 class="text-2xl font-bold">{{ $sku->name }}</h1>
            <div class="my-4 px-3 py-4 border flex justify-between items-center">
                <div class="font-semibold text-lg">
                   {{ trans('base.leave_review_product') }}
                </div>
                <div wire:click='openModalReview'>
                    <button class="btn">{{ trans('base.write_review') }}</button>
                </div>
            </div>

            <dialog id="modal" class="modal" @if ($openModalReview) open @endif>
                <div class="w-screen h-screen relative  bg-base-content opacity-40">
                </div>
                <form wire:submit.prevent='createReview' method="dialog"
                    class="modal-box absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
                    <div class="border-b pb-3 mb-3 flex justify-between">
                        <div>
                            <h2 class="text-xl font-bold">{{ trans('base.write_review') }}</h2>
                        </div>
                        <div wire:click='hidenModalReview' class="cursor-pointer">
                            <i class="ri-close-line text-xl"></i>
                        </div>
                    </div>
                    <div class="rating w-full">
                        @for ($i = 0; $i < 5; $i++)
                            <input wire:model.defer='review.rating' value="{{ $i + 1 }}" type="radio"
                                name="rating-2" class="mask mask-star-2 bg-orange-400" />
                        @endfor
                    </div>
                    <div class="w-full mt-3">
                        @include('ui.form.textarea', [
                            'model' => 'review.comment',
                            'placeholder' => trans('base.your_comment'),
                        ])
                    </div>
                    <div class="mt-3">
                        <button class="btn" type="submit">
                            {{ trans('base.save') }}
                        </button>
                    </div>
                </form>
            </dialog>
            <ul class="grid gap-2 mb-8">
                @foreach ($sku->reviews as $review)
                    <li class="p-3 border rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <span class="font-bold">{{ $review->user->name }}</span>
                            <span class="text-sm text-gray-500">
                                {{ $review->created_at }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <div class="flex items-center">
                                <span class="font-semibold">{{ trans('base.rating') }}: </span><span> {{ $review->rating }}</span>
                            </div>
                        </div>
                        <div>
                            {{ $review->comment }}
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
    @if (count($also))
    <div class="mt-5">
        <div class="border-t">
            <h4 class="font-bold text-2xl my-2">{{ trans('base.last_reviewed_products') }}</h4>
        </div>
        <ul class="pb-5 flex flex-wrap">
            @foreach ($also as $sku)
                <li wire:key="aslo.{{ $sku->id }}.item">
                  @include('ui.components.sku-card',[
                    'styles' => 'max-w-[240px]'
                  ])
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
