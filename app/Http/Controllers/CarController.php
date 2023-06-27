<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carsQuery = Car::query();

        if ($request->filled('owner') && $request->input('owner') !== 'All') {
            $carsQuery->where('owner_id', $request->input('owner'));
        }

        if ($request->has('license_plate')) {
            $carsQuery->where('license_plate', 'like', '%' . $request->input('license_plate') . '%');
        }

        if ($request->has('manufacturer')) {
            $carsQuery->where('manufacturer', 'like', '%' . $request->input('manufacturer') . '%');
        }

        if ($request->has('model')) {
            $carsQuery->where('model', 'like', '%' . $request->input('model') . '%');
        }

        $cars = $carsQuery->get();
        $owners = Owner::all();

        return view('cars.index', compact('cars', 'owners'));
    }


    public function create()
    {
        $owners = Owner::orderBy('surname')->get();

        return view('cars.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:cars,license_plate|max:7',
            'owner_id' => 'nullable|exists:owners,id'
        ]);

        $car = new Car();
        $car->manufacturer = $validatedData['manufacturer'];
        $car->model = $validatedData['model'];
        $car->license_plate = $validatedData['license_plate'];
        $car->owner_id = $validatedData['owner_id'];
        $car->save();

        return redirect()->route('cars.index')->with('success', 'Car added successfully');
    }

    public function edit(Car $car)
    {
        $owners = Owner::orderBy('surname')->get();

        return view('cars.edit', compact('car', 'owners'));
    }

    public function update(Request $request, Car $car)
    {
        $validatedData = $request->validate([
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|unique:cars,license_plate,'.$car->id.'|max:7',
            'owner_id' => 'nullable|exists:owners,id'
        ]);

        $car->manufacturer = $validatedData['manufacturer'];
        $car->model = $validatedData['model'];
        $car->license_plate = $validatedData['license_plate'];
        $car->owner_id = $validatedData['owner_id'];
        $car->save();

        return redirect()->route('cars.index')->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car)
    {

        Log::info('Delete method called for car ' . $car->id);
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
    }
}
