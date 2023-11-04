<div>
    @if ($column->value($item))
        <span class="font-semibold"> {{ class_basename($item->relation_type) }}:</span>
        {{ $column->value($item)->getSeoData()['title'] }}
    @else
    -
    @endif

</div>
