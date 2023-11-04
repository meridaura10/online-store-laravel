<div class="form-control w-[100px] {{ $style ?? '' }}">
    <label id="{{ $id ?? $model }}" class="label flex gap-2 justify-between cursor-pointer">
      @if (isset($label))
      <span class="label-text">{{ $label }}</span>
      @endif
      <input
        type="checkbox"
        wire:loading.attr="disabled"
        id="{{ $id ?? $model }}"
        class="toggle @error($model) toggle-error @enderror"
        wire:model="{{ $model }}"
        />
    </label>
  </div>

