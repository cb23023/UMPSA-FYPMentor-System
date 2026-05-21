<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Topic Application Status</title>
</head>
<body>
    <h3>Dear {{ $studentName }},</h3>

    <p>We would like to inform you that your topic application titled <strong>{{ $topicTitle }}</strong> has been <strong>{{ $status }}</strong>.</p>

    @if($remarks)
        <p><strong>Remarks:</strong> {{ $remarks }}</p>
    @endif

    <p>If you have any questions, please feel free to contact us.</p>

    <p>Best regards,<br>Topic Management Team</p>
</body>
</html>
