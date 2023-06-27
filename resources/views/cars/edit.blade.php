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

                        <hr>

                        <form method="post" action="{{ route("cars.uploadPhoto", $car->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.photosUpload") }}</label>
                                <input type="file" name="photos[]" class="form-control" multiple>
                            </div>
                            <button class="btn btn-success">{{ __("messages.upload") }}</button>
                        </form>
                        @if ($car)
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.currentPhotos") }}</label>
                                <div class="row">
                                        <?php
                                        $photoDirectory = storage_path('app/public/photos');
                                        $files = File::files($photoDirectory);
                                        $carPhotos = array_filter($files, function($file) use ($car) {
                                            return strpos($file->getFilename(), 'car_' . $car->id . '_') === 0;
                                        });
                                        ?>
                                    @foreach ($carPhotos as $photo)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <img src="{{ asset('storage/photos/' . $photo->getFilename()) }}" class="card-img-top" alt="">
                                                <div class="card-body">
                                                    <form action="{{ route('cars.deletePhoto', [$car, $photo->getFilename()]) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">{{ __("messages.delete") }}</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
