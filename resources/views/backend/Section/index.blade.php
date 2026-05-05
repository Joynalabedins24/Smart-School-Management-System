@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-8 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('section.create') }}"> Add Section </a></div>
    </div>
    <div class="shadow-sm card col-8 mx-auto">
        <div class="card">
            <div class="card-header">
              Sections
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap">

                    @foreach ($Classes as $Classe)
                    <div class="d-flex flex-column col-md-4">
                        <div class="mx-auto ">
                            {{$Classe->name}}
                        </div>
                        <div>
                        <table class="table" border="1">
                            <tr>
                                <th>Section</th>
                                <th>Capasity</th>
                                <th>Action</th>
                            </tr>

                            @foreach ($sections as $section)
                                @if ($Classe->id == $section->class_id)
                                <tr>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->capacity }}</td>
                                    <td>
                                        <a class="btn btn-sm bg-warning  fw-bold" href="{{ route('section.edit',$section->id) }}"><i class="fa-solid fa-pencil"></i></a>
                                        <form action="{{ route('section.delete',$section->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete?')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </table>
                        </div>
                    </div>
                    @endforeach

                </div>

            </div>
        </div>

    </div>
@endsection
