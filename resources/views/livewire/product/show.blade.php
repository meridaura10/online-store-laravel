<div class="my-container" x-data="{ activeTab: 'all' }">
    <div class="flex gap-4 mt-4 border-b mb-4">
        <div @click="activeTab = 'all'"
            x-bind:class="activeTab === 'all' ? 'text-green-600 border-b-2 border-green-500' : ''"
            class="hover:text-green-600 cursor-pointer hover:border-green-500 pb-4 hover:border-b-2 transition-color">
            Усе про товар
        </div>
        <div @click="activeTab = 'properties'"
            x-bind:class="activeTab === 'properties' ? 'text-green-600 border-b-2 border-green-500 ' : ''"
            class="hover:text-green-600 cursor-pointer hover:border-green-500 pb-4 hover:border-b-2 transition-color">
            Характеристики
        </div>
        <div @click="activeTab = 'review'"
            x-bind:class="activeTab === 'review' ? 'text-green-600 border-b-2 border-green-500' : ''"
            class="hover:text-green-600 cursor-pointer hover:border-green-500 pb-4  hover:border-b-2 transition-color">
            Відгуки {{ count($sku->reviews) }}
        </div>
    </div>
    <div x-show="activeTab === 'all'">
        <div class="flex  justify-between">

            <div id="default-carousel" class="relative w-full max-w-[800px] h-64" data-carousel="slide">

                <div class="relative h-full overflow-hidden rounded-lg">
                    @foreach ($sku->images as $image)
                        <div class="hidden duration-700 ease-in-out  bg-white w-full" data-carousel-item>
                            <img src="{{ $image->url }}"
                                class="absolute h-full w-full object-contain block  -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                                alt="...">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->

                <!-- Slider controls -->
                @if (count($sku->images) > 1)
                    <button type="button"
                        class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 1 1 5l4 4" />
                            </svg>
                            <span class="sr-only">Previous</span>
                        </span>
                    </button>
                    <button type="button"
                        class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
                        <span
                            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span class="sr-only">Next</span>
                        </span>
                    </button>
                @endif
            </div>
            <div class="w-full">
                <h3 class="text-2xl font-bold">
                    {{ $sku->name }}
                </h3>

                <div class="my-3">
                    @foreach ($options as $optionTitle => $optionValues)
                        <div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $optionTitle }}</h3>
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
                                <span class="text-green-600 font-semibold"> є в наявності</span>
                            @else
                                <span class="text-red-400 font-semibold"> є в наявності</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div>
                            <button wire:click='addBasket'
                                class="bg-green-600 btn flex items-center gap-2 hover:bg-green-500 transition-all text-white">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-white" viewBox="0 0 24 24"
                                        width="28" height="28">
                                        <path
                                            d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z">
                                        </path>
                                    </svg>
                                </div>
                                купити
                            </button>
                        </div>
                        <div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-show="activeTab === 'properties'">
        <h1 class="text-3xl font-bold">Характеристики {{ $sku->name }}</h1>
        <div class="mt-4 mb-2">
            @foreach ($sku->values as $value)
                <li class="flex items-center"> <span
                        class="w-[40%] before:w-full gap-3 whitespace-nowrap before:h-[1px] before:block before:mb-1 flex flex-row-reverse items-end before:bg-gray-300">{{ $value->option->title }}</span>
                    <span class="pl-3">{{ $value->value }}</span>
                </li>
            @endforeach
        </div>
        <div class="mt-3">
            <ul>
                @foreach ($properties as $key => $attributesValues)
                    <li class="mb-4">
                        <h2 class="text-xl mb-2 font-bold">{{ $key }}</h2>
                        <ul class="grid gap-3">
                            @foreach ($attributesValues as $attrubuteValue)
                                <li class="flex items-center"> <span
                                        class="w-[40%] before:w-full gap-3 whitespace-nowrap before:h-[1px] before:block before:mb-1 flex flex-row-reverse items-end before:bg-gray-300">{{ $attrubuteValue['attribute']['title'] }}</span>
                                    <span class="pl-3">{{ $attrubuteValue['value'] }}</span>
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
                    Залиште свій відгук про цей товар
                </div>
                <div wire:click='$emit("open-modal-form-sku-review")'>
                    <button class="btn">написати відгук</button>
                </div>
            </div>
            @livewire('util.form-sku-review', ['sku' => $sku])
            <h2 class="text-xl font-bold my-4">reviews</h2>
            <ul>
                @foreach ($reviews as $review)
                    <li class="border px-3 py-4">
                        <div>
                            <span class="font-semibold text-lg">автор</span>: {{ $review->user->name }}
                        </div>
                        <div>
                            <span class="font-semibold text-lg">коментарій</span>: {{ $review->comment }}
                        </div>
                        <div>
                            <span class="font-semibold text-lg">оцінка</span>: {{ $review->rating }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
