@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-10 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('teacher.create') }}">Add Teacher</a></div>
    </div>
    <div class="shadow-sm card col-10 mx-auto">
        <div class="card">
            <div class="card-header">
              Teachers List
            </div>
            <div class="card-body table-responsive d-none d-md-block">
                <table class="table">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Employ ID</th>
                        <th scope="col">Qualification </th>
                        <th scope="col">Special Subject</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Hire Date</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $key => $teacher)
                        <tr>
                            <th scope="row" class="align-middle">{{$key + 1}}</th>
                            <td class="align-middle">
                                @if($teacher->profile_photo)
                                    <img
                                        src="{{ asset('uploads/teachers/'.$teacher->profile_photo) }}"
                                        alt="{{ $teacher->user->name }}"
                                        class="rounded-circle shadow"
                                        style="
                                            width: 75px;
                                            height: 75px;
                                            object-fit: cover;
                                            object-position: center;
                                            border: 3px solid #0d6efd;
                                            padding: 2px;
                                            background: #fff;
                                            "
                                            >
                                @else
                                    <img
                                        src="{{ asset('uploads/images/default.png') }}"
                                        alt="{{ $teacher->user->name }}"
                                        class="rounded-circle shadow"
                                        style="
                                            width: 75px;
                                            height: 75px;
                                            object-fit: cover;
                                            object-position: center;
                                            border: 3px solid #0d6efd;
                                            padding: 2px;
                                            background: #fff;
                                            "
                                            >
                                @endif
                            </td>
                            <td class="align-middle">
                                <b class="fs-4">{{ $teacher->user->name }}</b><br>
                                {{ $teacher->user->email }}
                            </td>
                            <td class="align-middle text-primary"><b>{{ $teacher->employee_id }}</b></td>
                            <td class="align-middle">{{ $teacher->qualification }}</td>
                            <td class="align-middle">{{ $teacher->subject_specialization }}</td>
                            <td class="align-middle"><i class="fa-solid fa-phone fw-bold"></i> {{ $teacher->phone }}</td>
                            <td class="align-middle">{{ \Carbon\Carbon::parse($teacher->hire_date)->format('d M Y') }}</td>
                            <td class="align-middle">
                                @if($teacher->status)
                                    <span class="badge rounded-pill bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-danger">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href=""
                                        class="btn btn-outline-primary table-action-btn"
                                        title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teacher.edit',$teacher->id) }}"
                                        class="btn btn-outline-success table-action-btn"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('teacher.destroy',$teacher->id) }}" method="POST" onsubmit="return confirm('Delete this teacher?')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-outline-danger table-action-btn"
                                            title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            {{-- mobile view --}}

            <div class="d-md-none m-2">

                @forelse($teachers as $teacher)

                    <div class="card border-0 shadow rounded-4 mb-3">

                        <div class="card-body">

                            <!-- Header -->
                            <div class="d-flex align-items-center">

                                <img    src="{{ $teacher->profile_photo
                                        ? asset('uploads/teachers/'.$teacher->profile_photo)
                                        : asset('uploads/images/default.png') }}"
                                        class="teacher-photo">

                                <div class="ms-3 flex-grow-1">

                                    <h6 class="fw-bold mb-1">

                                        {{ $teacher->user->name }}

                                    </h6>

                                    <span class="badge bg-primary">

                                        {{ $teacher->employee_id }}

                                    </span>

                                </div>

                                <span class="badge bg-success">

                                    Active

                                </span>

                            </div>

                            <hr>

                            <!-- Details -->

                            <div class="row g-2 small">

                                <div class="col-6">

                                    <strong>Qualification</strong>
                                    <br>
                                    {{ $teacher->qualification }}
                                </div>

                                <div class="col-6">
                                    <strong>Subject</strong>
                                    <br>
                                    {{ $teacher->subject_specialization }}
                                </div>
                                <div class="col-6">
                                    <strong>Phone</strong>
                                    <br>
                                    {{ $teacher->phone }}
                                </div>
                                <div class="col-6">
                                    <strong>Hire Date</strong>
                                    <br>
                                    {{ \Carbon\Carbon::parse($teacher->hire_date)->format('d M Y') }}
                                </div>
                            </div>
                            <hr>

                            <!-- Action Buttons -->

                           <div class="d-flex justify-content-between">
                                <a href="" class="btn btn-outline-primary rounded-pill px-3">
                                    <i class="fa-solid fa-eye"></i> View
                                </a>
                                <a href="{{ route('teacher.edit',$teacher->id) }}" class="btn btn-outline-success rounded-pill px-3">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <form action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button     onclick="return confirm('Delete this teacher?')"
                                                class="btn btn-outline-danger rounded-pill px-3">
                                                    <i class="fa-solid fa-trash"></i>   Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="alert alert-warning text-center">

                        No Teacher Found

                    </div>

                @endforelse

            </div>




        </div>

    </div>
@endsection
