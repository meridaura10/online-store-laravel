<div>
    <div>
        <div class="my-6">
            {!! $this->contentHeader()->render() !!}
        </div>
        <div class="border-b py-4 flex justify-between gap-8 items-end">
            <div class="flex w-full items-center">
                <div>
                    @if ($this->hasFilter())
                        <ul class="flex flex-wrap items-center">
                            <button type="button" wire:click="fullClaerF"
                                class="py-1.5 px-3 mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-red-300 hover:bg-red-300 hover:text-white">Скасувати</button>
                            @foreach ($f as $key => $values)
                                @switch($filters->filter($key)->type())
                                    @case('range')
                                        <li>
                                            <button type="button" wire:click='clearF("{{ $key }}")'
                                                class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">
                                                {{ $values['min'] ?? $filters->filter($key)->attributes['min'] }} -
                                                {{ $values['max'] ?? $filters->filter($key)->attributes['max'] }} грн
                                                <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                            </button>
                                        </li>
                                    @break

                                    @case('categories')
                                        @foreach ($values as $keyValue => $value)
                                            <li>
                                                <button type="button"
                                                    wire:click='clearF("{{ $key }}","{{ $keyValue }}")'
                                                    class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">
                                                    {{ $filters->filter($key)->values[$value][0]['parentName'] }}
                                                    <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                                </button>
                                            </li>
                                        @endforeach
                                    @break

                                    @default
                                        @foreach ($values as $keyValue => $value)
                                            <li> <button type="button"
                                                    wire:click='clearF("{{ $key }}","{{ $keyValue }}")'
                                                    class="py-1.5 px-3 flex items-center mr-2 mb-2 text-sm font-medium text-gray-500 transition-all  bg-white rounded-full border border-gray-300 hover:bg-gray-100">{{ $filters->filter($key)->values[$value] }}
                                                    <span><i class="ri-close-line text-gray-400 text-lg"></i></span>
                                                </button>
                                            </li>
                                        @endforeach
                                @endswitch
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            <div class="w-[300px]">
                <select wire:model='sort'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500  focus:border-blue-500 block w-full p-2.5">
                    <option disabled selected value="null">сортувати</option>
                    @foreach ($sorts as $sort)
                        {!! $sort->render($this) !!}
                    @endforeach
                </select>

            </div>
        </div>
    </div>
    <div class="flex flex-col  lg:flex-row ">

        <div class="max-w-[300px] overflow-hidden w-[300px] border-r">
            <ul>
                @foreach ($filters as $key => $filter)
                    <li class="@if ($key > 0) border-t @endIf  pr-3 pl-2">
                        <div x-data="{ open: true }" class="w-full py-2">
                            <div class="w-full hover:text-red-400  text-blue-600 ">
                                <div x-on:click="open = ! open"
                                    class="flex justify-between items-center cursor-pointer">
                                    <h2 class="text-sm py-1 transition-colors">{{ $filter->title }}
                                        <span
                                            class="text-gray-400 text-sm pl-1">{{ count($filter->values) > 0 ? count($filter->values) : '' }}</span>
                                    </h2>
                                    <i x-bind:class="open ? 'ri-arrow-down-s-line' : 'ri-arrow-up-s-line'"
                                        class="text-2xl text-gray-500"></i>
                                </div>
                            </div>
                            <div x-show="open" x-transition>

                                {!! $filter->render($this) !!}

                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <main class="w-full">
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5">
                @foreach ($skus as $sku)
                    @include('ui.components.sku-card',[
                        'styles' => 'border-r border-b'
                    ])
                @endforeach
            </div>
            <div class="px-2 py-8">
                {{ $skus->links() }}
            </div>
        </main>
    </div>

</div>
