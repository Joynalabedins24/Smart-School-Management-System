@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-5 mx-auto p-3">
    <form action="{{ route('subject.store')}}" method="POST" class="row g-3 needs-validation" novalidate>
      @csrf
        <!--Subject_name-->
        <div class="col-md-">
          <label for="validationCustom01" class="form-label">Subject Name</label>
          <input type="text" name="subjectName" class="form-control" id="validationCustom01" value="{{ old('subjectName') }}" required>
          <div class="invalid-feedback">
            User name required
          </div>
          <div class="text-danger">
              @error('subjectName')
              {{ $message }}
              @enderror
          </div>
        </div>


        <!-- Classes  -->
        <div class="col-md">
          <label for="validationCustom" class="form-label">Classes</label>
          <div class="input-group has-validation">
            <select class="form-select" name="class_id"  id="class_id" required>
            <option selected disabled value="{{ old('class_id') }}">Choose...</option>
            @foreach ($classes  as $class )
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
            </select>
            <div class="invalid-feedback">
              Please enter your Date of birth
            </div>
            <div class="class_id">
              @error('class_id')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>

        <div class="col-12">
          <button class="btn btn-primary" type="submit"> Add Subject </button>
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
            placeholder: "Choose a Teacher",
            allowClear: true
        });
      });
  </script>
<!-- searchable dropdown -->

@endsection
