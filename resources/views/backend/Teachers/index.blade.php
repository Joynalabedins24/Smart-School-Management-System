@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-10 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('teacher.create') }}">Add Teacher</a></div>
    </div>
    <div class="shadow-sm card col-10 mx-auto">
        <div class="card">
            <div class="card-header">
              All Teachers
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Employ ID</th>
                        <th scope="col">Qualification </th>
                        <th scope="col">Special Subject</th>
                        <th scope="col">Hire Date</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $key => $teacher)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{ $teacher->user->name }}</td>
                            <td>{{ $teacher->employee_id, }}</td>
                            <td>{{ $teacher->qualification }}</td>
                            <td>{{ $teacher->subject_specialization }}</td>
                            <td>{{ $teacher->hire_date  }}</td>
                            <td>
                                <div class="btn-group">


                                    <a class="btn fw-bold" href=""><i class="fa-solid fa-eye"></i></a>
                                    <a class="btn fw-bold" href=""><i class="fa-solid fa-pencil"></i></a>


                                    <button class="btn btn__delete"><i class="fa-solid fa-eraser"></i></button>
                                    <form class="delete__form" action="" method="POST">

                                        @csrf
                                        @method('DELETE')

                                    </form>


                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
