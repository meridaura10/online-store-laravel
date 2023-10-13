<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AttributeController extends BaseController
{
    public function model(): Builder
    {
        return Attribute::query();
    }
    public function name(): string
    {
        return 'attribute';
    }
}
