<div class="form-control w-full {{ $style ?? '' }}">
    @if ($label)
        <label class="label">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif
    <select wire:loading.attr="disabled" class="select {{ $styleSelect ?? '' }} select-bordered w-full"
        @if (isset($multiple)) multiple @endif id="{{ $model }}" wire:model="{{ $model }}">
        @if (isset($default))
            <option value="null" @if (isset($defaultDisabled) && $defaultDisabled) disabled @endif selected>{{ $default }}
            </option>
        @endif
        @foreach ($options as $option)
            <option value="{{ isset($isArray) ? $option[$keyName] : $option->$keyName }}">
                {{ isset($valueName) ? (isset($isArray) ? $option[$valueName] : $option->$valueName) : $option->$valueFunction() }}
            </option>
        @endforeach
    </select>
    @error($model)
        <label class="label">
            <span class="text-xs text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
