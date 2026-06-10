@extends('layouts.app')

@section('content')
<div class="col-9 mx-auto" >
    <form method="GET" class="input-group mb-3 d-flex gap-2 ">

    <!-- Search -->
    <input type="text"
           name="search"
           placeholder="Search permission"
           value="{{ request('search') }}"
           class="form-control w-25">

    <!-- Filter -->
    <select name="module" class="form-select w-25">
        <option value="">All Modules</option>
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
        <option value="fee">Fee</option>
    </select>

    <button class="btn btn-primary">Filter</button>

    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Reset</a>

    </form>
</div>
<div class="shadow-sm card col-9 mx-auto p-3">
    <a href="{{ route('permissions.create') }}" class="btn btn-primary col-2 mb-3">
        Add Permission
    </a>
    <table class="table">

    <tr>
        <th>Name</th>
        <th>Module</th>
        <th>Action</th>
    </tr>

    @foreach($permissions as $permission)
        <tr>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->module }}</td>
            <td>
                <a href="{{ route('permissions.edit',$permission->id) }}" class="btn btn-warning btn-sm">Edit</a>
            </td>
        </tr>
    @endforeach

    </table>
</div>
@endsection
