<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BrandController extends BaseController
{
    public function model(): Builder
    {
        return Brand::query();
    }
    public function name(): string
    {
        return 'brand';
    }
}
