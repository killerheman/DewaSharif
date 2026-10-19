<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileUpload extends Component
{
    public function __construct(
        public string $name,
        public string $label = '',
        public string $accept = 'image/*',
        public string $hint = '',
        public string $preview = '',
        public bool $required = false,
        public bool $disabled = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.file-upload');
    }
}