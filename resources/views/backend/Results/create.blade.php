@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('results.store') }}">
<div class="card p-3 col-10 mx-auto">
    <div class="row mb-3">



        <div class="col-md-4">
        <!-- Class -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="class_id">Class :</label>
            <select id="class_id" name="class_id" class="form-select">
                <option>Choose...</option>
                @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            </div>
        </div>



        <div class="col-md-4">
        <!-- Exam -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="exam_id">Exam :</label>
            <select class="form-select" id="exam_id" name="exam_id">
                <option>Choose...</option>

            </select>
            </div>
        </div>



        <div class="col-md-4">
            <!-- Subject -->
            <div class="input-group mb-3">
            <label class="input-group-text" for="subject_id">Subjects</label>
            <select class="form-select" id="subject_id" name="subject_id">
                <option>Choose...</option>

            </select>
            </div>
        </div>
    </div>
</div>
<div class="card p-3 col-10 mx-auto">
    <div>
        <h2 class="m-1 text-center">Marks Distribution</h2>
    </div>

    <form method="POST" action="{{ route('results.store') }}">
        @csrf
        <!-- Students List -->
        <div class="card" style="background-color:#ececec;">
        <div class="card-header">
              Students
        </div>
        <div class="card-body" id="student_list" style="background-color:#ececec;">

        </div>

        </div>

        <button class="btn btn-success col-2 mt-3">Save/Update Marks</button>



</div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-exams/' + classId,
            type: 'GET',
            success: function (data) {
                $('#exam_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, exam) {
                    $('#exam_id').append('<option value="' + exam.id + '">' + exam.name + '</option>');
                });
            }
        });
    } else {
        $('#exam_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>


<script>
$('#class_id').on('change', function () {
    var classId = $(this).val();
    if (classId) {
        $.ajax({
            url: '/get-subjectsbyclass/' + classId,
            type: 'GET',
            success: function (data) {
                $('#subject_id').empty().append('<option value="">Choose...</option>');
                $.each(data, function (key, subject) {
                    $('#subject_id').append('<option value="' + subject.id + '">' + subject.name + '</option>');
                });
            }
        });
    } else {
        $('#subject_id').empty().append('<option value="">Choose...</option>');
    }
});
</script>


<script>
document.getElementById('subject_id').addEventListener('change', function () {

    let classId = document.getElementById('class_id').value;
    let examId = document.getElementById('exam_id').value;
    let subjectId = this.value;

    if (!classId || !subjectId) {
        document.getElementById('student_list').innerHTML = "";
        return;
    }

    fetch(`/get-students-result/${classId}/${examId}/${subjectId}`)
        .then(res => res.json())
        .then(data => {

            let html = `
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th class="col-2">Marks</th>
                        <th class="col-2">Grade</th>
                    </tr>
                </thead>
                <tbody>
            `;

            data.forEach((student, index) => {
                //let checked = (student.marks === 'present') ? 'checked' : '';
                html += `
                <tr>
                    <td>${index + 1}</td>

                    <td>${student.user.name}</td>

                    <td>${student.student_id}</td>

                    <td>
                        <input  type="number"

                                name="students[${student.id}][marks]"
                                class="form-control marks"
                                placeholder="Enter Marks"
                                value ="${student.marks}">


                    </td>

                    <td>
                        <input  type="text"

                                name="students[${student.id}][grade]"
                                class="form-control grade"
                                placeholder="Optional"
                                value ="${student.grade}" readonly>
                    </td>
                </tr>
                `;
            });

            html += `</tbody></table>`;

            document.getElementById('student_list').innerHTML = html;
        });

});
</script>

<script>

document.addEventListener('input', function(e){

    if(e.target.classList.contains('marks')){

        let marks = parseInt(e.target.value) || 0;

        let grade = '';

        if (marks >= 80){
            grade = 'A+';
        }
        else if (marks >= 70){
            grade = 'A';
        }
        else if (marks >= 60){
            grade = 'A-';
        }
        else if (marks >= 50){
            grade = 'B';
        }
        else if (marks >= 40){
            grade = 'C';
        }
        else if (marks >= 33){
            grade = 'D';
        }
        else{
            grade = 'F';
        }

        let row = e.target.closest('tr');

        row.querySelector('.grade').value = grade;
    }

});

</script>



@endsection
