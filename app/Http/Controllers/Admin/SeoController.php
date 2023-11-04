<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seo;

class SeoController extends Controller
{
    public function index(){
        return view('admin.seo.index');
    }
    public function create(){
        return view('admin.seo.static.create');
    }
    public function edit(Seo $seo){
        return view('admin.seo.static.edit',compact('seo'));
    }
}
