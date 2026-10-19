<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public function __construct(
        public string $name,
        public string $type = 'text',
        public string $label = '',
        public mixed $value = null,
        public string $placeholder = '',
        public string $icon = '',
        public string $hint = '',
        public bool $required = false,
        public bool $readonly = false,
        public bool $disabled = false,
        public bool $floating = false,
        public bool $showToggle = true,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}