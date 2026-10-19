<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public function __construct(
        public string $name,
        public string $label = '',
        public mixed $value = null,
        public string $placeholder = '',
        public string $hint = '',
        public int $rows = 5,
        public bool $required = false,
        public bool $readonly = false,
        public bool $disabled = false,
        public bool $floating = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}