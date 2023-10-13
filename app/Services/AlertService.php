<?php

namespace App\Services;

use Illuminate\Console\View\Components\Alert;
use PhpParser\Node\Expr\Cast\Array_;

class AlertService
{
    public function open($component)
    {
        $component->emit('open-alert');
    }
    public function getData()
    {
        return session('alert');
    }
    public function setData($data)
    {
        session([
            'alert' => $data,
        ]);
    }
}
