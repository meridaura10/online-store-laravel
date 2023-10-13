<div class="form-control w-full max-w-xs">
    <label class="label">
        <span class="label-text">{{ $filter->title }}</span>
    </label>
    <select class="select select-bordered select-sm w-full max-w-xs" wire:model="f.{{ $filter->key }}" @if (! $filter->hasValues() {{-- || count($filter->values()) == 0 --}}) disabled @endif>
        <option value="null" disabled selected>{{ "select $filter->title" }}</option>
        @foreach ($filter->values() as $key => $name)
            <option value="{{ $key }}">{{ $name }}</option>
        @endforeach
    </select>
</div>

