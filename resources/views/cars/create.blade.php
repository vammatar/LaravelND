@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __("messages.carCreate") }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route("cars.store") }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __("messages.manufacturer") }}:</label>
                            <input class="form-control" name="manufacturer" type="text" value="{{ old('manufacturer') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("messages.model") }}:</label>
                            <input class="form-control" name="model" type="text" value="{{ old('model') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("messages.year") }}:</label>
                            <input class="form-control" name="year" type="text" value="{{ date('Y') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("messages.licensePlate") }}:</label>
                            <input class="form-control" name="license_plate" type="text" value="{{ old('license_plate') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __("messages.owner") }}:</label>
                            <select class="form-control" name="owner_id">
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>{{ $owner->name }} {{ $owner->surname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success">{{ __("messages.add") }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection