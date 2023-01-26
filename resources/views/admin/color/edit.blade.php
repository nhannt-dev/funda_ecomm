@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Color
                        <a href="{{ route('color') }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('updatecolor', $color->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $color->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" class="form-control" value="{{ $color->code }}">
                        </div>
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status" {{ $color->status ? 'checked' : ''}}>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary float-end">Update Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection