@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card col-10 mx-auto">

        <div class="card-header">
            <h4>User Role Management</h4>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-sm fs-6">

                    <thead class="table-dark">

                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Current Role</th>
                            <th>Assign Role</th>
                        </tr>

                    </thead>

                    <tbody>

                    @foreach($users as $user)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                                @foreach($user->roles as $role)

                                    <span class="badge bg-success small">
                                        {{ $role->name }}
                                    </span>

                                @endforeach

                            </td>

                            <td>

                                <form
                                    action="{{ route('users.roles.update', $user->id) }}"
                                    method="POST">

                                    @csrf

                                    <div class="d-flex gap-2">

                                        <select
                                            name="role"
                                            class="form-select form-select-sm">

                                            <option value="">
                                                Select Role
                                            </option>

                                            @foreach($roles as $role)

                                                <option
                                                    value="{{ $role->name }}"
                                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                                                    {{ ucfirst($role->name) }}

                                                </option>

                                            @endforeach

                                        </select>

                                        <button
                                            type="submit"
                                            class="btn btn-primary btn-sm">

                                            Update

                                        </button>

                                    </div>

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

@endsection
