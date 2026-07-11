@extends('layouts.app')
@section('content')
    <div class= "bg-gray  col-10 mx-auto mb-2" >
        <div> <a class="btn btn-primary" href="{{ route('student.create') }}"><i class="fa-regular fa-square-plus"></i> Add Student</a></div>
    </div>

    <div class="col-10 col-lg-10 mx-auto mb-3">

    <form method="GET">

        <div class="row g-2">
            <!-- Search -->
            <div class="col-12 col-md-5">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Search by Name / Student ID">

            </div>
            <!-- Filter -->
            <div class="col-12 col-md-4">

                <select
                    name="class_id"
                    class="form-select">

                    <option value="">All Classes</option>

                    @foreach($classes as $class)

                        <option
                            value="{{ $class->id }}"
                            {{ request('class_id')==$class->id?'selected':'' }}>

                            {{ $class->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-6 col-md-1">

                <button
                    class="btn btn-primary w-100">

                    <i class="fa fa-filter"></i>

                </button>

            </div>

            <div class="col-6 col-md-2">

                <a
                    href="{{ route('student.index') }}"
                    class="btn btn-secondary w-100">

                    Reset

                </a>

            </div>

        </div>

    </form>

    </div>




    <div class="shadow-sm card col-10 mx-auto">
        <div class="card border-0">
            <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                    <div class="fw-bold text-primary-emphasis">All Students</div>
                    <div class="fw-bold text-primary-emphasis">Active session : {{ activeSession()->name }}</div>
                </div>


            </div>
            <div class="card-body table-responsive d-none d-md-block">
                <table class="table ">
                    <thead class="table-dark">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Class & Section</th>
                        <th scope="col">Age</th>
                        <th scope="col">Date of Admission</th>
                        <th scope="col">Guardian Name</th>
                        <th scope="col">Guardian Phone</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-center">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $key => $student)
                        <tr class="align-middle">
                            <th scope="row">{{$key + 1}}</th>
                            <td class="align-middle">
                                @if($student->student->profile_photo)
                                    <img
                                        src="{{ asset('uploads/students/'.$student->student->profile_photo) }}"
                                        alt="{{ $student->student->user->name }}"
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
                                        alt="{{ $student->student->user->name }}"
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


                            <td>
                                <b class="">{{ $student->student->user->name }}</b><br>
                                <small class="text-primary">{{ $student->student->student_id }}</small>
                            </td>

                            <td>{{ $student->class->name }} ({{ $student->section->name }})</td>
                            <td>{{ $student->student->dob->age }}</td>
                            <td>{{ \Carbon\Carbon::parse($student->student->admission_date)->format('d M Y') }}</td>
                            <td>{{ $student->student->guardian_name }}</td>
                            <td class="text-info-emphasis fa-bold"><i class="fa-solid fa-phone fw-bold"></i> {{ $student->student->guardian_phone }}
                            </td>
                            <td>@if($student->status)
                                    <span class="badge rounded-pill bg-success">Active</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                @endif
                            </td>

                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-1 flex-wrap">
                                    <button type="button"
                                            class="btn btn-outline-info  view-avatar-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#avatarModal"
                                            data-name="{{ $student->student->user->name }}"
                                            data-avatar="{{ $student->student->avatar_url }}"
                                            title="See Avatar">
                                        <i class="fa-solid fa-user-astronaut"></i>
                                    </button>

                                    <a href=""
                                        class="btn btn-outline-primary table-action-btn"
                                        title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('student.edit',$student->id) }}"
                                        class="btn btn-outline-success table-action-btn"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('student.destroy',$student->id) }}" method="POST" onsubmit="return confirm('Delete this teacher?')">
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
            <div class="d-md-none">

                @forelse($students as $student)

                    <div class="card border-0 shadow rounded-4 m-2">

                        <div class="card-body">

                            <div class="d-flex align-items-center">

                                @if($student->student->profile_photo)
                                    <img    src="{{ asset('uploads/students/'.$student->student->profile_photo) }}"
                                            class="teacher-photo">
                                @else
                                    <img    src="{{ asset('uploads/images/default.png') }}"
                                            class="teacher-photo">
                                @endif

                                <div class="ms-3 flex-grow-1">

                                    <h6 class="fw-bold mb-1">
                                        {{ $student->student->user->name }}
                                    </h6>
                                    <span class="badge bg-primary">
                                        {{ $student->student->student_id }}
                                    </span>
                                </div>
                                @if($student->status)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                            <hr>
                            <div class="row g-2 small">
                                <div class="col-6">
                                    <strong>Class</strong>
                                    <br>
                                    {{ $student->class->name }}
                                </div>
                                <div class="col-6">
                                    <strong>Section</strong>
                                    <br>
                                    {{ $student->section->name }}
                                </div>
                                <div class="col-6">
                                    <strong>Age</strong>
                                    <br>
                                    {{ $student->student->dob->age }} Years
                                </div>
                                <div class="col-6">
                                    <strong>Admission</strong>
                                    <br>
                                    {{ \Carbon\Carbon::parse($student->student->admission_date)->format('d M Y') }}
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">

                                <button type="button"
                                            class="btn btn-outline-info  view-avatar-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#avatarModal"
                                            data-name="{{ $student->student->user->name }}"
                                            data-avatar="{{ $student->student->avatar_url }}"
                                            title="See Avatar">
                                        <i class="fa-solid fa-user-astronaut"></i> Avater
                                </button>
                                <a  href=""
                                class="btn btn-outline-primary rounded-pill">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a  href="{{ route('student.edit',$student->id) }}"
                                class="btn btn-outline-success rounded-pill">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form   action="{{ route('student.destroy',$student->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')

                                    <button onclick="return confirm('Delete this student?')"
                                            class="btn btn-outline-danger rounded-pill">
                                                <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning">
                        No Student Found
                    </div>
                @endforelse

            </div>
            <div class="mt-3">
                {{ $students->links() }}
            </div>
        </div>

    </div>


    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #1a1a2e; color: #fff; border-radius: 15px; border: 1px solid #333;">
            <div class="modal-header" style="border-bottom: 1px solid #333;">
                <h5 class="modal-title" id="avatarModalLabel">
                    🚀 <span id="modal-student-name" class="fw-bold"></span>-এর ৩ডি অবতার
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 0; position: relative; min-height: 400px; height: 450px; background: radial-gradient(circle, #252542 0%, #121224 100%);" id="modal-body-content">
                </div>
            <div class="modal-footer" style="border-top: 1px solid #333;">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
    <script src="https://aframe.io/releases/1.5.0/aframe.min.js"></script>
    <script src="https://unpkg.com/aframe-orbit-controls@1.3.2/dist/aframe-orbit-controls.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const avatarModal = document.getElementById('avatarModal');

    // টেস্ট ১: মডাল ডিভটি স্ক্রিপ্ট খুঁজে পাচ্ছে কিনা
    if (!avatarModal) {
        console.error("🚨 'avatarModal' আইডির কোনো মডাল খুঁজে পাওয়া যায়নি!");
        return;
    }

    avatarModal.addEventListener('show.bs.modal', function (event) {
        console.log("🎯 ম্যাজিক! মডাল ওপেন হওয়ার প্রসেস শুরু হয়েছে!");

        const button = event.relatedTarget;
        const studentName = button.getAttribute('data-name') || 'Student';
        const avatarUrl = button.getAttribute('data-avatar');

        console.log("👤 স্টুডেন্ট নাম:", studentName);
        console.log("📂 ফাইল পাথ (URL):", avatarUrl);

        document.getElementById('modal-student-name').innerText = studentName;
        const modalBody = document.getElementById('modal-body-content');

        if (!avatarUrl) {
            modalBody.innerHTML = `<div class="text-center p-5 text-muted">কোনো মডেল ফাইল আপলোড করা নেই!</div>`;
            return;
        }

        // এ-ফ্রেম লোড করা
        modalBody.innerHTML = `
            <a-scene embedded style="width: 100%; height: 100%;" vr-mode-ui="enabled: false">
                <a-ambient-light color="#ffffff" intensity="1.3"></a-ambient-light>
                <a-directional-light position="1 3 2" intensity="0.7"></a-directional-light>

                <a-entity id="avatar-model"
                  gltf-model="${avatarUrl}"
                  position="0 -1.5 -2.5"
                  scale="1.2 1.2 1.2"
                  rotation="0 180 0"
                  animation="property: rotation;
                             to: 0 540 0;
                             dur: 10000;
                             easing: linear;
                             loop: true">
                </a-entity>

                <a-entity camera position="0 0 0"></a-entity>
            </a-scene>
        `;

        setTimeout(() => {
            const scene = modalBody.querySelector('a-scene');
            if (scene && scene.resize) scene.resize();
        }, 300);
    });

    avatarModal.addEventListener('hidden.bs.modal', function () {
        document.getElementById('modal-body-content').innerHTML = '';
    });
});
</script>
@endsection
