@extends('layouts.app')

@section('content')
<div class="container">

    <select id="class_id" class="form-control mb-3">
    <option value="">Select Class</option>
    @foreach($classes as $class)
        <option value="{{ $class->id }}">{{ $class->name }}</option>
    @endforeach
    </select>

    <div class="card" style="background-color:#ececec;">
        <div class="card-header">
              All Students
        </div>
        <div class="card-body" id="student_list" style="background-color:#ececec;">

        </div>

    </div>


</div>
<script>
document.getElementById('class_id').addEventListener('change', function () {

    let classId = this.value;

    if (!classId) {
        document.getElementById('student_list').innerHTML = "";
        return;
    }

    fetch('/get-students/' + classId)
        .then(response => response.json())
        .then(data => {

            let html = `
            <table class="table table-light">
                <tr>
                    <th>Student</th>
                    <th>Present</th>
                    <th>Remarks</th>
                </tr>
            `;

            data.forEach(student => {
                html += `
                <tr>
                    <td>
                        ${student.user.name}
                        <input type="hidden" name="student_id[]" value="${student.id}">
                    </td>

                    <td>
                        <label class="toggle">
                            <input type="checkbox" name="status">
                            <span class="slider"></span>
                        </label>



                    </td>

                    <td>
                        <input class="form-control" type="textarea"
                               name="remarks"
                               value="">
                    </td>
                </tr>
                `;
            });

            html += `</table>`;

            document.getElementById('student_list').innerHTML = html;
        });
});
</script>
@endsection

