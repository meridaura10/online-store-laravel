@forelse ($column->value($item) as $value)
    {{ $value->value }};
@empty
    -
@endforelse
