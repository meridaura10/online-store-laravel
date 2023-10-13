<div id="{{ $id ?? '' }}" x-data='{ activeTab: {{ localization()->getDefaultLocale() }}}'>
    <div class="tabs">
        @foreach (localization()->getSupportedLocalesKeys() as $lang)
            <a
                id="{{ $lang }}"
                x-on:click.prevent="activeTab = {{ $lang }}"
                class="tab tab-bordered"
                x-bind:class="activeTab === {{ $lang }} ? 'tab-active' : ''"
            >
                {{ $lang }}
            </a>
        @endforeach
    </div>

    @foreach (localization()->getSupportedLocalesKeys() as $lang)
        <div x-show="activeTab === {{ $lang }}">
            @foreach ($fields as $field)
                @include("ui.form.".$field['type'], [
                    'id' => isset($id) ? $id.$lang : 'input',
                    'label' => trans("base.form.".$field['name']),
                    'model' => isset($model) ? $model.$lang.'.'.$field['name'] : "translations.$lang.".$field['name']
                ])
            @endforeach
        </div>
    @endforeach
</div>

