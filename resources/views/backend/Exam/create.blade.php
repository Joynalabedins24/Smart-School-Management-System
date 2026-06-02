@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <form action="{{ route('exams.store')}}" method="POST" class="row g-3 needs-validation">
      @csrf
        <!--Exam_name-->
        <div class="col-md-6">
          <label for="validationCustom01" class="form-label"> Exam Name</label>
          <input type="text" name="examName" class="form-control" id="validationCustom01" value="{{ old('examName') }}" required>
          <div class="invalid-feedback">
            Exam name needed
          </div>
          <div class="text-danger">
              @error('examName')
              {{ $message }}
              @enderror
          </div>
        </div>


        <!--Exam_Type-->
        <div class="col-md-6">
          <label for="Exam_Type" class="form-label"> Exam Type </label>
          <select class="form-select form-control" name="Exam_Type"  required>
            <option selected disabled value="{{ old('Exam_Type') }}">Choose...</option>

             <option value="final">Final</option>
             <option value="mid_term">Mid Term</option>
             <option value="class_test">Class Test</option>

          </select>
          <div class="invalid-feedback">
            Please enter The Date of your admission
          </div>
          <div class="text-danger">
            @error('Exam_Type')
            {{ $message }}
            @enderror
          </div>
        </div>


        <!-- Exam Start date  -->
        <div class="col-md-6">
          <label for="validationCustom2" class="form-label"> Start Date </label>
          <div class="input-group has-validation">
            <input type="date" name="startDate" class="form-control" id="validationCustom2" value="{{ old('startDate') }}" required>
            <div class="invalid-feedback">
              please enter the capasity of the section
            </div>
            <div class="text-danger">
              @error('startDate')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>

        <!-- Exam End date  -->
        <div class="col-md-6">
          <label for="validationCustom3" class="form-label"> Start Date </label>
          <div class="input-group has-validation">
            <input type="date" name="endDate" class="form-control" id="validationCustom3" value="{{ old('endDate') }}" required>
            <div class="invalid-feedback">
              please enter the capasity of the section
            </div>
            <div class="text-danger">
              @error('endDate')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>



        <!-- Classe name  -->
        <div class="col-md-">
          <label for="ClasseName" class="form-label"> Class, name </label>
          <select class="form-select select2 form-control" name="ClasseName"  id="ClasseName" required>
            <option selected disabled value="{{ old('ClasseName') }}">Choose...</option>
            @foreach ($classes  as $classe )
             <option value="{{ $classe->id }}">{{ $classe->name }}</option>
            @endforeach
          </select>
          <div class="invalid-feedback">
            Please enter The Date of your admission
          </div>
          <div class="text-danger">
            @error('ClasseName')
            {{ $message }}
            @enderror
          </div>
        </div>

        <div class="col-md-12">
          <button class="btn btn-primary" type="submit"> Add Exam </button>
        </div>
    </form>
</div>

<!-- searchable dropdown -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- jQuery & Select2 JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
      $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select a Class",
            allowClear: true
        });
      });
  </script>
<!-- searchable dropdown -->

@endsection
