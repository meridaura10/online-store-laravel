<?php

namespace App\Http\Livewire\Admin\User;

use App\Enums\User\RoleEnum;
use App\Http\Livewire\Admin\Datatable\Table;
use App\Http\Livewire\Admin\Datatable\Util\Column;
use App\Http\Livewire\Admin\Datatable\Util\Columns;
use App\Http\Livewire\Admin\Datatable\Util\Filter;
use App\Http\Livewire\Admin\Datatable\Util\Filters;
use App\Models\User;
use Livewire\Component;

class Index extends Table
{
    public function title(): string
    {
        return 'users';
    }
    public function model(): string
    {
        return User::class;
    }
    public function extendQuery(\Illuminate\Contracts\Database\Eloquent\Builder $builder)
    {
        return $builder;
    }
    public function createdLink()
    {
        return null;
    }
    public function columns():Columns{
        return new Columns(
            new Column(
                key: 'id',
                title: 'id',
            ),
            new Column(
                key: 'name',
                title: 'name',
            ),
            new Column(
                key: 'role',
                title: 'role',
                view: 'default:fieldEdit',
                columnParams: [
                    'options' => RoleEnum::cases(),
                    'model' => $this->model(),
                ],
            ),
            new Column(
                key: 'email_verified_at',
                title: 'email verified at',
            ),
            new Column(
                key: 'email',
                title: 'email',
            ),
            new Column(
                key: 'created_at',
                title: 'created',
            ),
        );
    }
    public function filters():Filters{
        return new Filters(
            new Filter(
                key: 'search',
                title: 'search'
            ),
            new Filter(
                key: 'role',
                title: 'search to role',
                values: 'roles',
                valuesKey: 'id',
                valuesName: 'name',
                view: 'default:status',
            )
        );
    }
    public function roles(){
        $values = [];

        foreach (RoleEnum::cases() as $payStatus) {
            $values[$payStatus->value] = $payStatus;
        }

        return $values;
    }
}
