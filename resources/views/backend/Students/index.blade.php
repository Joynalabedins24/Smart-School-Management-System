@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-11 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('student.create') }}"><i class="fa-regular fa-square-plus"></i> Add Student</a></div>
    </div>

    <div class="col-11 mx-auto" >
    <form method="GET" class="input-group mb-3 d-flex gap-2 ">

    <!-- Search -->
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search by name or ID..."
           class="form-control w-25">

    <!-- Filter -->
    <select name="class_id" class="form-select w-25">
        <option value="">All Classes</option>
        @foreach($classes as $class)
            <option value="{{ $class->id }}"
                {{ request('class_id') == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-primary">Apply</button>

    <a href="{{ route('student.index') }}" class="btn btn-secondary">Reset</a>

    </form>

    </div>

    <div class="shadow-sm card col-11 mx-auto">
        <div class="card">
            <div class="card-header">
              All Students
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Age</th>
                        <th scope="col">Date of Admission</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $key => $student)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{ $student->student->user->name }}</td>
                            <td>{{ $student->student->student_id }}</td>
                            <td>{{ $student->student->dob->age }}</td>
                            <td>{{ $student->student->admission_date }}</td>
                            <td>@if($student->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">


                                    <a class="btn btn-sm bg-primary fw-bold" href=""><i class="fa-solid fa-eye"></i></a>
                                    <a class="btn btn-sm bg-warning  fw-bold" href="{{ route('student.edit',$student->id) }}"><i class="fa-solid fa-pencil"></i></a>

                                    <form action="{{ route('student.destroy',$student->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                    <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $students->links() }}
            </div>
        </div>

    </div>
@endsection
