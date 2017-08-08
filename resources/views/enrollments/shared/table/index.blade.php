<table class="table">
    <tbody>
        @foreach ($enrollments as $year => $enrollments)
            <th colspan="4" class="active">
                {{ $year }} year
            </th>
            <tr>
                <th>Semester</th>
                <th>Course</th>
                <th>Shift</th>
                <th></th>
            </tr>
            @each('enrollments.shared.table.show', $enrollments, 'enrollment')
        @endforeach
    </tbody>
</table>