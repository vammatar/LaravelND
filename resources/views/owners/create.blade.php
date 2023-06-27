@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __("messages.ownerCreate") }}</div>
                    <div class="card-body">
                        <form method="post" action="{{ route("owners.store") }}">
                        @csrf
                        <div class="mb-3">
                        <label class="form-label">{{ __("messages.name") }}:</label>
                        <input class="form-control" name="name" type="text" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">{{ __("messages.surname") }}:</label>
                        <input class="form-control" name="surname" type="text" value="{{ old('surname') }}" required>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">{{ __("messages.birthYear") }}:</label>
                        <input class="form-control" name="year" type="text" value="{{ old('year') }}">
                        </div>
                        <button class="btn btn-success">{{ __("messages.addNewOwner") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
