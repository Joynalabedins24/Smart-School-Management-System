@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-8 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('classe.create') }}"> Add Class </a></div>
    </div>
    <div class="shadow-sm card col-8 mx-auto">
        <div class="card">
            <div class="card-header">
              Classess
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Class Teacher Name</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach($Classes as $key => $Classe)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{ $Classe->name }}</td>
                            <td>{{ $Classe->classTeacher->user->name }}</td>

                            <td>
                                <div class="btn-group">


                                    <a class="btn btn-sm bg-primary fw-bold" href=""><i class="fa-solid fa-eye"></i></a>
                                    <a class="btn btn-sm bg-warning  fw-bold" href="{{ route('classe.edit',$Classe->id) }}"><i class="fa-solid fa-pencil"></i></a>

                                    <form action="{{ route('classe.delete',$Classe->id) }}" method="POST" style="display:inline;">
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
        </div>

    </div>
@endsection
