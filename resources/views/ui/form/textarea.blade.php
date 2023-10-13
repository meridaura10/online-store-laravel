<div class="form-control {{ $style ?? ''}}">
    <label class="label" for="{{ $id ?? $model }}">
      <span class="label-text">{{ $label }}</span>
    </label>
    <textarea
        id={{ $id ?? $model }}
        placeholder="{{ $placeholder ?? 'Type here' }}"
        class="textarea textarea-bordered h-24 @error($model) textarea-error @enderror"
        wire:model="{{ $model }}"
    >
    </textarea>
    @error($model)
        <label class="label">
            <span class="text-xs text-error">{{ $message }}</span>
        </label>
    @enderror
</div>
