<?php

namespace App\Http\Controllers;

use App\Models\Processor;
use App\Models\RoutingType;


class Routing extends Controller
{
    public function index()
    {
        $types = RoutingType::all();

        return view('pages.routing.index', compact('types'));
    }

    public function settings(int $id)
    {
        $processors = Processor::all();
        $routingType = RoutingType::find($id);
        $type = $routingType->name;


        return view("pages.routing.settings", compact('type', 'processors'));
    }

    public function addSetting()
    {
        $data = request()->all();
//        dd(request()->all());


        return back()->with('pending', "Awaiting approval for new {$data['type']} setting");
    }
}
