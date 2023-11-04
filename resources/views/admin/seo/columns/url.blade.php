<div>
    @if ($column->value($item))
        {{ $column->value($item) }}
    @else
        {{ $item->relation->getseoData()['url'] }}
    @endif

</div>
