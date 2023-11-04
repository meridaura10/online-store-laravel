@if ($item)
    <div class="grid grid-cols-4 items-center mb-2  gap-5">

        @foreach ($options as $option)
            <div>
                <button type="button" wire:click='update("{{ $option }}")'
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ $option }}
                </button>
            </div>
        @endforeach
    </div>
    <div class="pt-3 border-t mt-4">
        <span class="text-lg font-semibold">зараз:</span> {{ $item->{$this->field} }}
    </div>
@endif
