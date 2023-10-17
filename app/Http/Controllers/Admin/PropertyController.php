<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PropertyController extends BaseController
{
    public function model(): Builder
    {
        return Property::query();
    }
    public function name(): string
    {
        return 'property';
    }
}
