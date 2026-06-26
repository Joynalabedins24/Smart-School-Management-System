@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-10 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('sections.create') }}"> Add Section </a></div>
    </div>
    <div class="shadow-sm card col-10 mx-auto">
        <div class="card">
            <div class="card-header">
              <h3>Sections</h3>
            </div>
            <div class="card-body">
                <div class="row">

                    @foreach ($Classes as $Classe)
                    <div class="d-flex flex-column col-md-4">
                        <div class="mx-auto ">
                            {{$Classe->name}}
                        </div>
                        <div>
                        <table class="table" border="1">
                            <tr class="table-dark">
                                <th>Section</th>
                                <th class="text-center">Capasity</th>
                                <th class="text-center">Action</th>
                            </tr>

                            @foreach ($sections as $section)
                                @if ($Classe->id == $section->class_id)
                                <tr class="align-middle">
                                    <td>{{ $section->name }}</td>
                                    <td class="text-center">{{ $section->capacity }}</td>
                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center gap-1 flex-wrap">

                                            <a href="{{ route('sections.edit',$section->id) }}"
                                                class="btn btn-outline-success table-action-btn"
                                                title="Edit">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                            </a>

                                            <form action="{{ route('sections.destroy',$section->id) }}" method="POST" onsubmit="return confirm('Delete this teacher?')">
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
