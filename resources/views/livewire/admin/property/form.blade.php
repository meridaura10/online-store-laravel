<div x-data='{ activeTab: {{ localization()->getDefaultLocale() }}}' class="p-4">
    <form wire:submit.prevent='save'>
        @component('ui.components.card')
            @include('ui.form.select', [

                'model' => 'property.parent_id',
                'default' => 'is property to parent',
                'label' => 'parent',
                'options' => $parentProperties,
                'isArray' => true,
                'keyName' => 'id',
                'valueName' => 'title',
            ])

            @include('ui.form.translations', ['fields' => [['name' => 'title', 'type' => 'input']]])
        @endcomponent
        @component('ui.components.card')
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold">
                    @if ($property->parent_id && $property->parent_id !== 'null')
                        values
                    @else
                        subproperties
                    @endIf
                </div>
                <div class="tabs">
                    @foreach (localization()->getSupportedLocalesKeys() as $lang)
                        <a id="{{ $lang }}" x-on:click.prevent="activeTab = {{ $lang }}"
                            class="tab tab-bordered" x-bind:class="activeTab === {{ $lang }} ? 'tab-active' : ''">
                            {{ $lang }}
                        </a>
                    @endforeach
                </div>
                <div>
                    <button wire:click="{{ $property->parent ? 'addValueProperty' : 'addSubProperty' }}" type="button"
                        class="btn btn-accent rounded-3xl">
                        <i class="ri-add-line"></i>
                    </button>
                </div>
            </div>
        @endcomponent


        @if ($property->parent_id && $property->parent_id !== 'null')
            values
        @else
            <ul>
                @foreach ($subProperties as $key => $property)
                    <li wire:key='{{ $key }}'>
                        @component('ui.components.card')
                            <div class="flex justify-between gap-5 items-end">
                                <div class="w-full">
                                    @foreach (localization()->getSupportedLocalesKeys() as $lang)
                                        <div wire:key='{{ $lang }}.input.{{ $key }}'
                                            x-show="activeTab === {{ $lang }}">
                                            @include('ui.form.input', [
                                                'label' => trans('base.form.title'),
                                                'model' => "translationsSubProperties.$key.$lang.title",
                                            ])
                                        </div>
                                    @endForeach
                                </div>
                                <div>
                                    <button wire:click='removeSubProperty({{ $key }})' type="button"
                                        class="btn btn-error">
                                        delete
                                    </button>
                                </div>
                            </div>
                            <div class="py-3 flex justify-between items-center">
                                <div class="text-lg font-semibold">
                                    values
                                </div>
                                <div>
                                    <button type="button" wire:click="addValueToSubProperty({{ $key }})"
                                        type="button" class="btn btn-accent rounded-3xl">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>
                            <ul>
                                @foreach ($propertiesValues[$key] as $keyValue => $value)
                                    <li wire:key='{{ $key . $keyValue }}'>
                                        <div class="flex justify-between gap-5 items-end">
                                            <div class="w-full">
                                                @foreach (localization()->getSupportedLocalesKeys() as $lang)
                                                    <div wire:key='{{ $lang }}.input.{{ $key }}'
                                                        x-show="activeTab === {{ $lang }}">
                                                        @include('ui.form.input', [
                                                            'label' => trans('base.form.value'),
                                                            'model' => "translationsPropertyValues.$key.$keyValue.$lang.value",
                                                        ])
                                                    </div>
                                                @endForeach
                                            </div>
                                            <div>
                                                <button type="button"
                                                    wire:click='removeSubPropertyValue({{ $key }},{{ $keyValue }})'
                                                    class="btn btn-error">
                                                    delete
                                                </button>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endcomponent
                    </li>
                @endforeach
            </ul>
        @endif


        {{-- <ul class="grid grid-cols-3 gap-4"> --}}
        {{-- @foreach ($values as $key => $value)
                <li class="" wire:key="{{ $key }}">
                    @component('ui.components.card')
                        <div class="pl-2 font-semibold text-lg">
                            value №<span>{{ $key + 1 }}</span>
                        </div>
                        <div class="p-2 flex items-end gap-3 justify-between">

                            @foreach (localization()->getSupportedLocalesKeys() as $lang)
                                <div wire:key='{{ $lang }}.input.{{ $key }}'
                                    x-show="activeTab === {{ $lang }}">
                                    @include('ui.form.input', [
                                        'label' => trans('base.form.value'),
                                        'model' => "translationsValues.$key.$lang.value",
                                    ])
                                </div>
                            @endForeach
                            <div>
                                <button wire:click='removeValue({{ $key }})' type="button" class="btn btn-error">
                                    delete
                                </button>
                            </div>
                        </div>
                    @endcomponent
                </li>
            @endforeach --}}
        {{-- </ul> --}}
        @component('ui.components.card')
            <div class="flex justify-between items-center">
                <div class="mt-4">
                    <button type="submit" class="btn">submit</button>
                </div>
                <div>
                    @foreach ($errors->all() as $error)
                        <span class="text-xs text-error">{{ $error }}</span>
                    @endforeach
                </div>
            </div>
        @endcomponent
    </form>
</div>
