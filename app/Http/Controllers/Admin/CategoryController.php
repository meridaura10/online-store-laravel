<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }
    public function create()
    {
        return view('admin.category.create');
    }
}
