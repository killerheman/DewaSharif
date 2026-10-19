<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        public string $text,
        public string $color = 'success',
        public bool $pill = false,
        public string $icon = '',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.badge');
    }
}