@extends('layouts.app')

@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <form action="{{ route('roles.update',$role->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Role Name</label>

            <input type="text"
                    name="name"
                    value="{{ $role->name }}"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-success">
                Update
            </button>

    </form>
</div>
@endsection
