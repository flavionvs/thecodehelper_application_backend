<?php

namespace App\View\Components\admin;

use Illuminate\View\Component;

class header extends Component
{
    public $header;
    public $link1;
    public function __construct($header, $link1)
    {
        $this->header = $header;
        $this->link1 = 'Hello';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.header');
    }
}
