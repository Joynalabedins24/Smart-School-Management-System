@extends('layouts.app')

@section('content')

<div class="card p-3 col-8 mx-auto">
    <div>
        <h2 class="m-1">ATTENDANCE TAKING</h2>
    </div>

    <form method="POST" action="{{ route('attendance.store') }}">
        @csrf

        <!-- Date -->
        <input type="date"id ="date" name="date" class="form-control mb-3" required>

        <!-- Class -->
        <select id="class_id" name="class_id" class="form-control mb-3">
            <option>Select Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        <!-- Section -->
        <select id="section_id" class="form-control mb-3">
            <option>Select Section</option>
        </select>

        <!-- Students List -->
        <div class="card" style="background-color:#ececec;">
        <div class="card-header">
              All Students
        </div>
        <div class="card-body" id="student_list" style="background-color:#ececec;">

        </div>

        </div>

        <button class="btn btn-success mt-3">Save Attendance</button>

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
<script>
document.getElementById('section_id').addEventListener('change', function () {

    let classId = document.getElementById('class_id').value;
    let date = document.getElementById('date').value;
    let sectionId = this.value;

    if (!classId || !sectionId) {
        document.getElementById('student_list').innerHTML = "";
        return;
    }

    fetch(`/get-students-edit/${classId}/${sectionId}/${date}`)
        .then(res => res.json())
        .then(data => {

            let html = `
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student ID</th>
                        <th>Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
            `;

            data.forEach((student, index) => {
                let checked = (student.status === 'present') ? 'checked' : '';
                html += `
                <tr>
                    <td>${index + 1}</td>

                    <td>${student.user.name}</td>

                    <td>${student.student_id}</td>

                    <td>
                        <label class="switch">
                            <input type="checkbox"
                                   name="students[${student.id}][status]"
                                   value="present" ${checked} >
                            <span class="slider round"></span>
                        </label>
                    </td>

                    <td>
                        <input type="text"
                               name="students[${student.id}][remarks]"
                               class="form-control"
                               placeholder="Optional">
                    </td>
                </tr>
                `;
            });

            html += `</tbody></table>`;

            document.getElementById('student_list').innerHTML = html;
        });

});
</script>


@endsection
