<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CabinetController extends Controller
{
    public function index(){
        return view('cabinet.index');
    }
    public function orders(){
        return view('cabinet.orders');
    }
    public function user(){
        return view('cabinet.user',[
            'user' => auth()->user(),
        ]);
    }
}
