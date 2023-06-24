<?php

namespace App\Http\Controllers\Api;

use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class Loans extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Loan::class);
    }

    public function index()
    {
        return MyResponse::success('Loans fetched',
            Loan::whereBelongsTo(auth()->user())->latest()->get()
                ->makeHidden(['approved_by', 'confirmed_by', 'declined_by'])
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'items' => 'required|array',
            'info' => 'nullable|string'
        ]);

        auth()->user()->loans()->create($request->only(['items', 'info', 'amount']));

        return MyResponse::success('Loan request added.');
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();

        return MyResponse::success('Loan request deleted.');
    }
}
