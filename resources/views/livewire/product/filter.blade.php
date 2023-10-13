<div class="sidebar pt-6 max-w-[250px] w-full border-r mr-4 bg-white">
    <div class="border-b pl-4 pb-4">
        <h3 class="text-lg text-blue-500 font-semibold">Brands</h3>
        <ul class="mt-2 space-y-2">
            @foreach ($brands as $brand)
                <li class="flex items-center">
                    <input wire:model="selectedFilters.brands" value="{{ $brand->id }}" wire:change='applyFilters'
                        type="checkbox" class="mr-2">
                    <label>{{ $brand->name }}</label>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="border-b pl-4 pb-4 pr-3">
        <h3 class="text-lg text-blue-500 font-semibold mt-4">Price</h3>
        <input type="number" wire:model="selectedFilters.price.min" name="min_price" placeholder="Min Price"
            class="mt-2 w-full p-2 border rounded-md">
        <input type="number" wire:model="selectedFilters.price.max" name="max_price" placeholder="Max Price"
            class="mt-2 w-full p-2 border rounded-md">
        <button wire:click='applyFilters' id="apply-filters"
            class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-md">Apply Filters</button>
    </div>

    <div class="border-b pl-4 pb-4 pr-3">
        <ul class="mt-2 space-y-2">
            @foreach ($options as $key => $values)
                <li>
                    <h3 class="text-lg text-blue-500 font-semibold">{{ $key }}</h3>
                    <ul class="mt-2 space-y-1">
                        @foreach ($values as $value)
                            <li class="flex items-center">
                                <input type="checkbox" wire:model="selectedFilters.options" wire:change='applyFilters'
                                    value="{{ $value['id'] }}" class="mr-2">
                                <label>{{ $value['value'] }}</label>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>

</div>
