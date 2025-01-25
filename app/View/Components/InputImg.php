<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class InputImg extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct( public User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-img');
    }
}
