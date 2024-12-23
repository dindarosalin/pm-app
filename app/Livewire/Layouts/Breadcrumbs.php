<?php

namespace App\Livewire\Layouts;

use Livewire\Component;

class Breadcrumbs extends Component
{
    public $breadcrumbs = [];

    public function mount()
    {
        $segments = request()->segments();
        $url = '';

        foreach ($segments as $index => $segment) {
            $url .= '/' . $segment;
            $this->breadcrumbs[] = [
                'name' => ucwords(str_replace('-', ' ', $segment)),
                'url' => url($url),
                'active' => $index == count($segments) - 1,
            ];
        }
    }
    
    public function render()
    {
        return view('livewire.layouts.breadcrumbs');
    }
}
