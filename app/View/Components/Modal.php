<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public string $id,
        public string $title = '',
        public string $size = '',
        public bool $scrollable = false,
        public bool $centered = false,
        public bool $static = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.modal');
    }
}