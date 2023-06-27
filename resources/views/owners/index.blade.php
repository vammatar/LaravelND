@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __("messages.ownerstList") }}</div>
                    <div class="card-body">
                        <form method="post" action="{{ route("owners.search") }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.name") }}</label>
                                <input class="form-control" name="name" value="{{ $filter->name }}" >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">{{ __("messages.surname") }}</label>
                                <input class="form-control" name="surname" value="{{ $filter->surname }}" >
                            </div>
                            <button class="btn btn-info">{{ __("messages.search") }}</button>
                        </form>
                        <hr>
                        <div class="mb-3">
                            <a href="{{ route('owners.create') }}" class="btn btn-success">{{ __("messages.addNewOwner") }}</a>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __("messages.name") }}</th>
                                    <th>{{ __("messages.surname") }}</th>
                                    <th>{{ __("messages.yearOfBirth") }}</th>
                                    <th>{{ __("messages.edit") }}</th>
                                    <th>{{ __("messages.delete") }}</th>
                                </tr>
                            </thead>
                            <tbody>
@foreach($owners as $owner)
    <tr>
        <td>{{ $owner->name }}</td>
        <td>{{ $owner->surname }}</td>
        <td>{{ $owner->year }}</td>
        <td>
            <a href="{{ route('owners.edit', $owner) }}" class="btn btn-primary">{{ __("messages.edit") }}</a>
        </td>
        <td>
            <form action="{{ route('owners.destroy', $owner) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">{{ __("messages.delete") }}</button>
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
