<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Grades Report for {{ $student->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .student-info p {
            margin: 0 0 8px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #d9e6f2;
            /* light blue */
        }
    </style>
</head>

<body>
    <h2>Grades Report for {{ $student->name }}</h2>

    <div class="student-info">
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Date of Birth:</strong> {{ $student->date_of_birth->format('d-m-Y') }}</p>
        <p><strong>Student since:</strong> {{ $student->created_at->diffForHumans() }}</p>
    </div>

    @if ($student->courses->isEmpty())
        <p>This student is not enrolled in any courses.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Partial Grade</th>
                    <th>Final Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ $course->pivot->partial_grade ?? 'N/A' }}</td>
                        <td>{{ $course->pivot->final_grade ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
