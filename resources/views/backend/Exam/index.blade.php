{{ $exams }}

@extends('layouts.app')
@section('content')

    <div class= "bg-gray  col-11 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('exams.create') }}"><i class="fa-regular fa-square-plus"></i> Add Exam</a></div>
    </div>

    <div class="col-11 mx-auto" >

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
                        <th scope="col">Start Date</th>
                        <th scope="col">End Date</th>
                        <th scope="col">classe</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($exams as $key => $exam)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{ $exam->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($exam->start_date)->format('jS F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($exam->end_date)->format('jS F Y') }}</td>
                            <td>{{ $exam->classe->name ?? '' }}</td>
                            <td>
                                <div class="btn-group">


                                    <a class="btn btn-sm bg-primary fw-bold" href=""><i class="fa-solid fa-eye"></i></a>
                                    <a class="btn btn-sm bg-warning  fw-bold" href="{{ route('exams.edit',$exam->id) }}"><i class="fa-solid fa-pencil"></i></a>

                                    <form action="{{ route('exams.destroy',$exam->id) }}" method="POST" style="display:inline;">
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
                {{ $exams->links() }}
            </div>
        </div>

    </div>
@endsection
