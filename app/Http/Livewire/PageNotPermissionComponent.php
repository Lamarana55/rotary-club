<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PageNotPermissionComponent extends Component
{
    public function render()
    {
        return view('pages_not_permissions.index')->extends("layouts.default")->section("content");
    }
}
