<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * The active section key (kasir|gudang|laporan)
     *
     * @var string|null
     */
    public $active;

    /**
     * Optional links array to override defaults
     *
     * @var array|null
     */
    public $links;

    /**
     * Whether to show logout button
     *
     * @var bool
     */
    public $showLogout;

    /**
     * Create a new component instance.
     */
    public function __construct($active = null, $links = null, $showLogout = true)
    {
        $this->active = $active;
        $this->links = $links;
        $this->showLogout = $showLogout;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
