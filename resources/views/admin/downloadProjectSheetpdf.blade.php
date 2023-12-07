<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $code .'   -   '. $cname}} </title>
    <style>
        table {
            width: 100%; /* the table width to 100% */
            table-layout: auto; /* Forces the table to use the specified layout */
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            padding: 3px;
            word-wrap: break-word;
            white-space: pre-line;
        }
    </style>
    <style>
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
<div class="sheet-page">
    <div style="text-align: center">
        <h1 style="text-align: center">Project List </h1>
        <div style="font-size: large">
            <span><b>{{ $program }}</b></span>&nbsp;
            <span><b>{{ $year }}</b></span><br/>
            <span><b>Semester : {{ $semester }}</b></span><br/>
            <span><b>{{ $code }}</b> </span> - <span><b>{{ $cname  }}</b></span>
        </div>
        <br/>
        <br/>
    </div>
    <table border="1" style="border-collapse: collapse; text-align: center">
        <thead>
        <tr style="background-color: #989898 ">
            {{--            <th>No.</th>--}}
            <th>Group No.</th>
            <th>Student Enrollment</th>
            <th>Student Name</th>
            <th>Project Name</th>
            <th>Guide Name</th>
        </tr>
        </thead>
        <tbody>

        @foreach($data as $key => $studentGroup)
                <?php $rowspan = count($studentGroup) ?>
            @foreach($studentGroup as $gkey => $student)
                    <?php $group = $student["group"] ?>
                <tr>
                    @if( $gkey == 0)
                        {{--                        <td rowspan="{{ $rowspan }}"> {{ ++$key }}</td>--}}
                        <td rowspan="{{ $rowspan }}"> {{ $group["number"] }}</td>
                    @endif
                    <td>{{ $student['student']['enro'] }}</td>
                    <td>{{ $student['student']['fname'] . "\t" }}{{ $student['student']['lname'] ? $student['student']['lname'] : '' }}</td>
                    @if( $gkey == 0)
                        @if($group["project"] )
                            <td rowspan="{{ $rowspan }}">{{ $group["project"]["title"] }}</td>
                        @else
                            <td rowspan="{{ $rowspan }}" style="color: red"> No Project</td>
                        @endif
                        @if($group["allocation"])
                            <td rowspan="{{ $rowspan }}">{{ $group["allocation"]["faculty"]["fname"] . "\t"}}{{ $group["allocation"]["faculty"]["lname"] ? $group["allocation"]["faculty"]["lname"] : '' }}</td>
                        @else
                            <td rowspan="{{ $rowspan }}" style="color: red"> No Guide</td>
                        @endif
                    @endif
                </tr>
                {{--                only one row for project --}}
            @endforeach
{{--                space after each group --}}
            @if( $loop->iteration != count($data))
                <tr>
                    <td colspan="5">&nbsp;</td>
                </tr>
            @endif
        @endforeach
        </tbody>
    </table>
    <br>
</div>
</body>
</html>
