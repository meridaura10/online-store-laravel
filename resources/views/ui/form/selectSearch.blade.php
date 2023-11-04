<div class="form-control relative" x-data="{ open: false }">
    <label class="label">
        <span class="label-text">{{ $label ?? 'label' }}</span>
    </label>
    <input type="text" readonly class="input @error($model) input-error @enderror  input-bordered"
        value="{{ $value ?? null }}" @click="open = true">
    <div class="p-2 shadow menu dropdown-content z-[1] absolute top-[84px] left-0  bg-base-100 border-2 w-full"
        x-show="open" x-cloak x-trap="open" @click.outside="open = false">
        <input type="text" class="input input-xs input-bordered" wire:model="{{ $searchModel }}"
            placeholder="{{ trans('base.search') }}">
        <ul class="max-h-64 w-full overflow-y-auto">
            @if (isset($default))
                <li @click="open = false"
                wire:click="$set('{{ $model }}',null)"
                    x-on:click="$wire.{{ $searchModel }} = ''"
                    wire:key="default.item.searh + {{ now() }}">
                    <a>{{ $default }}</a>
                </li>
            @endif
            @foreach ($options as $option)
                <li @click="open = false"
                    wire:click="$set('{{ $model }}', @if (isset($optionKey)) '{{ $option->$optionKey }}'
                    @else {{ $option }} @endIf )"
                    x-on:click="$wire.{{ $searchModel }} = ''"
                    wire:key="{{ isset($keyName) ? $option->$keyName : $option->$valueName }}">
                    <a>{{ $option->$valueName }}</a>
                </li>
            @endforeach
        </ul>
    </div>
    @error($model)
        <label class="label">
            <span class="text-xs text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
