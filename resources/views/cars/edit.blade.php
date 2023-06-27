@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __("messages.editCar") }}</div>
                    <div class="card-body">
                        <form method="post" action="{{ route("cars.update", $car->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.manufacturer") }}</label>
                                <input class="form-control" name="brand" type="text" value="{{ $car->manufacturer }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.model") }}</label>
                                <input class="form-control" name="model" type="text" value="{{ $car->model }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.licensePlate") }}</label>
                                <input class="form-control" name="license_plate" type="text" value="{{ $car->license_plate }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.owner") }}</label>
                                <select class="form-select" name="owner_id" required>
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}" @if ($car->owner_id == $owner->id) selected @endif>{{ $owner->name }} {{ $owner->surname }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-success">{{ __("messages.save") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
