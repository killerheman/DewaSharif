<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PageTitle extends Component
{
    public function __construct(
        public string $title,
        public string $subtitle = '',
        public string $icon = '',
        public string $buttonText = '',
        public string $buttonLink = '',
        public string $buttonIcon = 'bi bi-plus-circle-fill',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.page-title');
    }
}