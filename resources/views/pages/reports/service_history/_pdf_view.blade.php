<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pdf</title>
</head>

<body>
    <style>
        div.next {
            /* page-break-inside: avoid; */
            page-break-after: always;
        }
    </style>
    @include('pages.reports.service_history._list_card')
</body>

</html>
