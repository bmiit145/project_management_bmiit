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
{{--@dd($panels);--}}
@foreach($data as $key => $panel)
    <div class="sheet-page">
        <h1 style="text-align: center">Evaluation Sheet</h1>
        <br>
        <span>Course Code: &nbsp;&nbsp;<b>{{ $panel[0]["group"]["student_groups"][0]["course_year"]["course"]["code"]}} </b> </span>
        <br>
        <span>Course Name: &nbsp;&nbsp;<b>{{ $panel[0]["group"]["student_groups"][0]["course_year"]["course"]["name"]}} </b></span>
        <br>
        <span>Panel No: &nbsp;&nbsp;<b>{{ $key }} </b></span>
        <br>
        <br>

        <table border="1" style="border-collapse: collapse">
            <thead>
            <tr>
                <th>No.</th>
                <th>Group No.</th>
                <th>Project Name</th>
                @if($withStudent)
                    <th>Student Enrollment</th>
                    <th>Student Name</th>
                @endif
                {{--      Criteria Count          --}}
                {{--                @dd($panel[0]["group"]["student_groups"][0]["course_year"]["evaluation_mark"])--}}
                @foreach($panel[0]["group"]["student_groups"][0]["course_year"]["evaluation_mark"] as $no => $ecriteria)
                    {{--                    @dd($panel[0]["group"]["student_groups"][0]["course_year"]["evaluation_mark"]["id"] , $evaluations);--}}
                    @if((in_array( $ecriteria["id"] , $evaluations ) || $evaluations[0] == -1 ))
                        <th>{{ $ecriteria["evaluation_criteria"]["name"] . "\n( " . $ecriteria["outof"] ." )"}} </th>
                    @endif
                @endforeach
                <th>Total</th>
            </tr>
            </thead>
            <tbody>


            @foreach($panel as $pkey => $groups)
                {{--                @dd($groups)--}}
                @if($withStudent)
                        <?php $rowspan = count($groups["group"]["student_groups"]) ?>
                @else
                        <?php $rowspan = 1 ?>
                @endif
                @foreach($groups["group"]["student_groups"] as $gkey => $group)
                    <tr>
                        @if( $gkey == 0 || !$withStudent)
                            <td rowspan="{{ $rowspan }}"> {{ ++$pkey }}</td>
                            <td rowspan="{{ $rowspan }}"> {{ $groups["group"]["number"] }}</td>
                            <td rowspan="{{ $rowspan }}"> {{ $groups["group"]["project"] ? $groups["group"]["project"]["title"] : "No Project" }}</td>
                        @endif
                        @if($withStudent)
                            <td>{{ $group['student']['enro'] }}</td>
                            <td>{{ $group['student']['fname'] . "\t" . $group['student']['lname']  }}</td>
                        @endif
                        @foreach($groups["group"]["student_groups"][0]["course_year"]["evaluation_mark"] as $no => $ecriteria)
                            @if((in_array( $ecriteria["id"] , $evaluations ) || $evaluations[0] == -1 ))
                                <td></td>
                            @endif
                        @endforeach
                        <td></td>
                    </tr>
                    {{--                only one row for project --}}
                    @if(!$withStudent)
                        @break
                    @endif
                @endforeach
            @endforeach

            </tbody>
        </table>
        <br>
        {{--        // if last page then don't add new page--}}
        @if( $loop->iteration != count($data))
            <div class="new_page" style="page-break-before: always;"></div>
        @endif
    </div>
@endforeach

</body>
</html>
