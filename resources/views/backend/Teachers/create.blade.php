@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-10 mx-auto p-3">
    <form action="{{ route('teacher.store')}}" method="POST" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
      @csrf
        <!--Teacher_name-->
        <div class="col-md-4">
          <label  class="form-label">Teacher Name</label>
          <input type="text" name="name" class="form-control" id="validationCustom01" value="{{ old('teacherName') }}" >
        </div>

        <!--email-->
        <div class="col-md-4">
          <label  class="form-label">Email</label>
          <input type="email" name="email" class="form-control" id="validationCustom01" value="{{ old('email') }}" >
        </div>

        <!--password-->
        <div class="col-md-4">
          <label  class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="validationCustom01" value="{{ old('password') }}" >
        </div>

        <!-- qualification  -->
        <div class="col-md-6">
          <label for="validationCustom" class="form-label">Qualification</label>
          <div class="input-group has-validation">
            <input type="text" name="qualification" value="{{ old('qualification') }}" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
          </div>
        </div>

        <!-- subject_specialization  -->
        <div class="col-md-6">
          <label  class="form-label">Spacial Subject </label>
          <input type="text" name="subject_specialization" value="{{ old('subject_specialization') }}" class="form-control" id="validationCustom03" required>
        </div>

        <!-- Phone  -->
        <div class="col-md-4">
          <label  class="form-label">Phone </label>
          <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" id="validationCustom03" required>
        </div>

        <!-- Address  -->
        <div class="col-md-4">
          <label for="validationCustom03" class="form-label"> Address </label>
          <input type="text" name="address" value="{{ old('address') }}" class="form-control" id="validationCustom03" required>
        </div>


        <!-- hire_date  -->
        <div class="col-md-4">
          <label for="validationCustom04" class="form-label">Hire Date</label>
          <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="form-control" id="validationCustom03" required>
        </div>


        <!-- profile_photo  -->
        <div class="col-md-12">
            <label class="form-label">
                    Profile Photo
            </label>
            <input type="file" name="profile_photo" class="form-control" accept="image/*">
        </div>

        <div class="col-12">
          <button class="btn btn-primary" type="submit"> Add Teacher </button>
        </div>
    </form>
</div>


@endsection

