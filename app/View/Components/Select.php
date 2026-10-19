<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public function __construct(
        public string $name,
        public string $label = '',
        public array $options = [],
        public mixed $value = null,
        public string $placeholder = 'Select an option',
        public bool $required = false,
        public bool $disabled = false,
        public bool $multiple = false,
        public bool $floating = false,
        public string $hint = '',
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}