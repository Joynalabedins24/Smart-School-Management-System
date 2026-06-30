@extends('layouts.app')
@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mx-auto col-10 mb-4">
        <h2 class="h4 text-gray-800">Smart VR Classrooms</h2>
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Classroom
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mx-auto col-10 alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card col-10 shadow mb-4 mx-auto">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>Room No</th>
                            <th>Room Name</th>
                            <th>Type</th>
                            <th>Capacity</th>
                            <th>Floor</th>
                            <th>Thumbnail</th>
                            <th>VR Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classrooms as $classroom)
                            <tr>
                                <td class="font-weight-bold text-primary">{{ $classroom->room_no }}</td>
                                <td>{{ $classroom->room_name }}</td>
                                <td>
                                    <span class="badge bg-secondary text-capitalize">
                                        {{ $classroom->room_type }}
                                    </span>
                                </td>
                                <td>{{ $classroom->capacity }} Students</td>
                                <td>{{ $classroom->floor_no ?? 'N/A' }}</td>
                                <td>
                                    @if($classroom->thumbnail)
                                        <img src="{{ asset($classroom->thumbnail) }}" alt="Room Image" class="img-thumbnail" style="max-width: 80px; height: auto;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>
                                    @if($classroom->vr_model_path)
                                        <span class="badge bg-success"><i class="fas fa-cube"></i> VR Ready</span>
                                    @else
                                        <span class="badge bg-warning text-dark">No 3D Model</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($classroom->vr_model_path)
                                            <a href="{{ route('classrooms.show', $classroom->id) }}" class="btn btn-sm btn-success" title="Enter VR Classroom">
                                                <i class="fas fa-vr-cardboard"></i> Enter VR
                                            </a>
                                        @endif

                                        <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-info text-white" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this classroom?')" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No smart classrooms found. Click "Add New Classroom" to create one.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
