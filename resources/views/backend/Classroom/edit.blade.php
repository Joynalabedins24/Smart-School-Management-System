@extends('layouts.app')

@section('content')
<div class="shadow card col-10 mx-auto p-3">

<form action="{{ route('classrooms.update',$classroom->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-4 mb-3">
            <label>Room Number <span class="text-danger">*</span></label>
            <input
                type="text"
                name="room_no"
                class="form-control"
                value="{{ old('room_no',$classroom->room_no) }}"
                required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Room Name <span class="text-danger">*</span></label>
            <input
                type="text"
                name="room_name"
                class="form-control"
                value="{{ old('room_name',$classroom->room_name) }}"
                required>
        </div>

        <div class="col-md-4 mb-3">
            <label>Room Type</label>

            <select name="room_type" class="form-control">

                <option value="theory"
                {{ $classroom->room_type=='theory'?'selected':'' }}>
                Theory Room
                </option>

                <option value="lab"
                {{ $classroom->room_type=='lab'?'selected':'' }}>
                Lab
                </option>

                <option value="auditorium"
                {{ $classroom->room_type=='auditorium'?'selected':'' }}>
                Auditorium
                </option>

                <option value="conference"
                {{ $classroom->room_type=='conference'?'selected':'' }}>
                Conference
                </option>

            </select>

        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-3">
            <label>Floor</label>

            <input
                type="number"
                name="floor_no"
                class="form-control"
                value="{{ old('floor_no',$classroom->floor_no) }}">
        </div>

        <div class="col-md-3 mb-3">
            <label>Capacity</label>

            <input
                type="number"
                name="capacity"
                class="form-control"
                value="{{ old('capacity',$classroom->capacity) }}">
        </div>

        <div class="col-md-3 mb-3">
            <label>Room Length (Feet/Meter)</label>

            <input
                type="number"
                name="room_length"
                class="form-control"
                value="{{ old('room_length',$classroom->room_length) }}">
        </div>

        <div class="col-md-3 mb-3">
            <label>Room Width (Feet/Meter)</label>

            <input
                type="number"
                name="room_width"
                class="form-control"
                value="{{ old('room_width',$classroom->room_width) }}">
        </div>

    </div>

    {{-- Thumbnail --}}

    <div class="row">

        <div class="col-md-6 mb-4">

            <label>Current Thumbnail</label>

            <div class="border rounded p-3 text-center">

                @if($classroom->thumbnail)

                    <img
                        src="{{ asset($classroom->thumbnail) }}"
                        class="img-fluid rounded shadow"
                        style="height:180px;object-fit:cover">

                @else

                    <img
                        src="{{ asset('uploads/images/default-room.png') }}"
                        class="img-fluid rounded shadow"
                        style="height:180px">

                @endif

            </div>

            <label class="mt-3">
                Change Thumbnail
            </label>

            <input
                type="file"
                name="thumbnail"
                class="form-control"
                accept="image/*">

        </div>

        {{-- VR Model --}}

        <div class="col-md-6 mb-4">

            <label>Current VR Model</label>

            <div class="border rounded p-3 text-center">

                @if($classroom->vr_model_path)

                    <i class="fa-solid fa-cube fa-4x text-primary"></i>

                    <p class="mt-3">

                        {{ basename($classroom->vr_model_path) }}

                    </p>

                @else

                    <p class="text-muted mt-5">

                        No VR Model Uploaded

                    </p>

                @endif

            </div>

            <label class="mt-3">
                Replace VR Model
            </label>

            <input
                type="file"
                name="vr_model"
                class="form-control"
                accept=".glb,.gltf">

        </div>

    </div>

    <div class="mb-3">

        <label>Description</label>

        <textarea
            name="description"
            rows="4"
            class="form-control">{{ old('description',$classroom->description) }}</textarea>

    </div>

    <div class="mb-3">

        <label>Status</label>

        <select name="status" class="form-control">

            <option value="active"
            {{ $classroom->status=='active'?'selected':'' }}>
            Active
            </option>

            <option value="inactive"
            {{ $classroom->status=='inactive'?'selected':'' }}>
            Inactive
            </option>

        </select>

    </div>

    <button class="btn btn-success">

        Update Smart Classroom

    </button>

</form>

</div>
@endsection
