<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class OwnerController extends Controller
{
    public function __construct(){

    }

    public function index(Request $request){

        $filter=$request->session()->get('filterOwners', (object)['name'=>null,'surname'=>null]);

        $owners=Owner::filter($filter)->orderBy("name")->get();

        // $owners=Owner::all();
        return view("owners.index",[
            "owners"=>$owners,
            "filter"=>$filter
            ]
        );
    }

    public function search(Request $request){
        $filterOwners=new \stdClass();
        $filterOwners->name=$request->name;
        $filterOwners->surname=$request->surname;

        $request->session()->put('filterOwners', $filterOwners);
        return redirect()->route('owners.index');
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        Owner::create($validatedData);

        return redirect()->route('owners.index')->with('success', 'Owner created successfully.');
    }

    public function show(Owner $owner)
    {
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', ['owner' => $owner]);
    }

    public function update(Request $request, Owner $owner)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $owner->update($validatedData);

        return redirect()->route('owners.index')->with('success', 'Owner updated successfully.');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully.');
    }
}