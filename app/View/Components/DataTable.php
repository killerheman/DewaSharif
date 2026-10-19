<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DataTable extends Component
{
    public function __construct(
        public string $id = 'datatable',
        public bool $responsive = true,
        public bool $striped = true,
        public bool $hover = true,
        public bool $bordered = false,
        public bool $small = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.data-table');
    }
}