<div x-data='{ activeTab: {{ localization()->getDefaultLocale() }}}' class="p-4">
    <form wire:submit.prevent='save'>
        @component('ui.layouts.card')
            @include('ui.form.translations', ['fields' => [['name' => 'title', 'type' => 'input']]])
        @endcomponent
        @component('ui.layouts.card')
            <div class="flex justify-between items-center">
                <div class="text-xl font-bold">
                    values
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
                    <button wire:click='addValue' type="button" class="btn btn-accent rounded-3xl">
                        <i class="ri-add-line"></i>
                    </button>
                </div>
            </div>
        @endcomponent


        <ul class="grid grid-cols-3 gap-4">
            @foreach ($values as $key => $value)
                <li class="" wire:key="{{ $key }}">
                    @component('ui.layouts.card')
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
            @endforeach

        </ul>
        @component('ui.layouts.card')
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
