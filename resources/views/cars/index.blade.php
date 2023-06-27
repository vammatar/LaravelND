@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __("messages.ownerstList") }}</div>
                    <div class="card-body">
                    <form action="{{ route('cars.index') }}" method="GET">
    <div class="form-group">
        <label for="owner">{{ __("messages.owner") }}:</label>
        <select name="owner" id="owner" class="form-control">
            <option value="">All</option>
            @foreach($owners as $owner)
                <option value="{{ $owner->id }}" {{ Request::get('owner') == $owner->id ? 'selected' : '' }}>{{ $owner->name }} {{ $owner->surname }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="license_plate">{{ __("messages.licensePlate") }}:</label>
        <input type="text" name="license_plate" id="license_plate" class="form-control" value="{{ Request::get('license_plate') }}">
    </div>
    <div class="form-group">
        <label for="manufacturer">{{ __("messages.manufacturer") }}:</label>
        <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="{{ Request::get('manufacturer') }}">
    </div>
    <div class="form-group">
        <label for="model">{{ __("messages.model") }}:</label>
        <input type="text" name="model" id="model" class="form-control" value="{{ Request::get('model') }}">
    </div>
    <button type="submit" class="btn btn-primary">{{ __("messages.filter") }}</button>
</form>
<hr>
<div class="mb-3">
                            <a href="{{ route('cars.create') }}" class="btn btn-success">{{ __("messages.addNewCar") }}</a>
                        </div>
                        <table class="table">
    <thead>
        <tr>
            <th>{{ __("messages.licensePlate") }}</th>
            <th>{{ __("messages.manufacturer") }}</th>
            <th>{{ __("messages.model") }}</th>
            <th>{{ __("messages.owner") }}</th>
            <th>{{ __("messages.edit") }}</th>
            <th>{{ __("messages.delete") }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cars as $car)
            <tr>
                <td>{{ $car->license_plate }}</td>
                <td>{{ $car->manufacturer }}</td>
                <td>{{ $car->model }}</td>
                @if ($car->owner)
                    <td>{{ $car->owner->name }} {{ $car->owner->surname }}</td>
                @else
                    <td>{{ __("messages.unknownOwner") }}</td>
                @endif
                <td><a href="{{ route('cars.edit', $car->id) }}" class="btn btn-primary">{{ __("messages.edit") }}</a></td>
                <td>
                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this car?')">{{ __("messages.delete") }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
