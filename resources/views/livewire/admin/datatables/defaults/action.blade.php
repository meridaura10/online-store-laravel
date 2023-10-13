<div>
    {{-- @if($action->key == 'destroy')
        <div class="divider divider-horizontal"></div>
    @endif --}}
    <button class="btn {{ $action->style ?? '' }} btn-xs  join-item "
        wire:click="action('{{ $action->key }}', '{{ $item->id }}')"
        >
        @if ($action->icon)
            <i class="{{ $action->icon }}"></i>
        @endif
        @if ($action->title)
            {!! $action->title !!}
        @endif
    </button>
</div>

