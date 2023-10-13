<div class="flex gap-1">
    {{ $item->status }}
    <div>
        <button class="btn  btn-xs  join-item " wire:click="$emit('modal-change-status-open','{{ $item->id }}',{{ json_encode($column->columnParams) }})">
            <i class="ri-pencil-line"></i>
        </button>
    </div>
</div>
