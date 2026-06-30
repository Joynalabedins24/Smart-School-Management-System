@extends('layouts.app')
@section('content')
<div class="shadow card col-10 mx-auto p-3">
<form action="{{ route('classrooms.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <div class="row">
        <div class="col-md-6 form-group mb-3">
            <label>Room Number <span class="text-danger">*</span></label>
            <input type="text" name="room_no" class="form-control" placeholder="e.g., Room-402" required>
        </div>

        <div class="col-md-6 form-group mb-3">
            <label>Room Name <span class="text-danger">*</span></label>
            <input type="text" name="room_name" class="form-control" placeholder="e.g., Computer Lab A" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group mb-3">
            <label>Room Type <span class="text-danger">*</span></label>
            <select name="room_type" class="form-control" required>
                <option value="theory">Theory Room</option>
                <option value="lab">Lab</option>
                <option value="auditorium">Auditorium</option>
                <option value="conference">Conference</option>
            </select>
        </div>

        <div class="col-md-4 form-group mb-3">
            <label>Capacity (Students) <span class="text-danger">*</span></label>
            <input type="number" name="capacity" class="form-control" placeholder="e.g., 50" required>
        </div>

        <div class="col-md-4 form-group mb-3">
            <label>Floor No</label>
            <input type="number" name="floor_no" class="form-control" placeholder="e.g., 4">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group mb-3">
            <label>Room Thumbnail Image</label>
            <input type="file" name="thumbnail" class="form-control" accept="image/*">
            <small class="text-muted">JPG, PNG, or WEBP (Max: 2MB)</small>
        </div>

        <div class="col-md-6 form-group mb-3">
            <label>Upload VR Classroom Model (.glb / .gltf)</label>
            <input type="file" name="vr_model" class="form-control" accept=".glb,.gltf">
            <small class="text-muted">Upload your Polycam/Luma AI scanned 3D file (Max: 50MB)</small>
        </div>
    </div>

    <div class="form-group mb-3">
        <label>Description / Notes</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Enter room details..."></textarea>
    </div>

    <div class="form-group mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Save Smart Classroom</button>
</form>
<div>
@endsection
