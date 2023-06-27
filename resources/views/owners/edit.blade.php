@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __("messages.editOwner") }}</div>
                    <div class="card-body">
                    {{ $owner->id }}
                    <form method="post" action="{{ route('owners.update', $owner->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.name") }}</label>
                                <input class="form-control" name="name" type="text" value="{{ $owner->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.surname") }}</label>
                                <input class="form-control" name="surname" type="text" value="{{ $owner->surname }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.yearOfBirth") }}</label>
                                <input class="form-control" name="year" type="text" value="{{ $owner->year }}" required>
                            </div>
                            <button class="btn btn-success">{{ __("messages.save") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
