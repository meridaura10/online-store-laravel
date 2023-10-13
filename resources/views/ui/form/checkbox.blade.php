<div class="form-control w-[100px]">
    <label id="{{ $id ?? $model }}" class="label flex justify-between cursor-pointer">
      @if (isset($label))
      <span class="label-text">{{ $label }}</span>
      @endif
      <input
        type="checkbox"
        id="{{ $id ?? $model }}"
        class="toggle @error($model) toggle-error @enderror"
        wire:model="{{ $model }}"
        />
    </label>
  </div>

