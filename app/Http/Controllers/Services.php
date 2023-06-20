<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Services extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name')->with('providers')->get();

        return view('pages.services.index', compact('services'));
    }

    public function update(Request $request, Service $service)
    {
        $service->update($request->only(['name', 'description', 'is_available', 'menu_name']));

        $name = $request->filled('menu_name') ? 'Menu name' : 'Service';

        return back()->with('pending', "$name update awaiting approval.");
    }

    public function jsonData()
    {
        return response()->json(Service::all());
    }
}
