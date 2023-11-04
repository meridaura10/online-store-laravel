<div>
    <button class='btn {{ $styles ?? "btn-accent" }}' type="{{ isset($type) ? $type : 'button' }}">
        {{ $name ?? trans('base.save') }}
    </button>
</div>
