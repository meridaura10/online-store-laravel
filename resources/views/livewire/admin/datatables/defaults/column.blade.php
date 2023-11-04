@if ($column->valueIsArray($item))
    @forelse ($column->value($item) as $value)
    {{ $value->{$column->valueName} }};
    @if ($column->columnValues)
        <br>    
    @endif
    @empty
    -
    @endforelse
@else
{{ $column->value($item) ?? '-' }}
@endif
