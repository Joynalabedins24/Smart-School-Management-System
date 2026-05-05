@extends('layouts.app')
@section('content')
<div class="shadow-sm card col-9 mx-auto p-3">
    <form action="{{ route('section.store')}}" method="POST" class="row g-3 needs-validation">
      @csrf
        <!--Section_name-->
        <div class="col-md-4">
          <label for="validationCustom01" class="form-label"> Section Name</label>
          <input type="text" name="sectionName" class="form-control" id="validationCustom01" value="{{ old('sectionName') }}" required>
          <div class="invalid-feedback">
            Section name needed
          </div>
          <div class="text-danger">
              @error('sectionName')
              {{ $message }}
              @enderror
          </div>
        </div>


        <!-- Capacity  -->
        <div class="col-md-4">
          <label for="validationCustom2" class="form-label"> Capasity </label>
          <div class="input-group has-validation">
            <input type="text" name="Capacity" class="form-control" id="validationCustom2" value="{{ old('Capacity') }}" required>
            <div class="invalid-feedback">
              please enter the capasity of the section
            </div>
            <div class="text-danger">
              @error('Capacity')
              {{ $message }}
              @enderror
            </div>
          </div>
        </div>

        <!-- Classe name  -->
        <div class="col-md-4">
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
          <button class="btn btn-primary" type="submit"> Add Section </button>
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
