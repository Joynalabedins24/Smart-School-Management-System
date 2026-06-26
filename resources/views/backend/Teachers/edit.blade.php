@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-10 mx-auto p-3">
    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <!--Teacher_name-->
        <div class="col-md-6">
          <label  class="form-label">Teacher Name</label>
          <input type="text" name="name" class="form-control" id="validationCustom01" value="{{ $teacher->user->name }}" >
        </div>

        <!--email-->
        <div class="col-md-6">
          <label  class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="validationCustom01" value="{{ $teacher->user->email }}" >
        </div>

        <!-- qualification  -->
        <div class="col-md-6">
          <label for="validationCustom" class="form-label">Qualification</label>
          <div class="input-group has-validation">
            <input type="text" name="qualification" value="{{ $teacher->qualification }}" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
          </div>
        </div>

        <!-- subject_specialization  -->
        <div class="col-md-6">
          <label  class="form-label">Spacial Subject </label>
          <input type="text" name="subject_specialization" value="{{ $teacher->subject_specialization }}" class="form-control" id="validationCustom03" required>
        </div>

        <!-- Phone  -->
        <div class="col-md-4">
          <label  class="form-label">Phone </label>
          <input type="text" name="phone" value="{{ $teacher->phone }}" class="form-control" id="validationCustom03" required>
        </div>

        <!-- Address  -->
        <div class="col-md-4">
          <label for="validationCustom03" class="form-label"> Address </label>
          <input type="text" name="address" value="{{ $teacher->address }}" class="form-control" id="validationCustom03" required>
        </div>


        <!-- hire_date  -->
        <div class="col-md-4">
          <label for="validationCustom04" class="form-label">Hire Date</label>
          <input type="date" name="hire_date" value="{{ $teacher->hire_date }}" class="form-control" id="validationCustom03" required>
        </div>


        <!-- profile_photo  -->
        <div class="col-md-12">

    <label class="form-label fw-semibold">

        Profile Photo

    </label>

    <div class="border rounded-4 p-3 bg-light">

        <div class="row align-items-center">

            <div class="col-md-3 text-center">

                <img
                    id="previewImage"
                    src="{{ $teacher->profile_photo
                        ? asset('uploads/teachers/'.$teacher->profile_photo)
                        : asset('images/default-user.png') }}"
                    class="image-preview">

            </div>

            <div class="col-md-9">

                <input
                    type="file"
                    name="profile_photo"
                    id="profile_photo"
                    class="form-control"
                    accept="image/*">

                <small class="text-muted">

                    JPG, JPEG, PNG | Max: 2MB

                </small>

            </div>

        </div>

    </div>

</div>

        <div class="col-12">
          <button class="btn btn-primary" type="submit"> Update Teacher </button>
        </div>
    </form>
</div>

<script>

document.getElementById('profile_photo')
.addEventListener('change',function(e){

    const reader = new FileReader();

    reader.onload = function(){

        document
        .getElementById('previewImage')
        .src = reader.result;

    }

    reader.readAsDataURL(e.target.files[0]);

});

</script>
@endsection


