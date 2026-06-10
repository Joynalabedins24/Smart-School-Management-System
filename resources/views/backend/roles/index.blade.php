@extends('layouts.app')

@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <a href="{{ route('roles.create') }}" class="btn btn-primary col-2 mb-3">
        Add Role
    </a>

    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

        @foreach($roles as $role)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td class="col-9">{{ $role->name }}</td>

                <td>
                    <a  href="{{ route('roles.permissions.edit', $role->id) }}"
                        class="btn btn-primary btn-sm">
                        Permissions
                    </a>

                    <a  href="{{ route('roles.edit',$role->id) }}"
                        class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <form action="{{ route('roles.destroy',$role->id) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>
    </table>
</div>
@endsection
