<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public string $title = '',
        public string $icon = '',
        public string $color = 'success',
        public bool $footer = false,
        public bool $collapsible = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}