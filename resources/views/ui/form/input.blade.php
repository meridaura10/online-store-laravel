<div class="form-control w-full {{ $style ?? ''}}">
    <label class="label"  id="{{ $id ?? $name ?? $model}}">
        @if(isset($label))
            <span class="label-text  {{ $styleLabelText ?? '' }}">{{ $label }}</span>
        @endif
    </label>
    <input
        type="{{ $type ?? 'text'}}" id="{{ $id ?? $name ?? $model }}"
        placeholder="{{ $placeholder ?? 'Type here' }}"
        step="0.01"
        class="input input-bordered @error($model) input-error @enderror w-full"
        wire:model="{{ $model }}"
        @if(isset($wireInput)) wire:loading.attr="disabled" wire:model.debounce.500ms="{{ $wireInput }}" @endif
        />
    @if(isset($validationError) && !$validationError)
    @else
    @error($model)
        <label class="label">
            <span class="text-xs text-error">{{ $message }}</span>
        </label>
    @enderror

    @endif
</div>
