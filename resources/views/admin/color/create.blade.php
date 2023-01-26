@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Add Color
                        <a href="{{ route('color') }}" class="btn btn-primary btn-sm text-white float-end">Back</a>
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('storecolor') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="code">Code</label>
                            <input type="text" name="code" id="code" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <input type="checkbox" name="status" id="status">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary float-end">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection