<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class deleteFormBtn extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action,
        public ?string $method = 'post',
        public ?string $text = 'Удалить'
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-form-btn');
    }
}
