<div class="overflow-x-auto p-6">
    @livewire('util.confirm')
    <div class="card card-compact shadow-lg bg-base-100 mb-4">
        <div class="card-body">
            <div>
                <div class="p-1">
                    <div class="flex justify-between items-center">
                        <div>
                            @if ($this->createdLink())
                                <a href="{{ $this->createdLink() }}" class="ml-auto">
                                    <button class="btn btn-accent btn-sm">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </a>
                            @endif
                            @if ($this->editedLink())
                                <a href="{{ $this->editedLink() }}" class="ml-auto">
                                    <button class="btn btn-accent btn-sm">
                                        <i class="ri-pencil-fill"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                        <div>
                            <h1 class="font-bold text-xl">
                                {{ $this->title() }}
                            </h1>
                        </div>
                        <div>
                            <button @if (!$this->hasFilter()) disabled @endIf class="btn"
                                wire:click="clearFilter">{{ trans('base.table.drop_filter') }}

                            </button>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-2 gap-4 items-center justify-center md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-3">
                        @foreach ($filters as $filter)
                            {!! $filter->render($this) !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card card-compact shadow-lg bg-base-100 mb-4">
        <div class="card-body">

            <table class="table">
                <thead>
                    <tr class="select-none">
                        @foreach ($columns as $column)
                            <th @if ($column->sortable) wire:click="sortByNext('{{ $column->key }}')" @endif>
                                {{ $column->title }}

                                @if ($column->sortable)
                                    @if ($sortKey == $column->key)
                                        @if ($sortDirection)
                                            <i class="ri-arrow-up-line"></i>
                                        @else
                                            <i class="ri-arrow-down-line"></i>
                                        @endif
                                    @else
                                        <i class="ri-arrow-up-down-line"></i>
                                    @endif
                                @endif
                            </th>
                        @endforeach

                        @if ($this->hasActions())
                            <th class="text-rights">{{ trans('base.table.actions') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr class="hover" wire:key="{{ $item->id }}">
                            @foreach ($columns as $column)
                                <td>
                                    {!! $column->render($item) !!}
                                </td>
                            @endforeach

                            @if ($this->hasActions())
                                <td class="text-right">
                                    <div class="flex flex-row">

                                        <div class="join me-2">
                                            @foreach ($this->actions as $key => $action)
                                                @if (!in_array($action->key, ['destroy', 'delete']))
                                                    {!! $action->render($item) !!}
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="join">
                                            @foreach ($this->actions as $key => $action)
                                                @if (in_array($action->key, ['destroy', 'delete']))
                                                    {!! $action->render($item) !!}
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if ($usePagination)
                <div class="flex justify-between items-end p-2">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">{{ trans('base.table.per_page') }}</span>
                        </label>
                        <select class="select select-bordered w-full max-w-xs" wire:model="perPage">
                            @foreach ($perPages as $perPageOption)
                                <option value={{ $perPageOption }}
                                    @if ($perPageOption == $perPage) class="selected" @endif>
                                    {{ $perPageOption }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
