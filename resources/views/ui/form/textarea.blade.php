<div class="form-control {{ $style ?? '' }}">
    @if (isset($label))
        <label class="label" for="{{ $id ?? $model }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <textarea id={{ $id ?? $model }} placeholder="{{ $placeholder ?? 'Type here' }}"
        class="textarea textarea-bordered h-24 @error($model) textarea-error @enderror" wire:model.defer="{{ $model }}">
    </textarea>
    @error($model)
        <label class="label">
            <span class="text-xs text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
