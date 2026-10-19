<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        public string $type = 'button',
        public string $color = 'success',
        public string $size = '',
        public string $icon = '',
        public bool $loading = false,
        public bool $disabled = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}