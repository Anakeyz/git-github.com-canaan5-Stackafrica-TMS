<?php

namespace App\Http\Controllers;


use App\Models\Fee;
use App\Models\TerminalGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function back;
use function to_route;
use function view;

class Fees extends Controller
{
//    public function index()
//    {
//        return view('pages.fees.index');
//    }

    public function index( $id )
    {
        $group = TerminalGroup::find($id);
        return view('pages.terminal-groups.fees', compact('group'));
    }

    public function edit($groupId, $feeId)
    {
        $group = TerminalGroup::find($groupId);
        $fee = Fee::find($feeId);

        return view('pages.fees.edit', compact('group', 'fee'));
    }


    public function update($groupId, $feeId)
    {
        $fee = Fee::find($feeId);

        $data = \request()->only(['amount', 'amount_type', 'cap', 'info', 'config', 'newConfig']);

        $configs = collect();
        if ( \request()->has('config') ) {
            $configs = collect($data['config']);
        }

        if (\request()->has('newConfig') && sizeof(\request('newConfig')) > 0 ) {
            $ncArray = array_chunk(\request('newConfig'), 2);
            foreach ($ncArray as $item) {
                $configs->put($item[0], $item[1]);
            }

            unset($data['newConfig']);
            $data['config'] = $configs;
        }

        DB::table('fees')->where('id', $feeId)
            ->update($data);


        return to_route('terminal-groups.fees', [$groupId])->with('success', 'Update Successful!');
    }
}
