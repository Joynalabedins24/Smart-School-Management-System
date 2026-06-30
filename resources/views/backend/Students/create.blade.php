@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-10 mx-auto p-3">
    <form action="{{ route('student.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
      @csrf


        <!-- Student Name  -->
        <div class="col-md-6">
            <label class="form-label">
                Student Name
            </label>
            <input  type="text" name="name" value="{{ old('name') }}" class="form-control" required>
        </div>

        <!-- Email Address  -->
        <div class="col-md-6">

            <label class="form-label">
                Email
            </label>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" required >

        </div>

        <!-- Password  -->
        <div class="col-md-3">

            <label class="form-label">
                Password
            </label>
            <input type="password" name="password" value="{{ old('password')}}" class="form-control" required >

        </div>

        <!-- Date of Birth  -->
        <div class="col-md-3">
          <label for="validationCustomUsername" class="form-label">Date of birth</label>
          <div class="input-group has-validation">
            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
            <div class="invalid-feedback">
              Please enter your Date of birth
            </div>
            <div class="text-danger">
              @error('dob')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>

        <!-- Date of admission  -->
        <div class="col-md-3">
          <label for="validationCustom03" class="form-label">Admission Date</label>
          <input type="date" name="doa" value="{{ old('doa') }}" class="form-control" id="validationCustom03" required>
          <div class="invalid-feedback">
            Please enter The Date of your admission
          </div>
          <div class="text-danger">
            @error('doa')
            {{ $message }}
            @enderror
          </div>
        </div>


        <!-- Gender  -->
        <div class="col-md-3">
          <label for="validationCustom04" class="form-label">Gender</label>
          <select class="form-select" name="gender"  id="validationCustom04" required>
            <option selected disabled value="{{ old('gender') }}">Choose...</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
          <div class="invalid-feedback">
            pleas choose one of the!
          </div>
          <div class="text-danger">
            @error('gender')
            {{ $message }}
            @enderror
          </div>
        </div>


        <!-- Classes  -->
        <div class="col-md-6">
          <label for="validationCustom05"  class="form-label"> Classes </label>
          <select class="form-select" name="class_id"  id="class_id" required>
            <option selected disabled value="{{ old('class_id') }}">Choose...</option>
            @foreach ($classes  as $class )
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback">
            Please Choose one of them!
          </div>
          <div class="text-danger">
            @error('class_id')
            {{ $message }}
            @enderror
          </div>
        </div>


        <!-- Section  -->
        <div class="col-md-6">
          <label for="validationCustom05"  class="form-label">Section</label>
          <select class="form-select" name="section_id"  id="section_id" required>
            <option value="{{ old('section_id') }}">Choose...</option>
          </select>
          <div class="invalid-feedback">
            Please provide a fathers name
          </div>
          <div class="text-danger">
            @error('section_id')
            {{ $message }}
            @enderror
          </div>
        </div>

        <!-- Gardian  -->
        <div class="col-md-6">
            <label for="validationCustom06" class="form-label">Gardian Name</label>
            <input type="text" name="gName" value="{{ old('gName') }}" class="form-control" id="validationCustom06" required>
            <div class="invalid-feedback">
              Please provide mothers name
            </div>
            <div class="text-danger">
              @error('gName')
              {{ $message }}
              @enderror
            </div>
        </div>


        <!-- Gardian phone number -->
        <div class="col-md-6">
            <label for="validationCustom07" class="form-label">Gardian Phone Number</label>
            <input type="text" name="gPhone" value="{{ old('gPhone') }}" class="form-control" id="validationCustom07" required>
            <div class="invalid-feedback">
              Please provide mothers name
            </div>
            <div class="text-danger">
              @error('gPhone')
              {{ $message }}
              @enderror
            </div>
        </div>


        <!-- Address -->
        <div class="col-md-12">
            <label for="validationCustom08" class="form-label">Address</label>
            <textarea class="form-control" name="address"  id="validationCustom08" >{{ old('address') }}</textarea>
            <div class="invalid-feedback">
              Please provide mothers name
            </div>
            <div class="text-danger">
              @error('address')
              {{ $message }}
              @enderror
            </div>
        </div>

        <!-- Profile Photo -->
        <div class="col-md-12">
            <label class="form-label">
                Profile Photo
            </label>
            <input type="file" name="profile_photo" class="form-control" accept="image/*">
        </div>




        <div class="col-12">
          <button class="btn btn-primary" type="submit">Add Student</button>
        </div>
    </form>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-sections/' + classId,
            type: 'GET',
            success: function (data) {
                $('#section_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, section) {
                    $('#section_id').append('<option value="' + section.id + '">' + section.name + '</option>');
                });
            }
        });
    } else {
        $('#section_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>

@endsection

