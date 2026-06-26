@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-10 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('classe.create') }}"> Add Class </a></div>
    </div>
    <div class="shadow-sm card col-10 mx-auto">
        <div class="card">
            <div class="card-header">
                Classes
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="table-dark align-middle">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Class Name</th>
                        <th scope="col">Class Teacher Name</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody class="align-middle">

                        @foreach($Classes as $key => $Classe)
                        <tr>
                            <th scope="row">{{$key + 1}}</th>
                            <td>{{ $Classe->name }}</td>
                            <td>{{ $Classe->classTeacher->user->name }}</td>

                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <a href=""
                                        class="btn btn-outline-primary table-action-btn"
                                        title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('classe.edit',$Classe->id) }}"
                                        class="btn btn-outline-success table-action-btn"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('classe.delete',$Classe->id) }}" method="POST" onsubmit="return confirm('Delete this teacher?')">
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
        </div>

    </div>
@endsection
