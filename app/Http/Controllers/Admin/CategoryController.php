<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function model(): Builder
    {
        return Category::query();
    }
    public function name(): string
    {
        return 'category';
    }
}
