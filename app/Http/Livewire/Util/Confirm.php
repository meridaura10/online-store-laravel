<?php

namespace App\Http\Livewire\Util;

use Livewire\Component;

class Confirm extends Component
{
    public bool $open;

    public string $title;
    public string $description;
    public string $event;
    public array $params;

    protected $listeners = ['confirm-open' => 'openModal'];

    public function openModal($title, $description, $event, $params)
    {
        $this->title = $title;
        $this->description = $description;
        $this->event = $event;
        $this->params = $params;

        $this->open = true;
    }
    public function confirmed()
    {
        $this->emit($this->event, $this->params);

        $this->open = false;
    }

    public function render()
    {
        return view('livewire.util.confirm');
    }
}
