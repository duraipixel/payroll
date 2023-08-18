<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table,
        .input {
            width: 100%;
        }

        .input {
            border: 1px dotted black !important;
            padding: 0 7px;
            font-size: 14px
        } 
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            line-height: 25px;
        } 

        [border="0"] {
            border: none !important
        }

        [size="sm"] {
            font-size: 14px
        }

        [border="dotted"] {
            border: 1px dotted black !important;
        }
    </style>
</head>

<body>
    <center>
        <h3>AMALORPAVAM HIGHER SECONDARY SCHOOL</h3>
        <p><b>STAFF DATA SHEET</b></p>
        <p><b>Note :</b> The data that you furnish below are most important. In case of any change, (particularly mobile
            number), to be intimated to office in person. </p>
        <p><u>Please fill up all the categories without fail in capital letters.</u></p>
    </center>
    @include('pages.reports.staff.history.sections.personals-info')
    @include('pages.reports.staff.history.sections.family-info')
</body>

</html>
