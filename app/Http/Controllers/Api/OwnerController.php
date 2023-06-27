<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        return Owner::all();
    }

    public function store(Request $request)
    {
        $owner = Owner::create($request->all());
        return response()->json($owner, 201);
    }

    public function show(Owner $owner)
    {
        return $owner;
    }

    public function update(Request $request, Owner $owner)
    {
        $owner->update($request->all());
        return response()->json($owner, 200);
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();
        return response()->json(null, 204);
    }
}
