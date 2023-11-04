<div>
    @if (count($item->payments) > 1)
        {{ count($item->payments) }}платежів
    @else
        <div class="flex gap-1">
            currency: <span class="font-semibold">{{ $item->payments[0]->currency }}</span>
        </div>
        <div class="flex gap-1 ">
            system: <span class="font-semibold">{{ $item->payments[0]->system }}</span>
        </div>
        <div class="flex gap-1">
            status:  
            <span class="font-semibold">  @include('livewire.admin.datatables.defaults.columns.fieldEdit',[
                'item' => $item->payments[0],
                'column' => $column,
            ])</span>
        </div>
    @endif
</div>
