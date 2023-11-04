<div class="flex gap-1">
    <div>
        {{ $item->{$column->columnParams['field'] ?? $column->key} }}
    </div>
    <div>
        <button class="btn  btn-xs  join-item " wire:click="$emit('modal-change-field-open','{{ $item->id }}',{{ json_encode($column->columnParams) }},'{{ $column->key }}')">
            <i class="ri-pencil-line"></i>
        </button>
    </div>
</div>
