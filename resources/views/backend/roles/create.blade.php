@extends('layouts.app')

@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Role Name</label>
            <input type="text"
               name="name"
               class="form-control"
               required>
        </div>

        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </form>
</div>
@endsection
