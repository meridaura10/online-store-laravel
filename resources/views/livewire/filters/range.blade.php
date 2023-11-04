<div class="flex justify-center items-center">
    <div class="relative max-w-xl w-full">
        <div class="flex items-center justify-between py-2  text-sm text-gray-700">
            <div>
                <input placeholder="min{{ $filter->key }}" type="number" step="0.01" min="{{ $filter->attributes['min'] }}" max="{{ $filter->attributes['max'] }}" maxlength="7" 
                    wire:model.debounce.500="f.{{ $filter->key }}.min"
                    class="w-24 px-3 py-2 text-center border border-gray-200 rounded-lg bg-gray-50 focus:border-yellow-400 focus:outline-none">
            </div>
            <div>
                <input placeholder="max{{ $filter->key }}" type="number" step="0.01" min="{{ $filter->attributes['min'] }}" max="{{ $filter->attributes['max'] }}" maxlength="7" 
                    wire:model.debounce.500="f.{{ $filter->key }}.max"
                    class="w-24 px-3 py-2 text-center border border-gray-200 rounded-lg bg-gray-50 focus:border-yellow-400 focus:outline-none">
            </div>
        </div>

    </div>
</div>
