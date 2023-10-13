<div class="form-control w-full max-w-xs">
    <label class="label">
      <span class="label-text">{{ $filter->title }}</span>
    </label>
    <input type="text" wire:model="f.{{ $filter->key }}"  placeholder="{{ $filter->title }}" placeholder="Type here" class="input input-bordered input-sm w-full max-w-xs" />
  </div>
