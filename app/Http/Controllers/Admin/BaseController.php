<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    abstract public function model(): Builder;
    abstract public function name(): string;

    public function index()
    {
        $path = 'admin.' . $this->name() . '.index';
        return view($path);
    }
    public function edit($brandId)
    {
        $item = $this->model()->find($brandId);
        $path = 'admin.' . $this->name() . '.edit';
        return view($path, [
            $this->name() => $item,
        ]);
    }
    public function create()
    {
        $path = 'admin.' . $this->name() . '.create';
        return view($path);
    }
}
