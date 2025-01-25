<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Breadcrumb extends Component
{
    /**
     * The breadcrumb items.
     */

    /**
     * Create a new component instance.
     */
    public function __construct(public array $items)
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.breadcrumb');
    }
}
