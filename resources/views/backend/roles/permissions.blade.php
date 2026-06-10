@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        Role Permission Management
                    </h4>

                    <a href="{{ route('roles.index') }}"
                       class="btn btn-secondary btn-sm">
                        Back
                    </a>

                </div>

                <div class="card-body">

                    <div class="alert alert-info">
                        <strong>Role:</strong> {{ ucfirst($role->name) }}
                    </div>

                    <form action="{{ route('roles.permissions.update', $role->id) }}"
                          method="POST">

                        @csrf

                        <div class="table-responsive">

                            <table class="table table-bordered table-striped align-middle">

                                <thead class="table-dark">

                                    <tr>
                                        <th width="10%">SL</th>
                                        <th width="40%">Permission Name</th>
                                        <th width="30%">Module</th>
                                        <th width="20%" class="text-center">
                                            Allow
                                        </th>
                                    </tr>

                                </thead>

                                <tbody>

                                @forelse($permissions as $permission)

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                        </td>

                                        <td>

                                            <span class="badge bg-primary">
                                                {{ ucfirst($permission->module) }}
                                            </span>

                                        </td>

                                        <td class="text-center">

                                            <div class="form-check d-inline-block">

                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    name="permissions[]"
                                                    value="{{ $permission->name }}"
                                                    id="permission{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}
                                                >

                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4" class="text-center text-danger">

                                            No Permission Found

                                        </td>

                                    </tr>

                                @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-3">

                            <button type="submit"
                                    class="btn btn-success">

                                Save Permissions

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection
