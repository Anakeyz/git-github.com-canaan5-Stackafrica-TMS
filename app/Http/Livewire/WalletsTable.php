<?php

namespace App\Http\Livewire;

use App\Models\Wallet;
use Livewire\Component;
use Livewire\WithPagination;

class WalletsTable extends Component
{
    use WithPagination;

    public function render()
    {
        $wallets = Wallet::orderBy('account_number')->with('agent')->paginate(config('app.pagination'));

        return view('pages.wallets.table', compact('wallets'));
    }
}
