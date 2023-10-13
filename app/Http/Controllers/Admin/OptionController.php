<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OptionController extends BaseController
{
    public function model(): Builder
    {
        return Option::query();
    }
    public function name(): string
    {
        return 'option';
    }
}
