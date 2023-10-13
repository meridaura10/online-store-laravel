<?php

namespace App\Http\Livewire\Util;

use Livewire\Component;

class Alert extends Component
{
    public $isShow = false;
    public $data;
    public $isAdmin;

    protected $listeners = ['open-alert' => 'open'];
    public function mount($isAdmin = false)
    {
        $this->isAdmin = $isAdmin;
        $this->data  = [
            'message' => 'хай',
            'type' => 'success',
            'dellay' => '3000',
        ];
    }
    public function open()
    {
        $this->data = alert()->getData();
        if ($this->data) {
            $this->isShow = true;
        }
    }
    public function hidden()
    {
        $this->isShow = false;
    }

    public function render()
    {
        return view('livewire.util.alert');
    }
}
