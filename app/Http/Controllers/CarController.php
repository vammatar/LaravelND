<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Owner;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Middleware\PermissionMiddleware;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $licensePlateRule = 'nullable|regex:/^[A-Z]{3}[0-9]{3}$/';

        $validatedData = $request->validate([
            'license_plate' => $licensePlateRule,
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
        ], [
            'license_plate.regex' => __('messages.invalidLicensePlate'),
        ]);

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
        $licensePlateRule = 'required|regex:/^[A-Z]{3}[0-9]{3}$/';


        $validatedData = $request->validate([
            'manufacturer' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => $licensePlateRule,
            'owner_id' => 'nullable|exists:owners,id',
            'photos.*' => 'image|max:2048' //2MB max for photo
        ],
            [
                'license_plate.regex' => __('messages.invalidLicensePlate'),
            ]
        );

        $car->manufacturer = $validatedData['manufacturer'];
        $car->model = $validatedData['model'];
        $car->license_plate = $validatedData['license_plate'];
        $car->owner_id = $validatedData['owner_id'];

        // Handle photos
        if ($request->hasFile('photos')) {
            // Delete existing photos
            foreach ($car->photos as $photo) {
                Storage::delete($photo->path);
                $photo->delete();
            }

            // Upload new photos
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('public/photos');
                $car->photos()->create([
                    'path' => $path
                ]);
            }
        }

        $car->save();

        return redirect()->route('cars.index')->with('success', 'Car updated successfully');
    }

    public function destroy(Car $car)
    {

        Log::info('Delete method called for car ' . $car->id);
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Car deleted successfully');
    }

public function uploadPhoto(Request $request, Car $car)
{
    $request->validate([
        'photos.*' => 'image|max:2048' // only allow image files up to 2MB in size
    ]);

    $photos = $request->file('photos');
    $car_id = $car->id;

    foreach ($photos as $photo) {
        $filename = 'car_' . $car_id . '_' . time() . '_' . $photo->getClientOriginalName();
        $photo->storeAs('public/photos', $filename);
    }

    return redirect()->back()->with('success', 'Photos uploaded successfully.');
}

public function deletePhoto(Car $car, $photoFilename)
{
    $carPhotoPath = 'public/photos/' . $photoFilename;

    // Check if the photo belongs to the specified car
    if (strpos($photoFilename, 'car_' . $car->id . '_') !== 0) {
        return redirect()->back()->withErrors(['error' => 'photos does not belong to this car']);
    }

    // Delete the photo file from storage
    Storage::delete($carPhotoPath);

    return redirect()->back()->with('success', 'photos deleted successfully');
}
}
