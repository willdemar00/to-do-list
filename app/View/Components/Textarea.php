<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Textarea extends Component
{
    public $name;
    public $value;
    public $attr;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $value = '', $attr = [])
    {
        $this->name = $name;
        $this->value = $value;
        $this->attr = $attr;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}
