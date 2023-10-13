@if ($column->valueIsArray($item))
    @forelse ($column->value($item) as $value)
    {{ $value->name }}
    <br>
    @empty
    -
    @endforelse
@else
{{ $column->value($item) ?? '-' }}
@endif
