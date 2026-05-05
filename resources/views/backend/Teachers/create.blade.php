@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-5 mx-auto p-3">
    <form action="{{ route('teacher.store')}}" method="POST" class="row g-3 needs-validation" novalidate>
      @csrf
        <!--user_name-->
        <div class="col-md-">
          <label for="validationCustom01" class="form-label">User Name</label>
          <input type="text" name="userName" class="form-control" id="validationCustom01" value="{{ Auth::user()->name }}" disabled readonly>
          <div class="invalid-feedback">
            User name required
          </div>
          <div class="text-danger">
              @error('userName')
              {{ $message }}
              @enderror
          </div>
        </div>

        <!-- qualification  -->
        <div class="col-md">
          <label for="validationCustom" class="form-label">Qualification</label>
          <div class="input-group has-validation">
            <input type="text" name="qualification" value="{{ old('qualification') }}" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
            <div class="invalid-feedback">
              Please enter your Date of birth
            </div>
            <div class="qualification">
              @error('qualification')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>

        <!-- subject_specialization  -->
        <div class="col-md-">
          <label for="validationCustom03" class="form-label">Spacial Subject </label>
          <input type="text" name="subject_specialization" value="{{ old('subject_specialization') }}" class="form-control" id="validationCustom03" required>
          <div class="invalid-feedback">
            Please enter The Date of your admission
          </div>
          <div class="text-danger">
            @error('subject_specialization')
            {{ $message }}
            @enderror
          </div>
        </div>


        <!-- hire_date  -->
        <div class="col-md-">
          <label for="validationCustom04" class="form-label">Hire Date</label>
          <input type="date" name="hire_date" value="{{ old('hire_date') }}" class="form-control" id="validationCustom03" required>
          <div class="invalid-feedback">
            pleas choose one of the!
          </div>
          <div class="text-danger">
            @error('hire_date')
            {{ $message }}
            @enderror
          </div>
        </div>


        <div class="col-12">
          <button class="btn btn-primary" type="submit"> Add Teacher </button>
        </div>
    </form>
</div>


@endsection

