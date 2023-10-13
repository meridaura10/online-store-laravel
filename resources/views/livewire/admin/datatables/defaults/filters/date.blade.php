<div class="form-control w-full max-w-xs">
    <label class="label">
      <span class="label-text">{{ $filter->title }}</span>
    </label>
    <input
        wire:model="f.{{ $filter->key }}"
        type="date"
        placeholder="Type here"
        class="input input-sm input-bordered w-full max-w-xs"
    />
</div>
