@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h4>Academic Sessions</h4>

        </div>

        <div class="card-body">

            <!-- Create Form -->
            <form action="{{ route('AcademicSessions.store') }}"
                  method="POST">

                @csrf

                <div class="row mb-3">

                    <div class="col-md-8">

                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Session Name (2026)"
                               required>

                    </div>

                    <div class="col-md-4">

                        <button class="btn btn-primary">

                            Add Session

                        </button>

                    </div>

                </div>

            </form>

            <!-- Table -->
            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Session</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($sessions as $session)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $session->name }}
                            </td>

                            <td>

                                @if($session->is_active)

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                @else

                                    <span class="badge bg-secondary">

                                        Inactive

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if(!$session->is_active)

                                    <form action="{{ route(
                                            'AcademicSessions.active',
                                            $session->id
                                        ) }}"
                                          method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button class="btn btn-sm btn-success">

                                            Make Active

                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
