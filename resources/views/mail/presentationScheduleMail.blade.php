<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> {{"$assessmentType  Schedule on $dateOnly at   $timeOnly " }}</title>
</head>
<body>
@if($mailBody != null && $mailBody != '' &&  $mailBody != ' ' &&  str_replace(' ', '', $mailBody) != '')
    {!! $mailBody !!}
@else
    <p>Dear Students,</p>
    <p>Kindly find the attached schedule for your {{ $assessmentType }}  on {{ $dateOnly }}
        at {{ $timeOnly }}.</p>
    <p>Regards,</p>
@endif

</body>
</html>

