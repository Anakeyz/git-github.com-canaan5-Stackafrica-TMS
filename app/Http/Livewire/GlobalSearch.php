<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $search = '';

    public function render()
    {
        $users  = empty($this->search) ? User::inRandomOrder()->limit(1)->get()
            : User::withSearch($this->search)->limit(5)->get();

        return view('livewire.global-search', compact('users'));
    }
}
