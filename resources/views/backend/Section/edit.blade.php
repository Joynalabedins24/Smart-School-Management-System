@extends('layouts.app')

@section('content')

<div class="shadow-sm card col-9 mx-auto p-3">

    <form action="{{ route('section.update', $section->id) }}" class="row g-3" method="POST">
        @csrf

        <!-- Section Name -->
        <div class="mb-3 col-4">
            <label class="form-label">Section Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ $section->name }}" required>
        </div>

        <div class="mb-3 col-4">
            <label class="form-label">Section Name</label>
            <input type="text" name="capacity" class="form-control"
                   value="{{ $section->capacity }}" required>
        </div>

        <!-- Class -->
        <div class="mb-3 col-4">
            <label class="form-label">Class</label>
            <select class="form-select" name="class_id" required>

                @foreach ($classes as $class)
                    <option value="{{ $class->id }}"
                        {{ $section->class_id == $class->id ? 'selected' : '' }}>
                        {{ $class->name }}
                    </option>
                @endforeach

            </select>
        </div>
        <div class="col-md-12">
          <button class="btn btn-primary" type="submit"> Update Section </button>
        </div>
    </form>

</div>

@endsection
