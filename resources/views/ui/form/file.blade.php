<div class="form-control {{ $style ?? 'w-full'}}">
    @if(isset($label))
        <label class="label">
        <span class="label-text">{{ $label }}</span>
        </label>
    @endif
    <input
        type="{{ $type ?? 'file' }}"
        @if(isset($accept)) accept="{{ $accept }}" @endif
        wire:model="{{ $model }}"
        name="{{ $model }}"
        @if(isset($multiple) && !$multiple) @else multiple @endif
        class="file-input file-input-bordered w-full
         @error($model . ".*") file-input-error @enderror
         @error($model) file-input-error @enderror"
    />
    @error($model . ".*")
        <label class="label">
            <span class="text-xs text-error">{{ $message }}</span>
        </label>
    @enderror
    @error($model)
    <label class="label">
        <span class="text-xs text-error">{{ $message }}</span>
    </label>
@enderror
</div>
